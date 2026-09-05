## Sustainable ranking

| Rank | Target | Best stable RPM | Stable concurrency | Peak observed RPM | Peak concurrency | Peak stability | Duration s |
| --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | pure-php (PHP 8.5.10) | 335,984 | 63 | 335,984 | 63 | Stable | 245.3 |
| 2 | fast-route (1.3.1) | 296,112 | 63 | 296,112 | 63 | Stable | 245.6 |
| 3 | kumbia (v1.2.1) | 278,806 | 63 | 278,806 | 63 | Stable | 245.9 |
| 4 | flight (v3.19.3) | 237,737 | 63 | 237,737 | 63 | Stable | 246.7 |
| 5 | fatfree (3.9.3) | 235,755 | 63 | 235,755 | 63 | Stable | 246.5 |
| 6 | leaf (v5.0) | 230,689 | 63 | 230,689 | 63 | Stable | 246.8 |
| 7 | slim (4.15.3) | 179,587 | 63 | 179,587 | 63 | Stable | 248.2 |
| 8 | webrick-generated (5.1) | 175,040 | 63 | 175,040 | 63 | Stable | 248.8 |
| 9 | webrick-fused (5.1) | 166,743 | 63 | 166,743 | 63 | Stable | 249.1 |
| 10 | webrick-sharded (5.1) | 162,415 | 63 | 162,415 | 63 | Stable | 249.5 |
| 11 | nette (v3.3.0) | 141,177 | 63 | 141,177 | 63 | Stable | 250.8 |
| 12 | yii-basic (2.0.55) | 125,944 | 63 | 125,944 | 63 | Stable | 252.0 |
| 13 | codeigniter (v4.7.4) | 120,960 | 63 | 120,960 | 63 | Stable | 252.9 |
| 14 | symfony (v8.1.6) | 112,462 | 63 | 112,462 | 63 | Stable | 253.1 |
| 15 | cakephp (5.4.1) | 110,637 | 63 | 110,637 | 63 | Stable | 253.1 |
| 16 | infbyte (2.1.1) | 93,956 | 63 | 93,956 | 63 | Stable | 256.3 |
| 17 | infbyte-full (2.1.1) | 93,485 | 63 | 93,485 | 63 | Stable | 256.5 |
| 18 | laravel-api (v13.30.1) | 62,494 | 63 | 62,494 | 63 | Stable | 265.8 |
| 19 | laravel (v13.30.1) | 55,228 | 63 | 55,228 | 63 | Stable | 268.5 |

## Throughput — concurrency 2

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.10) | 209,382 | 0.10% | Stable | 209,278 | 209,485 |
| fast-route (1.3.1) | 193,337 | 1.50% | Stable | 191,883 | 194,791 |
| kumbia (v1.2.1) | 186,344 | 0.46% | Stable | 186,773 | 185,915 |
| fatfree (3.9.3) | 166,088 | 1.78% | Stable | 164,611 | 167,564 |
| flight (v3.19.3) | 162,045 | 0.22% | Stable | 161,867 | 162,223 |
| leaf (v5.0) | 156,721 | 0.09% | Stable | 156,791 | 156,651 |
| slim (4.15.3) | 133,969 | 0.14% | Stable | 133,872 | 134,066 |
| webrick-generated (5.1) | 124,275 | 0.26% | Stable | 124,113 | 124,437 |
| webrick-fused (5.1) | 119,593 | 0.10% | Stable | 119,654 | 119,531 |
| webrick-sharded (5.1) | 115,135 | 0.90% | Stable | 115,655 | 114,615 |
| nette (v3.3.0) | 99,230 | 0.25% | Stable | 99,107 | 99,353 |
| yii-basic (2.0.55) | 90,459 | 0.02% | Stable | 90,450 | 90,467 |
| codeigniter (v4.7.4) | 86,392 | 3.70% | Stable | 84,795 | 87,989 |
| symfony (v8.1.6) | 81,859 | 0.05% | Stable | 81,837 | 81,881 |
| cakephp (5.4.1) | 80,318 | 2.18% | Stable | 79,443 | 81,192 |
| infbyte (2.1.1) | 66,718 | 1.41% | Stable | 66,249 | 67,187 |
| infbyte-full (2.1.1) | 66,263 | 0.73% | Stable | 66,021 | 66,505 |
| laravel-api (v13.30.1) | 42,418 | 11.25% | Unstable | 40,032 | 44,805 |
| laravel (v13.30.1) | 38,689 | 2.40% | Stable | 38,225 | 39,153 |

## Throughput — concurrency 63

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.10) | 335,984 | 3.79% | Stable | 329,624 | 342,345 |
| fast-route (1.3.1) | 296,112 | 5.85% | Stable | 287,446 | 304,778 |
| kumbia (v1.2.1) | 278,806 | 1.90% | Stable | 281,450 | 276,162 |
| flight (v3.19.3) | 237,737 | 0.82% | Stable | 236,767 | 238,707 |
| fatfree (3.9.3) | 235,755 | 6.62% | Stable | 227,950 | 243,561 |
| leaf (v5.0) | 230,689 | 1.58% | Stable | 228,868 | 232,509 |
| slim (4.15.3) | 179,587 | 2.19% | Stable | 181,550 | 177,625 |
| webrick-generated (5.1) | 175,040 | 0.33% | Stable | 175,332 | 174,748 |
| webrick-fused (5.1) | 166,743 | 0.13% | Stable | 166,850 | 166,636 |
| webrick-sharded (5.1) | 162,415 | 0.45% | Stable | 162,779 | 162,051 |
| nette (v3.3.0) | 141,177 | 0.22% | Stable | 141,330 | 141,023 |
| yii-basic (2.0.55) | 125,944 | 0.42% | Stable | 125,678 | 126,210 |
| codeigniter (v4.7.4) | 120,960 | 4.41% | Stable | 118,293 | 123,627 |
| symfony (v8.1.6) | 112,462 | 0.22% | Stable | 112,340 | 112,585 |
| cakephp (5.4.1) | 110,637 | 4.21% | Stable | 108,305 | 112,968 |
| infbyte (2.1.1) | 93,956 | 2.10% | Stable | 92,968 | 94,944 |
| infbyte-full (2.1.1) | 93,485 | 1.08% | Stable | 92,980 | 93,990 |
| laravel-api (v13.30.1) | 62,494 | 5.18% | Stable | 60,876 | 64,113 |
| laravel (v13.30.1) | 55,228 | 0.40% | Stable | 55,118 | 55,339 |

## Throughput — concurrency 125

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.10) | 326,266 | 0.96% | Stable | 324,701 | 327,832 |
| fast-route (1.3.1) | 293,232 | 1.57% | Stable | 290,925 | 295,539 |
| kumbia (v1.2.1) | 275,192 | 2.60% | Stable | 278,773 | 271,611 |
| fatfree (3.9.3) | 233,944 | 4.76% | Stable | 228,381 | 239,507 |
| flight (v3.19.3) | 232,249 | 3.08% | Stable | 228,667 | 235,831 |
| leaf (v5.0) | 225,613 | 1.35% | Stable | 224,095 | 227,131 |
| slim (4.15.3) | 173,609 | 1.18% | Stable | 174,629 | 172,588 |
| webrick-generated (5.1) | 169,013 | 0.29% | Stable | 169,261 | 168,764 |
| webrick-fused (5.1) | 161,964 | 0.13% | Stable | 161,856 | 162,073 |
| webrick-sharded (5.1) | 156,167 | 0.34% | Stable | 156,434 | 155,900 |
| nette (v3.3.0) | 136,221 | 0.54% | Stable | 135,857 | 136,586 |
| yii-basic (2.0.55) | 121,715 | 0.01% | Stable | 121,722 | 121,708 |
| codeigniter (v4.7.4) | 115,906 | 4.21% | Stable | 113,465 | 118,348 |
| symfony (v8.1.6) | 107,183 | 0.52% | Stable | 106,906 | 107,461 |
| cakephp (5.4.1) | 106,718 | 2.70% | Stable | 105,275 | 108,160 |
| infbyte (2.1.1) | 89,648 | 2.30% | Stable | 88,615 | 90,681 |
| infbyte-full (2.1.1) | 89,420 | 0.45% | Stable | 89,217 | 89,622 |
| laravel-api (v13.30.1) | 60,372 | 3.86% | Stable | 59,208 | 61,536 |
| laravel (v13.30.1) | 53,323 | 0.27% | Stable | 53,250 | 53,395 |

## Throughput — concurrency 250

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM |
| --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.10) | 323,100 | 1.71% | Stable | 325,861 | 320,338 |
| fast-route (1.3.1) | 289,621 | 1.42% | Stable | 287,564 | 291,677 |
| kumbia (v1.2.1) | 268,563 | 1.60% | Stable | 270,712 | 266,415 |
| fatfree (3.9.3) | 231,267 | 3.23% | Stable | 227,531 | 235,004 |
| flight (v3.19.3) | 228,011 | 1.44% | Stable | 226,369 | 229,654 |
| leaf (v5.0) | 225,385 | 1.78% | Stable | 223,375 | 227,394 |
| slim (4.15.3) | 171,227 | 0.10% | Stable | 171,140 | 171,313 |
| webrick-generated (5.1) | 167,731 | 0.24% | Stable | 167,528 | 167,934 |
| webrick-fused (5.1) | 160,304 | 0.48% | Stable | 160,691 | 159,918 |
| webrick-sharded (5.1) | 153,475 | 0.95% | Stable | 154,201 | 152,749 |
| nette (v3.3.0) | 133,851 | 0.37% | Stable | 133,605 | 134,097 |
| yii-basic (2.0.55) | 117,973 | 0.44% | Stable | 117,715 | 118,231 |
| codeigniter (v4.7.4) | 112,287 | 4.59% | Stable | 109,712 | 114,862 |
| symfony (v8.1.6) | 103,983 | 0.63% | Stable | 103,656 | 104,310 |
| cakephp (5.4.1) | 102,599 | 4.29% | Stable | 100,401 | 104,798 |
| infbyte (2.1.1) | 86,053 | 1.23% | Stable | 85,523 | 86,583 |
| infbyte-full (2.1.1) | 85,293 | 0.71% | Stable | 84,991 | 85,594 |
| laravel-api (v13.30.1) | 57,115 | 4.27% | Stable | 55,896 | 58,335 |
| laravel (v13.30.1) | 50,231 | 2.31% | Stable | 49,652 | 50,811 |

## Latency — serial

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.10) | 0.44 | 0.47 | 0.50 | 0.00 | 0.43 |
| fast-route (1.3.1) | 0.48 | 0.52 | 0.53 | 0.00 | 0.47 |
| kumbia (v1.2.1) | 0.51 | 0.55 | 0.58 | 0.00 | 0.49 |
| fatfree (3.9.3) | 0.57 | 0.61 | 0.69 | 0.00 | 0.55 |
| leaf (v5.0) | 0.58 | 0.63 | 0.79 | 0.00 | 0.56 |
| flight (v3.19.3) | 0.59 | 0.63 | 0.65 | 0.00 | 0.57 |
| slim (4.15.3) | 0.71 | 0.79 | 0.89 | 0.00 | 0.71 |
| webrick-generated (5.1) | 0.80 | 0.84 | 0.87 | 0.00 | 0.77 |
| webrick-fused (5.1) | 0.83 | 0.88 | 0.95 | 0.00 | 0.80 |
| webrick-sharded (5.1) | 0.86 | 0.91 | 0.95 | 0.00 | 0.84 |
| yii-basic (2.0.55) | 0.86 | 1.85 | 1.88 | 0.00 | 1.07 |
| nette (v3.3.0) | 0.93 | 1.34 | 1.41 | 0.00 | 0.96 |
| cakephp (5.4.1) | 1.09 | 1.90 | 2.01 | 0.00 | 1.17 |
| symfony (v8.1.6) | 1.11 | 1.45 | 1.49 | 0.00 | 1.16 |
| codeigniter (v4.7.4) | 1.17 | 1.27 | 1.45 | 0.00 | 1.16 |
| infbyte (2.1.1) | 1.48 | 1.58 | 1.78 | 0.00 | 1.47 |
| infbyte-full (2.1.1) | 1.50 | 1.61 | 1.81 | 0.00 | 1.49 |
| laravel-api (v13.30.1) | 2.37 | 2.65 | 2.82 | 0.00 | 2.38 |
| laravel (v13.30.1) | 2.62 | 2.83 | 3.08 | 0.00 | 2.62 |

## Latency — concurrency 2

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.10) | 0.49 | 0.61 | 0.70 | 0.00 | 0.49 |
| fast-route (1.3.1) | 0.53 | 0.67 | 0.78 | 0.00 | 0.54 |
| kumbia (v1.2.1) | 0.55 | 0.69 | 0.80 | 0.00 | 0.55 |
| fatfree (3.9.3) | 0.64 | 0.76 | 0.88 | 0.00 | 0.63 |
| flight (v3.19.3) | 0.65 | 0.77 | 0.88 | 0.00 | 0.65 |
| leaf (v5.0) | 0.66 | 0.82 | 0.94 | 0.00 | 0.65 |
| slim (4.15.3) | 0.80 | 0.96 | 1.08 | 0.00 | 0.80 |
| webrick-generated (5.1) | 0.87 | 1.03 | 1.12 | 0.00 | 0.88 |
| webrick-fused (5.1) | 0.91 | 1.07 | 1.17 | 0.00 | 0.91 |
| webrick-sharded (5.1) | 0.95 | 1.12 | 1.30 | 0.00 | 0.95 |
| yii-basic (2.0.55) | 0.98 | 2.26 | 2.40 | 0.00 | 1.22 |
| nette (v3.3.0) | 1.08 | 1.57 | 1.75 | 0.00 | 1.13 |
| codeigniter (v4.7.4) | 1.27 | 1.50 | 1.70 | 0.00 | 1.29 |
| cakephp (5.4.1) | 1.30 | 2.24 | 2.43 | 0.00 | 1.40 |
| symfony (v8.1.6) | 1.32 | 1.74 | 1.92 | 0.00 | 1.35 |
| infbyte (2.1.1) | 1.66 | 2.00 | 2.15 | 0.00 | 1.69 |
| infbyte-full (2.1.1) | 1.67 | 2.01 | 2.19 | 0.00 | 1.70 |
| laravel-api (v13.30.1) | 2.62 | 3.27 | 3.58 | 0.00 | 2.69 |
| laravel (v13.30.1) | 2.87 | 3.56 | 3.83 | 0.00 | 2.96 |

## Latency — concurrency 63

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.10) | 10.74 | 12.14 | 12.90 | 0.00 | 10.72 |
| fast-route (1.3.1) | 12.26 | 13.94 | 14.88 | 0.00 | 12.28 |
| kumbia (v1.2.1) | 13.07 | 14.66 | 15.59 | 0.00 | 13.02 |
| flight (v3.19.3) | 15.46 | 16.87 | 17.71 | 0.00 | 15.44 |
| fatfree (3.9.3) | 15.58 | 17.27 | 18.29 | 0.00 | 15.56 |
| leaf (v5.0) | 15.88 | 17.37 | 18.29 | 0.00 | 15.83 |
| slim (4.15.3) | 20.60 | 22.68 | 24.02 | 0.00 | 20.65 |
| webrick-generated (5.1) | 21.16 | 23.02 | 24.15 | 0.00 | 21.21 |
| webrick-fused (5.1) | 22.22 | 24.16 | 25.61 | 0.00 | 22.29 |
| webrick-sharded (5.1) | 22.84 | 24.77 | 25.99 | 0.00 | 22.90 |
| nette (v3.3.0) | 26.31 | 28.64 | 29.97 | 0.00 | 26.39 |
| yii-basic (2.0.55) | 29.30 | 32.90 | 35.59 | 0.00 | 29.58 |
| codeigniter (v4.7.4) | 30.82 | 33.20 | 34.48 | 0.00 | 30.90 |
| symfony (v8.1.6) | 33.15 | 35.57 | 36.92 | 0.00 | 33.24 |
| cakephp (5.4.1) | 33.50 | 37.12 | 41.73 | 0.00 | 33.81 |
| infbyte (2.1.1) | 39.65 | 42.53 | 48.58 | 0.00 | 39.87 |
| infbyte-full (2.1.1) | 39.95 | 42.71 | 44.38 | 0.00 | 40.07 |
| laravel-api (v13.30.1) | 59.92 | 63.89 | 66.12 | 0.01 | 60.13 |
| laravel (v13.30.1) | 67.79 | 72.29 | 75.33 | 0.01 | 68.00 |

## Latency — concurrency 125

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.10) | 22.13 | 24.40 | 26.06 | 0.01 | 22.16 |
| fast-route (1.3.1) | 24.73 | 26.92 | 28.47 | 0.01 | 24.78 |
| kumbia (v1.2.1) | 26.52 | 28.46 | 29.52 | 0.01 | 26.43 |
| fatfree (3.9.3) | 31.39 | 33.38 | 34.39 | 0.01 | 31.31 |
| flight (v3.19.3) | 31.58 | 33.52 | 35.68 | 0.01 | 31.57 |
| leaf (v5.0) | 32.47 | 34.45 | 35.77 | 0.01 | 32.38 |
| slim (4.15.3) | 42.55 | 45.09 | 46.72 | 0.01 | 42.52 |
| webrick-generated (5.1) | 43.73 | 45.83 | 47.73 | 0.01 | 43.70 |
| webrick-fused (5.1) | 45.69 | 47.94 | 49.46 | 0.01 | 45.63 |
| webrick-sharded (5.1) | 47.33 | 49.68 | 51.61 | 0.01 | 47.36 |
| nette (v3.3.0) | 54.35 | 57.05 | 59.36 | 0.01 | 54.40 |
| yii-basic (2.0.55) | 60.60 | 64.70 | 74.13 | 0.01 | 60.88 |
| codeigniter (v4.7.4) | 64.00 | 67.21 | 69.83 | 0.02 | 64.07 |
| symfony (v8.1.6) | 69.25 | 72.40 | 74.83 | 0.01 | 69.31 |
| cakephp (5.4.1) | 69.51 | 73.16 | 75.51 | 0.01 | 69.62 |
| infbyte (2.1.1) | 82.86 | 86.57 | 92.28 | 0.02 | 83.00 |
| infbyte-full (2.1.1) | 83.13 | 86.65 | 89.29 | 0.02 | 83.20 |
| laravel-api (v13.30.1) | 123.41 | 128.31 | 132.39 | 0.03 | 123.47 |
| laravel (v13.30.1) | 139.75 | 144.59 | 149.11 | 0.04 | 139.73 |

## Latency — concurrency 250

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.10) | 44.91 | 47.92 | 49.66 | 0.02 | 44.91 |
| fast-route (1.3.1) | 50.33 | 53.63 | 55.81 | 0.02 | 50.31 |
| kumbia (v1.2.1) | 54.35 | 57.67 | 61.31 | 0.03 | 54.40 |
| fatfree (3.9.3) | 63.50 | 66.35 | 68.01 | 0.03 | 63.35 |
| flight (v3.19.3) | 64.51 | 67.26 | 68.96 | 0.03 | 64.40 |
| leaf (v5.0) | 65.18 | 68.02 | 69.77 | 0.03 | 64.87 |
| slim (4.15.3) | 86.42 | 90.35 | 93.79 | 0.04 | 86.27 |
| webrick-generated (5.1) | 88.21 | 91.40 | 95.42 | 0.05 | 88.09 |
| webrick-fused (5.1) | 92.37 | 95.27 | 99.86 | 0.04 | 92.29 |
| webrick-sharded (5.1) | 96.74 | 99.79 | 101.96 | 0.04 | 96.43 |
| nette (v3.3.0) | 110.96 | 114.21 | 116.53 | 0.05 | 110.74 |
| yii-basic (2.0.55) | 125.61 | 130.50 | 145.07 | 0.06 | 125.75 |
| codeigniter (v4.7.4) | 132.10 | 136.44 | 163.39 | 0.06 | 132.28 |
| symfony (v8.1.6) | 143.12 | 147.19 | 152.14 | 0.07 | 142.86 |
| cakephp (5.4.1) | 144.92 | 150.27 | 156.12 | 0.08 | 144.85 |
| infbyte (2.1.1) | 173.19 | 177.70 | 180.79 | 0.08 | 172.82 |
| infbyte-full (2.1.1) | 174.65 | 179.20 | 183.70 | 0.09 | 174.37 |
| laravel-api (v13.30.1) | 261.44 | 268.77 | 275.53 | 0.13 | 260.67 |
| laravel (v13.30.1) | 297.55 | 308.05 | 315.42 | 0.13 | 296.22 |

## Reliability — serial

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| cakephp (5.4.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| codeigniter (v4.7.4) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| fast-route (1.3.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| fatfree (3.9.3) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| flight (v3.19.3) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| kumbia (v1.2.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| leaf (v5.0) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| nette (v3.3.0) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| pure-php (PHP 8.5.10) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| slim (4.15.3) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| symfony (v8.1.6) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-generated (5.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| yii-basic (2.0.55) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 2

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.10) | 104693 | 104693 | 0.00% | 0 | 0 | 0 | 0 |
| fast-route (1.3.1) | 96670 | 96670 | 0.00% | 0 | 0 | 0 | 0 |
| kumbia (v1.2.1) | 93174 | 93174 | 0.00% | 0 | 0 | 0 | 0 |
| fatfree (3.9.3) | 83045 | 83045 | 0.00% | 0 | 0 | 0 | 0 |
| flight (v3.19.3) | 81024 | 81024 | 0.00% | 0 | 0 | 0 | 0 |
| leaf (v5.0) | 78361 | 78361 | 0.00% | 0 | 0 | 0 | 0 |
| slim (4.15.3) | 66987 | 66987 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-generated (5.1) | 62139 | 62139 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 59798 | 59798 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 57568 | 57568 | 0.00% | 0 | 0 | 0 | 0 |
| nette (v3.3.0) | 49616 | 49616 | 0.00% | 0 | 0 | 0 | 0 |
| yii-basic (2.0.55) | 45230 | 45230 | 0.00% | 0 | 0 | 0 | 0 |
| codeigniter (v4.7.4) | 43197 | 43197 | 0.00% | 0 | 0 | 0 | 0 |
| symfony (v8.1.6) | 40931 | 40931 | 0.00% | 0 | 0 | 0 | 0 |
| cakephp (5.4.1) | 40160 | 40160 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 33361 | 33361 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 33132 | 33132 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 21211 | 21211 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 19346 | 19346 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 63

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.10) | 168040 | 168040 | 0.00% | 0 | 0 | 0 | 0 |
| fast-route (1.3.1) | 148103 | 148103 | 0.00% | 0 | 0 | 0 | 0 |
| kumbia (v1.2.1) | 139450 | 139450 | 0.00% | 0 | 0 | 0 | 0 |
| flight (v3.19.3) | 118917 | 118917 | 0.00% | 0 | 0 | 0 | 0 |
| fatfree (3.9.3) | 117927 | 117927 | 0.00% | 0 | 0 | 0 | 0 |
| leaf (v5.0) | 115397 | 115397 | 0.00% | 0 | 0 | 0 | 0 |
| slim (4.15.3) | 89843 | 89843 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-generated (5.1) | 87569 | 87569 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 83424 | 83424 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 81260 | 81260 | 0.00% | 0 | 0 | 0 | 0 |
| nette (v3.3.0) | 70641 | 70641 | 0.00% | 0 | 0 | 0 | 0 |
| yii-basic (2.0.55) | 63024 | 63024 | 0.00% | 0 | 0 | 0 | 0 |
| codeigniter (v4.7.4) | 60532 | 60532 | 0.00% | 0 | 0 | 0 | 0 |
| symfony (v8.1.6) | 56285 | 56285 | 0.00% | 0 | 0 | 0 | 0 |
| cakephp (5.4.1) | 55371 | 55371 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 47032 | 47032 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 46796 | 46796 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 31303 | 31303 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 27670 | 27670 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 125

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.10) | 163231 | 163231 | 0.00% | 0 | 0 | 0 | 0 |
| fast-route (1.3.1) | 146718 | 146718 | 0.00% | 0 | 0 | 0 | 0 |
| kumbia (v1.2.1) | 137693 | 137693 | 0.00% | 0 | 0 | 0 | 0 |
| fatfree (3.9.3) | 117076 | 117076 | 0.00% | 0 | 0 | 0 | 0 |
| flight (v3.19.3) | 116229 | 116229 | 0.00% | 0 | 0 | 0 | 0 |
| leaf (v5.0) | 112911 | 112911 | 0.00% | 0 | 0 | 0 | 0 |
| slim (4.15.3) | 86903 | 86903 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-generated (5.1) | 84610 | 84610 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 81083 | 81083 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 78185 | 78185 | 0.00% | 0 | 0 | 0 | 0 |
| nette (v3.3.0) | 68213 | 68213 | 0.00% | 0 | 0 | 0 | 0 |
| yii-basic (2.0.55) | 60987 | 60987 | 0.00% | 0 | 0 | 0 | 0 |
| codeigniter (v4.7.4) | 58057 | 58057 | 0.00% | 0 | 0 | 0 | 0 |
| symfony (v8.1.6) | 53695 | 53695 | 0.00% | 0 | 0 | 0 | 0 |
| cakephp (5.4.1) | 53463 | 53463 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 44927 | 44927 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 44816 | 44816 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 30294 | 30294 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 26780 | 26780 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 250

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.10) | 161755 | 161755 | 0.00% | 0 | 0 | 0 | 0 |
| fast-route (1.3.1) | 145023 | 145023 | 0.00% | 0 | 0 | 0 | 0 |
| kumbia (v1.2.1) | 134487 | 134487 | 0.00% | 0 | 0 | 0 | 0 |
| fatfree (3.9.3) | 115841 | 115841 | 0.00% | 0 | 0 | 0 | 0 |
| flight (v3.19.3) | 114220 | 114220 | 0.00% | 0 | 0 | 0 | 0 |
| leaf (v5.0) | 112904 | 112904 | 0.00% | 0 | 0 | 0 | 0 |
| slim (4.15.3) | 85825 | 85825 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-generated (5.1) | 84080 | 84080 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (5.1) | 80366 | 80366 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (5.1) | 76951 | 76951 | 0.00% | 0 | 0 | 0 | 0 |
| nette (v3.3.0) | 67136 | 67136 | 0.00% | 0 | 0 | 0 | 0 |
| yii-basic (2.0.55) | 59197 | 59197 | 0.00% | 0 | 0 | 0 | 0 |
| codeigniter (v4.7.4) | 56353 | 56353 | 0.00% | 0 | 0 | 0 | 0 |
| symfony (v8.1.6) | 52201 | 52201 | 0.00% | 0 | 0 | 0 | 0 |
| cakephp (5.4.1) | 51510 | 51510 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 43240 | 43240 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 42857 | 42857 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.30.1) | 28772 | 28772 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.30.1) | 25335 | 25335 | 0.00% | 0 | 0 | 0 | 0 |

## Relative comparison

| Target | Peak throughput | Remote memory | Server time | Included files |
| --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.10) | 6.08× | 1.00× | 1.00× | 1.00× |
| fast-route (1.3.1) | 5.36× | 1.00× | 2.81× | 12.00× |
| kumbia (v1.2.1) | 5.05× | 1.05× | 2.24× | 15.00× |
| flight (v3.19.3) | 4.30× | 1.12× | 4.43× | 29.00× |
| fatfree (3.9.3) | 4.27× | 1.12× | 3.60× | 7.00× |
| leaf (v5.0) | 4.18× | 1.10× | 4.14× | 22.00× |
| slim (4.15.3) | 3.25× | 1.07× | 7.87× | 88.25× |
| webrick-generated (5.1) | 3.17× | 1.12× | 8.27× | 79.00× |
| webrick-fused (5.1) | 3.02× | 1.15× | 8.91× | 85.00× |
| webrick-sharded (5.1) | 2.94× | 1.15× | 9.62× | 86.83× |
| nette (v3.3.0) | 2.56× | 1.22× | 12.51× | 96.75× |
| yii-basic (2.0.55) | 2.28× | 1.93× | 8.85× | 61.00× |
| codeigniter (v4.7.4) | 2.19× | 1.27× | 15.54× | 118.00× |
| symfony (v8.1.6) | 2.04× | 1.44× | 8.06× | 207.50× |
| cakephp (5.4.1) | 2.00× | 1.44× | 16.94× | 167.50× |
| infbyte (2.1.1) | 1.70× | 1.34× | 22.26× | 134.25× |
| infbyte-full (2.1.1) | 1.69× | 1.34× | 22.48× | 150.25× |
| laravel-api (v13.30.1) | 1.13× | 1.93× | 9.54× | 395.38× |
| laravel (v13.30.1) | 1.00× | 2.15× | 15.72× | 414.25× |

## Resource telemetry

| Target | Samples | Avg CPU | Peak CPU | Avg MB | Peak MB | Remote MB |
| --- | --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.10) | 0 | — | — | — | — | 0.41 |
| fast-route (1.3.1) | 0 | — | — | — | — | 0.41 |
| kumbia (v1.2.1) | 0 | — | — | — | — | 0.43 |
| flight (v3.19.3) | 0 | — | — | — | — | 0.46 |
| fatfree (3.9.3) | 0 | — | — | — | — | 0.46 |
| leaf (v5.0) | 0 | — | — | — | — | 0.45 |
| slim (4.15.3) | 0 | — | — | — | — | 0.44 |
| webrick-generated (5.1) | 0 | — | — | — | — | 0.46 |
| webrick-fused (5.1) | 0 | — | — | — | — | 0.47 |
| webrick-sharded (5.1) | 0 | — | — | — | — | 0.47 |
| nette (v3.3.0) | 0 | — | — | — | — | 0.50 |
| yii-basic (2.0.55) | 0 | — | — | — | — | 0.79 |
| codeigniter (v4.7.4) | 0 | — | — | — | — | 0.52 |
| symfony (v8.1.6) | 0 | — | — | — | — | 0.59 |
| cakephp (5.4.1) | 0 | — | — | — | — | 0.59 |
| infbyte (2.1.1) | 0 | — | — | — | — | 0.55 |
| infbyte-full (2.1.1) | 0 | — | — | — | — | 0.55 |
| laravel-api (v13.30.1) | 0 | — | — | — | — | 0.79 |
| laravel (v13.30.1) | 0 | — | — | — | — | 0.88 |

## Server response telemetry

| Target | Metric | Samples | Average | Minimum | Maximum |
| --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.10) | Included files | 1205437 | 1.00000 | 1.00000 | 1.00000 |
| pure-php (PHP 8.5.10) | Server execution ms | 1205437 | 0.09288 | 0.02600 | 4.29000 |
| fast-route (1.3.1) | Included files | 1083025 | 12.00000 | 12.00000 | 12.00000 |
| fast-route (1.3.1) | Server execution ms | 1083025 | 0.26082 | 0.06900 | 7.75900 |
| kumbia (v1.2.1) | Included files | 892157 | 15.00000 | 15.00000 | 15.00000 |
| kumbia (v1.2.1) | Server execution ms | 892157 | 0.20844 | 0.06800 | 5.96500 |
| flight (v3.19.3) | Included files | 761933 | 29.00000 | 29.00000 | 29.00000 |
| flight (v3.19.3) | Server execution ms | 761933 | 0.41140 | 0.13900 | 9.52900 |
| fatfree (3.9.3) | Included files | 658338 | 7.00000 | 7.00000 | 7.00000 |
| fatfree (3.9.3) | Server execution ms | 658338 | 0.33476 | 0.11400 | 10.79700 |
| leaf (v5.0) | Included files | 636867 | 22.00000 | 22.00000 | 22.00000 |
| leaf (v5.0) | Server execution ms | 636867 | 0.38482 | 0.13400 | 10.81900 |
| slim (4.15.3) | Included files | 669115 | 88.24987 | 85.00000 | 98.00000 |
| slim (4.15.3) | Server execution ms | 669115 | 0.73110 | 0.25500 | 14.04200 |
| webrick-generated (5.1) | Included files | 485101 | 79.00000 | 79.00000 | 79.00000 |
| webrick-generated (5.1) | Server execution ms | 485101 | 0.76770 | 0.32200 | 14.13700 |
| webrick-fused (5.1) | Included files | 464511 | 85.00000 | 85.00000 | 85.00000 |
| webrick-fused (5.1) | Server execution ms | 464511 | 0.82791 | 0.35000 | 17.36400 |
| webrick-sharded (5.1) | Included files | 448452 | 86.83333 | 86.00000 | 87.00000 |
| webrick-sharded (5.1) | Server execution ms | 448452 | 0.89336 | 0.38200 | 15.80000 |
| nette (v3.3.0) | Included files | 521209 | 96.75036 | 91.00000 | 141.00000 |
| nette (v3.3.0) | Server execution ms | 521209 | 1.16192 | 0.44600 | 15.39300 |
| yii-basic (2.0.55) | Included files | 350162 | 61.00000 | 61.00000 | 61.00000 |
| yii-basic (2.0.55) | Server execution ms | 350162 | 0.82171 | 0.37900 | 12.93600 |
| codeigniter (v4.7.4) | Included files | 390495 | 118.00000 | 118.00000 | 118.00000 |
| codeigniter (v4.7.4) | Server execution ms | 390495 | 1.44295 | 0.65100 | 19.87900 |
| symfony (v8.1.6) | Included files | 416221 | 207.49967 | 201.00000 | 227.00000 |
| symfony (v8.1.6) | Server execution ms | 416221 | 0.74835 | 0.23700 | 28.30300 |
| cakephp (5.4.1) | Included files | 411005 | 167.49971 | 162.00000 | 205.00000 |
| cakephp (5.4.1) | Server execution ms | 411005 | 1.57370 | 0.62800 | 17.41400 |
| infbyte (2.1.1) | Included files | 347119 | 134.25002 | 133.00000 | 135.00000 |
| infbyte (2.1.1) | Server execution ms | 347119 | 2.06788 | 0.93300 | 26.54700 |
| infbyte-full (2.1.1) | Included files | 345199 | 150.25003 | 149.00000 | 151.00000 |
| infbyte-full (2.1.1) | Server execution ms | 345199 | 2.08791 | 0.97700 | 30.57300 |
| laravel-api (v13.30.1) | Included files | 233157 | 395.37506 | 393.00000 | 396.00000 |
| laravel-api (v13.30.1) | Server execution ms | 233157 | 0.88642 | 0.37500 | 15.77400 |
| laravel (v13.30.1) | Included files | 208261 | 414.24993 | 407.00000 | 435.00000 |
| laravel (v13.30.1) | Server execution ms | 208261 | 1.46051 | 0.68900 | 16.09800 |

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

| Setting | pure-php (PHP 8.5.10) | fast-route (1.3.1) | kumbia (v1.2.1) | flight (v3.19.3) | fatfree (3.9.3) | leaf (v5.0) | slim (4.15.3) | webrick-generated (5.1) | webrick-fused (5.1) | webrick-sharded (5.1) | nette (v3.3.0) | yii-basic (2.0.55) | codeigniter (v4.7.4) | symfony (v8.1.6) | cakephp (5.4.1) | infbyte (2.1.1) | infbyte-full (2.1.1) | laravel-api (v13.30.1) | laravel (v13.30.1) |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| Url | http://127.0.0.1:46639/frameworks/pure-php/asset/public/index.php/hello/index | http://127.0.0.1:46639/frameworks/fast-route/asset/public/index.php/hello/index | http://127.0.0.1:46639/frameworks/kumbia/asset/default/public/index.php/hello/index | http://127.0.0.1:46639/frameworks/flight/asset/public/index.php/hello/index | http://127.0.0.1:46639/frameworks/fatfree/asset/public/index.php/hello/index | http://127.0.0.1:46639/frameworks/leaf/asset/public/index.php/hello/index | http://127.0.0.1:46639/frameworks/slim/asset/public/index.php/hello/index | http://127.0.0.1:46639/frameworks/webrick-generated/asset/public/index.php/hello/index | http://127.0.0.1:46639/frameworks/webrick-fused/asset/public/index.php/hello/index | http://127.0.0.1:46639/frameworks/webrick-sharded/asset/public/index.php/hello/index | http://127.0.0.1:46639/frameworks/nette/asset/www/index.php/hello/index | http://127.0.0.1:46639/frameworks/yii-basic/asset/web/index.php/hello/index | http://127.0.0.1:46639/frameworks/codeigniter/asset/public/index.php/hello/index | http://127.0.0.1:46639/frameworks/symfony/asset/public/index.php/hello/index | http://127.0.0.1:46639/frameworks/cakephp/asset/webroot/index.php/hello/index | http://127.0.0.1:46639/frameworks/infbyte/asset/public/index.php/hello/index | http://127.0.0.1:46639/frameworks/infbyte-full/asset/public/index.php/hello/index | http://127.0.0.1:46639/frameworks/laravel-api/asset/public/index.php/api/hello/index | http://127.0.0.1:46639/frameworks/laravel/asset/public/index.php/hello/index |

## Target-server environment

These settings come from the PHP web runtime that received benchmark requests.

| Setting | Value |
| --- | --- |
| PHP version | 8.5.10 |
| PHP SAPI | fpm-fcgi |
| Loaded php.ini | /usr/local/etc/php/php.ini |
| Benchmark environment profile | fpm-production |
| OPcache extension loaded | Yes |
| OPcache enabled for web requests | Yes |
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
