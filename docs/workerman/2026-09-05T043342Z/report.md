## Sustainable ranking

| Rank | Target | Best stable RPM | Stable concurrency | Peak observed RPM | Peak concurrency | Peak stability | Duration s |
| --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | webrick-generated (5.1) | 785,147 | 250 | 785,147 | 250 | Stable | 243.9 |
| 2 | webrick-fused (5.1) | 770,678 | 250 | 770,678 | 250 | Stable | 243.9 |
| 3 | webrick-sharded (5.1) | 745,042 | 250 | 745,042 | 250 | Stable | 243.9 |
| 4 | infbyte-full (2.1.1) | 570,074 | 125 | 570,074 | 125 | Stable | 244.6 |
| 5 | infbyte (2.1.1) | 567,772 | 125 | 567,772 | 125 | Stable | 244.6 |

## Throughput — concurrency 2

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 296,144 | 1.02% | Stable | 297,648 | 294,640 |
| webrick-fused (5.1) | 294,134 | 0.13% | Stable | 293,948 | 294,320 |
| webrick-sharded (5.1) | 290,676 | 0.83% | Stable | 291,889 | 289,463 |
| infbyte (2.1.1) | 238,892 | 0.44% | Stable | 239,413 | 238,371 |
| infbyte-full (2.1.1) | 237,860 | 0.61% | Stable | 238,582 | 237,137 |

## Throughput — concurrency 63

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 738,443 | 0.05% | Stable | 738,267 | 738,620 |
| webrick-fused (5.1) | 730,548 | 0.53% | Stable | 732,492 | 728,605 |
| webrick-sharded (5.1) | 717,934 | 0.04% | Stable | 717,782 | 718,086 |
| infbyte-full (2.1.1) | 564,707 | 1.23% | Stable | 561,220 | 568,193 |
| infbyte (2.1.1) | 563,080 | 0.09% | Stable | 563,324 | 562,836 |

## Throughput — concurrency 125

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 770,713 | 0.31% | Stable | 771,891 | 769,535 |
| webrick-fused (5.1) | 761,176 | 0.42% | Stable | 759,578 | 762,774 |
| webrick-sharded (5.1) | 744,907 | 0.56% | Stable | 742,814 | 747,001 |
| infbyte-full (2.1.1) | 570,074 | 0.96% | Stable | 567,349 | 572,799 |
| infbyte (2.1.1) | 567,772 | 0.55% | Stable | 566,197 | 569,347 |

## Throughput — concurrency 250

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 785,147 | 0.87% | Stable | 788,550 | 781,744 |
| webrick-fused (5.1) | 770,678 | 1.05% | Stable | 766,620 | 774,737 |
| webrick-sharded (5.1) | 745,042 | 0.17% | Stable | 744,410 | 745,674 |
| infbyte (2.1.1) | 567,467 | 1.07% | Stable | 570,509 | 564,425 |
| infbyte-full (2.1.1) | 560,555 | 0.84% | Stable | 558,199 | 562,911 |

## Latency — serial

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-fused (5.1) | 0.30 | 0.34 | 0.36 | 0.00 | 0.29 |
| webrick-sharded (5.1) | 0.30 | 0.35 | 0.42 | 0.00 | 0.29 |
| webrick-generated (5.1) | 0.31 | 0.34 | 0.36 | 0.00 | 0.29 |
| infbyte-full (2.1.1) | 0.38 | 0.42 | 0.45 | 0.00 | 0.37 |
| infbyte (2.1.1) | 0.38 | 0.43 | 0.51 | 0.00 | 0.37 |

## Latency — concurrency 2

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 0.33 | 0.39 | 0.44 | 0.00 | 0.33 |
| webrick-fused (5.1) | 0.34 | 0.39 | 0.44 | 0.00 | 0.33 |
| webrick-sharded (5.1) | 0.34 | 0.40 | 0.45 | 0.00 | 0.34 |
| infbyte (2.1.1) | 0.43 | 0.51 | 0.55 | 0.00 | 0.43 |
| infbyte-full (2.1.1) | 0.43 | 0.51 | 0.57 | 0.00 | 0.43 |

## Latency — concurrency 63

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 2.13 | 4.57 | 6.21 | 0.00 | 2.46 |
| webrick-fused (5.1) | 2.17 | 4.63 | 6.29 | 0.00 | 2.51 |
| webrick-sharded (5.1) | 2.24 | 4.78 | 6.53 | 0.00 | 2.58 |
| infbyte-full (2.1.1) | 3.97 | 8.64 | 11.91 | 0.00 | 4.39 |
| infbyte (2.1.1) | 4.03 | 8.70 | 12.08 | 0.00 | 4.45 |

## Latency — concurrency 125

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 3.58 | 7.15 | 9.19 | 0.00 | 4.00 |
| webrick-fused (5.1) | 3.63 | 7.31 | 9.48 | 0.00 | 4.08 |
| webrick-sharded (5.1) | 3.73 | 7.52 | 9.69 | 0.00 | 4.21 |
| infbyte-full (2.1.1) | 6.51 | 13.23 | 18.16 | 0.00 | 6.95 |
| infbyte (2.1.1) | 6.65 | 13.31 | 17.96 | 0.00 | 7.03 |

## Latency — concurrency 250

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 6.73 | 10.85 | 14.99 | 0.01 | 7.04 |
| webrick-fused (5.1) | 6.86 | 10.86 | 15.26 | 0.01 | 7.15 |
| webrick-sharded (5.1) | 7.12 | 11.47 | 15.92 | 0.01 | 7.45 |
| infbyte-full (2.1.1) | 10.10 | 22.01 | 30.68 | 0.02 | 12.06 |
| infbyte (2.1.1) | 10.11 | 22.30 | 30.97 | 0.02 | 12.16 |

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
| webrick-generated (5.1) | 148074 | 148074 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 147068 | 147068 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 145340 | 145340 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 119447 | 119447 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 118931 | 118931 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 63

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 369251 | 369251 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 365318 | 365318 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 358997 | 358997 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 282408 | 282408 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 281577 | 281577 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 125

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 385417 | 385417 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 380640 | 380640 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 372508 | 372508 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 285110 | 285110 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 283950 | 283950 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 250

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 392676 | 392676 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 385432 | 385432 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 372647 | 372647 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 283871 | 283871 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 280401 | 280401 | 0.00% | 0 | 0 | 0 | 0 |

## Relative comparison

| Target | Peak throughput | Remote memory | Server time | Included files |
| --- | --- | --- | --- | --- |
| webrick-generated (5.1) | 1.38× | 1.00× | 1.00× | 1.00× |
| webrick-fused (5.1) | 1.36× | 1.01× | 1.19× | 1.07× |
| webrick-sharded (5.1) | 1.31× | 1.00× | 1.32× | 1.09× |
| infbyte-full (2.1.1) | 1.00× | 2.17× | 7.54× | 1.80× |
| infbyte (2.1.1) | 1.00× | 1.14× | 7.66× | 1.63× |

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
| webrick-generated (5.1) | Included files | 1950630 | 90.99996 | 84.00000 | 91.00000 |
| webrick-generated (5.1) | Server execution ms | 1950630 | 0.02194 | 0.00500 | 12.25700 |
| webrick-fused (5.1) | Included files | 1925193 | 96.99999 | 90.00000 | 97.00000 |
| webrick-fused (5.1) | Server execution ms | 1925193 | 0.02620 | 0.00600 | 5.72000 |
| webrick-sharded (5.1) | Included files | 1881744 | 98.99999 | 95.00000 | 99.00000 |
| webrick-sharded (5.1) | Server execution ms | 1881744 | 0.02906 | 0.00600 | 6.74100 |
| infbyte-full (2.1.1) | Included files | 1943699 | 163.99995 | 155.00000 | 164.00000 |
| infbyte-full (2.1.1) | Server execution ms | 1943699 | 0.16539 | 0.04500 | 29.55600 |
| infbyte (2.1.1) | Included files | 1947689 | 147.99999 | 138.00000 | 148.00000 |
| infbyte (2.1.1) | Server execution ms | 1947689 | 0.16814 | 0.04600 | 28.40600 |

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
| Url | http://127.0.0.1:38319/webrick-generated/asset/public/index.php/hello/index | http://127.0.0.1:38319/webrick-fused/asset/public/index.php/hello/index | http://127.0.0.1:38319/webrick-sharded/asset/public/index.php/hello/index | http://127.0.0.1:38319/infbyte-full/asset/public/index.php/hello/index | http://127.0.0.1:38319/infbyte/asset/public/index.php/hello/index |

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
