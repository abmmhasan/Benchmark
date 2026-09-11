## Overall ranking

| Rank | Target | Ranked RPM | Ranked concurrency | Ranking stability | Peak observed RPM | Peak concurrency | Peak stability | Duration s |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | webrick-generated (5.1) | 769,597 | 250 | Stable | 769,597 | 250 | Stable | 244.0 |
| 2 | webrick-fused (5.1) | 762,459 | 250 | Stable | 762,459 | 250 | Stable | 244.1 |
| 3 | webrick-sharded (5.1) | 754,875 | 250 | Stable | 754,875 | 250 | Stable | 244.0 |
| 4 | infbyte (2.1.1) | 571,527 | 250 | Stable | 571,527 | 250 | Stable | 244.7 |
| 5 | infbyte-full (2.1.1) | 570,584 | 125 | Stable | 570,584 | 125 | Stable | 244.7 |

## Throughput — concurrency 2

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 291,135 | 0.65% | Stable | 292,085 | 290,184 |
| webrick-fused (5.1) | 287,302 | 1.07% | Stable | 288,832 | 285,772 |
| webrick-sharded (5.1) | 284,959 | 0.94% | Stable | 286,293 | 283,625 |
| infbyte (2.1.1) | 236,230 | 0.56% | Stable | 236,887 | 235,573 |
| infbyte-full (2.1.1) | 234,651 | 0.91% | Stable | 235,723 | 233,580 |

## Throughput — concurrency 63

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 727,919 | 0.05% | Stable | 727,725 | 728,113 |
| webrick-fused (5.1) | 723,119 | 0.38% | Stable | 724,490 | 721,748 |
| webrick-sharded (5.1) | 719,136 | 0.91% | Stable | 722,391 | 715,880 |
| infbyte (2.1.1) | 561,318 | 1.61% | Stable | 556,810 | 565,825 |
| infbyte-full (2.1.1) | 559,502 | 1.02% | Stable | 556,657 | 562,347 |

## Throughput — concurrency 125

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 759,626 | 0.04% | Stable | 759,462 | 759,790 |
| webrick-fused (5.1) | 754,341 | 0.40% | Stable | 755,856 | 752,826 |
| webrick-sharded (5.1) | 751,190 | 0.50% | Stable | 753,061 | 749,318 |
| infbyte-full (2.1.1) | 570,584 | 0.71% | Stable | 572,614 | 568,554 |
| infbyte (2.1.1) | 568,029 | 1.46% | Stable | 563,894 | 572,163 |

## Throughput — concurrency 250

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 769,597 | 0.03% | Stable | 769,694 | 769,500 |
| webrick-fused (5.1) | 762,459 | 0.29% | Stable | 763,564 | 761,353 |
| webrick-sharded (5.1) | 754,875 | 0.79% | Stable | 757,868 | 751,882 |
| infbyte (2.1.1) | 571,527 | 1.25% | Stable | 567,953 | 575,102 |
| infbyte-full (2.1.1) | 568,466 | 1.05% | Stable | 571,447 | 565,485 |

## Latency — serial

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 0.31 | 0.34 | 0.37 | 0.00 | 0.30 |
| webrick-sharded (5.1) | 0.32 | 0.35 | 0.36 | 0.00 | 0.30 |
| webrick-fused (5.1) | 0.32 | 0.36 | 0.39 | 0.00 | 0.30 |
| infbyte (2.1.1) | 0.38 | 0.44 | 0.48 | 0.00 | 0.38 |
| infbyte-full (2.1.1) | 0.39 | 0.44 | 0.48 | 0.00 | 0.38 |

## Latency — concurrency 2

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 0.34 | 0.40 | 0.44 | 0.00 | 0.33 |
| webrick-fused (5.1) | 0.34 | 0.40 | 0.45 | 0.00 | 0.34 |
| webrick-sharded (5.1) | 0.35 | 0.41 | 0.46 | 0.00 | 0.35 |
| infbyte (2.1.1) | 0.43 | 0.51 | 0.57 | 0.00 | 0.43 |
| infbyte-full (2.1.1) | 0.44 | 0.52 | 0.58 | 0.00 | 0.44 |

## Latency — concurrency 63

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 2.13 | 4.55 | 6.20 | 0.00 | 2.47 |
| webrick-fused (5.1) | 2.19 | 4.69 | 6.34 | 0.00 | 2.54 |
| webrick-sharded (5.1) | 2.20 | 4.68 | 6.38 | 0.00 | 2.55 |
| infbyte (2.1.1) | 4.00 | 8.56 | 11.76 | 0.00 | 4.40 |
| infbyte-full (2.1.1) | 4.01 | 8.91 | 12.41 | 0.00 | 4.47 |

## Latency — concurrency 125

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 3.63 | 7.22 | 9.25 | 0.00 | 4.05 |
| webrick-fused (5.1) | 3.68 | 7.38 | 9.52 | 0.00 | 4.13 |
| webrick-sharded (5.1) | 3.69 | 7.45 | 9.69 | 0.00 | 4.16 |
| infbyte (2.1.1) | 6.66 | 13.65 | 18.83 | 0.00 | 7.09 |
| infbyte-full (2.1.1) | 6.67 | 13.73 | 18.77 | 0.00 | 7.10 |

## Latency — concurrency 250

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 6.87 | 10.88 | 15.27 | 0.01 | 7.16 |
| webrick-fused (5.1) | 6.95 | 11.50 | 15.51 | 0.01 | 7.27 |
| webrick-sharded (5.1) | 7.01 | 11.69 | 15.70 | 0.01 | 7.34 |
| infbyte (2.1.1) | 9.97 | 21.77 | 30.66 | 0.02 | 12.00 |
| infbyte-full (2.1.1) | 10.11 | 22.30 | 31.19 | 0.02 | 12.15 |

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
| webrick-generated (5.1) | 145569 | 145569 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 143653 | 143653 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 142481 | 142481 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 118116 | 118116 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 117327 | 117327 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 63

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 363987 | 363987 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 361600 | 361600 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 359604 | 359604 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 280701 | 280701 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 279794 | 279794 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 125

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 379881 | 379881 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 377222 | 377222 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 375659 | 375659 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 285368 | 285368 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 284089 | 284089 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 250

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 384910 | 384910 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 381322 | 381322 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 377566 | 377566 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 285880 | 285880 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 284399 | 284399 | 0.00% | 0 | 0 | 0 | 0 |

## Relative comparison

| Target | Peak throughput | Remote memory | Server time | Included files |
| --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 1.35× | 1.00× | 1.00× | 1.00× |
| webrick-fused (5.1) | 1.34× | 1.01× | 1.19× | 1.07× |
| webrick-sharded (5.1) | 1.32× | 1.00× | 1.31× | 1.09× |
| infbyte (2.1.1) | 1.00× | 1.14× | 7.63× | 1.63× |
| infbyte-full (2.1.1) | 1.00× | 2.19× | 7.55× | 1.80× |

## Resource telemetry

| Target | Samples | Avg CPU | Peak CPU | Avg MB | Peak MB | Remote MB |
| --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 0 | — | — | — | — | 1.94 |
| webrick-fused (5.1) | 0 | — | — | — | — | 1.95 |
| webrick-sharded (5.1) | 0 | — | — | — | — | 1.94 |
| infbyte (2.1.1) | 0 | — | — | — | — | 2.22 |
| infbyte-full (2.1.1) | 0 | — | — | — | — | 4.24 |

## Server response telemetry

| Target | Metric | Samples | Average | Minimum | Maximum |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | Included files | 1919027 | 90.99998 | 84.00000 | 91.00000 |
| webrick-generated (5.1) | Server execution ms | 1919027 | 0.02204 | 0.00500 | 5.13100 |
| webrick-fused (5.1) | Included files | 1903202 | 97.00000 | 97.00000 | 97.00000 |
| webrick-fused (5.1) | Server execution ms | 1903202 | 0.02633 | 0.00600 | 22.07400 |
| webrick-sharded (5.1) | Included files | 1890473 | 98.99997 | 92.00000 | 99.00000 |
| webrick-sharded (5.1) | Server execution ms | 1890473 | 0.02895 | 0.00600 | 6.24700 |
| infbyte (2.1.1) | Included files | 1947571 | 147.99996 | 140.00000 | 148.00000 |
| infbyte (2.1.1) | Server execution ms | 1947571 | 0.16820 | 0.04500 | 28.95400 |
| infbyte-full (2.1.1) | Included files | 1943775 | 163.99997 | 156.00000 | 164.00000 |
| infbyte-full (2.1.1) | Server execution ms | 1943775 | 0.16643 | 0.04500 | 25.40600 |

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

| Setting | webrick-generated (5.1) | webrick-fused (5.1) | webrick-sharded (5.1) | infbyte (2.1.1) | infbyte-full (2.1.1) |
| --- | --- | --- | --- | --- | --- |
| Url | http://127.0.0.1:43185/webrick-generated/asset/public/index.php/hello/index | http://127.0.0.1:43185/webrick-fused/asset/public/index.php/hello/index | http://127.0.0.1:43185/webrick-sharded/asset/public/index.php/hello/index | http://127.0.0.1:43185/infbyte/asset/public/index.php/hello/index | http://127.0.0.1:43185/infbyte-full/asset/public/index.php/hello/index |

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
