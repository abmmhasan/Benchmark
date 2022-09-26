<?php

namespace AbmmHasan\Benchmark;

use CurlMultiHandle;
use Exception;
use InvalidArgumentException;

class RequestBenchmark
{
    private CurlMultiHandle $cmh;
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
    private array $singleThreadConfiguration = [
        'count' => 1000
    ];
    private array $multiThreadConfiguration = [
        'threads' => 10,
        'count' => 1000,
        'piping' => 'optimal'
    ];

    /**
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
        if (!in_array($method, $this->validMethods)) {
            throw new Exception('Invalid HTTP method');
        }

        $this->method = strtoupper($method);
        $this->url = $link;
        return $this;
    }

    /**
     * @param array $headers
     * @return static
     */
    public function setHeaders(array $headers): static
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @param array|string $body
     * @return static
     */
    public function setBody(array|string $body): static
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @param int $status
     * @return static
     */
    public function setExpectedStatus(int $status = 200): static
    {
        $this->expect = $status;
        return $this;
    }

    /**
     * @param int $numberOfRequests
     * @return static
     * @throws Exception
     */
    public function setSingleThreadOption(int $numberOfRequests = 1000): static
    {
        if ($numberOfRequests < 1) {
            throw new Exception('Minimum required request count is 1!');
        }
        return $this;
    }

    /**
     * @param int $numberOfThreads
     * @param int $numberOfRequests
     * @param string $pipingType
     * @return static
     * @throws Exception
     */
    public function setMultiThreadOption(
        int    $numberOfThreads = 10,
        int    $numberOfRequests = 1000,
        string $pipingType = 'optimal'
    ): static
    {
        if ($numberOfThreads < 2) {
            throw new Exception('Minimum required thread count is 2!');
        }
        if ($numberOfRequests < $numberOfThreads) {
            throw new Exception('Request count should be greater than or equal to given thread!');
        }
        if (!in_array($pipingType, ['optimal', 'max'])) {
            throw new Exception('Pipe: Invalid type!');
        }
        $this->multiThreadConfiguration = [
            'threads' => $numberOfThreads,
            'count' => $numberOfRequests,
            'piping' => $pipingType
        ];
        return $this;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function execute(): array
    {
        $startTime = microtime(true);
        $option = $this->prepareOption();
        $singleThread = $this->singleThreaded($option);
        sleep(1);
        $multiThreaded = $this->multiThreaded($option);
        return [
            'method' => $this->method,
            'url' => $this->url,
            'expects' => $this->expect,
            'singleThread' => $singleThread,
            'multiThread' => $multiThreaded,
            'score' => round($singleThread['req/s'] + $multiThreaded['req/s'], 5),
            'took' => round(microtime(true) - $startTime, 5)
        ];
    }

    /**
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
            'req/s' => round($this->multiThreadConfiguration['count'] / $duration, 5),
            'duration' => $duration
        ];
    }

    /**
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
     * @param array $options
     * @return void
     */
    private function setupMultiThread(array $options): void
    {
        $this->cmh = curl_multi_init();
        curl_multi_setopt($this->cmh, CURLMOPT_MAX_TOTAL_CONNECTIONS, $this->multiThreadConfiguration['threads']);
        curl_multi_setopt($this->cmh, CURLMOPT_MAX_PIPELINE_LENGTH, match ($this->multiThreadConfiguration['piping']) {
            'optimal' => $this->multiThreadConfiguration['count'] <= $this->multiThreadConfiguration['threads']
                ?: ceil($this->multiThreadConfiguration['count'] / $this->multiThreadConfiguration['threads']),
            default => $this->multiThreadConfiguration['count']
        });
        for ($index = 0; $index < $this->multiThreadConfiguration['count']; $index++) {
            $handle = curl_init();
            curl_setopt_array($handle, $options);
            curl_multi_add_handle($this->cmh, $handle);
        }
    }

    /**
     * @param $handle
     * @return array
     * @throws Exception
     */
    private function seriesRequest($handle): array
    {
        $responseTime = [];
        for ($count = 0; $count < $this->singleThreadConfiguration['count']; $count++) {
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
            'req/s' => round($this->singleThreadConfiguration['count'] / $totalTime, 5),
            'duration' => [
                'total' => round($totalTime, 5),
                'avg' => round($totalTime / $this->singleThreadConfiguration['count'], 5),
                'min' => round(min($responseTime), 5),
                'max' => round(max($responseTime), 5)
            ]
        ];
    }

    /**
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
     * @return array
     */
    private function prepareOption(): array
    {
        if (empty($this->url)) {
            throw new InvalidArgumentException('Invalid URL');
        }
        $curlOption = [
            CURLOPT_URL => $this->url,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 1,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $this->method
        ];
        if ($this->method === 'POST' || $this->method === 'PUT' || $this->method === 'PATCH') {
            $curlOption[CURLOPT_POSTFIELDS] = $this->body;
        }
        if (!empty($this->headers)) {
            foreach ($this->headers as $key => $value) {
                $curlOption[CURLOPT_HTTPHEADER][] = "$key: $value";
            }
        }
        return $curlOption;
    }
}
