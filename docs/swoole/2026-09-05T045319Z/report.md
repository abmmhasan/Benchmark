## Sustainable ranking

| Rank | Target | Best stable RPM | Stable concurrency | Peak observed RPM | Peak concurrency | Peak stability | Duration s |
| --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | hyperf (v3.2.0) | 642,381 | 250 | 642,381 | 250 | Stable | 244.6 |
| 2 | webrick-generated (5.1) | 480,962 | 250 | 480,962 | 250 | Stable | 247.0 |
| 3 | webrick-fused (5.1) | 472,675 | 125 | 472,675 | 125 | Stable | 244.8 |
| 4 | webrick-sharded (5.1) | 462,700 | 125 | 462,700 | 125 | Stable | 244.8 |
| 5 | infbyte-full (2.1.1) | 317,749 | 250 | 317,749 | 250 | Stable | 245.4 |
| 6 | infbyte (2.1.1) | 317,093 | 63 | 317,093 | 63 | Stable | 245.4 |
| 7 | symfony (v8.1.6) | 214,128 | 63 | 214,128 | 63 | Stable | 248.1 |
| 8 | laravel-api (v13.30.1) | 129,949 | 63 | 129,949 | 63 | Stable | 251.6 |
| 9 | laravel (v13.30.1) | 100,413 | 63 | 100,413 | 63 | Stable | 255.1 |

## Throughput — concurrency 2

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 258,096 | 10.25% | Unstable | 271,325 | 244,867 |
| webrick-fused (5.1) | 233,494 | 0.05% | Stable | 233,435 | 233,553 |
| webrick-sharded (5.1) | 221,006 | 11.32% | Unstable | 233,512 | 208,499 |
| webrick-generated (5.1) | 202,699 | 33.21% | Unstable | 236,358 | 169,039 |
| infbyte-full (2.1.1) | 195,563 | 2.68% | Stable | 198,186 | 192,939 |
| infbyte (2.1.1) | 180,410 | 19.91% | Unstable | 198,368 | 162,452 |
| symfony (v8.1.6) | 128,870 | 6.96% | Stable | 133,356 | 124,384 |
| laravel-api (v13.30.1) | 83,862 | 13.79% | Unstable | 89,645 | 78,080 |
| laravel (v13.30.1) | 59,380 | 34.08% | Unstable | 69,498 | 49,261 |

## Throughput — concurrency 63

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 612,122 | 0.48% | Stable | 613,590 | 610,654 |
| webrick-generated (5.1) | 471,481 | 0.03% | Stable | 471,410 | 471,551 |
| webrick-fused (5.1) | 464,023 | 0.13% | Stable | 463,731 | 464,315 |
| webrick-sharded (5.1) | 461,101 | 0.39% | Stable | 460,207 | 461,994 |
| infbyte-full (2.1.1) | 317,338 | 1.26% | Stable | 315,343 | 319,333 |
| infbyte (2.1.1) | 317,093 | 0.19% | Stable | 317,388 | 316,797 |
| symfony (v8.1.6) | 214,128 | 0.21% | Stable | 214,355 | 213,900 |
| laravel-api (v13.30.1) | 129,949 | 1.07% | Stable | 129,251 | 130,647 |
| laravel (v13.30.1) | 100,413 | 2.79% | Stable | 101,816 | 99,011 |

## Throughput — concurrency 125

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 622,928 | 0.67% | Stable | 625,005 | 620,852 |
| webrick-generated (5.1) | 476,971 | 0.33% | Stable | 476,174 | 477,769 |
| webrick-fused (5.1) | 472,675 | 0.39% | Stable | 471,759 | 473,591 |
| webrick-sharded (5.1) | 462,700 | 0.05% | Stable | 462,581 | 462,819 |
| infbyte-full (2.1.1) | 315,940 | 0.99% | Stable | 314,381 | 317,499 |
| infbyte (2.1.1) | 314,563 | 0.52% | Stable | 315,384 | 313,741 |
| symfony (v8.1.6) | 209,211 | 0.46% | Stable | 209,693 | 208,729 |
| laravel-api (v13.30.1) | 123,481 | 0.98% | Stable | 122,876 | 124,087 |
| laravel (v13.30.1) | 94,679 | 2.56% | Stable | 95,890 | 93,469 |

## Throughput — concurrency 250

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 642,381 | 0.26% | Stable | 643,204 | 641,557 |
| webrick-generated (5.1) | 480,962 | 2.80% | Stable | 474,234 | 487,690 |
| webrick-fused (5.1) | 468,804 | 0.07% | Stable | 468,645 | 468,963 |
| webrick-sharded (5.1) | 462,202 | 1.33% | Stable | 465,272 | 459,132 |
| infbyte-full (2.1.1) | 317,749 | 1.40% | Stable | 315,533 | 319,966 |
| infbyte (2.1.1) | 314,338 | 1.39% | Stable | 316,516 | 312,159 |
| symfony (v8.1.6) | 204,353 | 0.19% | Stable | 204,160 | 204,546 |
| laravel-api (v13.30.1) | 118,898 | 1.10% | Stable | 118,247 | 119,549 |
| laravel (v13.30.1) | 90,617 | 1.40% | Stable | 91,250 | 89,984 |

## Latency — serial

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 0.31 | 0.48 | 0.51 | 0.00 | 0.32 |
| webrick-fused (5.1) | 0.39 | 0.43 | 0.45 | 0.00 | 0.37 |
| webrick-generated (5.1) | 0.39 | 0.43 | 0.45 | 0.00 | 0.37 |
| webrick-sharded (5.1) | 0.39 | 0.44 | 0.46 | 0.00 | 0.37 |
| infbyte-full (2.1.1) | 0.45 | 0.50 | 0.53 | 0.00 | 0.43 |
| infbyte (2.1.1) | 0.45 | 0.51 | 0.54 | 0.00 | 0.43 |
| symfony (v8.1.6) | 0.51 | 1.38 | 1.42 | 0.00 | 0.70 |
| laravel-api (v13.30.1) | 1.05 | 1.11 | 1.19 | 0.00 | 1.03 |
| laravel (v13.30.1) | 1.34 | 1.44 | 3.34 | 0.00 | 1.35 |

## Latency — concurrency 2

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 0.34 | 0.55 | 0.62 | 0.00 | 0.39 |
| webrick-generated (5.1) | 0.43 | 0.54 | 0.62 | 0.00 | 0.52 |
| webrick-sharded (5.1) | 0.43 | 0.54 | 0.62 | 0.00 | 0.44 |
| webrick-fused (5.1) | 0.43 | 0.55 | 0.63 | 0.00 | 0.42 |
| infbyte (2.1.1) | 0.52 | 0.66 | 0.78 | 0.00 | 0.58 |
| infbyte-full (2.1.1) | 0.52 | 0.67 | 0.80 | 0.00 | 0.52 |
| symfony (v8.1.6) | 0.58 | 1.92 | 2.01 | 0.00 | 0.83 |
| laravel-api (v13.30.1) | 1.27 | 1.64 | 1.79 | 0.00 | 1.34 |
| laravel (v13.30.1) | 1.97 | 2.48 | 7.32 | 0.00 | 1.99 |

## Latency — concurrency 63

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 4.18 | 10.63 | 15.35 | 0.00 | 4.89 |
| webrick-sharded (5.1) | 6.14 | 14.72 | 20.82 | 0.00 | 7.14 |
| webrick-generated (5.1) | 6.26 | 14.53 | 20.91 | 0.00 | 7.08 |
| webrick-fused (5.1) | 6.59 | 14.55 | 20.20 | 0.00 | 7.31 |
| infbyte-full (2.1.1) | 9.80 | 22.94 | 34.03 | 0.00 | 10.97 |
| infbyte (2.1.1) | 9.92 | 22.95 | 33.88 | 0.00 | 11.09 |
| symfony (v8.1.6) | 14.86 | 34.46 | 50.78 | 0.00 | 17.10 |
| laravel-api (v13.30.1) | 25.48 | 53.17 | 61.11 | 0.00 | 28.71 |
| laravel (v13.30.1) | 33.62 | 60.08 | 69.25 | 0.00 | 37.28 |

## Latency — concurrency 125

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 7.67 | 20.58 | 30.02 | 0.00 | 9.31 |
| webrick-generated (5.1) | 11.98 | 29.67 | 43.36 | 0.00 | 14.08 |
| webrick-sharded (5.1) | 12.30 | 31.70 | 46.17 | 0.00 | 14.48 |
| webrick-fused (5.1) | 12.54 | 28.67 | 40.49 | 0.00 | 14.14 |
| infbyte (2.1.1) | 17.59 | 55.62 | 78.84 | 0.01 | 22.67 |
| infbyte-full (2.1.1) | 20.19 | 43.67 | 62.82 | 0.01 | 22.47 |
| symfony (v8.1.6) | 30.22 | 64.30 | 90.72 | 0.01 | 34.95 |
| laravel-api (v13.30.1) | 51.29 | 107.12 | 139.73 | 0.01 | 60.07 |
| laravel (v13.30.1) | 68.94 | 139.47 | 175.99 | 0.02 | 78.55 |

## Latency — concurrency 250

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 13.88 | 38.61 | 55.68 | 0.01 | 17.00 |
| webrick-generated (5.1) | 24.12 | 58.57 | 81.44 | 0.01 | 27.73 |
| webrick-fused (5.1) | 26.23 | 54.68 | 75.85 | 0.02 | 28.64 |
| webrick-sharded (5.1) | 26.36 | 58.41 | 81.08 | 0.02 | 29.22 |
| infbyte-full (2.1.1) | 37.60 | 92.80 | 126.07 | 0.02 | 44.92 |
| infbyte (2.1.1) | 39.10 | 99.69 | 136.31 | 0.02 | 45.65 |
| symfony (v8.1.6) | 64.63 | 110.71 | 132.47 | 0.03 | 71.79 |
| laravel-api (v13.30.1) | 108.55 | 179.44 | 206.85 | 0.06 | 124.82 |
| laravel (v13.30.1) | 148.09 | 259.22 | 311.97 | 0.07 | 163.97 |

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
| webrick-fused (5.1) | 116748 | 116748 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-generated (5.1) | 104510 | 104510 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 97783 | 97783 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 90206 | 90206 | 0.00% | 0 | 0 | 0 | 0 |
| symfony (v8.1.6) | 64437 | 64437 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 41933 | 41933 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 29691 | 29691 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 110505 | 110505 | 0.00% | 0 | 0 | 1 | 0 |
| hyperf (v3.2.0) | 129774 | 129773 | 0.00% | 0 | 0 | 1 | 0 |

## Reliability — concurrency 63

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| infbyte-full (2.1.1) | 158733 | 158733 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 158610 | 158610 | 0.00% | 0 | 0 | 0 | 0 |
| symfony (v8.1.6) | 107125 | 107125 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 65031 | 65031 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 50272 | 50272 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-generated (5.1) | 235796 | 235795 | 0.00% | 0 | 0 | 1 | 0 |
| webrick-fused (5.1) | 232061 | 232060 | 0.00% | 0 | 0 | 1 | 0 |
| webrick-sharded (5.1) | 230605 | 230601 | 0.00% | 0 | 0 | 5 | 0 |
| hyperf (v3.2.0) | 306121 | 306116 | 0.00% | 0 | 0 | 5 | 0 |

## Reliability — concurrency 125

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| symfony (v8.1.6) | 104725 | 104725 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 61858 | 61858 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 47457 | 47457 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 158081 | 158080 | 0.00% | 0 | 0 | 2 | 0 |
| infbyte (2.1.1) | 157402 | 157400 | 0.00% | 0 | 0 | 3 | 0 |
| webrick-sharded (5.1) | 231471 | 231466 | 0.00% | 0 | 0 | 5 | 0 |
| webrick-fused (5.1) | 236466 | 236457 | 0.00% | 0 | 0 | 10 | 0 |
| hyperf (v3.2.0) | 311565 | 311550 | 0.01% | 0 | 0 | 15 | 0 |
| webrick-generated (5.1) | 238626 | 238612 | 0.01% | 0 | 0 | 14 | 0 |

## Reliability — concurrency 250

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| symfony (v8.1.6) | 102416 | 102416 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 59677 | 59677 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 45553 | 45553 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 231342 | 231334 | 0.00% | 0 | 0 | 9 | 0 |
| hyperf (v3.2.0) | 321387 | 321376 | 0.00% | 0 | 0 | 11 | 0 |
| webrick-fused (5.1) | 234662 | 234651 | 0.01% | 0 | 0 | 12 | 0 |
| webrick-generated (5.1) | 240734 | 240721 | 0.01% | 0 | 0 | 13 | 0 |
| infbyte (2.1.1) | 157445 | 157436 | 0.01% | 0 | 0 | 10 | 0 |
| infbyte-full (2.1.1) | 159168 | 159144 | 0.02% | 0 | 0 | 24 | 0 |

## Relative comparison

| Target | Peak throughput | Remote memory | Server time | Included files |
| --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 6.40× | 1.44× | 1.00× | 4.25× |
| webrick-generated (5.1) | 4.79× | 1.00× | 5.97× | 1.00× |
| webrick-fused (5.1) | 4.71× | 1.01× | 6.11× | 1.07× |
| webrick-sharded (5.1) | 4.61× | 1.02× | 6.30× | 1.09× |
| infbyte-full (2.1.1) | 3.16× | 1.39× | 10.16× | 1.74× |
| infbyte (2.1.1) | 3.16× | 1.24× | 10.33× | 1.56× |
| symfony (v8.1.6) | 2.13× | 1.39× | 24.32× | 2.81× |
| laravel-api (v13.30.1) | 1.29× | 2.49× | 10.89× | 6.33× |
| laravel (v13.30.1) | 1.00× | 5.47× | 28.12× | 6.95× |

## Resource telemetry

| Target | Samples | Avg CPU | Peak CPU | Avg MB | Peak MB | Remote MB |
| --- | --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 0 | — | — | — | — | 12.20 |
| webrick-generated (5.1) | 0 | — | — | — | — | 8.49 |
| webrick-fused (5.1) | 0 | — | — | — | — | 8.58 |
| webrick-sharded (5.1) | 0 | — | — | — | — | 8.63 |
| infbyte-full (2.1.1) | 0 | — | — | — | — | 11.81 |
| infbyte (2.1.1) | 0 | — | — | — | — | 10.56 |
| symfony (v8.1.6) | 0 | — | — | — | — | 11.81 |
| laravel-api (v13.30.1) | 0 | — | — | — | — | 21.14 |
| laravel (v13.30.1) | 0 | — | — | — | — | 46.47 |

## Server response telemetry

| Target | Metric | Samples | Average | Minimum | Maximum |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | Included files | 1610775 | 386.79909 | 378.00000 | 387.00000 |
| hyperf (v3.2.0) | Server execution ms | 1610775 | 0.02900 | 0.00400 | 30.08600 |
| webrick-generated (5.1) | Included files | 1237003 | 90.99987 | 84.00000 | 91.00000 |
| webrick-generated (5.1) | Server execution ms | 1237003 | 0.17318 | 0.03000 | 32.31500 |
| webrick-fused (5.1) | Included files | 1237411 | 96.99980 | 90.00000 | 97.00000 |
| webrick-fused (5.1) | Server execution ms | 1237411 | 0.17730 | 0.03200 | 55.08300 |
| webrick-sharded (5.1) | Included files | 1213389 | 98.99980 | 91.00000 | 99.00000 |
| webrick-sharded (5.1) | Server execution ms | 1213389 | 0.18259 | 0.03500 | 42.69000 |
| infbyte-full (2.1.1) | Included files | 1157477 | 157.99942 | 147.00000 | 158.00000 |
| infbyte-full (2.1.1) | Server execution ms | 1157477 | 0.29455 | 0.05900 | 71.13100 |
| infbyte (2.1.1) | Included files | 1137302 | 141.99968 | 131.00000 | 142.00000 |
| infbyte (2.1.1) | Server execution ms | 1137302 | 0.29971 | 0.05700 | 59.46600 |
| symfony (v8.1.6) | Included files | 767403 | 255.99994 | 214.00000 | 256.00000 |
| symfony (v8.1.6) | Server execution ms | 767403 | 0.70541 | 0.07700 | 42.07700 |
| laravel-api (v13.30.1) | Included files | 466997 | 576.00027 | 549.00000 | 577.00000 |
| laravel-api (v13.30.1) | Server execution ms | 466997 | 0.31579 | 0.13200 | 40.72900 |
| laravel (v13.30.1) | Included files | 355946 | 632.25537 | 571.00000 | 633.00000 |
| laravel (v13.30.1) | Server execution ms | 355946 | 0.81544 | 0.35500 | 58.38600 |

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

| Setting | hyperf (v3.2.0) | webrick-generated (5.1) | webrick-fused (5.1) | webrick-sharded (5.1) | infbyte-full (2.1.1) | infbyte (2.1.1) | symfony (v8.1.6) | laravel-api (v13.30.1) | laravel (v13.30.1) |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| Url | http://127.0.0.1:43371/hyperf/hello/index | http://127.0.0.1:43371/webrick-generated/asset/public/index.php/hello/index | http://127.0.0.1:43371/webrick-fused/asset/public/index.php/hello/index | http://127.0.0.1:43371/webrick-sharded/asset/public/index.php/hello/index | http://127.0.0.1:43371/infbyte-full/asset/public/index.php/hello/index | http://127.0.0.1:43371/infbyte/asset/public/index.php/hello/index | http://127.0.0.1:43371/symfony/asset/public/index.php/hello/index | http://127.0.0.1:43371/laravel-api/asset/public/index.php/api/hello/index | http://127.0.0.1:43371/laravel/asset/public/index.php/hello/index |

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
