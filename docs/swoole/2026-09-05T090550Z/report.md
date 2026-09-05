## Sustainable ranking

| Rank | Target | Best stable RPM | Stable concurrency | Peak observed RPM | Peak concurrency | Peak stability | Duration s |
| --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | hyperf (v3.2.0) | 1,309,426 | 250 | 1,309,426 | 250 | Stable | 242.5 |
| 2 | webrick-generated (5.1) | 1,052,618 | 250 | 1,052,618 | 250 | Stable | 242.9 |
| 3 | webrick-fused (5.1) | 964,692 | 125 | 964,692 | 125 | Stable | 242.9 |
| 4 | infbyte (2.1.1) | 644,438 | 250 | 644,438 | 250 | Stable | 243.3 |
| 5 | infbyte-full (2.1.1) | 643,641 | 125 | 643,641 | 125 | Stable | 243.2 |
| 6 | laravel-api (v13.30.1) | 220,044 | 63 | 220,044 | 63 | Stable | 246.9 |
| 7 | laravel (v13.30.1) | 153,636 | 125 | 163,725 | 63 | Unstable | 249.3 |
| — | webrick-sharded (5.1) | — | — | 975,029 | 125 | Unstable | 243.0 |
| — | symfony (v8.1.6) | — | — | 374,517 | 63 | Unstable | 244.7 |

## Throughput — concurrency 2

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 516,028 | 0.86% | Stable | 513,813 | 518,244 |
| webrick-generated (5.1) | 413,606 | 2.43% | Stable | 408,585 | 418,627 |
| webrick-fused (5.1) | 400,657 | 9.96% | Stable | 420,608 | 380,705 |
| webrick-sharded (5.1) | 390,451 | 16.46% | Unstable | 422,583 | 358,319 |
| infbyte-full (2.1.1) | 341,336 | 1.28% | Stable | 339,146 | 343,525 |
| infbyte (2.1.1) | 322,733 | 7.49% | Stable | 334,816 | 310,651 |
| symfony (v8.1.6) | 212,225 | 11.19% | Unstable | 224,103 | 200,346 |
| laravel-api (v13.30.1) | 135,092 | 9.34% | Stable | 141,402 | 128,783 |
| laravel (v13.30.1) | 99,257 | 40.07% | Unstable | 119,143 | 79,371 |

## Throughput — concurrency 63

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 1,250,065 | 1.56% | Stable | 1,259,793 | 1,240,337 |
| webrick-fused (5.1) | 964,052 | 3.00% | Stable | 978,501 | 949,603 |
| webrick-generated (5.1) | 955,671 | 5.68% | Stable | 928,518 | 982,824 |
| webrick-sharded (5.1) | 930,916 | 15.94% | Unstable | 1,005,126 | 856,706 |
| infbyte-full (2.1.1) | 642,456 | 0.46% | Stable | 640,989 | 643,924 |
| infbyte (2.1.1) | 630,088 | 0.17% | Stable | 629,562 | 630,614 |
| symfony (v8.1.6) | 374,517 | 12.34% | Unstable | 397,629 | 351,406 |
| laravel-api (v13.30.1) | 220,044 | 9.12% | Stable | 230,077 | 210,010 |
| laravel (v13.30.1) | 163,725 | 14.70% | Unstable | 175,761 | 151,689 |

## Throughput — concurrency 125

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 1,281,199 | 4.44% | Stable | 1,252,736 | 1,309,661 |
| webrick-generated (5.1) | 985,537 | 0.87% | Stable | 981,230 | 989,844 |
| webrick-sharded (5.1) | 975,029 | 14.69% | Unstable | 1,046,642 | 903,416 |
| webrick-fused (5.1) | 964,692 | 5.43% | Stable | 938,520 | 990,863 |
| infbyte-full (2.1.1) | 643,641 | 1.05% | Stable | 647,005 | 640,277 |
| infbyte (2.1.1) | 639,857 | 0.53% | Stable | 638,154 | 641,559 |
| symfony (v8.1.6) | 353,647 | 11.59% | Unstable | 374,149 | 333,145 |
| laravel-api (v13.30.1) | 209,780 | 10.38% | Unstable | 220,664 | 198,897 |
| laravel (v13.30.1) | 153,636 | 8.78% | Stable | 160,384 | 146,888 |

## Throughput — concurrency 250

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 1,309,426 | 0.36% | Stable | 1,307,076 | 1,311,777 |
| webrick-generated (5.1) | 1,052,618 | 0.35% | Stable | 1,054,475 | 1,050,762 |
| webrick-sharded (5.1) | 959,359 | 13.40% | Unstable | 1,023,631 | 895,087 |
| webrick-fused (5.1) | 955,732 | 12.14% | Unstable | 897,710 | 1,013,754 |
| infbyte (2.1.1) | 644,438 | 4.21% | Stable | 630,887 | 657,988 |
| infbyte-full (2.1.1) | 630,572 | 1.53% | Stable | 635,385 | 625,759 |
| symfony (v8.1.6) | 350,733 | 13.37% | Unstable | 374,181 | 327,286 |
| laravel-api (v13.30.1) | 197,966 | 5.58% | Stable | 203,486 | 192,445 |
| laravel (v13.30.1) | 138,620 | 9.41% | Stable | 145,140 | 132,099 |

## Latency — serial

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 0.15 | 0.26 | 0.30 | 0.00 | 0.16 |
| webrick-generated (5.1) | 0.21 | 0.25 | 0.27 | 0.00 | 0.20 |
| webrick-fused (5.1) | 0.21 | 0.26 | 0.27 | 0.00 | 0.21 |
| webrick-sharded (5.1) | 0.22 | 0.27 | 0.31 | 0.00 | 0.21 |
| infbyte-full (2.1.1) | 0.25 | 0.29 | 0.33 | 0.00 | 0.24 |
| infbyte (2.1.1) | 0.26 | 0.30 | 0.47 | 0.00 | 0.25 |
| symfony (v8.1.6) | 0.30 | 0.83 | 0.86 | 0.00 | 0.40 |
| laravel-api (v13.30.1) | 0.62 | 0.69 | 0.91 | 0.00 | 0.61 |
| laravel (v13.30.1) | 0.80 | 0.89 | 3.90 | 0.00 | 0.83 |

## Latency — concurrency 2

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 0.18 | 0.30 | 0.36 | 0.00 | 0.19 |
| webrick-fused (5.1) | 0.23 | 0.32 | 0.36 | 0.00 | 0.25 |
| webrick-generated (5.1) | 0.24 | 0.32 | 0.38 | 0.00 | 0.24 |
| webrick-sharded (5.1) | 0.24 | 0.33 | 0.39 | 0.00 | 0.26 |
| infbyte-full (2.1.1) | 0.30 | 0.39 | 0.47 | 0.00 | 0.29 |
| infbyte (2.1.1) | 0.30 | 0.40 | 0.49 | 0.00 | 0.31 |
| symfony (v8.1.6) | 0.36 | 1.09 | 1.27 | 0.00 | 0.51 |
| laravel-api (v13.30.1) | 0.80 | 1.14 | 1.22 | 0.00 | 0.84 |
| laravel (v13.30.1) | 1.05 | 1.46 | 7.71 | 0.00 | 1.19 |

## Latency — concurrency 63

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 1.92 | 5.10 | 7.67 | 0.00 | 2.36 |
| webrick-generated (5.1) | 2.72 | 7.08 | 10.63 | 0.00 | 3.39 |
| webrick-fused (5.1) | 2.95 | 7.22 | 10.52 | 0.00 | 3.41 |
| webrick-sharded (5.1) | 3.05 | 7.52 | 10.86 | 0.00 | 3.57 |
| infbyte-full (2.1.1) | 4.91 | 11.15 | 16.59 | 0.00 | 5.44 |
| infbyte (2.1.1) | 4.99 | 11.75 | 17.62 | 0.00 | 5.54 |
| symfony (v8.1.6) | 8.44 | 21.23 | 33.40 | 0.00 | 9.82 |
| laravel-api (v13.30.1) | 15.05 | 32.85 | 41.18 | 0.00 | 17.01 |
| laravel (v13.30.1) | 20.09 | 40.12 | 51.79 | 0.00 | 23.00 |

## Latency — concurrency 125

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 3.47 | 10.29 | 16.57 | 0.00 | 4.50 |
| webrick-generated (5.1) | 5.45 | 14.37 | 21.14 | 0.00 | 6.61 |
| webrick-fused (5.1) | 5.49 | 14.60 | 21.73 | 0.00 | 6.75 |
| webrick-sharded (5.1) | 5.76 | 14.14 | 20.85 | 0.00 | 6.72 |
| infbyte-full (2.1.1) | 8.36 | 26.66 | 39.75 | 0.00 | 10.92 |
| infbyte (2.1.1) | 9.43 | 23.26 | 35.04 | 0.00 | 10.99 |
| symfony (v8.1.6) | 17.22 | 43.82 | 68.78 | 0.00 | 20.76 |
| laravel-api (v13.30.1) | 29.27 | 77.87 | 102.11 | 0.00 | 35.50 |
| laravel (v13.30.1) | 41.58 | 86.72 | 111.69 | 0.01 | 48.58 |

## Latency — concurrency 250

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 6.07 | 18.66 | 30.61 | 0.00 | 8.07 |
| webrick-generated (5.1) | 10.34 | 25.24 | 37.21 | 0.00 | 12.15 |
| webrick-fused (5.1) | 11.32 | 29.60 | 42.64 | 0.00 | 13.65 |
| webrick-sharded (5.1) | 11.78 | 28.64 | 40.74 | 0.01 | 13.47 |
| infbyte (2.1.1) | 19.08 | 44.22 | 61.90 | 0.01 | 21.98 |
| infbyte-full (2.1.1) | 20.16 | 44.05 | 61.47 | 0.01 | 22.50 |
| symfony (v8.1.6) | 36.09 | 76.99 | 111.07 | 0.01 | 41.98 |
| laravel-api (v13.30.1) | 62.51 | 133.30 | 177.29 | 0.02 | 75.14 |
| laravel (v13.30.1) | 90.94 | 202.35 | 265.84 | 0.03 | 107.68 |

## Reliability — serial

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| symfony (v8.1.6) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-generated (5.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 2

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 258015 | 258015 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-generated (5.1) | 206805 | 206805 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 200330 | 200330 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 195227 | 195227 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 161368 | 161368 | 0.00% | 0 | 0 | 0 | 0 |
| symfony (v8.1.6) | 106114 | 106114 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 67548 | 67548 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 49630 | 49630 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 170670 | 170669 | 0.00% | 0 | 0 | 1 | 0 |

## Reliability — concurrency 63

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| symfony (v8.1.6) | 187319 | 187319 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 110084 | 110084 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 81928 | 81928 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 315101 | 315099 | 0.00% | 0 | 0 | 2 | 0 |
| hyperf (v3.2.0) | 625090 | 625082 | 0.00% | 0 | 0 | 8 | 0 |
| infbyte-full (2.1.1) | 321295 | 321291 | 0.00% | 0 | 0 | 4 | 0 |
| webrick-fused (5.1) | 482088 | 482082 | 0.00% | 0 | 0 | 7 | 0 |
| webrick-generated (5.1) | 477900 | 477893 | 0.00% | 0 | 0 | 7 | 0 |
| webrick-sharded (5.1) | 465520 | 465511 | 0.00% | 0 | 0 | 10 | 0 |

## Reliability — concurrency 125

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| symfony (v8.1.6) | 176947 | 176947 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 105006 | 105006 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 76938 | 76938 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 320052 | 320043 | 0.00% | 0 | 0 | 9 | 0 |
| infbyte-full (2.1.1) | 321942 | 321931 | 0.00% | 0 | 0 | 11 | 0 |
| webrick-generated (5.1) | 492872 | 492860 | 0.00% | 0 | 0 | 12 | 0 |
| webrick-fused (5.1) | 482458 | 482444 | 0.00% | 0 | 0 | 14 | 0 |
| webrick-sharded (5.1) | 487637 | 487621 | 0.00% | 0 | 0 | 16 | 0 |
| hyperf (v3.2.0) | 640723 | 640697 | 0.00% | 0 | 0 | 26 | 0 |

## Reliability — concurrency 250

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| symfony (v8.1.6) | 175605 | 175605 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 99208 | 99208 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 69560 | 69560 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 479929 | 479906 | 0.01% | 0 | 0 | 24 | 0 |
| webrick-generated (5.1) | 526584 | 526556 | 0.01% | 0 | 0 | 28 | 0 |
| infbyte (2.1.1) | 322490 | 322470 | 0.01% | 0 | 0 | 20 | 0 |
| hyperf (v3.2.0) | 654936 | 654901 | 0.01% | 0 | 0 | 36 | 0 |
| infbyte-full (2.1.1) | 315591 | 315569 | 0.01% | 0 | 0 | 22 | 0 |
| webrick-fused (5.1) | 478151 | 478116 | 0.01% | 0 | 0 | 35 | 0 |

## Relative comparison

| Target | Peak throughput | Remote memory | Server time | Included files |
| --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 8.00× | 1.47× | 1.00× | 4.25× |
| webrick-generated (5.1) | 6.43× | 1.00× | 5.62× | 1.00× |
| webrick-fused (5.1) | 5.89× | 1.01× | 6.02× | 1.07× |
| infbyte (2.1.1) | 3.94× | 1.27× | 10.77× | 1.56× |
| infbyte-full (2.1.1) | 3.93× | 1.35× | 10.77× | 1.74× |
| laravel-api (v13.30.1) | 1.34× | 2.48× | 14.38× | 6.33× |
| laravel (v13.30.1) | 1.00× | 6.51× | 41.90× | 6.95× |
| webrick-sharded (5.1) | 5.96× | 1.01× | 6.29× | 1.09× |
| symfony (v8.1.6) | 2.29× | 1.39× | 30.80× | 2.81× |

## Resource telemetry

| Target | Samples | Avg CPU | Peak CPU | Avg MB | Peak MB | Remote MB |
| --- | --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 0 | — | — | — | — | 12.55 |
| webrick-generated (5.1) | 0 | — | — | — | — | 8.51 |
| webrick-fused (5.1) | 0 | — | — | — | — | 8.56 |
| infbyte (2.1.1) | 0 | — | — | — | — | 10.79 |
| infbyte-full (2.1.1) | 0 | — | — | — | — | 11.46 |
| laravel-api (v13.30.1) | 0 | — | — | — | — | 21.13 |
| laravel (v13.30.1) | 0 | — | — | — | — | 55.40 |
| webrick-sharded (5.1) | 0 | — | — | — | — | 8.59 |
| symfony (v8.1.6) | 0 | — | — | — | — | 11.82 |

## Server response telemetry

| Target | Metric | Samples | Average | Minimum | Maximum |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | Included files | 3275649 | 386.93683 | 378.00000 | 387.00000 |
| hyperf (v3.2.0) | Server execution ms | 3275649 | 0.01378 | 0.00200 | 13.26700 |
| webrick-generated (5.1) | Included files | 2563747 | 90.99986 | 84.00000 | 91.00000 |
| webrick-generated (5.1) | Server execution ms | 2563747 | 0.07745 | 0.01400 | 35.61700 |
| webrick-fused (5.1) | Included files | 2472041 | 96.99985 | 90.00000 | 97.00000 |
| webrick-fused (5.1) | Server execution ms | 2472041 | 0.08293 | 0.01400 | 43.23900 |
| infbyte (2.1.1) | Included files | 2247960 | 141.99962 | 130.00000 | 142.00000 |
| infbyte (2.1.1) | Server execution ms | 2247960 | 0.14844 | 0.02600 | 52.11500 |
| infbyte-full (2.1.1) | Included files | 2268919 | 157.99951 | 146.00000 | 158.00000 |
| infbyte-full (2.1.1) | Server execution ms | 2268919 | 0.14836 | 0.02600 | 59.40000 |
| laravel-api (v13.30.1) | Included files | 773691 | 576.38586 | 548.00000 | 577.00000 |
| laravel-api (v13.30.1) | Server execution ms | 773691 | 0.19813 | 0.08000 | 29.52400 |
| laravel (v13.30.1) | Included files | 566111 | 632.29638 | 559.00000 | 633.00000 |
| laravel (v13.30.1) | Server execution ms | 566111 | 0.57736 | 0.20800 | 77.04200 |
| webrick-sharded (5.1) | Included files | 2449976 | 98.99983 | 91.00000 | 99.00000 |
| webrick-sharded (5.1) | Server execution ms | 2449976 | 0.08672 | 0.01500 | 48.61700 |
| symfony (v8.1.6) | Included files | 1301969 | 255.99996 | 211.00000 | 256.00000 |
| symfony (v8.1.6) | Server execution ms | 1301969 | 0.42439 | 0.04000 | 61.35200 |

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

| Setting | hyperf (v3.2.0) | webrick-generated (5.1) | webrick-fused (5.1) | infbyte (2.1.1) | infbyte-full (2.1.1) | laravel-api (v13.30.1) | laravel (v13.30.1) | webrick-sharded (5.1) | symfony (v8.1.6) |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| Url | http://127.0.0.1:43241/hyperf/hello/index | http://127.0.0.1:43241/webrick-generated/asset/public/index.php/hello/index | http://127.0.0.1:43241/webrick-fused/asset/public/index.php/hello/index | http://127.0.0.1:43241/infbyte/asset/public/index.php/hello/index | http://127.0.0.1:43241/infbyte-full/asset/public/index.php/hello/index | http://127.0.0.1:43241/laravel-api/asset/public/index.php/api/hello/index | http://127.0.0.1:43241/laravel/asset/public/index.php/hello/index | http://127.0.0.1:43241/webrick-sharded/asset/public/index.php/hello/index | http://127.0.0.1:43241/symfony/asset/public/index.php/hello/index |

## Target-server environment

These settings come from the PHP web runtime that received benchmark requests.

| Setting | Value |
| --- | --- |
| PHP version | 8.5.10 |
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
