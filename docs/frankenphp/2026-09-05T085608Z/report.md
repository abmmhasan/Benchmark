## Sustainable ranking

| Rank | Target | Best stable RPM | Stable concurrency | Peak observed RPM | Peak concurrency | Peak stability | Duration s |
| --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | webrick-generated (5.1) | 419,445 | 250 | 419,445 | 250 | Stable | 246.3 |
| 2 | webrick-fused (5.1) | 416,160 | 125 | 416,160 | 125 | Stable | 246.3 |
| 3 | webrick-sharded (5.1) | 413,249 | 125 | 413,249 | 125 | Stable | 246.3 |
| 4 | infbyte-full (2.1.1) | 335,660 | 63 | 335,660 | 63 | Stable | 247.0 |
| 5 | infbyte (2.1.1) | 329,606 | 125 | 329,606 | 125 | Stable | 247.2 |
| 6 | laravel-api (v13.30.1) | 97,113 | 63 | 97,113 | 63 | Stable | 255.6 |
| 7 | laravel (v13.30.1) | 78,251 | 63 | 78,251 | 63 | Stable | 258.8 |

## Throughput — concurrency 2

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 171,398 | 1.31% | Stable | 172,523 | 170,274 |
| webrick-sharded (5.1) | 170,416 | 0.69% | Stable | 171,001 | 169,831 |
| webrick-fused (5.1) | 170,196 | 2.41% | Stable | 172,249 | 168,143 |
| infbyte-full (2.1.1) | 154,122 | 1.01% | Stable | 153,343 | 154,901 |
| infbyte (2.1.1) | 151,480 | 0.58% | Stable | 151,044 | 151,917 |
| laravel-api (v13.30.1) | 72,139 | 2.28% | Stable | 71,316 | 72,963 |
| laravel (v13.30.1) | 56,291 | 10.12% | Unstable | 59,139 | 53,443 |

## Throughput — concurrency 63

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 410,337 | 4.00% | Stable | 418,545 | 402,130 |
| webrick-fused (5.1) | 409,921 | 1.54% | Stable | 413,083 | 406,760 |
| webrick-sharded (5.1) | 408,057 | 0.35% | Stable | 408,768 | 407,346 |
| infbyte-full (2.1.1) | 335,660 | 0.10% | Stable | 335,484 | 335,836 |
| infbyte (2.1.1) | 325,987 | 1.81% | Stable | 328,945 | 323,029 |
| laravel-api (v13.30.1) | 97,113 | 0.95% | Stable | 96,652 | 97,575 |
| laravel (v13.30.1) | 78,251 | 1.81% | Stable | 78,958 | 77,545 |

## Throughput — concurrency 125

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 418,634 | 5.99% | Stable | 431,181 | 406,087 |
| webrick-fused (5.1) | 416,160 | 4.49% | Stable | 425,502 | 406,818 |
| webrick-sharded (5.1) | 413,249 | 3.41% | Stable | 420,293 | 406,205 |
| infbyte-full (2.1.1) | 334,555 | 0.33% | Stable | 335,109 | 334,000 |
| infbyte (2.1.1) | 329,606 | 0.63% | Stable | 330,643 | 328,570 |
| laravel-api (v13.30.1) | 94,603 | 1.95% | Stable | 93,681 | 95,526 |
| laravel (v13.30.1) | 75,427 | 2.25% | Stable | 76,275 | 74,580 |

## Throughput — concurrency 250

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 419,445 | 4.90% | Stable | 429,725 | 409,165 |
| webrick-fused (5.1) | 411,875 | 2.37% | Stable | 416,757 | 406,993 |
| webrick-sharded (5.1) | 404,988 | 4.15% | Stable | 413,400 | 396,576 |
| infbyte-full (2.1.1) | 320,745 | 0.07% | Stable | 320,638 | 320,852 |
| infbyte (2.1.1) | 314,647 | 2.99% | Stable | 319,352 | 309,942 |
| laravel-api (v13.30.1) | 91,028 | 0.28% | Stable | 91,156 | 90,901 |
| laravel (v13.30.1) | 70,408 | 4.26% | Stable | 71,908 | 68,909 |

## Latency — serial

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-sharded (5.1) | 0.55 | 0.59 | 0.62 | 0.00 | 0.53 |
| webrick-fused (5.1) | 0.55 | 0.60 | 0.65 | 0.00 | 0.54 |
| webrick-generated (5.1) | 0.55 | 0.61 | 0.68 | 0.00 | 0.54 |
| infbyte-full (2.1.1) | 0.61 | 0.68 | 0.73 | 0.00 | 0.60 |
| infbyte (2.1.1) | 0.63 | 0.71 | 0.89 | 0.00 | 0.62 |
| laravel-api (v13.30.1) | 1.40 | 1.58 | 1.70 | 0.00 | 1.42 |
| laravel (v13.30.1) | 1.67 | 1.92 | 3.60 | 0.00 | 1.72 |

## Latency — concurrency 2

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 0.63 | 0.73 | 0.81 | 0.00 | 0.63 |
| webrick-fused (5.1) | 0.63 | 0.74 | 0.83 | 0.00 | 0.63 |
| webrick-sharded (5.1) | 0.63 | 0.74 | 0.84 | 0.00 | 0.63 |
| infbyte-full (2.1.1) | 0.70 | 0.82 | 0.94 | 0.00 | 0.70 |
| infbyte (2.1.1) | 0.71 | 0.85 | 1.10 | 0.00 | 0.71 |
| laravel-api (v13.30.1) | 1.59 | 1.77 | 2.25 | 0.00 | 1.59 |
| laravel (v13.30.1) | 1.96 | 2.31 | 7.18 | 0.00 | 2.04 |

## Latency — concurrency 63

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 7.62 | 12.97 | 16.23 | 0.00 | 7.86 |
| webrick-fused (5.1) | 7.66 | 12.92 | 16.29 | 0.00 | 7.90 |
| webrick-sharded (5.1) | 7.71 | 12.98 | 16.21 | 0.00 | 7.93 |
| infbyte-full (2.1.1) | 10.03 | 14.98 | 18.31 | 0.00 | 10.08 |
| infbyte (2.1.1) | 10.35 | 15.52 | 19.03 | 0.00 | 10.42 |
| laravel-api (v13.30.1) | 38.43 | 42.17 | 45.29 | 0.01 | 38.55 |
| laravel (v13.30.1) | 47.80 | 51.87 | 55.36 | 0.01 | 47.94 |

## Latency — concurrency 125

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 15.14 | 23.32 | 28.32 | 0.01 | 15.32 |
| webrick-fused (5.1) | 15.37 | 23.33 | 28.47 | 0.00 | 15.49 |
| webrick-sharded (5.1) | 15.56 | 23.38 | 28.28 | 0.01 | 15.66 |
| infbyte-full (2.1.1) | 20.61 | 26.74 | 30.92 | 0.01 | 20.42 |
| infbyte (2.1.1) | 20.98 | 27.31 | 31.81 | 0.01 | 20.78 |
| laravel-api (v13.30.1) | 78.69 | 83.36 | 87.59 | 0.02 | 78.58 |
| laravel (v13.30.1) | 98.75 | 104.99 | 114.01 | 0.03 | 98.71 |

## Latency — concurrency 250

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 31.15 | 41.48 | 48.18 | 0.02 | 30.78 |
| webrick-fused (5.1) | 32.08 | 42.44 | 50.66 | 0.02 | 31.92 |
| webrick-sharded (5.1) | 32.87 | 43.01 | 49.68 | 0.02 | 32.73 |
| infbyte-full (2.1.1) | 44.35 | 51.75 | 56.42 | 0.02 | 44.02 |
| infbyte (2.1.1) | 45.22 | 52.96 | 58.07 | 0.03 | 44.88 |
| laravel-api (v13.30.1) | 163.69 | 170.90 | 178.37 | 0.10 | 163.30 |
| laravel (v13.30.1) | 211.76 | 225.13 | 235.67 | 0.13 | 211.21 |

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
| webrick-generated (5.1) | 85701 | 85701 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 85210 | 85210 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 85100 | 85100 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 77062 | 77062 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 75741 | 75741 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 36071 | 36071 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 28147 | 28147 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 63

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 205207 | 205207 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 205011 | 205011 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 204082 | 204082 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 167880 | 167880 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 163032 | 163032 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 48607 | 48607 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 39180 | 39180 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 125

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 209386 | 209386 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 208170 | 208170 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 206705 | 206705 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 167370 | 167370 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 164891 | 164891 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 47404 | 47404 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 37820 | 37820 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 250

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 209902 | 209902 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 206119 | 206119 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 202684 | 202684 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 160546 | 160546 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 157497 | 157497 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 45725 | 45725 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 35415 | 35415 | 0.00% | 0 | 0 | 0 | 0 |

## Relative comparison

| Target | Peak throughput | Remote memory | Server time | Included files |
| --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 5.36× | 1.01× | 1.00× | 1.00× |
| webrick-fused (5.1) | 5.32× | 1.00× | 1.19× | 1.07× |
| webrick-sharded (5.1) | 5.28× | 1.00× | 1.28× | 1.09× |
| infbyte-full (2.1.1) | 4.29× | 2.43× | 6.03× | 1.82× |
| infbyte (2.1.1) | 4.21× | 1.08× | 6.06× | 1.64× |
| laravel-api (v13.30.1) | 1.24× | 2.69× | 11.15× | 6.25× |
| laravel (v13.30.1) | 1.00× | 13.82× | 25.85× | 6.91× |

## Resource telemetry

| Target | Samples | Avg CPU | Peak CPU | Avg MB | Peak MB | Remote MB |
| --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 0 | — | — | — | — | 1.74 |
| webrick-fused (5.1) | 0 | — | — | — | — | 1.73 |
| webrick-sharded (5.1) | 0 | — | — | — | — | 1.73 |
| infbyte-full (2.1.1) | 0 | — | — | — | — | 4.20 |
| infbyte (2.1.1) | 0 | — | — | — | — | 1.86 |
| laravel-api (v13.30.1) | 0 | — | — | — | — | 4.65 |
| laravel (v13.30.1) | 0 | — | — | — | — | 23.91 |

## Server response telemetry

| Target | Metric | Samples | Average | Minimum | Maximum |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | Included files | 1072798 | 87.99997 | 82.00000 | 88.00000 |
| webrick-generated (5.1) | Server execution ms | 1072798 | 0.03880 | 0.00700 | 14.73600 |
| webrick-fused (5.1) | Included files | 1064105 | 93.99995 | 88.00000 | 94.00000 |
| webrick-fused (5.1) | Server execution ms | 1064105 | 0.04613 | 0.00800 | 24.18000 |
| webrick-sharded (5.1) | Included files | 1055527 | 95.99997 | 89.00000 | 96.00000 |
| webrick-sharded (5.1) | Server execution ms | 1055527 | 0.04969 | 0.00800 | 16.22800 |
| infbyte-full (2.1.1) | Included files | 1155716 | 159.99992 | 151.00000 | 160.00000 |
| infbyte-full (2.1.1) | Server execution ms | 1155716 | 0.23381 | 0.05600 | 22.55700 |
| infbyte (2.1.1) | Included files | 1132320 | 143.99994 | 135.00000 | 144.00000 |
| infbyte (2.1.1) | Server execution ms | 1132320 | 0.23521 | 0.05600 | 19.89400 |
| laravel-api (v13.30.1) | Included files | 365613 | 549.99820 | 521.00000 | 550.00000 |
| laravel-api (v13.30.1) | Server execution ms | 365613 | 0.43269 | 0.16600 | 16.87500 |
| laravel (v13.30.1) | Included files | 291122 | 608.30863 | 533.00000 | 609.00000 |
| laravel (v13.30.1) | Server execution ms | 291122 | 1.00304 | 0.38700 | 44.43500 |

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

| Setting | webrick-generated (5.1) | webrick-fused (5.1) | webrick-sharded (5.1) | infbyte-full (2.1.1) | infbyte (2.1.1) | laravel-api (v13.30.1) | laravel (v13.30.1) |
| --- | --- | --- | --- | --- | --- | --- | --- |
| Url | http://127.0.0.1:44063/webrick-generated/asset/public/index.php/hello/index | http://127.0.0.1:44063/webrick-fused/asset/public/index.php/hello/index | http://127.0.0.1:44063/webrick-sharded/asset/public/index.php/hello/index | http://127.0.0.1:44063/infbyte-full/asset/public/index.php/hello/index | http://127.0.0.1:44063/infbyte/asset/public/index.php/hello/index | http://127.0.0.1:44063/laravel-api/asset/public/index.php/api/hello/index | http://127.0.0.1:44063/laravel/asset/public/index.php/hello/index |

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
