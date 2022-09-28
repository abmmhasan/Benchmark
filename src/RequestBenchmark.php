<?php

namespace AbmmHasan\Benchmark;

use CurlMultiHandle;
use Exception;
use InvalidArgumentException;

class RequestBenchmark
{
    private CurlMultiHandle $cmh;
    private array $curlOptions = [];
    private array $headers = [];
    private ?string $body = null;
    private array $validMethods = [
        'GET',
        'POST',
        'PUT',
        'DELETE',
        'HEAD',
        'PATCH'
    ];
    private int $expect = 200;
    private string $method = 'GET';
    private string $url;
    private array $requestConfiguration = [
        'threads' => 10,
        'count' => 1000,
        'piping' => 'optimal'
    ];
    private array $result = [
        'error' => 'uninitialized'
    ];

    /**
     * Set link & method for benchmark
     *
     * @param string $link
     * @param string $method
     * @return static
     * @throws Exception
     */
    public function setUrl(string $link, string $method = 'GET'): static
    {
        if (filter_var($link, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException('Invalid URL');
        }
        $method = strtoupper($method);
        if (!in_array($method, $this->validMethods)) {
            throw new Exception('Invalid HTTP method');
        }

        $this->method = $method;
        $this->url = $link;
        return $this;
    }

    /**
     * Set passable headers
     *
     * @param array $headers
     * @return static
     */
    public function setHeaders(array $headers): static
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * Set body
     *
     * @param array|string $body
     * @return static
     */
    public function setBody(array|string $body): static
    {
        $this->body = $body;
        return $this;
    }

    /**
     * Set expected status (the status return by the set endpoint)
     *
     * @param int $status
     * @return static
     */
    public function setExpectedStatus(int $status = 200): static
    {
        $this->expect = $status;
        return $this;
    }

    /**
     * Set options for user requests
     *
     * @param int $numberOfUsers
     * @param int $numberOfRequests
     * @param string $pipingType
     * @return static
     * @throws Exception
     */
    public function setUserOption(
        int    $numberOfUsers = 10,
        int    $numberOfRequests = 1000,
        string $pipingType = 'optimal'
    ): static
    {
        if ($numberOfUsers < 2) {
            throw new Exception('Minimum required thread count is 2!');
        }
        if ($numberOfRequests < 100) {
            throw new Exception('Request count should be greater than or equal to 100!');
        }
        if ($numberOfRequests < $numberOfUsers) {
            throw new Exception('Request count should be greater than or equal to given thread!');
        }
        if (!in_array($pipingType, ['optimal', 'max'])) {
            throw new Exception('Pipe: Invalid type!');
        }
        $this->requestConfiguration = [
            'threads' => $numberOfUsers,
            'count' => $numberOfRequests,
            'piping' => $pipingType
        ];
        return $this;
    }

    /**
     * Set curl option (this will override curl settings except URL, Method, Header & Body)
     *
     * @param array $curlOptions
     * @return static
     */
    public function setCurlOption(array $curlOptions): static
    {
        $this->curlOptions = $curlOptions;
        return $this;
    }

    /**
     * Start benchmarking with configured options
     *
     * @return static
     * @throws Exception
     */
    public function start(): static
    {
        $this->result = [
            'error' => 'unfinished'
        ];
        $startTime = microtime(true);
        $option = $this->prepareOption();
        $singleThreadReq = $this->singleThreaded($option);
        $this->result = [
            'req/s' => [
                'singleUser' => $singleThreadReq['req/s'],
                'multipleUsers' => $this->multiThreaded($option)['req/s']
            ],
            'responseDuration' => $singleThreadReq['avgDuration'],
            'took' => round(microtime(true) - $startTime, 5)
        ];
        return $this;
    }

    /**
     * Get any of the predefined variable
     *
     * @param string $key
     * @return array|int|string|string[]|null
     */
    public function __get(string $key)
    {
        return match ($key) {
            'result' => $this->result,
            'headers' => $this->headers,
            'body' => $this->body,
            'method' => $this->method,
            'url' => $this->url,
            'expectedStatus' => $this->expect,
            'configuration' => $this->requestConfiguration
        };
    }

    /**
     * Multiple user request
     *
     * @param $option
     * @return array
     * @throws Exception
     */
    private function multiThreaded($option): array
    {
        $this->setupMultiThread($option);
        $duration = $this->threadedRequest();
        if (($diffs = array_diff($this->getThreadedResponse(), [$this->expect])) !== []) {
            throw new Exception(
                "API status is invalid (Expected: $this->expect, Found: " . implode(', ', $diffs) . ")"
            );
        }
        return [
            'req/s' => round($this->requestConfiguration['count'] / $duration, 5)
        ];
    }

    /**
     * Single user request
     *
     * @param $option
     * @return array
     * @throws Exception
     */
    private function singleThreaded($option): array
    {
        $curlHandle = curl_init();
        curl_setopt_array($curlHandle, $option);
        return $this->seriesRequest($curlHandle);
    }

    /**
     * Get response from multiuser request
     *
     * @return array
     */
    private function getThreadedResponse(): array
    {
        $results = [];
        while (false !== ($info = curl_multi_info_read($this->cmh))) {
            $results[] = curl_getinfo($info["handle"], CURLINFO_HTTP_CODE);
            curl_multi_remove_handle($this->cmh, $info["handle"]);
            curl_close($info["handle"]);
        }
        curl_multi_close($this->cmh);
        return array_unique($results);
    }

    /**
     * Perform multiuser request
     *
     * @return float
     */
    private function threadedRequest(): float
    {
        $startedAt = microtime(true);
        for (; ;) {
            $running = 0;
            do {
                $error = curl_multi_exec($this->cmh, $running);
            } while ($error === CURLM_CALL_MULTI_PERFORM);
            if ($running < 1) {
                break;
            }
            curl_multi_select($this->cmh, 1);
        }
        return microtime(true) - $startedAt;
    }

    /**
     * Setup required options for multiuser
     *
     * @param array $options
     * @return void
     */
    private function setupMultiThread(array $options): void
    {
        $this->cmh = curl_multi_init();
        curl_multi_setopt($this->cmh, CURLMOPT_MAX_TOTAL_CONNECTIONS, $this->requestConfiguration['threads']);
        curl_multi_setopt($this->cmh, CURLMOPT_MAX_PIPELINE_LENGTH, match ($this->requestConfiguration['piping']) {
            'optimal' => $this->requestConfiguration['count'] <= $this->requestConfiguration['threads']
                ?: ceil($this->requestConfiguration['count'] / $this->requestConfiguration['threads']),
            default => $this->requestConfiguration['count']
        });
        for ($index = 0; $index < $this->requestConfiguration['count']; $index++) {
            $handle = curl_init();
            curl_setopt_array($handle, $options);
            curl_multi_add_handle($this->cmh, $handle);
        }
    }

    /**
     * Setup & execute single user requests
     *
     * @param $handle
     * @return array
     * @throws Exception
     */
    private function seriesRequest($handle): array
    {
        $responseTime = [];
        for ($count = 0; $count < $this->requestConfiguration['count']; $count++) {
            $startedAt = microtime(true);
            if (($status = $this->executeCurl($handle)['code']) !== $this->expect) {
                curl_close($handle);
                throw new Exception("API status is invalid (Expected: $this->expect, Found: $status)");
            }
            $responseTime[] = microtime(true) - $startedAt;
        }
        curl_close($handle);
        $totalTime = array_sum($responseTime);
        return [
            'req/s' => round($this->requestConfiguration['count'] / $totalTime, 5),
            'avgDuration' => round($totalTime / $this->requestConfiguration['count'], 5)
        ];
    }

    /**
     * Execute curls
     *
     * @param $handle
     * @return array
     */
    private function executeCurl($handle): array
    {
        try {
            return [
                'response' => curl_exec($handle),
                'code' => curl_getinfo($handle, CURLINFO_HTTP_CODE),
            ];
        } catch (Exception $e) {
            return [
                'response' => $e->getMessage(),
                'code' => 500
            ];
        }
    }

    /**
     * Prepare required options
     *
     * @return array
     */
    private function prepareOption(): array
    {
        if (empty($this->url)) {
            throw new InvalidArgumentException('Invalid URL');
        }
        $curlOption = [
            CURLOPT_URL => $this->url,
            CURLOPT_CUSTOMREQUEST => $this->method
        ];
        if (
            ($this->method === 'POST' || $this->method === 'PUT' || $this->method === 'PATCH') &&
            !empty($this->body)
        ) {
            $curlOption[CURLOPT_POSTFIELDS] = $this->body;
        }
        if (!empty($this->headers)) {
            foreach ($this->headers as $key => $value) {
                $curlOption[CURLOPT_HTTPHEADER][] = "$key: $value";
            }
        }
        $curlOption += $this->curlOptions;
        $curlOption += [
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 1,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1
        ];
        return $curlOption;
    }
}
