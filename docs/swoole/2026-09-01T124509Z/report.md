## Sustainable ranking

| Rank | Target | Best stable RPM | Stable concurrency | Peak observed RPM | Peak concurrency | Peak stability | Duration s |
| --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | hyperf (v3.2.0) | 525,064 | 250 | 525,064 | 250 | Stable | 244.4 |
| 2 | webrick-generated (5.0) | 413,607 | 63 | 413,607 | 63 | Stable | 245.1 |
| 3 | webrick-fused (5.0) | 413,323 | 125 | 413,323 | 125 | Stable | 247.9 |
| 4 | webrick-sharded (5.0) | 411,674 | 125 | 411,674 | 125 | Stable | 245.1 |
| 5 | infbyte (2.1.1) | 311,296 | 63 | 311,296 | 63 | Stable | 248.0 |
| 6 | infbyte-full (2.1.1) | 308,401 | 63 | 308,401 | 63 | Stable | 245.5 |
| 7 | symfony (v8.1.6) | 169,784 | 63 | 169,784 | 63 | Stable | 249.5 |
| 8 | laravel-api (v13.29.0) | 126,912 | 63 | 126,912 | 63 | Stable | 251.6 |
| 9 | laravel (v13.29.0) | 94,779 | 63 | 94,779 | 63 | Stable | 255.8 |

## Throughput — concurrency 2

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 248,400 | 0.80% | Stable | 249,399 | 247,401 |
| webrick-generated (5.0) | 217,081 | 3.64% | Stable | 221,030 | 213,131 |
| webrick-sharded (5.0) | 216,327 | 1.75% | Stable | 218,221 | 214,434 |
| webrick-fused (5.0) | 205,934 | 13.49% | Unstable | 219,828 | 192,041 |
| infbyte (2.1.1) | 194,816 | 1.60% | Stable | 196,370 | 193,261 |
| infbyte-full (2.1.1) | 192,665 | 2.61% | Stable | 195,181 | 190,149 |
| symfony (v8.1.6) | 108,203 | 9.85% | Stable | 113,531 | 102,874 |
| laravel-api (v13.29.0) | 83,455 | 17.75% | Unstable | 90,861 | 76,049 |
| laravel (v13.29.0) | 61,685 | 30.70% | Unstable | 71,154 | 52,217 |

## Throughput — concurrency 63

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 512,399 | 10.73% | Unstable | 539,899 | 484,899 |
| webrick-generated (5.0) | 413,607 | 5.14% | Stable | 424,232 | 402,983 |
| webrick-fused (5.0) | 406,893 | 4.22% | Stable | 415,476 | 398,310 |
| webrick-sharded (5.0) | 405,929 | 4.01% | Stable | 414,062 | 397,796 |
| infbyte (2.1.1) | 311,296 | 0.90% | Stable | 312,690 | 309,901 |
| infbyte-full (2.1.1) | 308,401 | 0.73% | Stable | 307,268 | 309,533 |
| symfony (v8.1.6) | 169,784 | 3.56% | Stable | 172,806 | 166,762 |
| laravel-api (v13.29.0) | 126,912 | 4.03% | Stable | 129,472 | 124,352 |
| laravel (v13.29.0) | 94,779 | 8.45% | Stable | 98,784 | 90,775 |

## Throughput — concurrency 125

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 522,578 | 5.74% | Stable | 537,588 | 507,569 |
| webrick-fused (5.0) | 413,323 | 3.63% | Stable | 420,822 | 405,823 |
| webrick-sharded (5.0) | 411,674 | 5.75% | Stable | 423,512 | 399,835 |
| webrick-generated (5.0) | 409,393 | 9.30% | Stable | 428,427 | 390,359 |
| infbyte (2.1.1) | 310,397 | 1.46% | Stable | 312,662 | 308,131 |
| infbyte-full (2.1.1) | 302,729 | 3.65% | Stable | 308,254 | 297,205 |
| symfony (v8.1.6) | 164,594 | 4.79% | Stable | 168,534 | 160,653 |
| laravel-api (v13.29.0) | 119,478 | 4.46% | Stable | 122,143 | 116,813 |
| laravel (v13.29.0) | 89,416 | 8.31% | Stable | 93,133 | 85,699 |

## Throughput — concurrency 250

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 525,064 | 4.28% | Stable | 536,306 | 513,823 |
| webrick-fused (5.0) | 408,274 | 6.58% | Stable | 421,708 | 394,839 |
| webrick-generated (5.0) | 402,642 | 6.71% | Stable | 416,147 | 389,138 |
| webrick-sharded (5.0) | 402,629 | 1.31% | Stable | 405,275 | 399,983 |
| infbyte (2.1.1) | 298,665 | 9.38% | Stable | 284,658 | 312,673 |
| infbyte-full (2.1.1) | 297,387 | 2.08% | Stable | 300,482 | 294,293 |
| symfony (v8.1.6) | 158,622 | 5.15% | Stable | 162,709 | 154,534 |
| laravel-api (v13.29.0) | 115,237 | 4.14% | Stable | 117,622 | 112,852 |
| laravel (v13.29.0) | 84,764 | 13.76% | Unstable | 90,597 | 78,931 |

## Latency — serial

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 0.33 | 0.49 | 0.53 | 0.00 | 0.35 |
| webrick-sharded (5.0) | 0.39 | 0.52 | 0.55 | 0.00 | 0.40 |
| webrick-fused (5.0) | 0.40 | 0.52 | 0.57 | 0.00 | 0.40 |
| webrick-generated (5.0) | 0.40 | 0.53 | 0.60 | 0.00 | 0.40 |
| infbyte-full (2.1.1) | 0.46 | 0.51 | 0.54 | 0.00 | 0.44 |
| infbyte (2.1.1) | 0.46 | 0.52 | 0.55 | 0.00 | 0.44 |
| symfony (v8.1.6) | 0.53 | 1.42 | 1.59 | 0.00 | 0.84 |
| laravel-api (v13.29.0) | 1.06 | 1.13 | 1.19 | 0.00 | 1.03 |
| laravel (v13.29.0) | 1.41 | 1.61 | 3.80 | 0.00 | 1.42 |

## Latency — concurrency 2

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 0.38 | 0.60 | 0.68 | 0.00 | 0.41 |
| webrick-generated (5.0) | 0.45 | 0.67 | 0.79 | 0.00 | 0.46 |
| webrick-sharded (5.0) | 0.45 | 0.67 | 0.79 | 0.00 | 0.47 |
| webrick-fused (5.0) | 0.46 | 0.69 | 0.80 | 0.00 | 0.49 |
| infbyte (2.1.1) | 0.53 | 0.67 | 0.79 | 0.00 | 0.52 |
| infbyte-full (2.1.1) | 0.53 | 0.68 | 0.84 | 0.00 | 0.53 |
| symfony (v8.1.6) | 0.62 | 2.00 | 2.11 | 0.00 | 1.01 |
| laravel-api (v13.29.0) | 1.30 | 1.64 | 1.80 | 0.00 | 1.35 |
| laravel (v13.29.0) | 1.73 | 2.32 | 6.12 | 0.00 | 1.88 |

## Latency — concurrency 63

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 5.22 | 13.96 | 19.53 | 0.00 | 6.33 |
| webrick-sharded (5.0) | 6.92 | 19.43 | 28.89 | 0.00 | 8.44 |
| webrick-generated (5.0) | 7.27 | 16.83 | 24.65 | 0.00 | 8.24 |
| webrick-fused (5.0) | 7.43 | 18.08 | 26.03 | 0.00 | 8.43 |
| infbyte-full (2.1.1) | 9.54 | 26.98 | 39.28 | 0.00 | 11.39 |
| infbyte (2.1.1) | 10.10 | 24.28 | 35.19 | 0.00 | 11.27 |
| symfony (v8.1.6) | 18.88 | 43.90 | 59.75 | 0.00 | 21.77 |
| laravel-api (v13.29.0) | 25.84 | 54.79 | 62.59 | 0.00 | 29.43 |
| laravel (v13.29.0) | 35.52 | 66.73 | 77.09 | 0.01 | 39.56 |

## Latency — concurrency 125

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 9.65 | 27.62 | 40.28 | 0.00 | 12.10 |
| webrick-generated (5.0) | 14.07 | 37.81 | 55.73 | 0.00 | 16.72 |
| webrick-fused (5.0) | 14.08 | 33.95 | 49.35 | 0.00 | 16.41 |
| webrick-sharded (5.0) | 14.38 | 34.81 | 50.54 | 0.00 | 16.49 |
| infbyte-full (2.1.1) | 20.07 | 52.28 | 71.82 | 0.01 | 23.46 |
| infbyte (2.1.1) | 20.50 | 44.09 | 62.72 | 0.01 | 22.81 |
| symfony (v8.1.6) | 38.11 | 85.46 | 119.30 | 0.01 | 44.69 |
| laravel-api (v13.29.0) | 51.72 | 116.16 | 154.23 | 0.01 | 62.15 |
| laravel (v13.29.0) | 71.83 | 158.76 | 205.38 | 0.02 | 83.33 |

## Latency — concurrency 250

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 17.43 | 52.03 | 76.72 | 0.02 | 21.70 |
| webrick-fused (5.0) | 27.31 | 72.70 | 102.89 | 0.02 | 33.51 |
| webrick-generated (5.0) | 28.19 | 76.36 | 106.62 | 0.02 | 33.78 |
| webrick-sharded (5.0) | 29.21 | 74.49 | 102.99 | 0.02 | 34.27 |
| infbyte (2.1.1) | 36.90 | 107.20 | 148.15 | 0.02 | 46.42 |
| infbyte-full (2.1.1) | 41.98 | 98.55 | 131.93 | 0.03 | 48.14 |
| symfony (v8.1.6) | 81.97 | 149.90 | 178.34 | 0.05 | 92.93 |
| laravel-api (v13.29.0) | 110.03 | 205.92 | 253.82 | 0.07 | 128.78 |
| laravel (v13.29.0) | 156.78 | 282.79 | 339.23 | 0.08 | 176.11 |

## Reliability — serial

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.29.0) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.29.0) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| symfony (v8.1.6) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.0) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-generated (5.0) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.0) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 2

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 124202 | 124202 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-generated (5.0) | 108542 | 108542 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.0) | 108166 | 108166 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 97409 | 97409 | 0.00% | 0 | 0 | 0 | 0 |
| symfony (v8.1.6) | 54103 | 54103 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.29.0) | 41729 | 41729 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.29.0) | 30848 | 30848 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.0) | 107395 | 107394 | 0.00% | 0 | 0 | 1 | 0 |
| infbyte-full (2.1.1) | 96335 | 96334 | 0.00% | 0 | 0 | 1 | 0 |

## Reliability — concurrency 63

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| infbyte-full (2.1.1) | 154265 | 154265 | 0.00% | 0 | 0 | 0 | 0 |
| symfony (v8.1.6) | 84954 | 84954 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.29.0) | 63516 | 63516 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.29.0) | 47451 | 47451 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 155709 | 155707 | 0.00% | 0 | 0 | 2 | 0 |
| webrick-fused (5.0) | 203506 | 203503 | 0.00% | 0 | 0 | 3 | 0 |
| webrick-sharded (5.0) | 203019 | 203016 | 0.00% | 0 | 0 | 3 | 0 |
| webrick-generated (5.0) | 206852 | 206846 | 0.00% | 0 | 0 | 6 | 0 |
| hyperf (v3.2.0) | 256249 | 256242 | 0.00% | 0 | 0 | 7 | 0 |

## Reliability — concurrency 125

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| symfony (v8.1.6) | 82417 | 82417 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.29.0) | 59854 | 59854 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.29.0) | 44820 | 44820 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 155313 | 155311 | 0.00% | 0 | 0 | 3 | 0 |
| infbyte-full (2.1.1) | 151507 | 151503 | 0.00% | 0 | 0 | 5 | 0 |
| webrick-fused (5.0) | 206775 | 206765 | 0.01% | 0 | 0 | 10 | 0 |
| hyperf (v3.2.0) | 261389 | 261375 | 0.01% | 0 | 0 | 14 | 0 |
| webrick-sharded (5.0) | 205958 | 205945 | 0.01% | 0 | 0 | 13 | 0 |
| webrick-generated (5.0) | 204833 | 204818 | 0.01% | 0 | 0 | 15 | 0 |

## Reliability — concurrency 250

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| symfony (v8.1.6) | 79551 | 79551 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.29.0) | 57863 | 57863 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.29.0) | 42622 | 42622 | 0.00% | 0 | 0 | 0 | 0 |
| hyperf (v3.2.0) | 262717 | 262696 | 0.01% | 0 | 0 | 21 | 0 |
| webrick-generated (5.0) | 201565 | 201548 | 0.01% | 0 | 0 | 17 | 0 |
| webrick-fused (5.0) | 204404 | 204384 | 0.01% | 0 | 0 | 21 | 0 |
| webrick-sharded (5.0) | 201589 | 201556 | 0.02% | 0 | 0 | 33 | 0 |
| infbyte (2.1.1) | 155504 | 155472 | 0.02% | 0 | 0 | 32 | 0 |
| infbyte-full (2.1.1) | 148960 | 148919 | 0.03% | 0 | 0 | 42 | 0 |

## Relative comparison

| Target | Peak throughput | Remote memory | Server time | Included files |
| --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 5.54× | 1.26× | 1.00× | 4.20× |
| webrick-generated (5.0) | 4.36× | 1.17× | 6.34× | 1.00× |
| webrick-fused (5.0) | 4.36× | 1.19× | 6.31× | 1.07× |
| webrick-sharded (5.0) | 4.34× | 1.20× | 6.44× | 1.09× |
| infbyte (2.1.1) | 3.28× | 1.00× | 8.96× | 1.53× |
| infbyte-full (2.1.1) | 3.25× | 1.11× | 9.27× | 1.71× |
| symfony (v8.1.6) | 1.79× | 1.15× | 28.89× | 2.78× |
| laravel-api (v13.29.0) | 1.34× | 2.05× | 9.62× | 6.25× |
| laravel (v13.29.0) | 1.00× | 4.00× | 25.33× | 6.86× |

## Resource telemetry

| Target | Samples | Avg CPU | Peak CPU | Avg MB | Peak MB | Remote MB |
| --- | --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | 0 | — | — | — | — | 12.77 |
| webrick-generated (5.0) | 0 | — | — | — | — | 11.77 |
| webrick-fused (5.0) | 0 | — | — | — | — | 12.05 |
| webrick-sharded (5.0) | 0 | — | — | — | — | 12.15 |
| infbyte (2.1.1) | 0 | — | — | — | — | 10.10 |
| infbyte-full (2.1.1) | 0 | — | — | — | — | 11.25 |
| symfony (v8.1.6) | 0 | — | — | — | — | 11.59 |
| laravel-api (v13.29.0) | 0 | — | — | — | — | 20.66 |
| laravel (v13.29.0) | 0 | — | — | — | — | 40.41 |

## Server response telemetry

| Target | Metric | Samples | Average | Minimum | Maximum |
| --- | --- | --- | --- | --- | --- |
| hyperf (v3.2.0) | Included files | 1091473 | 386.84513 | 378.00000 | 387.00000 |
| hyperf (v3.2.0) | Server execution ms | 1091473 | 0.03352 | 0.00400 | 38.01500 |
| webrick-generated (5.0) | Included files | 1453507 | 91.99968 | 77.00000 | 92.00000 |
| webrick-generated (5.0) | Server execution ms | 1453507 | 0.21267 | 0.01100 | 64.67600 |
| webrick-fused (5.0) | Included files | 1454091 | 97.99976 | 83.00000 | 98.00000 |
| webrick-fused (5.0) | Server execution ms | 1454091 | 0.21152 | 0.01200 | 45.74000 |
| webrick-sharded (5.0) | Included files | 1447365 | 99.99964 | 85.00000 | 100.00000 |
| webrick-sharded (5.0) | Server execution ms | 1447365 | 0.21589 | 0.01300 | 47.32300 |
| infbyte (2.1.1) | Included files | 1137796 | 140.99979 | 129.00000 | 141.00000 |
| infbyte (2.1.1) | Server execution ms | 1137796 | 0.30032 | 0.06100 | 70.28900 |
| infbyte-full (2.1.1) | Included files | 1112039 | 156.99974 | 145.00000 | 157.00000 |
| infbyte-full (2.1.1) | Server execution ms | 1112039 | 0.31078 | 0.06100 | 72.84900 |
| symfony (v8.1.6) | Included files | 612047 | 255.99975 | 208.00000 | 256.00000 |
| symfony (v8.1.6) | Server execution ms | 612047 | 0.96835 | 0.06800 | 62.20600 |
| laravel-api (v13.29.0) | Included files | 455923 | 575.01986 | 545.00000 | 576.00000 |
| laravel-api (v13.29.0) | Server execution ms | 455923 | 0.32262 | 0.13000 | 56.70000 |
| laravel (v13.29.0) | Included files | 341478 | 631.24873 | 558.00000 | 632.00000 |
| laravel (v13.29.0) | Server execution ms | 341478 | 0.84915 | 0.36700 | 54.92700 |

## Common configuration

| Setting | Value |
| --- | --- |
| Method | GET |
| Expected status | 200 |
| Count per phase | 5000 |
| Max concurrency | 250 |
| Concurrency levels | 2, 63, 125, 250 |
| Repetitions | 2 |
| Maximum rpm spread percent | 10 |
| Warm up requests per scenario | 10 |
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
| Route workload | Static (GET 200), Dynamic middle (GET 200), Dynamic last (GET 200), 404 (GET 404), 405 (POST 405) |

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

| Setting | hyperf (v3.2.0) | webrick-generated (5.0) | webrick-fused (5.0) | webrick-sharded (5.0) | infbyte (2.1.1) | infbyte-full (2.1.1) | symfony (v8.1.6) | laravel-api (v13.29.0) | laravel (v13.29.0) |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| Url | http://127.0.0.1:39897/hyperf/hello/index | http://127.0.0.1:39897/webrick-generated/asset/public/index.php/hello/index | http://127.0.0.1:39897/webrick-fused/asset/public/index.php/hello/index | http://127.0.0.1:39897/webrick-sharded/asset/public/index.php/hello/index | http://127.0.0.1:39897/infbyte/asset/public/index.php/hello/index | http://127.0.0.1:39897/infbyte-full/asset/public/index.php/hello/index | http://127.0.0.1:39897/symfony/asset/public/index.php/hello/index | http://127.0.0.1:39897/laravel-api/asset/public/index.php/api/hello/index | http://127.0.0.1:39897/laravel/asset/public/index.php/hello/index |

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
