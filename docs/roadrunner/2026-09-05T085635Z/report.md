## Sustainable ranking

| Rank | Target | Best stable RPM | Stable concurrency | Peak observed RPM | Peak concurrency | Peak stability | Duration s |
| --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | webrick-generated (5.1) | 196,714 | 63 | 196,714 | 63 | Stable | 248.4 |
| 2 | webrick-sharded (5.1) | 195,951 | 63 | 195,951 | 63 | Stable | 248.6 |
| 3 | webrick-fused (5.1) | 195,538 | 63 | 195,538 | 63 | Stable | 248.6 |
| 4 | infbyte-full (2.1.1) | 174,340 | 63 | 174,340 | 63 | Stable | 249.3 |
| 5 | infbyte (2.1.1) | 173,192 | 63 | 173,192 | 63 | Stable | 249.4 |
| 6 | laravel-api (v13.30.1) | 76,716 | 63 | 76,716 | 63 | Stable | 258.5 |
| 7 | laravel (v13.30.1) | 63,820 | 63 | 63,820 | 63 | Stable | 262.8 |

## Throughput — concurrency 2

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 123,165 | 0.39% | Stable | 123,406 | 122,924 |
| webrick-fused (5.1) | 122,912 | 0.38% | Stable | 123,143 | 122,682 |
| webrick-sharded (5.1) | 122,421 | 0.41% | Stable | 122,669 | 122,172 |
| infbyte (2.1.1) | 112,211 | 0.32% | Stable | 112,034 | 112,387 |
| infbyte-full (2.1.1) | 111,741 | 0.00% | Stable | 111,743 | 111,739 |
| laravel-api (v13.30.1) | 56,666 | 2.09% | Stable | 56,074 | 57,258 |
| laravel (v13.30.1) | 46,622 | 4.84% | Stable | 47,750 | 45,495 |

## Throughput — concurrency 63

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 196,714 | 0.13% | Stable | 196,585 | 196,844 |
| webrick-sharded (5.1) | 195,951 | 0.79% | Stable | 196,724 | 195,178 |
| webrick-fused (5.1) | 195,538 | 0.52% | Stable | 196,046 | 195,030 |
| infbyte-full (2.1.1) | 174,340 | 0.22% | Stable | 174,527 | 174,152 |
| infbyte (2.1.1) | 173,192 | 1.70% | Stable | 171,717 | 174,667 |
| laravel-api (v13.30.1) | 76,716 | 0.36% | Stable | 76,577 | 76,855 |
| laravel (v13.30.1) | 63,820 | 1.22% | Stable | 64,209 | 63,432 |

## Throughput — concurrency 125

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 191,664 | 0.32% | Stable | 191,970 | 191,358 |
| webrick-fused (5.1) | 190,174 | 0.35% | Stable | 190,510 | 189,838 |
| webrick-sharded (5.1) | 189,325 | 1.11% | Stable | 190,375 | 188,275 |
| infbyte (2.1.1) | 168,150 | 0.70% | Stable | 167,562 | 168,738 |
| infbyte-full (2.1.1) | 168,098 | 0.61% | Stable | 167,587 | 168,610 |
| laravel-api (v13.30.1) | 74,157 | 0.07% | Stable | 74,132 | 74,181 |
| laravel (v13.30.1) | 62,046 | 1.06% | Stable | 62,374 | 61,718 |

## Throughput — concurrency 250

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 188,295 | 0.37% | Stable | 188,641 | 187,949 |
| webrick-fused (5.1) | 187,127 | 0.09% | Stable | 187,208 | 187,045 |
| webrick-sharded (5.1) | 187,068 | 0.51% | Stable | 187,541 | 186,594 |
| infbyte-full (2.1.1) | 167,080 | 0.44% | Stable | 166,716 | 167,443 |
| infbyte (2.1.1) | 167,056 | 0.81% | Stable | 167,733 | 166,379 |
| laravel-api (v13.30.1) | 71,833 | 0.07% | Stable | 71,857 | 71,809 |
| laravel (v13.30.1) | 59,734 | 0.68% | Stable | 59,936 | 59,532 |

## Latency — serial

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 0.75 | 0.87 | 0.92 | 0.00 | 0.74 |
| webrick-sharded (5.1) | 0.76 | 0.88 | 0.93 | 0.00 | 0.76 |
| webrick-fused (5.1) | 0.76 | 0.88 | 0.95 | 0.00 | 0.76 |
| infbyte-full (2.1.1) | 0.82 | 0.99 | 1.04 | 0.00 | 0.83 |
| infbyte (2.1.1) | 0.83 | 0.99 | 1.05 | 0.00 | 0.83 |
| laravel-api (v13.30.1) | 1.69 | 1.92 | 2.13 | 0.00 | 1.69 |
| laravel (v13.30.1) | 2.07 | 2.34 | 3.83 | 0.00 | 2.09 |

## Latency — concurrency 2

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 0.88 | 1.10 | 1.23 | 0.00 | 0.88 |
| webrick-fused (5.1) | 0.88 | 1.10 | 1.24 | 0.00 | 0.88 |
| webrick-sharded (5.1) | 0.88 | 1.10 | 1.25 | 0.00 | 0.89 |
| infbyte (2.1.1) | 0.97 | 1.23 | 1.39 | 0.00 | 0.98 |
| infbyte-full (2.1.1) | 0.97 | 1.23 | 1.40 | 0.00 | 0.98 |
| laravel-api (v13.30.1) | 1.96 | 2.46 | 2.92 | 0.00 | 2.01 |
| laravel (v13.30.1) | 2.35 | 3.05 | 6.05 | 0.00 | 2.46 |

## Latency — concurrency 63

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 18.73 | 21.08 | 22.83 | 0.00 | 18.73 |
| webrick-sharded (5.1) | 18.83 | 21.12 | 22.62 | 0.00 | 18.80 |
| webrick-fused (5.1) | 18.85 | 21.20 | 22.77 | 0.00 | 18.84 |
| infbyte (2.1.1) | 21.17 | 25.16 | 27.50 | 0.00 | 21.34 |
| infbyte-full (2.1.1) | 21.23 | 23.60 | 25.04 | 0.00 | 21.20 |
| laravel-api (v13.30.1) | 48.78 | 52.30 | 54.89 | 0.01 | 48.80 |
| laravel (v13.30.1) | 58.68 | 62.96 | 65.59 | 0.01 | 58.73 |

## Latency — concurrency 125

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 38.40 | 41.62 | 43.59 | 0.01 | 38.42 |
| webrick-fused (5.1) | 38.59 | 42.09 | 49.07 | 0.01 | 38.71 |
| webrick-sharded (5.1) | 38.85 | 42.36 | 44.52 | 0.01 | 38.90 |
| infbyte (2.1.1) | 43.85 | 47.37 | 50.62 | 0.01 | 43.88 |
| infbyte-full (2.1.1) | 43.89 | 47.03 | 49.42 | 0.01 | 43.90 |
| laravel-api (v13.30.1) | 100.34 | 105.84 | 111.15 | 0.03 | 100.31 |
| laravel (v13.30.1) | 120.09 | 126.67 | 133.60 | 0.03 | 119.95 |

## Latency — concurrency 250

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 78.35 | 82.98 | 85.48 | 0.05 | 78.40 |
| webrick-fused (5.1) | 78.79 | 83.63 | 86.83 | 0.04 | 78.91 |
| webrick-sharded (5.1) | 78.92 | 83.69 | 85.90 | 0.05 | 78.91 |
| infbyte (2.1.1) | 88.49 | 93.43 | 96.94 | 0.05 | 88.53 |
| infbyte-full (2.1.1) | 88.54 | 93.34 | 95.59 | 0.05 | 88.51 |
| laravel-api (v13.30.1) | 207.68 | 217.95 | 226.61 | 0.12 | 206.92 |
| laravel (v13.30.1) | 250.08 | 263.15 | 277.12 | 0.15 | 248.72 |

## Reliability — serial

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| infbyte (2.1.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-generated (5.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 2

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 61584 | 61584 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 61458 | 61458 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 61212 | 61212 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 56107 | 56107 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 55872 | 55872 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 28335 | 28335 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 23313 | 23313 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 63

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 98409 | 98409 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 98026 | 98026 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 97822 | 97822 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 87223 | 87223 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 86647 | 86647 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 38413 | 38413 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 31966 | 31966 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 125

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 95935 | 95935 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 95192 | 95192 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 94766 | 94766 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 84180 | 84180 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 84155 | 84155 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 37185 | 37185 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 31131 | 31131 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 250

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 94360 | 94360 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 93777 | 93777 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 93750 | 93750 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 83757 | 83757 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 83737 | 83737 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 36128 | 36128 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 30087 | 30087 | 0.00% | 0 | 0 | 0 | 0 |

## Relative comparison

| Target | Peak throughput | Remote memory | Server time | Included files |
| --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 3.08× | 1.00× | 1.00× | 1.00× |
| webrick-sharded (5.1) | 3.07× | 1.04× | 1.32× | 1.05× |
| webrick-fused (5.1) | 3.06× | 1.01× | 1.22× | 1.04× |
| infbyte-full (2.1.1) | 2.73× | 2.16× | 6.23× | 1.45× |
| infbyte (2.1.1) | 2.71× | 1.15× | 6.27× | 1.35× |
| laravel-api (v13.30.1) | 1.20× | 3.20× | 13.65× | 4.00× |
| laravel (v13.30.1) | 1.00× | 11.57× | 32.29× | 4.35× |

## Resource telemetry

| Target | Samples | Avg CPU | Peak CPU | Avg MB | Peak MB | Remote MB |
| --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 0 | — | — | — | — | 1.95 |
| webrick-sharded (5.1) | 0 | — | — | — | — | 2.02 |
| webrick-fused (5.1) | 0 | — | — | — | — | 1.97 |
| infbyte-full (2.1.1) | 0 | — | — | — | — | 4.21 |
| infbyte (2.1.1) | 0 | — | — | — | — | 2.25 |
| laravel-api (v13.30.1) | 0 | — | — | — | — | 6.24 |
| laravel (v13.30.1) | 0 | — | — | — | — | 22.57 |

## Server response telemetry

| Target | Metric | Samples | Average | Minimum | Maximum |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | Included files | 532935 | 163.00000 | 163.00000 | 163.00000 |
| webrick-generated (5.1) | Server execution ms | 532935 | 0.02752 | 0.00900 | 3.14500 |
| webrick-sharded (5.1) | Included files | 529135 | 171.00000 | 171.00000 | 171.00000 |
| webrick-sharded (5.1) | Server execution ms | 529135 | 0.03640 | 0.01000 | 2.73700 |
| webrick-fused (5.1) | Included files | 529879 | 169.00000 | 169.00000 | 169.00000 |
| webrick-fused (5.1) | Server execution ms | 529879 | 0.03345 | 0.00900 | 3.05200 |
| infbyte-full (2.1.1) | Included files | 632012 | 236.00000 | 236.00000 | 236.00000 |
| infbyte-full (2.1.1) | Server execution ms | 632012 | 0.17143 | 0.06300 | 5.83800 |
| infbyte (2.1.1) | Included files | 631340 | 220.00000 | 220.00000 | 220.00000 |
| infbyte (2.1.1) | Server execution ms | 631340 | 0.17246 | 0.06300 | 5.01700 |
| laravel-api (v13.30.1) | Included files | 290118 | 652.00000 | 652.00000 | 652.00000 |
| laravel-api (v13.30.1) | Server execution ms | 290118 | 0.37561 | 0.15500 | 10.69900 |
| laravel (v13.30.1) | Included files | 242990 | 708.24934 | 708.00000 | 709.00000 |
| laravel (v13.30.1) | Server execution ms | 242990 | 0.88871 | 0.36000 | 23.65800 |

## Common configuration

| Setting | Value |
| --- | --- |
| Method | GET |
| Expected status | 200 |
| Count per phase | 5000 |
| Max concurrency | 250 |
| Concurrency levels | [2,63,125,250] |
| Repetitions | 2 |
| Maximum rpm spread percent | 10 |
| Warm up requests per scenario | 10 |
| Minimum duration seconds | 30 |
| Timeout seconds | 10 |
| Http2 | no |
| Verify ssl | yes |
| Piping mode | optimal |
| Skip preflight | no |
| Header names | ["Accept","Cache-Control"] |
| Has request body | no |
| Response memory extraction | yes |
| Response metrics extraction | yes |
| Route workload | ["Static (GET 200)","Dynamic first (GET 200)","Dynamic middle (GET 200)","Dynamic last (GET 200)","Multiple parameters (GET 200)","Static precedence (GET 200)","404 (GET 404)","405 (POST 405)"] |
| Route scenarios | [{"key":"static","label":"Static","method":"GET","expectedStatus":200,"pattern":"/hello/index"},{"key":"dynamic-first","label":"Dynamic first","method":"GET","expectedStatus":200,"pattern":"/{value}/hello/index"},{"key":"dynamic-middle","label":"Dynamic middle","method":"GET","expectedStatus":200,"pattern":"/hello/{value}/index"},{"key":"dynamic-last","label":"Dynamic last","method":"GET","expectedStatus":200,"pattern":"/hello/index/{value}"},{"key":"multiple-parameters","label":"Multiple parameters","method":"GET","expectedStatus":200,"pattern":"/hello/pair/{first}/{second}"},{"key":"static-precedence","label":"Static precedence","method":"GET","expectedStatus":200,"pattern":"/hello/benchmark/fixed"},{"key":"not-found","label":"404","method":"GET","expectedStatus":404,"pattern":"/benchmark/not-found"},{"key":"method-not-allowed","label":"405","method":"POST","expectedStatus":405,"pattern":"/hello/index"}] |

## Load-generator environment

| Setting | Value |
| --- | --- |
| Load generator | php-curl-multi |
| Php version | 8.4.25 |
| Php sapi | cli |
| Memory limit | -1 |
| CLI OPcache enabled | no |
| CLI OPcache JIT mode | 1235 |
| Xdebug loaded | no |
| Curl version | 8.5.0 |
| Operating system | Linux 6.17.0-1022-azure |

## Target-specific configuration

| Setting | webrick-generated (5.1) | webrick-sharded (5.1) | webrick-fused (5.1) | infbyte-full (2.1.1) | infbyte (2.1.1) | laravel-api (v13.30.1) | laravel (v13.30.1) |
| --- | --- | --- | --- | --- | --- | --- | --- |
| Url | http://127.0.0.1:43957/webrick-generated/asset/public/index.php/hello/index | http://127.0.0.1:43957/webrick-sharded/asset/public/index.php/hello/index | http://127.0.0.1:43957/webrick-fused/asset/public/index.php/hello/index | http://127.0.0.1:43957/infbyte-full/asset/public/index.php/hello/index | http://127.0.0.1:43957/infbyte/asset/public/index.php/hello/index | http://127.0.0.1:43957/laravel-api/asset/public/index.php/api/hello/index | http://127.0.0.1:43957/laravel/asset/public/index.php/hello/index |

## Target-server environment

These settings come from the PHP web runtime that received benchmark requests.

| Setting | Value |
| --- | --- |
| PHP version | 8.5.10 |
| PHP SAPI | cli |
| Loaded php.ini | /usr/local/etc/php/php.ini |
| Benchmark environment profile | roadrunner-production |
| OPcache extension loaded | Yes |
| OPcache enabled for web requests | Yes |
