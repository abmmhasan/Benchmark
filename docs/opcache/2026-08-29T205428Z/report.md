## Sustainable ranking

| Rank | Target | Best stable RPM | Stable concurrency | Peak observed RPM | Peak concurrency | Peak stability | Duration s |
| --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | pure-php (PHP 8.5.9) | 419,137 | 63 | 419,137 | 63 | Stable | 387.5 |
| 2 | fast-route (1.3.1) | 363,666 | 63 | 363,666 | 63 | Stable | 388.1 |
| 3 | kumbia (v1.2.1) | 343,850 | 63 | 343,850 | 63 | Stable | 388.4 |
| 4 | leaf (v5.0) | 291,371 | 63 | 291,371 | 63 | Stable | 389.0 |
| 5 | fatfree (3.9.3) | 286,121 | 63 | 286,121 | 63 | Stable | 389.3 |
| 6 | flight (v3.19.1) | 264,935 | 63 | 264,935 | 63 | Stable | 389.6 |
| 7 | slim (4.15.2) | 203,622 | 63 | 203,622 | 63 | Stable | 391.6 |
| 8 | yii-basic (2.0.55) | 194,465 | 63 | 194,465 | 63 | Stable | 391.5 |
| 9 | webrick-fused (4.0.2) | 166,053 | 63 | 166,053 | 63 | Stable | 393.5 |
| 10 | webrick-sharded (4.0.2) | 161,291 | 63 | 161,291 | 63 | Stable | 394.1 |
| 11 | codeigniter (v4.7.4) | 125,416 | 63 | 125,416 | 63 | Stable | 397.7 |
| 12 | cakephp (5.4.1) | 118,684 | 63 | 118,684 | 63 | Stable | 398.4 |
| 13 | nette (v3.3.0) | 116,082 | 63 | 116,082 | 63 | Stable | 399.2 |
| 14 | symfony (v8.1.5) | 112,999 | 63 | 112,999 | 63 | Stable | 399.0 |
| 15 | infbyte (2.1.1) | 94,538 | 63 | 94,538 | 63 | Stable | 403.7 |
| 16 | infbyte-full (2.1.1) | 94,025 | 63 | 94,025 | 63 | Stable | 403.8 |
| 17 | laravel-api (v13.29.0) | 56,202 | 63 | 56,202 | 63 | Stable | 419.1 |
| 18 | laravel (v13.29.0) | 49,208 | 63 | 49,208 | 63 | Stable | 425.4 |

## Throughput — concurrency 2

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM | Run 3 RPM |
| --- | --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.9) | 248,792 | 0.11% | Stable | 248,614 | 248,792 | 248,891 |
| fast-route (1.3.1) | 227,804 | 1.48% | Stable | 227,804 | 228,285 | 224,913 |
| kumbia (v1.2.1) | 219,306 | 0.10% | Stable | 219,089 | 219,306 | 219,314 |
| leaf (v5.0) | 200,096 | 0.27% | Stable | 200,396 | 200,096 | 199,862 |
| fatfree (3.9.3) | 194,991 | 0.44% | Stable | 195,466 | 194,991 | 194,616 |
| flight (v3.19.1) | 184,792 | 0.21% | Stable | 184,792 | 184,675 | 185,055 |
| yii-basic (2.0.55) | 150,129 | 0.33% | Stable | 150,129 | 149,854 | 150,356 |
| slim (4.15.2) | 149,033 | 0.37% | Stable | 148,693 | 149,033 | 149,249 |
| webrick-fused (4.0.2) | 126,372 | 0.06% | Stable | 126,372 | 126,345 | 126,421 |
| webrick-sharded (4.0.2) | 121,592 | 0.33% | Stable | 121,592 | 121,511 | 121,907 |
| codeigniter (v4.7.4) | 94,487 | 0.66% | Stable | 94,360 | 94,487 | 94,980 |
| cakephp (5.4.1) | 90,698 | 0.95% | Stable | 90,698 | 90,165 | 91,030 |
| symfony (v8.1.5) | 89,227 | 0.32% | Stable | 89,151 | 89,227 | 89,434 |
| nette (v3.3.0) | 87,465 | 0.36% | Stable | 87,362 | 87,465 | 87,675 |
| infbyte (2.1.1) | 70,091 | 0.77% | Stable | 69,572 | 70,112 | 70,091 |
| infbyte-full (2.1.1) | 69,605 | 0.67% | Stable | 69,325 | 69,605 | 69,789 |
| laravel-api (v13.29.0) | 42,699 | 0.72% | Stable | 42,640 | 42,946 | 42,699 |
| laravel (v13.29.0) | 37,088 | 1.02% | Stable | 36,716 | 37,095 | 37,088 |

## Throughput — concurrency 63

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM | Run 3 RPM |
| --- | --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.9) | 419,137 | 0.84% | Stable | 419,137 | 420,277 | 416,745 |
| fast-route (1.3.1) | 363,666 | 0.89% | Stable | 363,666 | 365,539 | 362,287 |
| kumbia (v1.2.1) | 343,850 | 0.47% | Stable | 345,248 | 343,625 | 343,850 |
| leaf (v5.0) | 291,371 | 1.65% | Stable | 292,225 | 291,371 | 287,420 |
| fatfree (3.9.3) | 286,121 | 2.93% | Stable | 289,526 | 286,121 | 281,133 |
| flight (v3.19.1) | 264,935 | 4.06% | Stable | 257,985 | 264,935 | 268,753 |
| slim (4.15.2) | 203,622 | 0.93% | Stable | 204,054 | 203,622 | 202,161 |
| yii-basic (2.0.55) | 194,465 | 3.73% | Stable | 200,428 | 194,465 | 193,176 |
| webrick-fused (4.0.2) | 166,053 | 2.93% | Stable | 162,713 | 166,053 | 167,580 |
| webrick-sharded (4.0.2) | 161,291 | 0.63% | Stable | 161,291 | 160,854 | 161,878 |
| codeigniter (v4.7.4) | 125,416 | 3.12% | Stable | 125,416 | 128,492 | 124,580 |
| cakephp (5.4.1) | 118,684 | 2.34% | Stable | 121,315 | 118,535 | 118,684 |
| nette (v3.3.0) | 116,082 | 1.43% | Stable | 116,009 | 117,667 | 116,082 |
| symfony (v8.1.5) | 112,999 | 2.01% | Stable | 111,870 | 114,146 | 112,999 |
| infbyte (2.1.1) | 94,538 | 2.61% | Stable | 92,617 | 94,538 | 95,081 |
| infbyte-full (2.1.1) | 94,025 | 0.75% | Stable | 93,634 | 94,025 | 94,342 |
| laravel-api (v13.29.0) | 56,202 | 3.32% | Stable | 56,202 | 57,048 | 55,182 |
| laravel (v13.29.0) | 49,208 | 1.84% | Stable | 48,534 | 49,441 | 49,208 |

## Throughput — concurrency 125

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM | Run 3 RPM |
| --- | --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.9) | 401,966 | 1.43% | Stable | 402,534 | 401,966 | 396,803 |
| fast-route (1.3.1) | 348,521 | 2.12% | Stable | 354,079 | 348,521 | 346,695 |
| kumbia (v1.2.1) | 331,489 | 0.60% | Stable | 332,230 | 331,489 | 330,251 |
| leaf (v5.0) | 279,664 | 5.04% | Stable | 279,664 | 285,504 | 271,404 |
| fatfree (3.9.3) | 277,821 | 2.50% | Stable | 278,088 | 277,821 | 271,139 |
| flight (v3.19.1) | 255,368 | 2.01% | Stable | 253,705 | 255,368 | 258,842 |
| slim (4.15.2) | 193,455 | 1.20% | Stable | 193,455 | 192,435 | 194,762 |
| yii-basic (2.0.55) | 188,410 | 1.58% | Stable | 188,410 | 190,781 | 187,802 |
| webrick-fused (4.0.2) | 157,900 | 2.96% | Stable | 154,010 | 157,900 | 158,685 |
| webrick-sharded (4.0.2) | 153,930 | 0.38% | Stable | 154,305 | 153,930 | 153,713 |
| codeigniter (v4.7.4) | 118,841 | 3.04% | Stable | 116,646 | 120,259 | 118,841 |
| cakephp (5.4.1) | 110,288 | 2.55% | Stable | 112,627 | 109,818 | 110,288 |
| nette (v3.3.0) | 107,726 | 0.94% | Stable | 107,726 | 107,711 | 108,721 |
| symfony (v8.1.5) | 105,236 | 2.34% | Stable | 105,236 | 104,796 | 107,259 |
| infbyte (2.1.1) | 88,364 | 1.04% | Stable | 87,786 | 88,705 | 88,364 |
| infbyte-full (2.1.1) | 88,054 | 1.37% | Stable | 86,909 | 88,054 | 88,111 |
| laravel-api (v13.29.0) | 53,417 | 1.45% | Stable | 53,122 | 53,417 | 53,894 |
| laravel (v13.29.0) | 46,025 | 5.84% | Stable | 44,422 | 46,025 | 47,112 |

## Throughput — concurrency 250

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM | Run 3 RPM |
| --- | --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.9) | 318,526 | 0.84% | Stable | 320,296 | 317,617 | 318,526 |
| fast-route (1.3.1) | 282,099 | 2.78% | Stable | 283,199 | 282,099 | 275,357 |
| kumbia (v1.2.1) | 269,671 | 1.07% | Stable | 269,671 | 267,615 | 270,514 |
| leaf (v5.0) | 230,548 | 4.94% | Stable | 233,084 | 230,548 | 221,700 |
| fatfree (3.9.3) | 220,917 | 5.11% | Stable | 228,577 | 220,917 | 217,288 |
| flight (v3.19.1) | 208,019 | 2.68% | Stable | 202,988 | 208,561 | 208,019 |
| slim (4.15.2) | 156,751 | 0.78% | Stable | 156,959 | 155,742 | 156,751 |
| yii-basic (2.0.55) | 152,872 | 0.89% | Stable | 152,872 | 152,859 | 154,223 |
| webrick-fused (4.0.2) | 128,365 | 1.46% | Stable | 128,402 | 128,365 | 126,529 |
| webrick-sharded (4.0.2) | 122,802 | 1.40% | Stable | 121,282 | 122,802 | 123,000 |
| codeigniter (v4.7.4) | 93,857 | 2.86% | Stable | 95,665 | 92,979 | 93,857 |
| cakephp (5.4.1) | 88,828 | 0.70% | Stable | 88,828 | 88,302 | 88,921 |
| symfony (v8.1.5) | 87,553 | 0.83% | Stable | 87,121 | 87,553 | 87,849 |
| nette (v3.3.0) | 85,799 | 1.91% | Stable | 87,295 | 85,660 | 85,799 |
| infbyte (2.1.1) | 69,357 | 0.34% | Stable | 69,156 | 69,390 | 69,357 |
| infbyte-full (2.1.1) | 68,542 | 0.83% | Stable | 68,690 | 68,542 | 68,124 |
| laravel-api (v13.29.0) | 41,667 | 1.19% | Stable | 41,667 | 41,366 | 41,864 |
| laravel (v13.29.0) | 36,219 | 3.88% | Stable | 34,832 | 36,238 | 36,219 |

## Latency — serial

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.9) | 0.35 | 0.39 | 0.64 | 0.00 | 0.34 |
| fast-route (1.3.1) | 0.40 | 0.43 | 0.66 | 0.00 | 0.38 |
| kumbia (v1.2.1) | 0.41 | 0.45 | 0.73 | 0.00 | 0.40 |
| leaf (v5.0) | 0.46 | 0.50 | 0.92 | 0.00 | 0.45 |
| fatfree (3.9.3) | 0.47 | 0.51 | 0.72 | 0.00 | 0.46 |
| flight (v3.19.1) | 0.50 | 0.54 | 0.84 | 0.00 | 0.49 |
| yii-basic (2.0.55) | 0.62 | 0.68 | 1.35 | 0.00 | 0.61 |
| slim (4.15.2) | 0.63 | 0.68 | 1.28 | 0.00 | 0.62 |
| webrick-fused (4.0.2) | 0.76 | 0.82 | 1.21 | 0.00 | 0.74 |
| webrick-sharded (4.0.2) | 0.79 | 0.86 | 1.61 | 0.00 | 0.79 |
| codeigniter (v4.7.4) | 1.02 | 1.10 | 1.97 | 0.00 | 1.02 |
| cakephp (5.4.1) | 1.07 | 1.15 | 2.22 | 0.00 | 1.07 |
| symfony (v8.1.5) | 1.10 | 1.17 | 1.92 | 0.00 | 1.01 |
| nette (v3.3.0) | 1.11 | 1.20 | 2.40 | 0.00 | 1.12 |
| infbyte (2.1.1) | 1.41 | 1.48 | 2.43 | 0.00 | 1.41 |
| infbyte-full (2.1.1) | 1.42 | 1.49 | 2.11 | 0.00 | 1.42 |
| laravel-api (v13.29.0) | 2.38 | 2.49 | 3.51 | 0.00 | 2.16 |
| laravel (v13.29.0) | 2.79 | 3.00 | 5.94 | 0.00 | 2.56 |

## Latency — concurrency 2

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.9) | 0.39 | 0.51 | 0.73 | 0.00 | 0.39 |
| fast-route (1.3.1) | 0.43 | 0.56 | 0.80 | 0.00 | 0.44 |
| kumbia (v1.2.1) | 0.45 | 0.58 | 0.82 | 0.00 | 0.46 |
| leaf (v5.0) | 0.50 | 0.63 | 0.89 | 0.00 | 0.51 |
| fatfree (3.9.3) | 0.51 | 0.64 | 0.91 | 0.00 | 0.52 |
| flight (v3.19.1) | 0.55 | 0.68 | 0.97 | 0.00 | 0.55 |
| yii-basic (2.0.55) | 0.69 | 0.85 | 1.16 | 0.00 | 0.70 |
| slim (4.15.2) | 0.70 | 0.85 | 1.16 | 0.00 | 0.71 |
| webrick-fused (4.0.2) | 0.84 | 1.01 | 1.36 | 0.00 | 0.85 |
| webrick-sharded (4.0.2) | 0.87 | 1.05 | 1.41 | 0.00 | 0.89 |
| codeigniter (v4.7.4) | 1.14 | 1.38 | 1.80 | 0.00 | 1.17 |
| cakephp (5.4.1) | 1.18 | 1.45 | 1.82 | 0.00 | 1.22 |
| nette (v3.3.0) | 1.23 | 1.51 | 1.96 | 0.00 | 1.27 |
| symfony (v8.1.5) | 1.24 | 1.47 | 1.89 | 0.00 | 1.17 |
| infbyte (2.1.1) | 1.54 | 1.93 | 2.31 | 0.00 | 1.61 |
| infbyte-full (2.1.1) | 1.55 | 1.94 | 2.31 | 0.00 | 1.63 |
| laravel-api (v13.29.0) | 2.55 | 3.24 | 3.66 | 0.00 | 2.44 |
| laravel (v13.29.0) | 2.94 | 3.76 | 4.18 | 0.00 | 2.84 |

## Latency — concurrency 63

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.9) | 6.03 | 14.90 | 24.12 | 0.01 | 6.96 |
| fast-route (1.3.1) | 8.03 | 20.46 | 32.06 | 0.01 | 9.22 |
| kumbia (v1.2.1) | 8.74 | 22.69 | 32.72 | 0.01 | 9.94 |
| leaf (v5.0) | 10.24 | 29.58 | 42.39 | 0.01 | 12.30 |
| fatfree (3.9.3) | 10.67 | 30.21 | 44.58 | 0.01 | 12.53 |
| flight (v3.19.1) | 11.69 | 34.60 | 49.83 | 0.01 | 13.75 |
| slim (4.15.2) | 14.35 | 47.49 | 64.18 | 0.01 | 18.15 |
| yii-basic (2.0.55) | 15.56 | 48.58 | 64.52 | 0.01 | 19.07 |
| webrick-fused (4.0.2) | 17.26 | 60.81 | 80.11 | 0.01 | 22.43 |
| webrick-sharded (4.0.2) | 17.27 | 67.02 | 84.90 | 0.01 | 23.13 |
| codeigniter (v4.7.4) | 25.88 | 69.98 | 84.67 | 0.01 | 29.86 |
| nette (v3.3.0) | 26.63 | 75.79 | 92.77 | 0.01 | 32.29 |
| symfony (v8.1.5) | 26.67 | 78.85 | 95.26 | 0.01 | 29.97 |
| cakephp (5.4.1) | 27.70 | 69.71 | 84.84 | 0.01 | 31.57 |
| infbyte-full (2.1.1) | 35.64 | 84.25 | 98.51 | 0.01 | 39.94 |
| infbyte (2.1.1) | 36.02 | 84.04 | 99.73 | 0.01 | 39.71 |
| laravel-api (v13.29.0) | 67.82 | 132.52 | 161.42 | 0.01 | 53.59 |
| laravel (v13.29.0) | 77.09 | 151.03 | 176.04 | 0.01 | 70.01 |

## Latency — concurrency 125

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.9) | 11.73 | 31.36 | 56.09 | 0.02 | 14.53 |
| fast-route (1.3.1) | 15.91 | 42.47 | 62.32 | 0.01 | 18.94 |
| kumbia (v1.2.1) | 17.21 | 46.72 | 67.52 | 0.01 | 20.56 |
| leaf (v5.0) | 20.11 | 63.60 | 92.47 | 0.01 | 25.63 |
| fatfree (3.9.3) | 20.13 | 61.76 | 89.34 | 0.01 | 25.66 |
| flight (v3.19.1) | 22.75 | 67.73 | 98.05 | 0.01 | 28.22 |
| slim (4.15.2) | 27.31 | 101.48 | 140.97 | 0.01 | 38.03 |
| yii-basic (2.0.55) | 28.85 | 99.75 | 136.96 | 0.02 | 39.03 |
| webrick-sharded (4.0.2) | 30.95 | 138.93 | 184.06 | 0.02 | 48.14 |
| webrick-fused (4.0.2) | 31.36 | 136.43 | 183.45 | 0.01 | 46.90 |
| codeigniter (v4.7.4) | 43.77 | 161.14 | 190.51 | 0.02 | 62.59 |
| cakephp (5.4.1) | 51.79 | 156.01 | 191.93 | 0.02 | 67.48 |
| nette (v3.3.0) | 54.69 | 151.68 | 183.50 | 0.02 | 69.11 |
| symfony (v8.1.5) | 56.64 | 156.86 | 185.57 | 0.02 | 64.45 |
| infbyte-full (2.1.1) | 73.23 | 176.84 | 214.15 | 0.02 | 84.67 |
| infbyte (2.1.1) | 75.33 | 170.24 | 205.47 | 0.02 | 84.37 |
| laravel-api (v13.29.0) | 132.30 | 272.11 | 355.06 | 0.03 | 113.97 |
| laravel (v13.29.0) | 151.67 | 311.63 | 357.28 | 0.04 | 148.01 |

## Latency — concurrency 250

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.9) | 13.92 | 34.64 | 316.40 | 0.04 | 29.42 |
| fast-route (1.3.1) | 20.54 | 52.98 | 1,101.70 | 0.04 | 41.43 |
| kumbia (v1.2.1) | 21.86 | 60.40 | 1,155.90 | 0.04 | 44.69 |
| leaf (v5.0) | 26.48 | 77.08 | 1,418.99 | 0.03 | 54.68 |
| fatfree (3.9.3) | 26.52 | 79.78 | 1,655.53 | 0.03 | 57.11 |
| flight (v3.19.1) | 28.43 | 86.88 | 1,896.00 | 0.04 | 61.64 |
| slim (4.15.2) | 36.65 | 120.61 | 2,095.30 | 0.04 | 82.85 |
| yii-basic (2.0.55) | 38.84 | 117.40 | 1,928.47 | 0.05 | 84.45 |
| webrick-sharded (4.0.2) | 43.08 | 173.45 | 1,937.26 | 0.05 | 104.17 |
| webrick-fused (4.0.2) | 46.74 | 148.28 | 301.35 | 0.05 | 98.10 |
| codeigniter (v4.7.4) | 55.09 | 208.33 | 413.74 | 0.06 | 134.17 |
| symfony (v8.1.5) | 58.86 | 214.52 | 1,765.72 | 0.06 | 136.50 |
| cakephp (5.4.1) | 61.02 | 210.59 | 289.45 | 0.07 | 140.34 |
| nette (v3.3.0) | 65.84 | 207.17 | 301.57 | 0.07 | 138.97 |
| infbyte (2.1.1) | 95.25 | 231.93 | 315.54 | 0.07 | 159.73 |
| infbyte-full (2.1.1) | 101.61 | 224.57 | 316.59 | 0.07 | 160.66 |
| laravel-api (v13.29.0) | 185.19 | 354.90 | 482.30 | 0.11 | 180.36 |
| laravel (v13.29.0) | 218.99 | 406.38 | 490.42 | 0.11 | 238.77 |

## Reliability — serial

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| cakephp (5.4.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| codeigniter (v4.7.4) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| fast-route (1.3.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| fatfree (3.9.3) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| flight (v3.19.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| kumbia (v1.2.1) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.29.0) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.29.0) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| leaf (v5.0) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| nette (v3.3.0) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| pure-php (PHP 8.5.9) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| slim (4.15.2) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| symfony (v8.1.5) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (4.0.2) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (4.0.2) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| yii-basic (2.0.55) | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 2

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.9) | 124397 | 124397 | 0.00% | 0 | 0 | 0 | 0 |
| fast-route (1.3.1) | 113903 | 113903 | 0.00% | 0 | 0 | 0 | 0 |
| kumbia (v1.2.1) | 109654 | 109654 | 0.00% | 0 | 0 | 0 | 0 |
| leaf (v5.0) | 100049 | 100049 | 0.00% | 0 | 0 | 0 | 0 |
| fatfree (3.9.3) | 97496 | 97496 | 0.00% | 0 | 0 | 0 | 0 |
| flight (v3.19.1) | 92397 | 92397 | 0.00% | 0 | 0 | 0 | 0 |
| yii-basic (2.0.55) | 75066 | 75066 | 0.00% | 0 | 0 | 0 | 0 |
| slim (4.15.2) | 74517 | 74517 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (4.0.2) | 63188 | 63188 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (4.0.2) | 60797 | 60797 | 0.00% | 0 | 0 | 0 | 0 |
| codeigniter (v4.7.4) | 47244 | 47244 | 0.00% | 0 | 0 | 0 | 0 |
| cakephp (5.4.1) | 45351 | 45351 | 0.00% | 0 | 0 | 0 | 0 |
| symfony (v8.1.5) | 44615 | 44615 | 0.00% | 0 | 0 | 0 | 0 |
| nette (v3.3.0) | 43733 | 43733 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 35046 | 35046 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 34803 | 34803 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.29.0) | 21351 | 21351 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.29.0) | 18544 | 18544 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 63

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.9) | 209624 | 209624 | 0.00% | 0 | 0 | 0 | 0 |
| fast-route (1.3.1) | 181881 | 181881 | 0.00% | 0 | 0 | 0 | 0 |
| kumbia (v1.2.1) | 171982 | 171982 | 0.00% | 0 | 0 | 0 | 0 |
| leaf (v5.0) | 145734 | 145734 | 0.00% | 0 | 0 | 0 | 0 |
| fatfree (3.9.3) | 143114 | 143114 | 0.00% | 0 | 0 | 0 | 0 |
| flight (v3.19.1) | 132519 | 132519 | 0.00% | 0 | 0 | 0 | 0 |
| slim (4.15.2) | 101862 | 101862 | 0.00% | 0 | 0 | 0 | 0 |
| yii-basic (2.0.55) | 97279 | 97279 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (4.0.2) | 83086 | 83086 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (4.0.2) | 80693 | 80693 | 0.00% | 0 | 0 | 0 | 0 |
| codeigniter (v4.7.4) | 62747 | 62747 | 0.00% | 0 | 0 | 0 | 0 |
| cakephp (5.4.1) | 59382 | 59382 | 0.00% | 0 | 0 | 0 | 0 |
| nette (v3.3.0) | 58085 | 58085 | 0.00% | 0 | 0 | 0 | 0 |
| symfony (v8.1.5) | 56541 | 56541 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 47321 | 47321 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 47053 | 47053 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.29.0) | 28139 | 28139 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.29.0) | 24634 | 24634 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 125

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.9) | 201081 | 201081 | 0.00% | 0 | 0 | 0 | 0 |
| fast-route (1.3.1) | 174375 | 174375 | 0.00% | 0 | 0 | 0 | 0 |
| kumbia (v1.2.1) | 165849 | 165849 | 0.00% | 0 | 0 | 0 | 0 |
| leaf (v5.0) | 139951 | 139951 | 0.00% | 0 | 0 | 0 | 0 |
| fatfree (3.9.3) | 139018 | 139018 | 0.00% | 0 | 0 | 0 | 0 |
| flight (v3.19.1) | 127805 | 127805 | 0.00% | 0 | 0 | 0 | 0 |
| slim (4.15.2) | 96832 | 96832 | 0.00% | 0 | 0 | 0 | 0 |
| yii-basic (2.0.55) | 94300 | 94300 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-fused (4.0.2) | 79050 | 79050 | 0.00% | 0 | 0 | 0 | 0 |
| webrick-sharded (4.0.2) | 77057 | 77057 | 0.00% | 0 | 0 | 0 | 0 |
| codeigniter (v4.7.4) | 59502 | 59502 | 0.00% | 0 | 0 | 0 | 0 |
| cakephp (5.4.1) | 55222 | 55222 | 0.00% | 0 | 0 | 0 | 0 |
| nette (v3.3.0) | 53941 | 53941 | 0.00% | 0 | 0 | 0 | 0 |
| symfony (v8.1.5) | 52705 | 52705 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte (2.1.1) | 44264 | 44264 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte-full (2.1.1) | 44111 | 44111 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api (v13.29.0) | 26768 | 26768 | 0.00% | 0 | 0 | 0 | 0 |
| laravel (v13.29.0) | 23084 | 23084 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 250

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.9) | 196447 | 196447 | 0.00% | 0 | 0 | 0 | 0 |
| fast-route (1.3.1) | 174046 | 174046 | 0.00% | 0 | 0 | 0 | 0 |
| kumbia (v1.2.1) | 166403 | 166403 | 0.00% | 0 | 0 | 0 | 0 |
| leaf (v5.0) | 142280 | 142280 | 0.00% | 0 | 0 | 0 | 0 |
| fatfree (3.9.3) | 136339 | 136339 | 0.00% | 0 | 0 | 0 | 0 |
| flight (v3.19.1) | 128387 | 128387 | 0.00% | 0 | 0 | 0 | 0 |
| slim (4.15.2) | 96772 | 96772 | 0.00% | 0 | 2 | 0 | 0 |
| yii-basic (2.0.55) | 94372 | 94364 | 0.00% | 0 | 3 | 0 | 0 |
| webrick-sharded (4.0.2) | 75841 | 75815 | 0.03% | 0 | 26 | 0 | 0 |
| webrick-fused (4.0.2) | 79280 | 79250 | 0.04% | 0 | 30 | 0 | 0 |
| codeigniter (v4.7.4) | 57992 | 57962 | 0.07% | 0 | 40 | 0 | 0 |
| symfony (v8.1.5) | 54118 | 54072 | 0.07% | 0 | 38 | 0 | 0 |
| cakephp (5.4.1) | 54904 | 54860 | 0.08% | 0 | 44 | 0 | 0 |
| nette (v3.3.0) | 53065 | 52994 | 0.12% | 0 | 66 | 0 | 0 |
| infbyte (2.1.1) | 42970 | 42849 | 0.28% | 0 | 121 | 0 | 0 |
| infbyte-full (2.1.1) | 42470 | 42346 | 0.29% | 0 | 125 | 0 | 0 |
| laravel-api (v13.29.0) | 25973 | 25770 | 0.78% | 0 | 203 | 0 | 0 |
| laravel (v13.29.0) | 22639 | 22412 | 1.00% | 0 | 227 | 0 | 0 |

## Relative comparison

| Target | Peak throughput | Remote memory | Server time | Included files |
| --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.9) | 8.52× | 1.00× | 1.00× | 1.00× |
| fast-route (1.3.1) | 7.39× | 1.03× | 1.82× | 12.00× |
| kumbia (v1.2.1) | 6.99× | 1.08× | 2.11× | 14.00× |
| leaf (v5.0) | 5.92× | 1.08× | 2.57× | 22.00× |
| fatfree (3.9.3) | 5.81× | 1.13× | 2.84× | 7.00× |
| flight (v3.19.1) | 5.38× | 1.10× | 2.94× | 26.00× |
| slim (4.15.2) | 4.14× | 1.13× | 4.16× | 82.00× |
| yii-basic (2.0.55) | 3.95× | 1.90× | 4.62× | 54.00× |
| webrick-fused (4.0.2) | 3.37× | 1.28× | 5.92× | 73.00× |
| webrick-sharded (4.0.2) | 3.28× | 1.28× | 6.30× | 73.00× |
| codeigniter (v4.7.4) | 2.55× | 1.28× | 10.21× | 118.00× |
| cakephp (5.4.1) | 2.41× | 1.45× | 11.35× | 167.00× |
| nette (v3.3.0) | 2.36× | 1.35× | 12.26× | 130.00× |
| symfony (v8.1.5) | 2.30× | 1.40× | 5.49× | 191.00× |
| infbyte (2.1.1) | 1.92× | 1.35× | 16.43× | 133.00× |
| infbyte-full (2.1.1) | 1.91× | 1.38× | 16.49× | 149.00× |
| laravel-api (v13.29.0) | 1.14× | 1.95× | 4.54× | 395.00× |
| laravel (v13.29.0) | 1.00× | 1.98× | 2.40× | 407.00× |

## Resource telemetry

| Target | Samples | Avg CPU | Peak CPU | Avg MB | Peak MB | Remote MB |
| --- | --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.9) | 0 | — | — | — | — | 0.40 |
| fast-route (1.3.1) | 0 | — | — | — | — | 0.41 |
| kumbia (v1.2.1) | 0 | — | — | — | — | 0.43 |
| leaf (v5.0) | 0 | — | — | — | — | 0.43 |
| fatfree (3.9.3) | 0 | — | — | — | — | 0.45 |
| flight (v3.19.1) | 0 | — | — | — | — | 0.44 |
| slim (4.15.2) | 0 | — | — | — | — | 0.45 |
| yii-basic (2.0.55) | 0 | — | — | — | — | 0.76 |
| webrick-fused (4.0.2) | 0 | — | — | — | — | 0.51 |
| webrick-sharded (4.0.2) | 0 | — | — | — | — | 0.51 |
| codeigniter (v4.7.4) | 0 | — | — | — | — | 0.51 |
| cakephp (5.4.1) | 0 | — | — | — | — | 0.58 |
| nette (v3.3.0) | 0 | — | — | — | — | 0.54 |
| symfony (v8.1.5) | 0 | — | — | — | — | 0.56 |
| infbyte (2.1.1) | 0 | — | — | — | — | 0.54 |
| infbyte-full (2.1.1) | 0 | — | — | — | — | 0.55 |
| laravel-api (v13.29.0) | 0 | — | — | — | — | 0.78 |
| laravel (v13.29.0) | 0 | — | — | — | — | 0.79 |

## Server response telemetry

| Target | Metric | Samples | Average | Minimum | Maximum |
| --- | --- | --- | --- | --- | --- |
| pure-php (PHP 8.5.9) | Included files | 2207317 | 1.00000 | 1.00000 | 1.00000 |
| pure-php (PHP 8.5.9) | Server execution ms | 2207317 | 2.33928 | 0.11500 | 152.63100 |
| fast-route (1.3.1) | Included files | 1945068 | 12.00000 | 12.00000 | 12.00000 |
| fast-route (1.3.1) | Server execution ms | 1945068 | 4.25518 | 0.14200 | 165.69700 |
| kumbia (v1.2.1) | Included files | 1856169 | 14.00000 | 14.00000 | 14.00000 |
| kumbia (v1.2.1) | Server execution ms | 1856169 | 4.92543 | 0.16200 | 253.71300 |
| leaf (v5.0) | Included files | 1592423 | 22.00000 | 22.00000 | 22.00000 |
| leaf (v5.0) | Server execution ms | 1592423 | 6.00316 | 0.19700 | 260.89500 |
| fatfree (3.9.3) | Included files | 1561456 | 7.00000 | 7.00000 | 7.00000 |
| fatfree (3.9.3) | Server execution ms | 1561456 | 6.64126 | 0.20000 | 310.25200 |
| flight (v3.19.1) | Included files | 1454948 | 26.00000 | 26.00000 | 26.00000 |
| flight (v3.19.1) | Server execution ms | 1454948 | 6.87033 | 0.22800 | 229.74100 |
| slim (4.15.2) | Included files | 1124006 | 82.00000 | 82.00000 | 82.00000 |
| slim (4.15.2) | Server execution ms | 1124006 | 9.73452 | 0.33700 | 344.62500 |
| yii-basic (2.0.55) | Included files | 1102038 | 54.00000 | 54.00000 | 54.00000 |
| yii-basic (2.0.55) | Server execution ms | 1102038 | 10.80675 | 0.33800 | 387.05600 |
| webrick-fused (4.0.2) | Included files | 925096 | 73.00000 | 73.00000 | 73.00000 |
| webrick-fused (4.0.2) | Server execution ms | 925096 | 13.83848 | 0.43400 | 380.63300 |
| webrick-sharded (4.0.2) | Included files | 897555 | 73.00000 | 73.00000 | 73.00000 |
| webrick-sharded (4.0.2) | Server execution ms | 897555 | 14.74000 | 0.47000 | 351.81800 |
| codeigniter (v4.7.4) | Included files | 698854 | 118.00000 | 118.00000 | 118.00000 |
| codeigniter (v4.7.4) | Server execution ms | 698854 | 23.88695 | 0.72300 | 568.45800 |
| cakephp (5.4.1) | Included files | 661261 | 167.00000 | 167.00000 | 167.00000 |
| cakephp (5.4.1) | Server execution ms | 661261 | 26.54362 | 0.75600 | 470.84500 |
| nette (v3.3.0) | Included files | 643411 | 130.00380 | 130.00000 | 134.00000 |
| nette (v3.3.0) | Server execution ms | 643411 | 28.68497 | 0.80500 | 475.79400 |
| symfony (v8.1.5) | Included files | 639602 | 191.00000 | 191.00000 | 191.00000 |
| symfony (v8.1.5) | Server execution ms | 639602 | 12.85371 | 0.20000 | 287.35900 |
| infbyte (2.1.1) | Included files | 522262 | 133.00000 | 133.00000 | 133.00000 |
| infbyte (2.1.1) | Server execution ms | 522262 | 38.43625 | 1.07900 | 424.34300 |
| infbyte-full (2.1.1) | Included files | 519160 | 149.00000 | 149.00000 | 149.00000 |
| infbyte-full (2.1.1) | Server execution ms | 519160 | 38.56443 | 1.09300 | 450.12600 |
| laravel-api (v13.29.0) | Included files | 321110 | 395.00000 | 395.00000 | 395.00000 |
| laravel-api (v13.29.0) | Server execution ms | 321110 | 10.62625 | 0.19600 | 326.80000 |
| laravel (v13.29.0) | Included files | 279526 | 407.00000 | 407.00000 | 407.00000 |
| laravel (v13.29.0) | Server execution ms | 279526 | 5.61999 | 0.10300 | 318.90600 |

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

| Setting | pure-php (PHP 8.5.9) | fast-route (1.3.1) | kumbia (v1.2.1) | leaf (v5.0) | fatfree (3.9.3) | flight (v3.19.1) | slim (4.15.2) | yii-basic (2.0.55) | webrick-fused (4.0.2) | webrick-sharded (4.0.2) | codeigniter (v4.7.4) | cakephp (5.4.1) | nette (v3.3.0) | symfony (v8.1.5) | infbyte (2.1.1) | infbyte-full (2.1.1) | laravel-api (v13.29.0) | laravel (v13.29.0) |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| Url | http://127.0.0.1:32768/frameworks/pure-php/asset/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/fast-route/asset/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/kumbia/asset/default/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/leaf/asset/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/fatfree/asset/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/flight/asset/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/slim/asset/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/yii-basic/asset/web/index.php?r=hello/index | http://127.0.0.1:32768/frameworks/webrick-fused/asset/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/webrick-sharded/asset/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/codeigniter/asset/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/cakephp/asset/webroot/index.php/hello/index | http://127.0.0.1:32768/frameworks/nette/asset/www/index.php/hello/index | http://127.0.0.1:32768/frameworks/symfony/asset/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/infbyte/asset/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/infbyte-full/asset/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/laravel-api/asset/public/index.php/api/hello/index | http://127.0.0.1:32768/frameworks/laravel/asset/public/index.php/hello/index |

## Target-server environment

These settings come from the PHP web runtime that received benchmark requests.

| Setting | Value |
| --- | --- |
| PHP version | 8.5.9 |
| PHP SAPI | apache2handler |
| Loaded php.ini | /usr/local/etc/php/php.ini |
| Benchmark environment profile | opcache-production |
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
