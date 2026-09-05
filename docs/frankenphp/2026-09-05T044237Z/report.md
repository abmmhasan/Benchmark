## Sustainable ranking

| Rank | Target | Best stable RPM | Stable concurrency | Peak observed RPM | Peak concurrency | Peak stability | Duration s |
| --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | webrick-generated (5.1) | 664,917 | 250 | 664,917 | 250 | Stable | 245.8 |
| 2 | webrick-fused (5.1) | 638,073 | 250 | 638,073 | 250 | Stable | 245.8 |
| 3 | webrick-sharded (5.1) | 626,260 | 250 | 626,260 | 250 | Stable | 245.9 |
| 4 | infbyte (2.1.1) | 437,493 | 63 | 437,493 | 63 | Stable | 246.8 |
| 5 | infbyte-full (2.1.1) | 432,803 | 63 | 432,803 | 63 | Stable | 246.8 |
| 6 | laravel-api (v13.30.1) | 121,439 | 63 | 121,439 | 63 | Stable | 254.5 |
| 7 | laravel (v13.30.1) | 93,371 | 63 | 93,371 | 63 | Stable | 258.1 |

## Throughput — concurrency 2

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 201,926 | 0.18% | Stable | 201,741 | 202,111 |
| webrick-fused (5.1) | 199,748 | 0.71% | Stable | 199,037 | 200,459 |
| webrick-sharded (5.1) | 198,230 | 0.04% | Stable | 198,270 | 198,189 |
| infbyte (2.1.1) | 169,995 | 0.73% | Stable | 169,370 | 170,619 |
| infbyte-full (2.1.1) | 168,902 | 0.71% | Stable | 168,305 | 169,498 |
| laravel-api (v13.30.1) | 79,963 | 0.72% | Stable | 79,673 | 80,252 |
| laravel (v13.30.1) | 63,164 | 3.29% | Stable | 64,202 | 62,126 |

## Throughput — concurrency 63

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 616,946 | 0.07% | Stable | 616,718 | 617,174 |
| webrick-fused (5.1) | 598,928 | 0.24% | Stable | 598,219 | 599,636 |
| webrick-sharded (5.1) | 586,168 | 0.10% | Stable | 586,472 | 585,863 |
| infbyte (2.1.1) | 437,493 | 0.06% | Stable | 437,356 | 437,629 |
| infbyte-full (2.1.1) | 432,803 | 0.24% | Stable | 432,275 | 433,331 |
| laravel-api (v13.30.1) | 121,439 | 0.33% | Stable | 121,642 | 121,237 |
| laravel (v13.30.1) | 93,371 | 2.74% | Stable | 94,649 | 92,093 |

## Throughput — concurrency 125

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 657,528 | 2.06% | Stable | 650,764 | 664,292 |
| webrick-fused (5.1) | 631,071 | 1.34% | Stable | 626,844 | 635,298 |
| webrick-sharded (5.1) | 619,932 | 0.18% | Stable | 620,504 | 619,360 |
| infbyte (2.1.1) | 431,330 | 0.78% | Stable | 429,655 | 433,004 |
| infbyte-full (2.1.1) | 427,715 | 1.49% | Stable | 430,910 | 424,519 |
| laravel-api (v13.30.1) | 116,762 | 0.14% | Stable | 116,846 | 116,677 |
| laravel (v13.30.1) | 90,038 | 2.51% | Stable | 91,170 | 88,906 |

## Throughput — concurrency 250

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 664,917 | 1.95% | Stable | 658,443 | 671,391 |
| webrick-fused (5.1) | 638,073 | 1.71% | Stable | 632,613 | 643,533 |
| webrick-sharded (5.1) | 626,260 | 2.76% | Stable | 634,899 | 617,622 |
| infbyte (2.1.1) | 418,024 | 1.29% | Stable | 415,321 | 420,726 |
| infbyte-full (2.1.1) | 416,321 | 0.56% | Stable | 417,493 | 415,150 |
| laravel-api (v13.30.1) | 111,207 | 0.24% | Stable | 111,342 | 111,073 |
| laravel (v13.30.1) | 85,394 | 2.27% | Stable | 86,363 | 84,424 |

## Latency — serial

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-fused (5.1) | 0.48 | 0.57 | 0.63 | 0.00 | 0.47 |
| webrick-generated (5.1) | 0.48 | 0.57 | 0.64 | 0.00 | 0.47 |
| webrick-sharded (5.1) | 0.50 | 0.58 | 0.65 | 0.00 | 0.48 |
| infbyte-full (2.1.1) | 0.59 | 0.69 | 0.74 | 0.00 | 0.57 |
| infbyte (2.1.1) | 0.59 | 0.70 | 0.78 | 0.00 | 0.58 |
| laravel-api (v13.30.1) | 1.30 | 1.57 | 1.69 | 0.00 | 1.31 |
| laravel (v13.30.1) | 1.61 | 1.96 | 3.29 | 0.00 | 1.64 |

## Latency — concurrency 2

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 0.50 | 0.58 | 0.66 | 0.00 | 0.50 |
| webrick-fused (5.1) | 0.51 | 0.58 | 0.67 | 0.00 | 0.51 |
| webrick-sharded (5.1) | 0.51 | 0.59 | 0.69 | 0.00 | 0.51 |
| infbyte (2.1.1) | 0.61 | 0.70 | 0.85 | 0.00 | 0.61 |
| infbyte-full (2.1.1) | 0.61 | 0.71 | 0.84 | 0.00 | 0.61 |
| laravel-api (v13.30.1) | 1.39 | 1.60 | 2.17 | 0.00 | 1.40 |
| laravel (v13.30.1) | 1.75 | 2.06 | 5.05 | 0.00 | 1.79 |

## Latency — concurrency 63

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 5.13 | 8.88 | 11.34 | 0.00 | 5.32 |
| webrick-fused (5.1) | 5.35 | 9.13 | 11.63 | 0.00 | 5.53 |
| webrick-sharded (5.1) | 5.50 | 9.29 | 11.73 | 0.00 | 5.66 |
| infbyte (2.1.1) | 7.98 | 11.96 | 14.58 | 0.00 | 7.97 |
| infbyte-full (2.1.1) | 8.09 | 12.02 | 14.66 | 0.00 | 8.07 |
| laravel-api (v13.30.1) | 30.80 | 34.05 | 36.34 | 0.00 | 30.81 |
| laravel (v13.30.1) | 40.06 | 44.18 | 48.05 | 0.00 | 40.16 |

## Latency — concurrency 125

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 9.63 | 15.73 | 19.56 | 0.00 | 9.85 |
| webrick-fused (5.1) | 10.19 | 16.35 | 20.05 | 0.00 | 10.38 |
| webrick-sharded (5.1) | 10.49 | 16.54 | 20.24 | 0.00 | 10.64 |
| infbyte (2.1.1) | 16.40 | 21.93 | 25.49 | 0.00 | 16.29 |
| infbyte-full (2.1.1) | 16.65 | 22.09 | 25.86 | 0.00 | 16.47 |
| laravel-api (v13.30.1) | 63.80 | 68.19 | 71.84 | 0.01 | 63.70 |
| laravel (v13.30.1) | 82.89 | 88.88 | 95.93 | 0.01 | 82.70 |

## Latency — concurrency 250

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 19.45 | 28.39 | 33.76 | 0.01 | 19.55 |
| webrick-fused (5.1) | 20.63 | 29.29 | 34.44 | 0.01 | 20.64 |
| webrick-sharded (5.1) | 21.27 | 29.64 | 34.60 | 0.01 | 21.29 |
| infbyte (2.1.1) | 34.33 | 41.35 | 45.38 | 0.01 | 34.17 |
| infbyte-full (2.1.1) | 34.48 | 41.64 | 46.05 | 0.01 | 34.32 |
| laravel-api (v13.30.1) | 134.32 | 140.81 | 145.29 | 0.04 | 133.84 |
| laravel (v13.30.1) | 175.33 | 185.95 | 193.63 | 0.06 | 174.32 |

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
| webrick-generated (5.1) | 100965 | 100965 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 99875 | 99875 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 99116 | 99116 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 84999 | 84999 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 84452 | 84452 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 39982 | 39982 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 31584 | 31584 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 63

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 308519 | 308519 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 299500 | 299500 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 293130 | 293130 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 218795 | 218795 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 216427 | 216427 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 60772 | 60772 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 46735 | 46735 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 125

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 328851 | 328851 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 315623 | 315623 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 310060 | 310060 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 215745 | 215745 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 213945 | 213945 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 58485 | 58485 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 45124 | 45124 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 250

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 332611 | 332611 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 319241 | 319241 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 313275 | 313275 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 209219 | 209219 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 208329 | 208329 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 55804 | 55804 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 42903 | 42903 | 0.00% | 0 | 0 | 0 | 0 |

## Relative comparison

| Target | Peak throughput | Remote memory | Server time | Included files |
| --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 7.12× | 1.36× | 1.00× | 1.00× |
| webrick-fused (5.1) | 6.83× | 1.35× | 1.22× | 1.07× |
| webrick-sharded (5.1) | 6.71× | 1.19× | 1.34× | 1.09× |
| infbyte (2.1.1) | 4.69× | 1.00× | 6.50× | 1.64× |
| infbyte-full (2.1.1) | 4.64× | 3.28× | 6.52× | 1.82× |
| laravel-api (v13.30.1) | 1.30× | 3.40× | 12.98× | 6.25× |
| laravel (v13.30.1) | 1.00× | 20.09× | 30.51× | 6.91× |

## Resource telemetry

| Target | Samples | Avg CPU | Peak CPU | Avg MB | Peak MB | Remote MB |
| --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 0 | — | — | — | — | 1.74 |
| webrick-fused (5.1) | 0 | — | — | — | — | 1.73 |
| webrick-sharded (5.1) | 0 | — | — | — | — | 1.52 |
| infbyte (2.1.1) | 0 | — | — | — | — | 1.28 |
| infbyte-full (2.1.1) | 0 | — | — | — | — | 4.20 |
| laravel-api (v13.30.1) | 0 | — | — | — | — | 4.35 |
| laravel (v13.30.1) | 0 | — | — | — | — | 25.71 |

## Server response telemetry

| Target | Metric | Samples | Average | Minimum | Maximum |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | Included files | 1613923 | 87.99999 | 82.00000 | 88.00000 |
| webrick-generated (5.1) | Server execution ms | 1613923 | 0.02934 | 0.00500 | 12.72500 |
| webrick-fused (5.1) | Included files | 1558864 | 93.99997 | 88.00000 | 94.00000 |
| webrick-fused (5.1) | Server execution ms | 1558864 | 0.03592 | 0.00500 | 24.36500 |
| webrick-sharded (5.1) | Included files | 1530875 | 95.99996 | 89.00000 | 96.00000 |
| webrick-sharded (5.1) | Server execution ms | 1530875 | 0.03933 | 0.00600 | 12.85300 |
| infbyte (2.1.1) | Included files | 1467512 | 143.99992 | 136.00000 | 144.00000 |
| infbyte (2.1.1) | Server execution ms | 1467512 | 0.19057 | 0.03400 | 15.67000 |
| infbyte-full (2.1.1) | Included files | 1456304 | 159.99992 | 152.00000 | 160.00000 |
| infbyte-full (2.1.1) | Server execution ms | 1456304 | 0.19141 | 0.03400 | 22.15600 |
| laravel-api (v13.30.1) | Included files | 440083 | 549.99922 | 520.00000 | 550.00000 |
| laravel-api (v13.30.1) | Server execution ms | 440083 | 0.38070 | 0.14100 | 10.44000 |
| laravel (v13.30.1) | Included files | 342689 | 608.28592 | 533.00000 | 609.00000 |
| laravel (v13.30.1) | Server execution ms | 342689 | 0.89516 | 0.31400 | 38.16800 |

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

| Setting | webrick-generated (5.1) | webrick-fused (5.1) | webrick-sharded (5.1) | infbyte (2.1.1) | infbyte-full (2.1.1) | laravel-api (v13.30.1) | laravel (v13.30.1) |
| --- | --- | --- | --- | --- | --- | --- | --- |
| Url | http://127.0.0.1:35965/webrick-generated/asset/public/index.php/hello/index | http://127.0.0.1:35965/webrick-fused/asset/public/index.php/hello/index | http://127.0.0.1:35965/webrick-sharded/asset/public/index.php/hello/index | http://127.0.0.1:35965/infbyte/asset/public/index.php/hello/index | http://127.0.0.1:35965/infbyte-full/asset/public/index.php/hello/index | http://127.0.0.1:35965/laravel-api/asset/public/index.php/api/hello/index | http://127.0.0.1:35965/laravel/asset/public/index.php/hello/index |

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
