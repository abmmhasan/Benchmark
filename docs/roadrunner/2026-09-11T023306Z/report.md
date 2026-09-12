## Overall ranking

| Rank | Target | Ranked RPM | Ranked concurrency | Ranking stability | Peak observed RPM | Peak concurrency | Peak stability | Duration s |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | webrick-generated (5.1) | 213,158 | 63 | Stable | 213,158 | 63 | Stable | 248.1 |
| 2 | webrick-sharded (5.1) | 212,230 | 63 | Stable | 212,230 | 63 | Stable | 248.1 |
| 3 | webrick-fused (5.1) | 211,403 | 63 | Stable | 211,403 | 63 | Stable | 248.1 |
| 4 | infbyte (2.1.1) | 187,258 | 63 | Stable | 187,258 | 63 | Stable | 249.0 |
| 5 | infbyte-full (2.1.1) | 186,500 | 63 | Stable | 186,500 | 63 | Stable | 249.0 |
| 6 | laravel-api (v13.31.0) | 82,349 | 63 | Stable | 82,349 | 63 | Stable | 258.9 |
| 7 | laravel (v13.31.0) | 67,885 | 63 | Stable | 67,885 | 63 | Stable | 263.0 |

## Throughput — concurrency 2

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 135,966 | 0.13% | Stable | 135,881 | 136,052 |
| webrick-fused (5.1) | 135,073 | 0.14% | Stable | 135,169 | 134,977 |
| webrick-sharded (5.1) | 134,889 | 0.43% | Stable | 135,180 | 134,598 |
| infbyte (2.1.1) | 122,303 | 0.78% | Stable | 121,827 | 122,779 |
| infbyte-full (2.1.1) | 121,313 | 0.84% | Stable | 120,801 | 121,826 |
| laravel-api (v13.31.0) | 58,976 | 0.92% | Stable | 58,705 | 59,247 |
| laravel (v13.31.0) | 48,162 | 6.88% | Stable | 49,818 | 46,506 |

## Throughput — concurrency 63

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 213,158 | 0.73% | Stable | 213,939 | 212,376 |
| webrick-sharded (5.1) | 212,230 | 0.05% | Stable | 212,283 | 212,178 |
| webrick-fused (5.1) | 211,403 | 0.61% | Stable | 212,043 | 210,763 |
| infbyte (2.1.1) | 187,258 | 0.98% | Stable | 188,175 | 186,340 |
| infbyte-full (2.1.1) | 186,500 | 0.36% | Stable | 186,838 | 186,162 |
| laravel-api (v13.31.0) | 82,349 | 0.23% | Stable | 82,255 | 82,443 |
| laravel (v13.31.0) | 67,885 | 2.70% | Stable | 68,800 | 66,970 |

## Throughput — concurrency 125

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 209,996 | 0.01% | Stable | 209,981 | 210,011 |
| webrick-fused (5.1) | 208,006 | 0.76% | Stable | 208,795 | 207,217 |
| webrick-sharded (5.1) | 207,717 | 0.32% | Stable | 208,051 | 207,383 |
| infbyte-full (2.1.1) | 180,745 | 0.01% | Stable | 180,756 | 180,734 |
| infbyte (2.1.1) | 178,948 | 1.98% | Stable | 177,179 | 180,717 |
| laravel-api (v13.31.0) | 79,732 | 1.35% | Stable | 79,195 | 80,269 |
| laravel (v13.31.0) | 65,601 | 2.08% | Stable | 66,284 | 64,918 |

## Throughput — concurrency 250

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 209,143 | 0.38% | Stable | 208,749 | 209,537 |
| webrick-sharded (5.1) | 206,854 | 1.31% | Stable | 208,209 | 205,500 |
| webrick-fused (5.1) | 205,690 | 1.06% | Stable | 206,777 | 204,603 |
| infbyte-full (2.1.1) | 180,641 | 0.46% | Stable | 180,229 | 181,054 |
| infbyte (2.1.1) | 180,059 | 1.48% | Stable | 178,728 | 181,390 |
| laravel-api (v13.31.0) | 77,075 | 0.66% | Stable | 76,820 | 77,331 |
| laravel (v13.31.0) | 63,036 | 4.12% | Stable | 64,336 | 61,737 |

## Latency — serial

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-sharded (5.1) | 0.70 | 0.82 | 0.86 | 0.00 | 0.70 |
| webrick-generated (5.1) | 0.70 | 0.82 | 0.91 | 0.00 | 0.70 |
| webrick-fused (5.1) | 0.71 | 0.83 | 0.87 | 0.00 | 0.71 |
| infbyte (2.1.1) | 0.79 | 0.94 | 0.98 | 0.00 | 0.79 |
| infbyte-full (2.1.1) | 0.79 | 0.95 | 1.00 | 0.00 | 0.79 |
| laravel-api (v13.31.0) | 1.74 | 1.93 | 2.04 | 0.00 | 1.73 |
| laravel (v13.31.0) | 2.09 | 2.33 | 4.01 | 0.00 | 2.11 |

## Latency — concurrency 2

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-fused (5.1) | 0.79 | 0.97 | 1.12 | 0.00 | 0.80 |
| webrick-generated (5.1) | 0.79 | 0.97 | 1.12 | 0.00 | 0.79 |
| webrick-sharded (5.1) | 0.79 | 0.97 | 1.12 | 0.00 | 0.80 |
| infbyte (2.1.1) | 0.88 | 1.10 | 1.25 | 0.00 | 0.88 |
| infbyte-full (2.1.1) | 0.88 | 1.11 | 1.26 | 0.00 | 0.90 |
| laravel-api (v13.31.0) | 1.87 | 2.33 | 2.71 | 0.00 | 1.92 |
| laravel (v13.31.0) | 2.28 | 2.87 | 6.14 | 0.00 | 2.38 |

## Latency — concurrency 63

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 17.22 | 19.45 | 20.85 | 0.00 | 17.22 |
| webrick-sharded (5.1) | 17.31 | 19.51 | 20.91 | 0.00 | 17.29 |
| webrick-fused (5.1) | 17.37 | 19.59 | 21.03 | 0.00 | 17.36 |
| infbyte (2.1.1) | 19.67 | 22.08 | 23.76 | 0.00 | 19.67 |
| infbyte-full (2.1.1) | 19.75 | 22.18 | 23.78 | 0.00 | 19.75 |
| laravel-api (v13.31.0) | 45.43 | 49.34 | 54.32 | 0.01 | 45.33 |
| laravel (v13.31.0) | 55.18 | 59.89 | 64.92 | 0.01 | 55.12 |

## Latency — concurrency 125

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 34.90 | 37.99 | 39.83 | 0.01 | 34.91 |
| webrick-fused (5.1) | 35.25 | 38.34 | 40.15 | 0.01 | 35.24 |
| webrick-sharded (5.1) | 35.31 | 38.38 | 40.06 | 0.01 | 35.31 |
| infbyte (2.1.1) | 40.66 | 48.32 | 51.32 | 0.01 | 41.11 |
| infbyte-full (2.1.1) | 40.70 | 44.05 | 45.99 | 0.01 | 40.69 |
| laravel-api (v13.31.0) | 93.57 | 100.96 | 112.19 | 0.02 | 92.97 |
| laravel (v13.31.0) | 113.41 | 123.67 | 148.95 | 0.03 | 113.15 |

## Latency — concurrency 250

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 70.28 | 74.82 | 76.87 | 0.04 | 70.27 |
| webrick-sharded (5.1) | 71.03 | 75.80 | 77.87 | 0.03 | 71.06 |
| webrick-fused (5.1) | 71.43 | 76.15 | 78.37 | 0.04 | 71.46 |
| infbyte-full (2.1.1) | 81.59 | 86.40 | 88.76 | 0.04 | 81.59 |
| infbyte (2.1.1) | 81.75 | 86.96 | 90.45 | 0.04 | 81.88 |
| laravel-api (v13.31.0) | 193.89 | 204.76 | 214.48 | 0.11 | 192.49 |
| laravel (v13.31.0) | 237.45 | 253.99 | 268.39 | 0.14 | 235.39 |

## Reliability — serial

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| infbyte (2.1.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.31.0) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.31.0) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-generated (5.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 2

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 67984 | 67984 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 67538 | 67538 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 67446 | 67446 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 61153 | 61153 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 60658 | 60658 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.31.0) | 29489 | 29489 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.31.0) | 24082 | 24082 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 63

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 106627 | 106627 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 106168 | 106168 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 105755 | 105755 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 93685 | 93685 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 93303 | 93303 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.31.0) | 41227 | 41227 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.31.0) | 34001 | 34001 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 125

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 105104 | 105104 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 104110 | 104110 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 103963 | 103963 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 90478 | 90478 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 89596 | 89596 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.31.0) | 39966 | 39966 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.31.0) | 32912 | 32912 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 250

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 104792 | 104792 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 103645 | 103645 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 103063 | 103063 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 90541 | 90541 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 90239 | 90239 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.31.0) | 38753 | 38753 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.31.0) | 31731 | 31731 | 0.00% | 0 | 0 | 0 | 0 |

## Relative comparison

| Target | Peak throughput | Remote memory | Server time | Included files |
| --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 3.14× | 1.00× | 1.00× | 1.00× |
| webrick-sharded (5.1) | 3.13× | 1.04× | 1.34× | 1.05× |
| webrick-fused (5.1) | 3.11× | 1.01× | 1.25× | 1.04× |
| infbyte (2.1.1) | 2.76× | 1.15× | 6.24× | 1.35× |
| infbyte-full (2.1.1) | 2.75× | 2.17× | 6.28× | 1.45× |
| laravel-api (v13.31.0) | 1.21× | 3.20× | 13.83× | 4.00× |
| laravel (v13.31.0) | 1.00× | 12.04× | 32.43× | 4.35× |

## Resource telemetry

| Target | Samples | Avg CPU | Peak CPU | Avg MB | Peak MB | Remote MB |
| --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 0 | — | — | — | — | 1.95 |
| webrick-sharded (5.1) | 0 | — | — | — | — | 2.02 |
| webrick-fused (5.1) | 0 | — | — | — | — | 1.97 |
| infbyte (2.1.1) | 0 | — | — | — | — | 2.25 |
| infbyte-full (2.1.1) | 0 | — | — | — | — | 4.24 |
| laravel-api (v13.31.0) | 0 | — | — | — | — | 6.24 |
| laravel (v13.31.0) | 0 | — | — | — | — | 23.47 |

## Server response telemetry

| Target | Metric | Samples | Average | Minimum | Maximum |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | Included files | 584266 | 163.00000 | 163.00000 | 163.00000 |
| webrick-generated (5.1) | Server execution ms | 584266 | 0.02756 | 0.00900 | 3.33500 |
| webrick-sharded (5.1) | Included files | 579339 | 171.00000 | 171.00000 | 171.00000 |
| webrick-sharded (5.1) | Server execution ms | 579339 | 0.03702 | 0.01100 | 2.50200 |
| webrick-fused (5.1) | Included files | 578204 | 169.00000 | 169.00000 | 169.00000 |
| webrick-fused (5.1) | Server execution ms | 578204 | 0.03446 | 0.01000 | 2.62900 |
| infbyte (2.1.1) | Included files | 679344 | 220.00000 | 220.00000 | 220.00000 |
| infbyte (2.1.1) | Server execution ms | 679344 | 0.17197 | 0.06600 | 6.87300 |
| infbyte-full (2.1.1) | Included files | 679958 | 236.00000 | 236.00000 | 236.00000 |
| infbyte-full (2.1.1) | Server execution ms | 679958 | 0.17310 | 0.06800 | 4.00100 |
| laravel-api (v13.31.0) | Included files | 308868 | 652.00000 | 652.00000 | 652.00000 |
| laravel-api (v13.31.0) | Server execution ms | 308868 | 0.38125 | 0.15600 | 23.79200 |
| laravel (v13.31.0) | Included files | 255449 | 708.24818 | 708.00000 | 709.00000 |
| laravel (v13.31.0) | Server execution ms | 255449 | 0.89377 | 0.37700 | 31.40500 |

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

| Setting | webrick-generated (5.1) | webrick-sharded (5.1) | webrick-fused (5.1) | infbyte (2.1.1) | infbyte-full (2.1.1) | laravel-api (v13.31.0) | laravel (v13.31.0) |
| --- | --- | --- | --- | --- | --- | --- | --- |
| Url | http://127.0.0.1:39217/webrick-generated/asset/public/index.php/hello/index | http://127.0.0.1:39217/webrick-sharded/asset/public/index.php/hello/index | http://127.0.0.1:39217/webrick-fused/asset/public/index.php/hello/index | http://127.0.0.1:39217/infbyte/asset/public/index.php/hello/index | http://127.0.0.1:39217/infbyte-full/asset/public/index.php/hello/index | http://127.0.0.1:39217/laravel-api/asset/public/index.php/api/hello/index | http://127.0.0.1:39217/laravel/asset/public/index.php/hello/index |

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
