## Sustainable ranking

| Rank | Target | Best stable RPM | Stable concurrency | Peak observed RPM | Peak concurrency | Peak stability | Duration s |
| --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | webrick-generated (5.1) | 969,128 | 250 | 969,128 | 250 | Stable | 243.7 |
| 2 | webrick-fused (5.1) | 954,999 | 250 | 954,999 | 250 | Stable | 243.7 |
| 3 | webrick-sharded (5.1) | 947,742 | 250 | 947,742 | 250 | Stable | 243.7 |
| 4 | infbyte-full (2.1.1) | 678,301 | 250 | 678,301 | 250 | Stable | 244.3 |
| 5 | infbyte (2.1.1) | 677,599 | 250 | 677,599 | 250 | Stable | 244.2 |

## Throughput — concurrency 2

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 342,732 | 1.05% | Stable | 344,528 | 340,936 |
| webrick-fused (5.1) | 338,231 | 0.43% | Stable | 338,957 | 337,505 |
| webrick-sharded (5.1) | 334,152 | 0.40% | Stable | 334,817 | 333,487 |
| infbyte (2.1.1) | 265,807 | 2.01% | Stable | 268,476 | 263,137 |
| infbyte-full (2.1.1) | 265,619 | 0.24% | Stable | 265,943 | 265,295 |

## Throughput — concurrency 63

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 907,904 | 0.10% | Stable | 908,371 | 907,437 |
| webrick-fused (5.1) | 893,301 | 0.03% | Stable | 893,146 | 893,456 |
| webrick-sharded (5.1) | 888,097 | 0.68% | Stable | 891,121 | 885,073 |
| infbyte-full (2.1.1) | 661,503 | 0.61% | Stable | 659,497 | 663,509 |
| infbyte (2.1.1) | 657,717 | 1.99% | Stable | 651,180 | 664,254 |

## Throughput — concurrency 125

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 952,938 | 0.44% | Stable | 955,025 | 950,850 |
| webrick-fused (5.1) | 940,834 | 0.45% | Stable | 942,946 | 938,723 |
| webrick-sharded (5.1) | 930,195 | 0.39% | Stable | 932,009 | 928,380 |
| infbyte (2.1.1) | 671,363 | 0.73% | Stable | 668,926 | 673,800 |
| infbyte-full (2.1.1) | 669,656 | 0.15% | Stable | 670,148 | 669,164 |

## Throughput — concurrency 250

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 969,128 | 0.32% | Stable | 970,671 | 967,585 |
| webrick-fused (5.1) | 954,999 | 0.44% | Stable | 957,089 | 952,909 |
| webrick-sharded (5.1) | 947,742 | 0.94% | Stable | 943,290 | 952,194 |
| infbyte-full (2.1.1) | 678,301 | 0.56% | Stable | 676,393 | 680,209 |
| infbyte (2.1.1) | 677,599 | 1.64% | Stable | 672,045 | 683,153 |

## Latency — serial

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 0.26 | 0.29 | 0.31 | 0.00 | 0.25 |
| webrick-fused (5.1) | 0.26 | 0.30 | 0.32 | 0.00 | 0.25 |
| webrick-sharded (5.1) | 0.26 | 0.30 | 0.32 | 0.00 | 0.25 |
| infbyte-full (2.1.1) | 0.33 | 0.38 | 0.41 | 0.00 | 0.32 |
| infbyte (2.1.1) | 0.33 | 0.39 | 0.43 | 0.00 | 0.32 |

## Latency — concurrency 2

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 0.27 | 0.33 | 0.36 | 0.00 | 0.27 |
| webrick-fused (5.1) | 0.28 | 0.33 | 0.37 | 0.00 | 0.27 |
| webrick-sharded (5.1) | 0.28 | 0.33 | 0.38 | 0.00 | 0.28 |
| infbyte (2.1.1) | 0.37 | 0.45 | 0.50 | 0.00 | 0.37 |
| infbyte-full (2.1.1) | 0.37 | 0.45 | 0.50 | 0.00 | 0.37 |

## Latency — concurrency 63

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 1.80 | 3.76 | 5.07 | 0.00 | 2.04 |
| webrick-fused (5.1) | 1.99 | 3.97 | 5.37 | 0.00 | 2.13 |
| webrick-sharded (5.1) | 2.07 | 4.04 | 5.47 | 0.00 | 2.18 |
| infbyte-full (2.1.1) | 3.65 | 8.27 | 11.54 | 0.00 | 4.08 |
| infbyte (2.1.1) | 3.67 | 8.06 | 11.31 | 0.00 | 4.07 |

## Latency — concurrency 125

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 2.88 | 5.92 | 7.85 | 0.00 | 3.32 |
| webrick-fused (5.1) | 2.94 | 6.06 | 8.02 | 0.00 | 3.41 |
| webrick-sharded (5.1) | 2.98 | 6.17 | 8.23 | 0.00 | 3.47 |
| infbyte-full (2.1.1) | 6.46 | 14.04 | 19.40 | 0.00 | 7.14 |
| infbyte (2.1.1) | 6.57 | 14.52 | 20.17 | 0.00 | 7.29 |

## Latency — concurrency 250

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 5.34 | 9.63 | 12.19 | 0.01 | 5.63 |
| webrick-fused (5.1) | 5.43 | 10.36 | 12.51 | 0.01 | 5.80 |
| webrick-sharded (5.1) | 5.47 | 10.48 | 12.71 | 0.01 | 5.84 |
| infbyte-full (2.1.1) | 11.65 | 22.07 | 29.54 | 0.01 | 12.04 |
| infbyte (2.1.1) | 11.79 | 23.27 | 31.54 | 0.01 | 12.40 |

## Reliability — serial

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| infbyte (2.1.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-generated (5.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 2

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 171367 | 171367 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 169117 | 169117 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 167077 | 167077 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 132905 | 132905 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 132811 | 132811 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 63

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 453985 | 453985 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 446697 | 446697 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 444086 | 444086 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 330796 | 330796 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 328900 | 328900 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 125

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 476533 | 476533 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 470477 | 470477 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 465169 | 465169 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 335773 | 335773 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 334896 | 334896 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 250

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 484672 | 484672 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 477628 | 477628 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 473953 | 473953 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 339300 | 339300 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 338965 | 338965 | 0.00% | 0 | 0 | 0 | 0 |

## Relative comparison

| Target | Peak throughput | Remote memory | Server time | Included files |
| --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 1.43× | 1.00× | 1.00× | 1.00× |
| webrick-fused (5.1) | 1.41× | 1.01× | 1.27× | 1.07× |
| webrick-sharded (5.1) | 1.40× | 1.00× | 1.38× | 1.09× |
| infbyte-full (2.1.1) | 1.00× | 2.17× | 8.64× | 1.80× |
| infbyte (2.1.1) | 1.00× | 1.14× | 8.70× | 1.63× |

## Resource telemetry

| Target | Samples | Avg CPU | Peak CPU | Avg MB | Peak MB | Remote MB |
| --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 0 | — | — | — | — | 1.94 |
| webrick-fused (5.1) | 0 | — | — | — | — | 1.95 |
| webrick-sharded (5.1) | 0 | — | — | — | — | 1.94 |
| infbyte-full (2.1.1) | 0 | — | — | — | — | 4.21 |
| infbyte (2.1.1) | 0 | — | — | — | — | 2.22 |

## Server response telemetry

| Target | Metric | Samples | Average | Minimum | Maximum |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | Included files | 2387341 | 90.99999 | 84.00000 | 91.00000 |
| webrick-generated (5.1) | Server execution ms | 2387341 | 0.01766 | 0.00300 | 6.05900 |
| webrick-fused (5.1) | Included files | 2353382 | 96.99999 | 93.00000 | 97.00000 |
| webrick-fused (5.1) | Server execution ms | 2353382 | 0.02243 | 0.00300 | 4.30100 |
| webrick-sharded (5.1) | Included files | 2332930 | 98.99999 | 92.00000 | 99.00000 |
| webrick-sharded (5.1) | Server execution ms | 2332930 | 0.02436 | 0.00400 | 7.97400 |
| infbyte-full (2.1.1) | Included files | 2285603 | 163.99997 | 155.00000 | 164.00000 |
| infbyte-full (2.1.1) | Server execution ms | 2285603 | 0.15251 | 0.03100 | 39.35100 |
| infbyte (2.1.1) | Included files | 2283083 | 147.99998 | 140.00000 | 148.00000 |
| infbyte (2.1.1) | Server execution ms | 2283083 | 0.15362 | 0.03100 | 21.19800 |

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

| Setting | webrick-generated (5.1) | webrick-fused (5.1) | webrick-sharded (5.1) | infbyte-full (2.1.1) | infbyte (2.1.1) |
| --- | --- | --- | --- | --- | --- |
| Url | http://127.0.0.1:38849/webrick-generated/asset/public/index.php/hello/index | http://127.0.0.1:38849/webrick-fused/asset/public/index.php/hello/index | http://127.0.0.1:38849/webrick-sharded/asset/public/index.php/hello/index | http://127.0.0.1:38849/infbyte-full/asset/public/index.php/hello/index | http://127.0.0.1:38849/infbyte/asset/public/index.php/hello/index |

## Target-server environment

These settings come from the PHP web runtime that received benchmark requests.

| Setting | Value |
| --- | --- |
| PHP version | 8.5.10 |
| PHP SAPI | cli |
| Loaded php.ini | /usr/local/etc/php/php.ini |
| Benchmark environment profile | workerman-production |
| OPcache extension loaded | Yes |
| OPcache enabled for web requests | Yes |
