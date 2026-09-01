## Sustainable ranking

| Rank | Target | Best stable RPM | Stable concurrency | Peak observed RPM | Peak concurrency | Peak stability | Duration s |
| --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | hyperf (v3.2.0) | 904,819 | 250 | 904,819 | 250 | Stable | 366.4 |
| 2 | symfony (v8.1.5) | 439,692 | 125 | 439,692 | 125 | Stable | 368.1 |
| 3 | webrick-fused (4.0.2) | 405,836 | 250 | 405,836 | 250 | Stable | 367.0 |
| 4 | webrick-sharded (4.0.2) | 393,078 | 125 | 393,078 | 125 | Stable | 367.3 |
| 5 | infbyte (2.1.1) | 347,315 | 63 | 347,315 | 63 | Stable | 367.6 |
| 6 | infbyte-full (2.1.1) | 341,053 | 250 | 341,053 | 250 | Stable | 367.8 |
| 7 | laravel-api (v13.29.0) | 129,504 | 63 | 129,504 | 63 | Stable | 377.5 |
| 8 | laravel (v13.29.0) | 100,902 | 63 | 100,902 | 63 | Stable | 381.6 |

## Throughput — concurrency 2

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM | Run 3 RPM |
| --- | --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 329,775 | 8.49% | Stable | 329,881 | 301,899 | 329,775 |
| webrick-sharded (4.0.2) | 216,190 | 12.58% | Unstable | 224,704 | 197,504 | 216,190 |
| webrick-fused (4.0.2) | 209,501 | 11.36% | Unstable | 206,139 | 229,946 | 209,501 |
| infbyte-full (2.1.1) | 209,471 | 14.89% | Unstable | 213,049 | 181,862 | 209,471 |
| infbyte (2.1.1) | 208,323 | 8.65% | Stable | 213,551 | 195,528 | 208,323 |
| symfony (v8.1.5) | 199,799 | 4.20% | Stable | 199,799 | 199,771 | 208,157 |
| laravel-api (v13.29.0) | 77,030 | 14.74% | Unstable | 88,288 | 76,932 | 77,030 |
| laravel (v13.29.0) | 56,370 | 35.05% | Unstable | 72,962 | 53,206 | 56,370 |

## Throughput — concurrency 63

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM | Run 3 RPM |
| --- | --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 853,340 | 2.18% | Stable | 853,340 | 838,333 | 856,974 |
| symfony (v8.1.5) | 437,074 | 0.07% | Stable | 436,869 | 437,074 | 437,174 |
| webrick-fused (4.0.2) | 399,223 | 2.36% | Stable | 398,652 | 399,223 | 408,086 |
| webrick-sharded (4.0.2) | 390,626 | 1.52% | Stable | 390,626 | 385,436 | 391,371 |
| infbyte (2.1.1) | 347,315 | 3.75% | Stable | 350,718 | 337,681 | 347,315 |
| infbyte-full (2.1.1) | 338,172 | 2.26% | Stable | 344,730 | 337,087 | 338,172 |
| laravel-api (v13.29.0) | 129,504 | 0.12% | Stable | 129,609 | 129,447 | 129,504 |
| laravel (v13.29.0) | 100,902 | 3.11% | Stable | 103,377 | 100,242 | 100,902 |

## Throughput — concurrency 125

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM | Run 3 RPM |
| --- | --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 881,385 | 2.33% | Stable | 881,385 | 896,408 | 875,859 |
| symfony (v8.1.5) | 439,692 | 0.97% | Stable | 438,329 | 439,692 | 442,573 |
| webrick-fused (4.0.2) | 404,876 | 0.57% | Stable | 404,303 | 404,876 | 406,606 |
| webrick-sharded (4.0.2) | 393,078 | 0.22% | Stable | 393,398 | 392,522 | 393,078 |
| infbyte-full (2.1.1) | 340,695 | 1.29% | Stable | 344,736 | 340,695 | 340,328 |
| infbyte (2.1.1) | 338,614 | 2.47% | Stable | 338,614 | 337,216 | 345,572 |
| laravel-api (v13.29.0) | 123,567 | 1.55% | Stable | 121,980 | 123,890 | 123,567 |
| laravel (v13.29.0) | 95,059 | 3.26% | Stable | 97,178 | 95,059 | 94,079 |

## Throughput — concurrency 250

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM | Run 3 RPM |
| --- | --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 904,819 | 1.40% | Stable | 917,252 | 904,819 | 904,611 |
| symfony (v8.1.5) | 435,633 | 1.51% | Stable | 438,449 | 431,893 | 435,633 |
| webrick-fused (4.0.2) | 405,836 | 1.51% | Stable | 401,415 | 405,836 | 407,531 |
| webrick-sharded (4.0.2) | 391,486 | 1.48% | Stable | 394,288 | 391,486 | 388,491 |
| infbyte-full (2.1.1) | 341,053 | 1.20% | Stable | 341,480 | 337,394 | 341,053 |
| infbyte (2.1.1) | 336,101 | 2.08% | Stable | 335,758 | 336,101 | 342,746 |
| laravel-api (v13.29.0) | 118,224 | 0.58% | Stable | 118,224 | 117,927 | 118,611 |
| laravel (v13.29.0) | 90,598 | 2.05% | Stable | 91,980 | 90,120 | 90,598 |

## Latency — serial

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 0.28 | 0.33 | 0.35 | 0.00 | 0.27 |
| webrick-fused (4.0.2) | 0.38 | 0.44 | 0.52 | 0.00 | 0.37 |
| webrick-sharded (4.0.2) | 0.39 | 0.44 | 0.51 | 0.00 | 0.38 |
| infbyte (2.1.1) | 0.42 | 0.46 | 0.49 | 0.00 | 0.40 |
| infbyte-full (2.1.1) | 0.43 | 0.47 | 0.49 | 0.00 | 0.41 |
| symfony (v8.1.5) | 0.46 | 0.54 | 0.82 | 0.00 | 0.45 |
| laravel-api (v13.29.0) | 1.05 | 1.32 | 2.10 | 0.00 | 1.07 |
| laravel (v13.29.0) | 1.29 | 1.41 | 2.86 | 0.00 | 1.33 |

## Latency — concurrency 2

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 0.29 | 0.35 | 0.39 | 0.00 | 0.29 |
| webrick-fused (4.0.2) | 0.44 | 0.58 | 0.71 | 0.00 | 0.48 |
| webrick-sharded (4.0.2) | 0.45 | 0.59 | 0.73 | 0.00 | 0.47 |
| symfony (v8.1.5) | 0.50 | 0.61 | 0.82 | 0.00 | 0.51 |
| infbyte-full (2.1.1) | 0.50 | 0.62 | 0.74 | 0.00 | 0.49 |
| infbyte (2.1.1) | 0.50 | 0.63 | 0.77 | 0.00 | 0.49 |
| laravel-api (v13.29.0) | 1.35 | 1.86 | 2.26 | 0.00 | 1.47 |
| laravel (v13.29.0) | 1.91 | 2.49 | 5.85 | 0.00 | 2.05 |

## Latency — concurrency 63

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 2.40 | 5.18 | 7.48 | 0.00 | 2.66 |
| webrick-fused (4.0.2) | 6.83 | 20.17 | 30.47 | 0.00 | 8.62 |
| symfony (v8.1.5) | 7.24 | 13.19 | 20.59 | 0.00 | 7.76 |
| webrick-sharded (4.0.2) | 7.76 | 20.13 | 29.85 | 0.00 | 8.85 |
| infbyte (2.1.1) | 8.96 | 20.93 | 31.23 | 0.00 | 9.91 |
| infbyte-full (2.1.1) | 9.14 | 21.53 | 32.45 | 0.00 | 10.37 |
| laravel-api (v13.29.0) | 26.09 | 52.08 | 58.75 | 0.00 | 28.82 |
| laravel (v13.29.0) | 34.18 | 57.99 | 65.41 | 0.00 | 37.12 |

## Latency — concurrency 125

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 4.06 | 8.65 | 12.36 | 0.00 | 4.56 |
| symfony (v8.1.5) | 14.63 | 24.65 | 34.01 | 0.00 | 15.46 |
| webrick-fused (4.0.2) | 14.92 | 36.35 | 51.96 | 0.00 | 17.22 |
| webrick-sharded (4.0.2) | 15.76 | 36.94 | 52.64 | 0.00 | 17.82 |
| infbyte-full (2.1.1) | 17.94 | 43.05 | 63.89 | 0.00 | 20.82 |
| infbyte (2.1.1) | 18.35 | 43.66 | 63.97 | 0.00 | 20.94 |
| laravel-api (v13.29.0) | 51.88 | 110.86 | 142.54 | 0.01 | 60.06 |
| laravel (v13.29.0) | 68.66 | 137.21 | 167.10 | 0.02 | 78.27 |

## Latency — concurrency 250

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 5.90 | 12.83 | 17.93 | 0.01 | 7.04 |
| webrick-fused (4.0.2) | 30.35 | 76.98 | 108.01 | 0.02 | 34.84 |
| webrick-sharded (4.0.2) | 31.17 | 74.54 | 106.71 | 0.02 | 36.00 |
| symfony (v8.1.5) | 31.42 | 48.70 | 63.99 | 0.02 | 32.12 |
| infbyte (2.1.1) | 32.79 | 93.97 | 124.36 | 0.02 | 42.54 |
| infbyte-full (2.1.1) | 35.68 | 89.34 | 122.16 | 0.02 | 41.95 |
| laravel-api (v13.29.0) | 108.86 | 183.98 | 220.31 | 0.05 | 125.54 |
| laravel (v13.29.0) | 145.02 | 256.94 | 322.90 | 0.07 | 164.06 |

## Reliability — serial

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.29.0) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.29.0) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| symfony (v8.1.5) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (4.0.2) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (4.0.2) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 2

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 164889 | 164889 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (4.0.2) | 108097 | 108097 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (4.0.2) | 104751 | 104751 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 104737 | 104737 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 104163 | 104163 | 0.00% | 0 | 0 | 0 | 0 |
| symfony (v8.1.5) | 99901 | 99901 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.29.0) | 38517 | 38517 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.29.0) | 28186 | 28186 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 63

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 426710 | 426710 | 0.00% | 0 | 0 | 0 | 0 |
| symfony (v8.1.5) | 218584 | 218584 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (4.0.2) | 199688 | 199688 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (4.0.2) | 195365 | 195365 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 173716 | 173716 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 169145 | 169145 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.29.0) | 64829 | 64829 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.29.0) | 50520 | 50520 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 125

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 446414 | 446414 | 0.00% | 0 | 0 | 0 | 0 |
| symfony (v8.1.5) | 219917 | 219917 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (4.0.2) | 202552 | 202552 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (4.0.2) | 196669 | 196669 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 170449 | 170449 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 169446 | 169446 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.29.0) | 61903 | 61903 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.29.0) | 47650 | 47650 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 250

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 452577 | 452577 | 0.00% | 0 | 0 | 0 | 0 |
| symfony (v8.1.5) | 218035 | 218035 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (4.0.2) | 203216 | 203216 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (4.0.2) | 195977 | 195977 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 170818 | 170818 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.29.0) | 59333 | 59333 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.29.0) | 45530 | 45530 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 168287 | 168287 | 0.00% | 0 | 0 | 1 | 0 |

## Relative comparison

| Target | Peak throughput | Remote memory | Server time | Included files |
| --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 8.97× | 1.48× | 1.00× | 5.18× |
| symfony (v8.1.5) | 4.36× | 1.41× | 3.03× | 2.79× |
| webrick-fused (4.0.2) | 4.02× | 1.00× | 2.37× | 1.00× |
| webrick-sharded (4.0.2) | 3.90× | 1.11× | 2.68× | 1.00× |
| infbyte (2.1.1) | 3.44× | 1.42× | 4.06× | 1.82× |
| infbyte-full (2.1.1) | 3.38× | 1.48× | 4.11× | 2.04× |
| laravel-api (v13.29.0) | 1.28× | 2.55× | 1.81× | 7.67× |
| laravel (v13.29.0) | 1.00× | 8.78× | 1.68× | 7.81× |

## Resource telemetry

| Target | Samples | Avg CPU | Peak CPU | Avg MB | Peak MB | Remote MB |
| --- | --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 0 | — | — | — | — | 11.75 |
| symfony (v8.1.5) | 0 | — | — | — | — | 11.25 |
| webrick-fused (4.0.2) | 0 | — | — | — | — | 7.96 |
| webrick-sharded (4.0.2) | 0 | — | — | — | — | 8.83 |
| infbyte (2.1.1) | 0 | — | — | — | — | 11.34 |
| infbyte-full (2.1.1) | 0 | — | — | — | — | 11.78 |
| laravel-api (v13.29.0) | 0 | — | — | — | — | 20.33 |
| laravel (v13.29.0) | 0 | — | — | — | — | 69.85 |

## Server response telemetry

| Target | Metric | Samples | Average | Minimum | Maximum |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | Included files | 4469442 | 377.91130 | 377.00000 | 378.00000 |
| hyperf (v3.2.0) | Server execution ms | 4469442 | 0.06222 | 0.01300 | 45.58700 |
| symfony (v8.1.5) | Included files | 2288794 | 204.00000 | 201.00000 | 204.00000 |
| symfony (v8.1.5) | Server execution ms | 2288794 | 0.18847 | 0.05100 | 85.28000 |
| webrick-fused (4.0.2) | Included files | 2157373 | 72.99998 | 70.00000 | 73.00000 |
| webrick-fused (4.0.2) | Server execution ms | 2157373 | 0.14739 | 0.02100 | 101.66900 |
| webrick-sharded (4.0.2) | Included files | 2095855 | 72.99997 | 70.00000 | 73.00000 |
| webrick-sharded (4.0.2) | Server execution ms | 2095855 | 0.16673 | 0.02700 | 70.78000 |
| infbyte (2.1.1) | Included files | 1860823 | 132.99998 | 130.00000 | 133.00000 |
| infbyte (2.1.1) | Server execution ms | 1860823 | 0.25281 | 0.05000 | 75.28000 |
| infbyte-full (2.1.1) | Included files | 1851385 | 148.99998 | 146.00000 | 149.00000 |
| infbyte-full (2.1.1) | Server execution ms | 1851385 | 0.25551 | 0.05200 | 108.54300 |
| laravel-api (v13.29.0) | Included files | 693730 | 560.22938 | 548.00000 | 561.00000 |
| laravel-api (v13.29.0) | Server execution ms | 693730 | 0.11285 | 0.05000 | 26.29200 |
| laravel (v13.29.0) | Included files | 539288 | 570.10024 | 554.00000 | 571.00000 |
| laravel (v13.29.0) | Server execution ms | 539288 | 0.10467 | 0.05100 | 35.99500 |

## Common configuration

| Setting | Value |
| --- | --- |
| Method | GET |
| Expected status | 200 |
| Count per phase | 5000 |
| Max concurrency | 250 |
| Concurrency levels | 2, 63, 125, 250 |
| Repetitions | 3 |
| Maximum rpm spread percent | 10 |
| Warm up requests | 10 |
| Minimum duration seconds | 30 |
| Timeout seconds | 10 |
| Http2 | no |
| Verify ssl | yes |
| Piping mode | optimal |
| Skip preflight | no |
| Header names | Accept, Cache-Control |
| Has request body | no |
| Response memory extraction | yes |
| Response metrics extraction | yes |

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

| Setting | hyperf (v3.2.0) | symfony (v8.1.5) | webrick-fused (4.0.2) | webrick-sharded (4.0.2) | infbyte (2.1.1) | infbyte-full (2.1.1) | laravel-api (v13.29.0) | laravel (v13.29.0) |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| Url | http://127.0.0.1:32769/hyperf/hello/index | http://127.0.0.1:32769/symfony/asset/public/index.php/hello/index | http://127.0.0.1:32769/webrick-fused/asset/public/index.php/hello/index | http://127.0.0.1:32769/webrick-sharded/asset/public/index.php/hello/index | http://127.0.0.1:32769/infbyte/asset/public/index.php/hello/index | http://127.0.0.1:32769/infbyte-full/asset/public/index.php/hello/index | http://127.0.0.1:32769/laravel-api/asset/public/index.php/api/hello/index | http://127.0.0.1:32769/laravel/asset/public/index.php/hello/index |

## Target-server environment

These settings come from the PHP web runtime that received benchmark requests.

| Setting | Value |
| --- | --- |
| PHP version | 8.5.9 |
| PHP SAPI | cli |
| Loaded php.ini | /usr/local/etc/php/php.ini |
| Benchmark environment profile | swoole-production |
| OPcache extension loaded | Yes |
| OPcache enabled for web requests | No |
| opcache.enable setting | Yes |
| opcache.enable_cli setting | No |
| OPcache JIT active | No |
| OPcache JIT mode | disable |
| OPcache JIT buffer | 64M |
| OPcache memory consumption (MB) | 128 |
| OPcache interned strings buffer (MB) | 8 |
| OPcache maximum accelerated files | 10000 |
| OPcache validates timestamps | Yes |
| OPcache revalidation frequency | 2 seconds |
