## Sustainable ranking

| Rank | Target | Best stable RPM | Stable concurrency | Peak observed RPM | Peak concurrency | Peak stability | Duration s |
| --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | webrick-fused (5.1) | 280,491 | 63 | 280,491 | 63 | Stable | 247.3 |
| 2 | webrick-generated (5.1) | 279,455 | 63 | 279,455 | 63 | Stable | 247.3 |
| 3 | webrick-sharded (5.1) | 278,965 | 63 | 278,965 | 63 | Stable | 247.3 |
| 4 | infbyte (2.1.1) | 238,279 | 63 | 238,279 | 63 | Stable | 248.3 |
| 5 | infbyte-full (2.1.1) | 237,378 | 63 | 237,378 | 63 | Stable | 248.4 |
| 6 | laravel-api (v13.30.1) | 106,737 | 63 | 106,737 | 63 | Stable | 255.3 |
| 7 | laravel (v13.30.1) | 88,898 | 63 | 88,898 | 63 | Stable | 258.1 |

## Throughput — concurrency 2

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 159,371 | 1.38% | Stable | 158,271 | 160,472 |
| webrick-sharded (5.1) | 158,421 | 1.21% | Stable | 157,465 | 159,376 |
| webrick-fused (5.1) | 158,014 | 1.45% | Stable | 156,867 | 159,160 |
| infbyte (2.1.1) | 139,304 | 2.31% | Stable | 137,696 | 140,911 |
| infbyte-full (2.1.1) | 138,922 | 0.42% | Stable | 138,632 | 139,212 |
| laravel-api (v13.30.1) | 71,115 | 1.96% | Stable | 70,417 | 71,813 |
| laravel (v13.30.1) | 59,856 | 2.64% | Stable | 60,644 | 59,067 |

## Throughput — concurrency 63

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-fused (5.1) | 280,491 | 1.93% | Stable | 277,782 | 283,200 |
| webrick-generated (5.1) | 279,455 | 0.48% | Stable | 280,127 | 278,784 |
| webrick-sharded (5.1) | 278,965 | 2.00% | Stable | 276,176 | 281,753 |
| infbyte (2.1.1) | 238,279 | 1.14% | Stable | 236,916 | 239,642 |
| infbyte-full (2.1.1) | 237,378 | 1.42% | Stable | 239,069 | 235,687 |
| laravel-api (v13.30.1) | 106,737 | 1.16% | Stable | 106,116 | 107,358 |
| laravel (v13.30.1) | 88,898 | 1.13% | Stable | 89,402 | 88,393 |

## Throughput — concurrency 125

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-fused (5.1) | 273,718 | 1.79% | Stable | 271,269 | 276,167 |
| webrick-generated (5.1) | 272,757 | 1.54% | Stable | 270,657 | 274,858 |
| webrick-sharded (5.1) | 272,135 | 2.80% | Stable | 268,331 | 275,938 |
| infbyte-full (2.1.1) | 233,001 | 1.03% | Stable | 234,202 | 231,800 |
| infbyte (2.1.1) | 230,945 | 2.82% | Stable | 227,683 | 234,207 |
| laravel-api (v13.30.1) | 102,812 | 1.00% | Stable | 102,300 | 103,325 |
| laravel (v13.30.1) | 85,534 | 1.22% | Stable | 86,054 | 85,013 |

## Throughput — concurrency 250

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 267,581 | 1.80% | Stable | 265,169 | 269,994 |
| webrick-fused (5.1) | 266,705 | 1.16% | Stable | 265,162 | 268,248 |
| webrick-sharded (5.1) | 264,027 | 2.56% | Stable | 260,643 | 267,411 |
| infbyte (2.1.1) | 227,167 | 0.98% | Stable | 226,057 | 228,276 |
| infbyte-full (2.1.1) | 225,812 | 0.73% | Stable | 226,636 | 224,988 |
| laravel-api (v13.30.1) | 98,091 | 0.49% | Stable | 97,850 | 98,331 |
| laravel (v13.30.1) | 81,284 | 0.55% | Stable | 81,505 | 81,062 |

## Latency — serial

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-sharded (5.1) | 0.64 | 0.74 | 0.79 | 0.00 | 0.63 |
| webrick-generated (5.1) | 0.64 | 0.74 | 0.80 | 0.00 | 0.63 |
| webrick-fused (5.1) | 0.65 | 0.75 | 0.80 | 0.00 | 0.64 |
| infbyte (2.1.1) | 0.73 | 0.86 | 0.93 | 0.00 | 0.73 |
| infbyte-full (2.1.1) | 0.74 | 0.88 | 0.93 | 0.00 | 0.74 |
| laravel-api (v13.30.1) | 1.40 | 1.52 | 1.61 | 0.00 | 1.39 |
| laravel (v13.30.1) | 1.66 | 1.80 | 2.83 | 0.00 | 1.65 |

## Latency — concurrency 2

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 0.67 | 0.79 | 0.91 | 0.00 | 0.67 |
| webrick-sharded (5.1) | 0.67 | 0.80 | 0.90 | 0.00 | 0.67 |
| webrick-fused (5.1) | 0.67 | 0.80 | 0.92 | 0.00 | 0.67 |
| infbyte (2.1.1) | 0.76 | 0.94 | 1.05 | 0.00 | 0.77 |
| infbyte-full (2.1.1) | 0.77 | 0.94 | 1.08 | 0.00 | 0.78 |
| laravel-api (v13.30.1) | 1.54 | 1.88 | 2.18 | 0.00 | 1.58 |
| laravel (v13.30.1) | 1.81 | 2.25 | 4.70 | 0.00 | 1.90 |

## Latency — concurrency 63

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-fused (5.1) | 13.15 | 14.97 | 16.14 | 0.00 | 13.19 |
| webrick-generated (5.1) | 13.18 | 15.10 | 16.83 | 0.00 | 13.24 |
| webrick-sharded (5.1) | 13.22 | 15.05 | 16.16 | 0.00 | 13.26 |
| infbyte (2.1.1) | 15.54 | 17.39 | 18.56 | 0.00 | 15.57 |
| infbyte-full (2.1.1) | 15.61 | 17.46 | 18.65 | 0.00 | 15.63 |
| laravel-api (v13.30.1) | 35.07 | 37.93 | 39.77 | 0.00 | 35.10 |
| laravel (v13.30.1) | 42.13 | 45.37 | 47.73 | 0.00 | 42.21 |

## Latency — concurrency 125

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-fused (5.1) | 26.90 | 29.48 | 30.95 | 0.00 | 26.98 |
| webrick-generated (5.1) | 26.97 | 29.63 | 31.47 | 0.00 | 27.08 |
| webrick-sharded (5.1) | 27.08 | 29.55 | 30.86 | 0.00 | 27.14 |
| infbyte (2.1.1) | 31.69 | 37.45 | 40.44 | 0.00 | 32.05 |
| infbyte-full (2.1.1) | 31.71 | 34.15 | 35.53 | 0.00 | 31.75 |
| laravel-api (v13.30.1) | 72.50 | 76.58 | 79.73 | 0.01 | 72.43 |
| laravel (v13.30.1) | 87.15 | 92.12 | 96.49 | 0.01 | 87.14 |

## Latency — concurrency 250

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 55.14 | 58.89 | 60.74 | 0.01 | 55.28 |
| webrick-fused (5.1) | 55.34 | 59.15 | 60.73 | 0.01 | 55.45 |
| webrick-sharded (5.1) | 55.91 | 59.57 | 61.21 | 0.01 | 56.03 |
| infbyte (2.1.1) | 65.12 | 69.01 | 70.78 | 0.02 | 65.24 |
| infbyte-full (2.1.1) | 65.54 | 69.38 | 71.09 | 0.02 | 65.62 |
| laravel-api (v13.30.1) | 152.50 | 159.95 | 166.69 | 0.04 | 151.75 |
| laravel (v13.30.1) | 184.42 | 194.34 | 208.42 | 0.04 | 183.14 |

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
| webrick-generated (5.1) | 79687 | 79687 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 79212 | 79212 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 79008 | 79008 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 69653 | 69653 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 69463 | 69463 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 35559 | 35559 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 29929 | 29929 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 63

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-fused (5.1) | 140299 | 140299 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-generated (5.1) | 139782 | 139782 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 139536 | 139536 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 119194 | 119194 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 118741 | 118741 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 53425 | 53425 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 44507 | 44507 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 125

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-fused (5.1) | 136962 | 136962 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-generated (5.1) | 136488 | 136488 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 136171 | 136171 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 116609 | 116609 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 115576 | 115576 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 51515 | 51515 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 42880 | 42880 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 250

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 133999 | 133999 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 133563 | 133563 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 132227 | 132227 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 113793 | 113793 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 113121 | 113121 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 49259 | 49259 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 40841 | 40841 | 0.00% | 0 | 0 | 0 | 0 |

## Relative comparison

| Target | Peak throughput | Remote memory | Server time | Included files |
| --- | --- | --- | --- | --- |
| webrick-fused (5.1) | 3.16× | 1.01× | 1.21× | 1.04× |
| webrick-generated (5.1) | 3.14× | 1.00× | 1.00× | 1.00× |
| webrick-sharded (5.1) | 3.14× | 1.04× | 1.32× | 1.05× |
| infbyte (2.1.1) | 2.68× | 1.15× | 6.09× | 1.35× |
| infbyte-full (2.1.1) | 2.67× | 2.16× | 6.10× | 1.45× |
| laravel-api (v13.30.1) | 1.20× | 3.20× | 11.36× | 4.00× |
| laravel (v13.30.1) | 1.00× | 14.33× | 26.51× | 4.35× |

## Resource telemetry

| Target | Samples | Avg CPU | Peak CPU | Avg MB | Peak MB | Remote MB |
| --- | --- | --- | --- | --- | --- | --- |
| webrick-fused (5.1) | 0 | — | — | — | — | 1.97 |
| webrick-generated (5.1) | 0 | — | — | — | — | 1.95 |
| webrick-sharded (5.1) | 0 | — | — | — | — | 2.02 |
| infbyte (2.1.1) | 0 | — | — | — | — | 2.25 |
| infbyte-full (2.1.1) | 0 | — | — | — | — | 4.21 |
| laravel-api (v13.30.1) | 0 | — | — | — | — | 6.24 |
| laravel (v13.30.1) | 0 | — | — | — | — | 27.94 |

## Server response telemetry

| Target | Metric | Samples | Average | Minimum | Maximum |
| --- | --- | --- | --- | --- | --- |
| webrick-fused (5.1) | Included files | 742253 | 169.00000 | 169.00000 | 169.00000 |
| webrick-fused (5.1) | Server execution ms | 742253 | 0.03261 | 0.00700 | 2.81500 |
| webrick-generated (5.1) | Included files | 742439 | 163.00000 | 163.00000 | 163.00000 |
| webrick-generated (5.1) | Server execution ms | 742439 | 0.02694 | 0.00700 | 3.55600 |
| webrick-sharded (5.1) | Included files | 738225 | 171.00000 | 171.00000 | 171.00000 |
| webrick-sharded (5.1) | Server execution ms | 738225 | 0.03559 | 0.00800 | 3.42400 |
| infbyte (2.1.1) | Included files | 846430 | 220.00000 | 220.00000 | 220.00000 |
| infbyte (2.1.1) | Server execution ms | 846430 | 0.16397 | 0.06100 | 3.99000 |
| infbyte-full (2.1.1) | Included files | 845865 | 236.00000 | 236.00000 | 236.00000 |
| infbyte-full (2.1.1) | Server execution ms | 845865 | 0.16442 | 0.05400 | 6.12600 |
| laravel-api (v13.30.1) | Included files | 389516 | 652.00000 | 652.00000 | 652.00000 |
| laravel-api (v13.30.1) | Server execution ms | 389516 | 0.30597 | 0.13900 | 10.43300 |
| laravel (v13.30.1) | Included files | 326312 | 708.25148 | 708.00000 | 709.00000 |
| laravel (v13.30.1) | Server execution ms | 326312 | 0.71417 | 0.29500 | 27.55300 |

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

| Setting | webrick-fused (5.1) | webrick-generated (5.1) | webrick-sharded (5.1) | infbyte (2.1.1) | infbyte-full (2.1.1) | laravel-api (v13.30.1) | laravel (v13.30.1) |
| --- | --- | --- | --- | --- | --- | --- | --- |
| Url | http://127.0.0.1:40827/webrick-fused/asset/public/index.php/hello/index | http://127.0.0.1:40827/webrick-generated/asset/public/index.php/hello/index | http://127.0.0.1:40827/webrick-sharded/asset/public/index.php/hello/index | http://127.0.0.1:40827/infbyte/asset/public/index.php/hello/index | http://127.0.0.1:40827/infbyte-full/asset/public/index.php/hello/index | http://127.0.0.1:40827/laravel-api/asset/public/index.php/api/hello/index | http://127.0.0.1:40827/laravel/asset/public/index.php/hello/index |

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
