## Sustainable ranking

| Rank | Target | Best stable RPM | Stable concurrency | Peak observed RPM | Peak concurrency | Peak stability | Duration s |
| --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | hyperf (v3.2.0) | 571,229 | 250 | 571,229 | 250 | Stable | 244.5 |
| 2 | webrick-fused (5.1) | 432,840 | 125 | 432,840 | 125 | Stable | 244.9 |
| 3 | webrick-sharded (5.1) | 425,515 | 250 | 425,515 | 250 | Stable | 245.0 |
| 4 | webrick-generated (5.1) | 422,950 | 63 | 422,950 | 63 | Stable | 245.0 |
| 5 | infbyte (2.1.1) | 288,973 | 125 | 288,973 | 125 | Stable | 245.7 |
| 6 | infbyte-full (2.1.1) | 287,525 | 63 | 287,525 | 63 | Stable | 247.9 |
| 7 | symfony (v8.1.6) | 190,781 | 63 | 190,781 | 63 | Stable | 248.5 |
| 8 | laravel-api (v13.30.1) | 116,349 | 63 | 116,349 | 63 | Stable | 252.8 |
| 9 | laravel (v13.30.1) | 90,283 | 63 | 90,283 | 63 | Stable | 256.2 |

## Throughput — concurrency 2

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 233,093 | 9.54% | Stable | 244,209 | 221,977 |
| webrick-fused (5.1) | 219,443 | 0.22% | Stable | 219,684 | 219,202 |
| webrick-sharded (5.1) | 218,934 | 0.85% | Stable | 218,009 | 219,859 |
| webrick-generated (5.1) | 216,498 | 5.00% | Stable | 221,910 | 211,087 |
| infbyte (2.1.1) | 171,833 | 9.29% | Stable | 179,816 | 163,849 |
| infbyte-full (2.1.1) | 170,929 | 10.66% | Unstable | 180,037 | 161,821 |
| symfony (v8.1.6) | 117,368 | 7.89% | Stable | 122,000 | 112,735 |
| laravel-api (v13.30.1) | 74,407 | 19.91% | Unstable | 81,814 | 67,000 |
| laravel (v13.30.1) | 57,120 | 26.46% | Unstable | 64,677 | 49,563 |

## Throughput — concurrency 63

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 549,300 | 3.36% | Stable | 540,081 | 558,519 |
| webrick-generated (5.1) | 422,950 | 2.32% | Stable | 427,859 | 418,040 |
| webrick-fused (5.1) | 421,118 | 0.67% | Stable | 419,703 | 422,533 |
| webrick-sharded (5.1) | 419,030 | 0.67% | Stable | 417,633 | 420,427 |
| infbyte (2.1.1) | 288,627 | 3.28% | Stable | 283,897 | 293,357 |
| infbyte-full (2.1.1) | 287,525 | 1.53% | Stable | 285,327 | 289,723 |
| symfony (v8.1.6) | 190,781 | 2.52% | Stable | 188,378 | 193,183 |
| laravel-api (v13.30.1) | 116,349 | 1.48% | Stable | 115,490 | 117,208 |
| laravel (v13.30.1) | 90,283 | 1.17% | Stable | 90,812 | 89,754 |

## Throughput — concurrency 125

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 552,963 | 3.42% | Stable | 543,498 | 562,428 |
| webrick-fused (5.1) | 432,840 | 2.64% | Stable | 438,550 | 427,130 |
| webrick-sharded (5.1) | 422,625 | 0.46% | Stable | 421,662 | 423,588 |
| webrick-generated (5.1) | 421,705 | 4.78% | Stable | 431,793 | 411,616 |
| infbyte (2.1.1) | 288,973 | 0.57% | Stable | 288,152 | 289,794 |
| infbyte-full (2.1.1) | 283,991 | 4.63% | Stable | 277,421 | 290,561 |
| symfony (v8.1.6) | 188,133 | 3.22% | Stable | 185,102 | 191,165 |
| laravel-api (v13.30.1) | 111,605 | 2.16% | Stable | 110,397 | 112,812 |
| laravel (v13.30.1) | 85,757 | 1.04% | Stable | 86,205 | 85,310 |

## Throughput — concurrency 250

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 571,229 | 1.95% | Stable | 565,653 | 576,804 |
| webrick-sharded (5.1) | 425,515 | 2.03% | Stable | 421,197 | 429,832 |
| webrick-fused (5.1) | 423,159 | 1.41% | Stable | 420,167 | 426,151 |
| webrick-generated (5.1) | 420,252 | 5.22% | Stable | 431,214 | 409,291 |
| infbyte (2.1.1) | 284,288 | 2.90% | Stable | 280,165 | 288,411 |
| infbyte-full (2.1.1) | 270,420 | 10.80% | Unstable | 255,822 | 285,018 |
| symfony (v8.1.6) | 181,748 | 0.48% | Stable | 181,309 | 182,187 |
| laravel-api (v13.30.1) | 107,316 | 2.71% | Stable | 105,860 | 108,772 |
| laravel (v13.30.1) | 81,200 | 0.37% | Stable | 81,350 | 81,050 |

## Latency — serial

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 0.35 | 0.51 | 0.57 | 0.00 | 0.36 |
| webrick-fused (5.1) | 0.41 | 0.45 | 0.47 | 0.00 | 0.39 |
| webrick-sharded (5.1) | 0.41 | 0.45 | 0.48 | 0.00 | 0.39 |
| webrick-generated (5.1) | 0.41 | 0.46 | 0.48 | 0.00 | 0.39 |
| infbyte (2.1.1) | 0.48 | 0.54 | 0.58 | 0.00 | 0.46 |
| infbyte-full (2.1.1) | 0.48 | 0.54 | 0.59 | 0.00 | 0.47 |
| symfony (v8.1.6) | 0.54 | 1.47 | 1.51 | 0.00 | 0.74 |
| laravel-api (v13.30.1) | 1.16 | 1.22 | 1.29 | 0.00 | 1.15 |
| laravel (v13.30.1) | 1.46 | 1.54 | 2.63 | 0.00 | 1.47 |

## Latency — concurrency 2

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 0.39 | 0.62 | 0.69 | 0.00 | 0.43 |
| webrick-generated (5.1) | 0.46 | 0.57 | 0.66 | 0.00 | 0.47 |
| webrick-fused (5.1) | 0.46 | 0.58 | 0.67 | 0.00 | 0.46 |
| webrick-sharded (5.1) | 0.47 | 0.58 | 0.66 | 0.00 | 0.46 |
| infbyte (2.1.1) | 0.58 | 0.72 | 0.87 | 0.00 | 0.60 |
| infbyte-full (2.1.1) | 0.59 | 0.73 | 0.86 | 0.00 | 0.59 |
| symfony (v8.1.6) | 0.65 | 2.10 | 2.22 | 0.00 | 0.93 |
| laravel-api (v13.30.1) | 1.52 | 1.84 | 1.95 | 0.00 | 1.55 |
| laravel (v13.30.1) | 1.81 | 2.41 | 8.10 | 0.00 | 2.05 |

## Latency — concurrency 63

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 4.44 | 10.93 | 15.90 | 0.00 | 5.15 |
| webrick-generated (5.1) | 6.71 | 16.31 | 23.55 | 0.00 | 7.72 |
| webrick-sharded (5.1) | 6.85 | 16.95 | 24.39 | 0.00 | 7.92 |
| webrick-fused (5.1) | 6.92 | 15.90 | 22.20 | 0.00 | 7.87 |
| infbyte (2.1.1) | 8.73 | 31.46 | 45.92 | 0.00 | 12.07 |
| infbyte-full (2.1.1) | 10.53 | 26.64 | 39.44 | 0.00 | 12.09 |
| symfony (v8.1.6) | 16.81 | 39.33 | 55.75 | 0.00 | 19.31 |
| laravel-api (v13.30.1) | 29.85 | 49.85 | 53.78 | 0.01 | 32.19 |
| laravel (v13.30.1) | 38.72 | 60.14 | 69.58 | 0.01 | 41.55 |

## Latency — concurrency 125

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 7.67 | 19.76 | 29.07 | 0.00 | 9.03 |
| webrick-sharded (5.1) | 12.66 | 35.15 | 51.03 | 0.01 | 15.83 |
| webrick-fused (5.1) | 13.19 | 31.30 | 44.64 | 0.01 | 15.21 |
| webrick-generated (5.1) | 13.33 | 36.42 | 52.56 | 0.01 | 15.91 |
| infbyte (2.1.1) | 18.26 | 64.80 | 88.17 | 0.01 | 24.58 |
| infbyte-full (2.1.1) | 21.39 | 53.99 | 78.11 | 0.01 | 24.95 |
| symfony (v8.1.6) | 33.71 | 74.23 | 104.59 | 0.01 | 39.02 |
| laravel-api (v13.30.1) | 59.05 | 119.04 | 143.21 | 0.02 | 66.63 |
| laravel (v13.30.1) | 77.87 | 145.32 | 167.86 | 0.02 | 86.89 |

## Latency — concurrency 250

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 13.35 | 32.49 | 48.96 | 0.01 | 15.06 |
| webrick-generated (5.1) | 25.97 | 64.65 | 90.40 | 0.02 | 31.11 |
| webrick-sharded (5.1) | 27.12 | 61.82 | 87.55 | 0.02 | 30.78 |
| webrick-fused (5.1) | 27.46 | 63.09 | 88.21 | 0.02 | 31.31 |
| infbyte (2.1.1) | 45.32 | 102.59 | 138.34 | 0.03 | 50.41 |
| infbyte-full (2.1.1) | 46.36 | 108.07 | 148.02 | 0.03 | 51.94 |
| symfony (v8.1.6) | 71.92 | 133.13 | 160.94 | 0.04 | 80.96 |
| laravel-api (v13.30.1) | 122.40 | 215.05 | 253.60 | 0.07 | 138.43 |
| laravel (v13.30.1) | 164.52 | 294.12 | 354.38 | 0.09 | 183.15 |

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
| webrick-fused (5.1) | 109723 | 109723 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 109469 | 109469 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-generated (5.1) | 108251 | 108251 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 85918 | 85918 | 0.00% | 0 | 0 | 0 | 0 |
| symfony (v8.1.6) | 58685 | 58685 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 37205 | 37205 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 28561 | 28561 | 0.00% | 0 | 0 | 0 | 0 |
| hyperf (v3.2.0) | 116549 | 116548 | 0.00% | 0 | 0 | 1 | 0 |
| infbyte-full (2.1.1) | 85467 | 85466 | 0.00% | 0 | 0 | 1 | 0 |

## Reliability — concurrency 63

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| webrick-sharded (5.1) | 209563 | 209563 | 0.00% | 0 | 0 | 0 | 0 |
| symfony (v8.1.6) | 95444 | 95444 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 58229 | 58229 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 45199 | 45199 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 144372 | 144371 | 0.00% | 0 | 0 | 2 | 0 |
| infbyte-full (2.1.1) | 143814 | 143813 | 0.00% | 0 | 0 | 1 | 0 |
| webrick-fused (5.1) | 210610 | 210608 | 0.00% | 0 | 0 | 3 | 0 |
| webrick-generated (5.1) | 211539 | 211535 | 0.00% | 0 | 0 | 4 | 0 |
| hyperf (v3.2.0) | 274702 | 274697 | 0.00% | 0 | 0 | 5 | 0 |

## Reliability — concurrency 125

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| infbyte-full (2.1.1) | 142120 | 142120 | 0.00% | 0 | 0 | 0 | 0 |
| symfony (v8.1.6) | 94181 | 94181 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 55915 | 55915 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 42990 | 42990 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-generated (5.1) | 210969 | 210964 | 0.00% | 0 | 0 | 5 | 0 |
| infbyte (2.1.1) | 144613 | 144610 | 0.00% | 0 | 0 | 4 | 0 |
| hyperf (v3.2.0) | 276571 | 276563 | 0.00% | 0 | 0 | 8 | 0 |
| webrick-fused (5.1) | 216544 | 216536 | 0.00% | 0 | 0 | 9 | 0 |
| webrick-sharded (5.1) | 211444 | 211431 | 0.01% | 0 | 0 | 13 | 0 |

## Reliability — concurrency 250

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| symfony (v8.1.6) | 91114 | 91114 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 53902 | 53902 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 40845 | 40845 | 0.00% | 0 | 0 | 0 | 0 |
| hyperf (v3.2.0) | 285795 | 285787 | 0.00% | 0 | 0 | 8 | 0 |
| webrick-sharded (5.1) | 212994 | 212985 | 0.00% | 0 | 0 | 9 | 0 |
| webrick-generated (5.1) | 210370 | 210361 | 0.00% | 0 | 0 | 9 | 0 |
| infbyte (2.1.1) | 142384 | 142376 | 0.01% | 0 | 0 | 8 | 0 |
| webrick-fused (5.1) | 211822 | 211809 | 0.01% | 0 | 0 | 13 | 0 |
| infbyte-full (2.1.1) | 140037 | 140016 | 0.02% | 0 | 0 | 21 | 0 |

## Relative comparison

| Target | Peak throughput | Remote memory | Server time | Included files |
| --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 6.33× | 1.55× | 1.00× | 4.50× |
| webrick-fused (5.1) | 4.79× | 1.01× | 6.29× | 1.07× |
| webrick-sharded (5.1) | 4.71× | 1.04× | 6.42× | 1.09× |
| webrick-generated (5.1) | 4.68× | 1.00× | 6.14× | 1.00× |
| infbyte (2.1.1) | 3.20× | 1.31× | 10.57× | 1.64× |
| infbyte-full (2.1.1) | 3.18× | 1.40× | 10.68× | 1.83× |
| symfony (v8.1.6) | 2.11× | 1.49× | 25.70× | 2.98× |
| laravel-api (v13.30.1) | 1.29× | 2.62× | 10.62× | 6.69× |
| laravel (v13.30.1) | 1.00× | 5.54× | 28.01× | 7.34× |

## Resource telemetry

| Target | Samples | Avg CPU | Peak CPU | Avg MB | Peak MB | Remote MB |
| --- | --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 0 | — | — | — | — | 12.24 |
| webrick-fused (5.1) | 0 | — | — | — | — | 7.99 |
| webrick-sharded (5.1) | 0 | — | — | — | — | 8.23 |
| webrick-generated (5.1) | 0 | — | — | — | — | 7.90 |
| infbyte (2.1.1) | 0 | — | — | — | — | 10.32 |
| infbyte-full (2.1.1) | 0 | — | — | — | — | 11.08 |
| symfony (v8.1.6) | 0 | — | — | — | — | 11.81 |
| laravel-api (v13.30.1) | 0 | — | — | — | — | 20.67 |
| laravel (v13.30.1) | 0 | — | — | — | — | 43.78 |

## Server response telemetry

| Target | Metric | Samples | Average | Minimum | Maximum |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | Included files | 1437930 | 386.79278 | 378.00000 | 387.00000 |
| hyperf (v3.2.0) | Server execution ms | 1437930 | 0.03185 | 0.00700 | 11.16000 |
| webrick-fused (5.1) | Included files | 1130553 | 91.99974 | 85.00000 | 92.00000 |
| webrick-fused (5.1) | Server execution ms | 1130553 | 0.20035 | 0.04500 | 56.06500 |
| webrick-sharded (5.1) | Included files | 1122710 | 93.99982 | 86.00000 | 94.00000 |
| webrick-sharded (5.1) | Server execution ms | 1122710 | 0.20460 | 0.04400 | 50.98500 |
| webrick-generated (5.1) | Included files | 1119197 | 85.99987 | 79.00000 | 86.00000 |
| webrick-generated (5.1) | Server execution ms | 1119197 | 0.19568 | 0.04500 | 49.31900 |
| infbyte (2.1.1) | Included files | 1044546 | 140.99955 | 129.00000 | 141.00000 |
| infbyte (2.1.1) | Server execution ms | 1044546 | 0.33677 | 0.07500 | 56.41400 |
| infbyte-full (2.1.1) | Included files | 1032829 | 156.99964 | 145.00000 | 157.00000 |
| infbyte-full (2.1.1) | Server execution ms | 1032829 | 0.34019 | 0.07300 | 91.12000 |
| symfony (v8.1.6) | Included files | 688846 | 255.99953 | 211.00000 | 256.00000 |
| symfony (v8.1.6) | Server execution ms | 688846 | 0.81863 | 0.09600 | 59.91200 |
| laravel-api (v13.30.1) | Included files | 420499 | 575.00734 | 546.00000 | 576.00000 |
| laravel-api (v13.30.1) | Server execution ms | 420499 | 0.33822 | 0.14700 | 44.75500 |
| laravel (v13.30.1) | Included files | 325189 | 631.20942 | 557.00000 | 632.00000 |
| laravel (v13.30.1) | Server execution ms | 325189 | 0.89201 | 0.38600 | 54.10300 |

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

| Setting | hyperf (v3.2.0) | webrick-fused (5.1) | webrick-sharded (5.1) | webrick-generated (5.1) | infbyte (2.1.1) | infbyte-full (2.1.1) | symfony (v8.1.6) | laravel-api (v13.30.1) | laravel (v13.30.1) |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| Url | http://127.0.0.1:46299/hyperf/hello/index | http://127.0.0.1:46299/webrick-fused/asset/public/index.php/hello/index | http://127.0.0.1:46299/webrick-sharded/asset/public/index.php/hello/index | http://127.0.0.1:46299/webrick-generated/asset/public/index.php/hello/index | http://127.0.0.1:46299/infbyte/asset/public/index.php/hello/index | http://127.0.0.1:46299/infbyte-full/asset/public/index.php/hello/index | http://127.0.0.1:46299/symfony/asset/public/index.php/hello/index | http://127.0.0.1:46299/laravel-api/asset/public/index.php/api/hello/index | http://127.0.0.1:46299/laravel/asset/public/index.php/hello/index |

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
