## Overall ranking

| Rank | Target | Ranked RPM | Ranked concurrency | Ranking stability | Peak observed RPM | Peak concurrency | Peak stability | Duration s |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | webrick-generated (5.1) | 787,761 | 250 | Stable | 787,761 | 250 | Stable | 245.4 |
| 2 | webrick-fused (5.1) | 752,872 | 250 | Stable | 752,872 | 250 | Stable | 245.4 |
| 3 | webrick-sharded (5.1) | 742,091 | 250 | Stable | 742,091 | 250 | Stable | 245.5 |
| 4 | infbyte (2.1.1) | 505,173 | 125 | Stable | 505,173 | 125 | Stable | 246.3 |
| 5 | infbyte-full (2.1.1) | 501,950 | 125 | Stable | 501,950 | 125 | Stable | 246.3 |
| 6 | laravel-api (v13.31.0) | 139,746 | 63 | Stable | 139,746 | 63 | Stable | 253.1 |
| 7 | laravel (v13.31.0) | 107,282 | 63 | Stable | 107,282 | 63 | Stable | 256.1 |

## Throughput — concurrency 2

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 223,352 | 0.40% | Stable | 223,799 | 222,905 |
| webrick-fused (5.1) | 220,185 | 0.17% | Stable | 220,375 | 219,994 |
| webrick-sharded (5.1) | 218,695 | 0.05% | Stable | 218,638 | 218,753 |
| infbyte (2.1.1) | 188,093 | 0.26% | Stable | 187,846 | 188,339 |
| infbyte-full (2.1.1) | 187,352 | 0.47% | Stable | 186,913 | 187,791 |
| laravel-api (v13.31.0) | 89,200 | 0.96% | Stable | 88,771 | 89,629 |
| laravel (v13.31.0) | 72,232 | 0.02% | Stable | 72,240 | 72,224 |

## Throughput — concurrency 63

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 704,608 | 0.40% | Stable | 706,011 | 703,205 |
| webrick-fused (5.1) | 686,369 | 0.60% | Stable | 688,422 | 684,316 |
| webrick-sharded (5.1) | 673,305 | 0.39% | Stable | 671,976 | 674,634 |
| infbyte (2.1.1) | 501,361 | 0.01% | Stable | 501,339 | 501,383 |
| infbyte-full (2.1.1) | 497,986 | 0.16% | Stable | 497,593 | 498,380 |
| laravel-api (v13.31.0) | 139,746 | 0.20% | Stable | 139,606 | 139,886 |
| laravel (v13.31.0) | 107,282 | 2.51% | Stable | 108,628 | 105,936 |

## Throughput — concurrency 125

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 753,773 | 2.19% | Stable | 745,507 | 762,039 |
| webrick-fused (5.1) | 734,813 | 0.76% | Stable | 732,006 | 737,619 |
| webrick-sharded (5.1) | 721,555 | 0.10% | Stable | 721,208 | 721,902 |
| infbyte (2.1.1) | 505,173 | 0.50% | Stable | 503,919 | 506,427 |
| infbyte-full (2.1.1) | 501,950 | 0.02% | Stable | 502,009 | 501,892 |
| laravel-api (v13.31.0) | 133,600 | 0.12% | Stable | 133,523 | 133,678 |
| laravel (v13.31.0) | 102,173 | 2.75% | Stable | 103,576 | 100,770 |

## Throughput — concurrency 250

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 787,761 | 0.01% | Stable | 787,796 | 787,725 |
| webrick-fused (5.1) | 752,872 | 0.80% | Stable | 749,851 | 755,893 |
| webrick-sharded (5.1) | 742,091 | 0.72% | Stable | 739,406 | 744,777 |
| infbyte (2.1.1) | 495,699 | 0.13% | Stable | 495,374 | 496,023 |
| infbyte-full (2.1.1) | 488,561 | 0.09% | Stable | 488,339 | 488,784 |
| laravel-api (v13.31.0) | 126,592 | 0.20% | Stable | 126,464 | 126,720 |
| laravel (v13.31.0) | 96,333 | 1.12% | Stable | 96,874 | 95,793 |

## Latency — serial

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 0.45 | 0.53 | 0.58 | 0.00 | 0.44 |
| webrick-fused (5.1) | 0.45 | 0.53 | 0.59 | 0.00 | 0.44 |
| webrick-sharded (5.1) | 0.46 | 0.55 | 0.60 | 0.00 | 0.45 |
| infbyte-full (2.1.1) | 0.54 | 0.64 | 0.71 | 0.00 | 0.53 |
| infbyte (2.1.1) | 0.54 | 0.65 | 0.72 | 0.00 | 0.53 |
| laravel-api (v13.31.0) | 1.18 | 1.44 | 1.52 | 0.00 | 1.19 |
| laravel (v13.31.0) | 1.42 | 1.75 | 3.31 | 0.00 | 1.47 |

## Latency — concurrency 2

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 0.46 | 0.52 | 0.60 | 0.00 | 0.45 |
| webrick-fused (5.1) | 0.46 | 0.53 | 0.61 | 0.00 | 0.46 |
| webrick-sharded (5.1) | 0.46 | 0.54 | 0.63 | 0.00 | 0.46 |
| infbyte-full (2.1.1) | 0.55 | 0.63 | 0.75 | 0.00 | 0.55 |
| infbyte (2.1.1) | 0.55 | 0.64 | 0.77 | 0.00 | 0.55 |
| laravel-api (v13.31.0) | 1.25 | 1.42 | 2.01 | 0.00 | 1.26 |
| laravel (v13.31.0) | 1.54 | 1.80 | 2.60 | 0.00 | 1.56 |

## Latency — concurrency 63

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 4.43 | 7.93 | 10.26 | 0.00 | 4.64 |
| webrick-fused (5.1) | 4.61 | 8.09 | 10.39 | 0.00 | 4.80 |
| webrick-sharded (5.1) | 4.74 | 8.20 | 10.45 | 0.00 | 4.92 |
| infbyte (2.1.1) | 6.95 | 10.59 | 12.89 | 0.00 | 6.95 |
| infbyte-full (2.1.1) | 7.00 | 10.64 | 12.99 | 0.00 | 7.00 |
| laravel-api (v13.31.0) | 26.78 | 29.78 | 31.70 | 0.00 | 26.78 |
| laravel (v13.31.0) | 34.81 | 38.81 | 42.66 | 0.00 | 34.96 |

## Latency — concurrency 125

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 8.20 | 14.36 | 18.42 | 0.00 | 8.54 |
| webrick-fused (5.1) | 8.59 | 14.33 | 17.91 | 0.00 | 8.83 |
| webrick-sharded (5.1) | 8.85 | 14.51 | 17.91 | 0.00 | 9.05 |
| infbyte (2.1.1) | 13.97 | 19.27 | 22.79 | 0.00 | 13.85 |
| infbyte-full (2.1.1) | 14.09 | 19.27 | 22.53 | 0.00 | 13.97 |
| laravel-api (v13.31.0) | 55.76 | 59.66 | 62.40 | 0.01 | 55.70 |
| laravel (v13.31.0) | 72.87 | 78.73 | 84.03 | 0.01 | 72.90 |

## Latency — concurrency 250

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 16.02 | 24.54 | 29.77 | 0.00 | 16.22 |
| webrick-fused (5.1) | 17.17 | 25.59 | 30.89 | 0.00 | 17.29 |
| webrick-sharded (5.1) | 17.44 | 25.74 | 30.89 | 0.01 | 17.57 |
| infbyte (2.1.1) | 28.84 | 35.68 | 39.50 | 0.01 | 28.65 |
| infbyte-full (2.1.1) | 29.29 | 36.10 | 39.87 | 0.01 | 29.13 |
| laravel-api (v13.31.0) | 118.07 | 123.81 | 127.99 | 0.03 | 117.57 |
| laravel (v13.31.0) | 154.65 | 165.55 | 179.18 | 0.04 | 154.58 |

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
| webrick-generated (5.1) | 111678 | 111678 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 110094 | 110094 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 109349 | 109349 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 94048 | 94048 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 93678 | 93678 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.31.0) | 44601 | 44601 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.31.0) | 36117 | 36117 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 63

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 352348 | 352348 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 343232 | 343232 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 336702 | 336702 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 250718 | 250718 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 249037 | 249037 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.31.0) | 69924 | 69924 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.31.0) | 53694 | 53694 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 125

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 376974 | 376974 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 367489 | 367489 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 360846 | 360846 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 252679 | 252679 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 251066 | 251066 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.31.0) | 66905 | 66905 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.31.0) | 51204 | 51204 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 250

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 394105 | 394105 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 376619 | 376619 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 371238 | 371238 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 248034 | 248034 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 244462 | 244462 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.31.0) | 63502 | 63502 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.31.0) | 48371 | 48371 | 0.00% | 0 | 0 | 0 | 0 |

## Relative comparison

| Target | Peak throughput | Remote memory | Server time | Included files |
| --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 7.34× | 1.00× | 1.00× | 1.00× |
| webrick-fused (5.1) | 7.02× | 1.12× | 1.21× | 1.07× |
| webrick-sharded (5.1) | 6.92× | 1.12× | 1.34× | 1.09× |
| infbyte (2.1.1) | 4.71× | 1.19× | 6.50× | 1.64× |
| infbyte-full (2.1.1) | 4.68× | 2.73× | 6.56× | 1.82× |
| laravel-api (v13.31.0) | 1.30× | 2.68× | 13.15× | 6.25× |
| laravel (v13.31.0) | 1.00× | 16.37× | 31.27× | 6.91× |

## Resource telemetry

| Target | Samples | Avg CPU | Peak CPU | Avg MB | Peak MB | Remote MB |
| --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 0 | — | — | — | — | 1.55 |
| webrick-fused (5.1) | 0 | — | — | — | — | 1.73 |
| webrick-sharded (5.1) | 0 | — | — | — | — | 1.74 |
| infbyte (2.1.1) | 0 | — | — | — | — | 1.85 |
| infbyte-full (2.1.1) | 0 | — | — | — | — | 4.23 |
| laravel-api (v13.31.0) | 0 | — | — | — | — | 4.15 |
| laravel (v13.31.0) | 0 | — | — | — | — | 25.37 |

## Server response telemetry

| Target | Metric | Samples | Average | Minimum | Maximum |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | Included files | 1860160 | 87.99999 | 82.00000 | 88.00000 |
| webrick-generated (5.1) | Server execution ms | 1860160 | 0.02523 | 0.00400 | 13.87300 |
| webrick-fused (5.1) | Included files | 1803659 | 93.99998 | 88.00000 | 94.00000 |
| webrick-fused (5.1) | Server execution ms | 1803659 | 0.03064 | 0.00400 | 13.95800 |
| webrick-sharded (5.1) | Included files | 1774704 | 95.99997 | 89.00000 | 96.00000 |
| webrick-sharded (5.1) | Server execution ms | 1774704 | 0.03377 | 0.00500 | 16.26500 |
| infbyte (2.1.1) | Included files | 1700955 | 143.99996 | 136.00000 | 144.00000 |
| infbyte (2.1.1) | Server execution ms | 1700955 | 0.16388 | 0.02800 | 18.19100 |
| infbyte-full (2.1.1) | Included files | 1686485 | 159.99996 | 151.00000 | 160.00000 |
| infbyte-full (2.1.1) | Server execution ms | 1686485 | 0.16552 | 0.02800 | 18.07500 |
| laravel-api (v13.31.0) | Included files | 499864 | 549.99917 | 521.00000 | 550.00000 |
| laravel-api (v13.31.0) | Server execution ms | 499864 | 0.33184 | 0.12700 | 8.15500 |
| laravel (v13.31.0) | Included files | 388770 | 608.25239 | 533.00000 | 609.00000 |
| laravel (v13.31.0) | Server execution ms | 388770 | 0.78894 | 0.27100 | 37.15100 |

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

| Setting | webrick-generated (5.1) | webrick-fused (5.1) | webrick-sharded (5.1) | infbyte (2.1.1) | infbyte-full (2.1.1) | laravel-api (v13.31.0) | laravel (v13.31.0) |
| --- | --- | --- | --- | --- | --- | --- | --- |
| Url | http://127.0.0.1:40591/webrick-generated/asset/public/index.php/hello/index | http://127.0.0.1:40591/webrick-fused/asset/public/index.php/hello/index | http://127.0.0.1:40591/webrick-sharded/asset/public/index.php/hello/index | http://127.0.0.1:40591/infbyte/asset/public/index.php/hello/index | http://127.0.0.1:40591/infbyte-full/asset/public/index.php/hello/index | http://127.0.0.1:40591/laravel-api/asset/public/index.php/api/hello/index | http://127.0.0.1:40591/laravel/asset/public/index.php/hello/index |

## Target-server environment

These settings come from the PHP web runtime that received benchmark requests.

| Setting | Value |
| --- | --- |
| PHP version | 8.5.9 |
| PHP SAPI | frankenphp |
| Loaded php.ini | /usr/local/etc/php/php.ini |
| Benchmark environment profile | frankenphp-production |
| OPcache extension loaded | Yes |
| OPcache enabled for web requests | Yes |
