## Sustainable ranking

| Rank | Target | Best stable RPM | Stable concurrency | Peak observed RPM | Peak concurrency | Peak stability | Duration s |
| --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | pure-php | 496,790 | 125 | 531,027 | 63 | Unstable | 386.1 |
| 2 | leaf | 360,619 | 125 | 381,184 | 63 | Unstable | 387.3 |
| 3 | kumbia | 287,133 | 2 | 443,511 | 63 | Unstable | 386.8 |
| 4 | fatfree | 278,024 | 250 | 378,522 | 63 | Unstable | 387.5 |
| 5 | slim | 262,429 | 63 | 262,429 | 63 | Stable | 389.2 |
| 6 | yii-basic | 252,870 | 63 | 252,870 | 63 | Stable | 389.2 |
| 7 | lumen | 162,026 | 125 | 166,840 | 63 | Unstable | 392.7 |
| 8 | symfony | 153,904 | 63 | 153,904 | 63 | Stable | 393.6 |
| 9 | nette | 147,303 | 63 | 147,303 | 63 | Stable | 395.1 |
| 10 | cakephp | 116,813 | 2 | 151,771 | 63 | Unstable | 394.7 |
| 11 | infbyte | 106,516 | 63 | 106,516 | 63 | Stable | 413.1 |
| 12 | codeigniter | 95,726 | 63 | 95,726 | 63 | Stable | 404.0 |
| 13 | laravel-api | 75,942 | 63 | 75,942 | 63 | Stable | 409.0 |
| 14 | laravel | 60,524 | 125 | 64,246 | 63 | Unstable | 415.4 |
| — | flight | — | — | 101,571 | 63 | Unstable | 479.5 |

## Throughput — concurrency 2

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM | Run 3 RPM |
| --- | --- | --- | --- | --- | --- | --- |
| pure-php | 322,545 | 0.71% | Stable | 324,730 | 322,439 | 322,545 |
| kumbia | 287,133 | 0.61% | Stable | 287,133 | 285,824 | 287,577 |
| leaf | 261,724 | 0.20% | Stable | 261,283 | 261,724 | 261,814 |
| fatfree | 254,825 | 0.34% | Stable | 254,978 | 254,119 | 254,825 |
| slim | 198,443 | 0.09% | Stable | 198,455 | 198,443 | 198,271 |
| yii-basic | 193,562 | 0.41% | Stable | 194,119 | 193,325 | 193,562 |
| lumen | 136,044 | 0.51% | Stable | 135,439 | 136,044 | 136,128 |
| symfony | 126,369 | 0.44% | Stable | 126,509 | 126,369 | 125,959 |
| cakephp | 116,813 | 1.90% | Stable | 117,790 | 115,568 | 116,813 |
| nette | 112,931 | 0.71% | Stable | 112,931 | 112,582 | 113,390 |
| infbyte | 78,863 | 0.74% | Stable | 78,863 | 78,474 | 79,056 |
| codeigniter | 69,465 | 0.19% | Stable | 69,493 | 69,362 | 69,465 |
| laravel-api | 58,239 | 0.89% | Stable | 57,901 | 58,419 | 58,239 |
| flight | 53,949 | 132.65% | Unstable | 103,900 | 32,336 | 53,949 |
| laravel | 49,572 | 5.71% | Unstable | 49,572 | 47,094 | 49,926 |

## Throughput — concurrency 63

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM | Run 3 RPM |
| --- | --- | --- | --- | --- | --- | --- |
| pure-php | 531,027 | 7.02% | Unstable | 531,027 | 536,227 | 498,973 |
| kumbia | 443,511 | 13.01% | Unstable | 443,511 | 393,083 | 450,802 |
| leaf | 381,184 | 6.05% | Unstable | 368,476 | 391,532 | 381,184 |
| fatfree | 378,522 | 6.25% | Unstable | 378,522 | 380,648 | 356,987 |
| slim | 262,429 | 2.07% | Stable | 262,429 | 264,090 | 258,657 |
| yii-basic | 252,870 | 2.05% | Stable | 253,716 | 248,543 | 252,870 |
| lumen | 166,840 | 6.14% | Unstable | 161,476 | 171,727 | 166,840 |
| symfony | 153,904 | 4.48% | Stable | 153,904 | 155,776 | 148,881 |
| cakephp | 151,771 | 6.25% | Unstable | 152,614 | 143,130 | 151,771 |
| nette | 147,303 | 1.94% | Stable | 147,303 | 149,267 | 146,406 |
| infbyte | 106,516 | 0.99% | Stable | 106,516 | 105,988 | 107,040 |
| flight | 101,571 | 56.54% | Unstable | 101,571 | 133,556 | 76,127 |
| codeigniter | 95,726 | 2.84% | Stable | 93,921 | 95,726 | 96,639 |
| laravel-api | 75,942 | 0.99% | Stable | 75,942 | 75,792 | 76,546 |
| laravel | 64,246 | 6.28% | Unstable | 64,246 | 60,824 | 64,859 |

## Throughput — concurrency 125

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM | Run 3 RPM |
| --- | --- | --- | --- | --- | --- | --- |
| pure-php | 496,790 | 2.49% | Stable | 496,790 | 501,832 | 489,471 |
| kumbia | 423,723 | 6.22% | Unstable | 424,507 | 398,133 | 423,723 |
| leaf | 360,619 | 2.88% | Stable | 353,246 | 360,619 | 363,616 |
| fatfree | 355,369 | 8.50% | Unstable | 362,237 | 355,369 | 332,030 |
| slim | 253,127 | 4.29% | Stable | 253,127 | 254,174 | 243,313 |
| yii-basic | 235,767 | 4.28% | Stable | 243,565 | 235,767 | 233,467 |
| lumen | 162,026 | 4.16% | Stable | 162,026 | 157,691 | 164,431 |
| symfony | 148,803 | 6.26% | Unstable | 152,240 | 148,803 | 142,922 |
| nette | 141,042 | 0.65% | Stable | 141,042 | 141,490 | 140,575 |
| cakephp | 138,717 | 9.63% | Unstable | 138,717 | 129,320 | 142,676 |
| infbyte | 99,267 | 3.01% | Stable | 99,267 | 101,702 | 98,719 |
| codeigniter | 89,526 | 1.79% | Stable | 88,910 | 90,511 | 89,526 |
| flight | 80,142 | 64.39% | Unstable | 79,024 | 80,142 | 130,630 |
| laravel-api | 70,605 | 1.32% | Stable | 70,965 | 70,605 | 70,036 |
| laravel | 60,524 | 4.78% | Stable | 60,524 | 57,935 | 60,828 |

## Throughput — concurrency 250

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM | Run 3 RPM |
| --- | --- | --- | --- | --- | --- | --- |
| pure-php | 391,585 | 2.12% | Stable | 396,472 | 391,585 | 388,165 |
| kumbia | 342,318 | 6.30% | Unstable | 342,318 | 325,027 | 346,608 |
| leaf | 286,276 | 4.37% | Stable | 286,276 | 295,013 | 282,491 |
| fatfree | 278,024 | 4.61% | Stable | 278,024 | 286,848 | 274,044 |
| slim | 199,736 | 2.80% | Stable | 199,580 | 199,736 | 205,170 |
| yii-basic | 194,288 | 2.41% | Stable | 194,874 | 190,201 | 194,288 |
| lumen | 128,415 | 3.89% | Stable | 131,491 | 128,415 | 126,493 |
| symfony | 118,689 | 3.10% | Stable | 119,063 | 118,689 | 115,380 |
| cakephp | 110,158 | 10.53% | Unstable | 110,158 | 103,083 | 114,683 |
| nette | 106,963 | 3.14% | Stable | 108,262 | 104,899 | 106,963 |
| flight | 83,619 | 16.61% | Unstable | 80,064 | 83,619 | 93,950 |
| infbyte | 77,775 | 6.19% | Unstable | 77,775 | 78,398 | 73,581 |
| codeigniter | 67,488 | 1.81% | Stable | 67,488 | 68,601 | 67,381 |
| laravel-api | 54,170 | 8.03% | Unstable | 54,424 | 54,170 | 50,073 |
| laravel | 46,738 | 5.64% | Unstable | 46,738 | 44,768 | 47,403 |

## Latency — serial

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| pure-php | 0.27 | 0.30 | 0.44 | 0.00 | 0.26 |
| kumbia | 0.32 | 0.35 | 0.66 | 0.00 | 0.31 |
| leaf | 0.35 | 0.39 | 0.69 | 0.00 | 0.34 |
| fatfree | 0.36 | 0.40 | 0.62 | 0.00 | 0.35 |
| slim | 0.48 | 0.52 | 1.05 | 0.00 | 0.47 |
| yii-basic | 0.48 | 0.53 | 1.08 | 0.00 | 0.48 |
| flight | 0.63 | 0.78 | 1.44 | 0.00 | 1.09 |
| lumen | 0.71 | 0.77 | 1.31 | 0.00 | 0.63 |
| symfony | 0.77 | 0.83 | 1.52 | 0.00 | 0.70 |
| cakephp | 0.83 | 0.90 | 1.75 | 0.00 | 0.83 |
| nette | 0.86 | 0.93 | 1.97 | 0.00 | 0.86 |
| infbyte | 1.25 | 1.87 | 7.42 | 0.00 | 1.51 |
| codeigniter | 1.45 | 1.50 | 2.30 | 0.00 | 1.45 |
| laravel-api | 1.76 | 1.85 | 2.69 | 0.00 | 1.58 |
| laravel | 2.12 | 2.42 | 4.41 | 0.00 | 1.96 |

## Latency — concurrency 2

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| pure-php | 0.30 | 0.40 | 0.60 | 0.00 | 0.30 |
| kumbia | 0.34 | 0.44 | 0.67 | 0.00 | 0.35 |
| leaf | 0.38 | 0.48 | 0.71 | 0.00 | 0.39 |
| fatfree | 0.39 | 0.49 | 0.76 | 0.00 | 0.40 |
| slim | 0.52 | 0.64 | 0.92 | 0.00 | 0.53 |
| yii-basic | 0.53 | 0.66 | 0.95 | 0.00 | 0.54 |
| flight | 0.65 | 0.83 | 1.17 | 0.00 | 2.16 |
| lumen | 0.81 | 0.96 | 1.30 | 0.00 | 0.74 |
| symfony | 0.87 | 1.03 | 1.40 | 0.00 | 0.81 |
| cakephp | 0.92 | 1.14 | 1.49 | 0.00 | 0.95 |
| nette | 0.95 | 1.16 | 1.58 | 0.00 | 0.99 |
| infbyte | 1.36 | 1.74 | 2.18 | 0.00 | 1.45 |
| codeigniter | 1.54 | 1.99 | 2.30 | 0.00 | 1.65 |
| laravel-api | 1.87 | 2.36 | 2.65 | 0.00 | 1.77 |
| laravel | 2.18 | 2.81 | 3.35 | 0.00 | 2.12 |

## Latency — concurrency 63

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| pure-php | 4.32 | 11.29 | 17.63 | 0.01 | 5.11 |
| flight | 6.57 | 85.05 | 121.47 | 0.01 | 31.72 |
| kumbia | 6.70 | 17.12 | 27.38 | 0.01 | 7.60 |
| leaf | 8.29 | 21.17 | 32.67 | 0.00 | 9.33 |
| fatfree | 8.37 | 21.44 | 32.82 | 0.00 | 9.43 |
| slim | 12.07 | 35.52 | 49.66 | 0.00 | 14.07 |
| yii-basic | 12.09 | 38.01 | 54.09 | 0.00 | 14.61 |
| nette | 18.38 | 68.15 | 84.24 | 0.00 | 25.45 |
| lumen | 19.10 | 58.54 | 74.94 | 0.00 | 20.18 |
| cakephp | 19.58 | 61.82 | 81.76 | 0.00 | 24.69 |
| symfony | 21.17 | 62.73 | 79.76 | 0.00 | 21.90 |
| infbyte | 30.19 | 79.99 | 94.36 | 0.00 | 35.28 |
| codeigniter | 38.20 | 78.35 | 93.19 | 0.01 | 39.28 |
| laravel-api | 43.94 | 122.63 | 150.57 | 0.01 | 39.99 |
| laravel | 58.70 | 120.02 | 148.80 | 0.01 | 50.09 |

## Latency — concurrency 125

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| flight | 6.14 | 205.59 | 326.08 | 0.02 | 62.44 |
| pure-php | 9.10 | 22.82 | 35.60 | 0.02 | 10.93 |
| kumbia | 14.07 | 34.57 | 52.70 | 0.01 | 16.09 |
| leaf | 16.02 | 47.85 | 70.44 | 0.01 | 19.92 |
| fatfree | 16.26 | 47.58 | 69.82 | 0.01 | 19.95 |
| slim | 23.21 | 73.49 | 101.87 | 0.01 | 29.02 |
| yii-basic | 23.35 | 79.04 | 114.82 | 0.01 | 31.23 |
| lumen | 29.45 | 141.89 | 179.12 | 0.01 | 42.39 |
| nette | 32.57 | 148.76 | 178.17 | 0.01 | 52.80 |
| symfony | 33.66 | 148.77 | 188.72 | 0.01 | 46.74 |
| cakephp | 40.14 | 138.63 | 180.86 | 0.01 | 53.67 |
| infbyte | 59.33 | 164.87 | 202.97 | 0.02 | 75.17 |
| codeigniter | 68.07 | 177.42 | 210.68 | 0.02 | 83.38 |
| laravel-api | 83.17 | 261.96 | 327.43 | 0.02 | 88.53 |
| laravel | 107.56 | 280.28 | 337.53 | 0.02 | 107.69 |

## Latency — concurrency 250

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| flight | 6.96 | 236.37 | 2,106.33 | 0.07 | 131.57 |
| pure-php | 10.65 | 28.13 | 612.91 | 0.03 | 25.52 |
| kumbia | 17.53 | 44.72 | 871.55 | 0.03 | 34.98 |
| fatfree | 21.70 | 60.49 | 1,188.23 | 0.03 | 45.47 |
| leaf | 21.78 | 59.94 | 1,209.89 | 0.02 | 44.57 |
| slim | 29.68 | 92.94 | 1,603.70 | 0.03 | 65.32 |
| yii-basic | 31.00 | 98.82 | 1,420.43 | 0.03 | 66.92 |
| lumen | 48.35 | 146.96 | 305.23 | 0.04 | 92.11 |
| cakephp | 49.13 | 174.63 | 2,277.49 | 0.04 | 115.15 |
| symfony | 49.92 | 156.72 | 1,469.60 | 0.04 | 100.58 |
| nette | 55.49 | 171.12 | 1,311.07 | 0.05 | 117.33 |
| infbyte | 80.88 | 210.26 | 290.70 | 0.06 | 148.81 |
| codeigniter | 103.59 | 217.61 | 316.41 | 0.05 | 161.27 |
| laravel-api | 136.94 | 321.79 | 431.48 | 0.07 | 176.72 |
| laravel | 163.43 | 363.24 | 472.74 | 0.08 | 195.82 |

## Reliability — serial

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| cakephp | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| codeigniter | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| fatfree | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| kumbia | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| laravel | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| leaf | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| lumen | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| nette | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| pure-php | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| slim | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| symfony | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| yii-basic | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| flight | 5000 | 4998 | 0.04% | 0 | 2 | 0 | 0 |

## Reliability — concurrency 2

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| pure-php | 161274 | 161274 | 0.00% | 0 | 0 | 0 | 0 |
| kumbia | 143567 | 143567 | 0.00% | 0 | 0 | 0 | 0 |
| leaf | 130863 | 130863 | 0.00% | 0 | 0 | 0 | 0 |
| fatfree | 127413 | 127413 | 0.00% | 0 | 0 | 0 | 0 |
| slim | 99222 | 99222 | 0.00% | 0 | 0 | 0 | 0 |
| yii-basic | 96783 | 96783 | 0.00% | 0 | 0 | 0 | 0 |
| lumen | 68024 | 68024 | 0.00% | 0 | 0 | 0 | 0 |
| symfony | 63186 | 63186 | 0.00% | 0 | 0 | 0 | 0 |
| cakephp | 58408 | 58408 | 0.00% | 0 | 0 | 0 | 0 |
| nette | 56466 | 56466 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte | 39433 | 39433 | 0.00% | 0 | 0 | 0 | 0 |
| codeigniter | 34734 | 34734 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api | 29122 | 29122 | 0.00% | 0 | 0 | 0 | 0 |
| flight | 26975 | 26975 | 0.00% | 0 | 0 | 0 | 0 |
| laravel | 24788 | 24788 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 63

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| pure-php | 265553 | 265553 | 0.00% | 0 | 0 | 0 | 0 |
| kumbia | 221803 | 221803 | 0.00% | 0 | 0 | 0 | 0 |
| leaf | 190648 | 190648 | 0.00% | 0 | 0 | 0 | 0 |
| fatfree | 189323 | 189323 | 0.00% | 0 | 0 | 0 | 0 |
| slim | 131267 | 131267 | 0.00% | 0 | 0 | 0 | 0 |
| yii-basic | 126484 | 126484 | 0.00% | 0 | 0 | 0 | 0 |
| lumen | 83466 | 83466 | 0.00% | 0 | 0 | 0 | 0 |
| symfony | 77004 | 77004 | 0.00% | 0 | 0 | 0 | 0 |
| cakephp | 75937 | 75937 | 0.00% | 0 | 0 | 0 | 0 |
| nette | 73703 | 73703 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte | 53299 | 53299 | 0.00% | 0 | 0 | 0 | 0 |
| codeigniter | 47910 | 47910 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api | 38015 | 38015 | 0.00% | 0 | 0 | 0 | 0 |
| laravel | 32159 | 32159 | 0.00% | 0 | 0 | 0 | 0 |
| flight | 56242 | 56241 | 0.00% | 0 | 1 | 0 | 0 |

## Reliability — concurrency 125

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| pure-php | 248522 | 248522 | 0.00% | 0 | 0 | 0 | 0 |
| kumbia | 211992 | 211992 | 0.00% | 0 | 0 | 0 | 0 |
| leaf | 180429 | 180429 | 0.00% | 0 | 0 | 0 | 0 |
| fatfree | 177797 | 177797 | 0.00% | 0 | 0 | 0 | 0 |
| slim | 126669 | 126669 | 0.00% | 0 | 0 | 0 | 0 |
| yii-basic | 117985 | 117985 | 0.00% | 0 | 0 | 0 | 0 |
| lumen | 81118 | 81118 | 0.00% | 0 | 0 | 0 | 0 |
| symfony | 74494 | 74494 | 0.00% | 0 | 0 | 0 | 0 |
| nette | 70623 | 70623 | 0.00% | 0 | 0 | 0 | 0 |
| cakephp | 69449 | 69449 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte | 49711 | 49711 | 0.00% | 0 | 0 | 0 | 0 |
| codeigniter | 44849 | 44849 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api | 35380 | 35380 | 0.00% | 0 | 0 | 0 | 0 |
| laravel | 30332 | 30332 | 0.00% | 0 | 0 | 0 | 0 |
| flight | 52489 | 52435 | 0.10% | 0 | 52 | 0 | 0 |

## Reliability — concurrency 250

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| pure-php | 241556 | 241556 | 0.00% | 0 | 0 | 0 | 0 |
| kumbia | 211211 | 211211 | 0.00% | 0 | 0 | 0 | 0 |
| leaf | 176654 | 176654 | 0.00% | 0 | 0 | 0 | 0 |
| fatfree | 171563 | 171563 | 0.00% | 0 | 0 | 0 | 0 |
| slim | 123274 | 123274 | 0.00% | 0 | 0 | 0 | 0 |
| yii-basic | 119924 | 119924 | 0.00% | 0 | 0 | 0 | 0 |
| symfony | 73294 | 73274 | 0.03% | 0 | 23 | 0 | 0 |
| lumen | 79303 | 79282 | 0.03% | 0 | 28 | 0 | 0 |
| cakephp | 68038 | 68007 | 0.05% | 0 | 31 | 0 | 0 |
| nette | 66089 | 66052 | 0.05% | 0 | 32 | 0 | 0 |
| infbyte | 48130 | 48040 | 0.20% | 0 | 92 | 0 | 0 |
| flight | 54118 | 54007 | 0.21% | 0 | 111 | 0 | 0 |
| codeigniter | 41824 | 41693 | 0.31% | 0 | 131 | 0 | 0 |
| laravel-api | 33627 | 33480 | 0.44% | 0 | 147 | 0 | 0 |
| laravel | 29065 | 28894 | 0.59% | 0 | 171 | 0 | 0 |

## Relative comparison

| Target | Peak throughput | Remote memory | Server time | Included files |
| --- | --- | --- | --- | --- |
| pure-php | 8.27× | 1.00× | 1.00× | 1.00× |
| leaf | 5.93× | 1.08× | 2.70× | 22.00× |
| kumbia | 6.90× | 1.08× | 2.14× | 14.00× |
| fatfree | 5.89× | 1.13× | 2.81× | 7.00× |
| slim | 4.08× | 1.13× | 4.59× | 82.00× |
| yii-basic | 3.94× | 1.90× | 4.86× | 54.00× |
| lumen | 2.60× | 1.13× | 9.61× | 107.00× |
| symfony | 2.40× | 1.28× | 10.69× | 184.00× |
| nette | 2.29× | 1.35× | 10.06× | 130.00× |
| cakephp | 2.36× | 1.45× | 10.12× | 167.00× |
| infbyte | 1.66× | 1.42× | 20.02× | 133.00× |
| codeigniter | 1.49× | 1.45× | 23.78× | 113.00× |
| laravel-api | 1.18× | 1.78× | 23.12× | 372.00× |
| laravel | 1.00× | 1.80× | 17.95× | 369.00× |
| flight | 1.58× | 2.40× | 8.50× | 76.00× |

## Resource telemetry

| Target | Samples | Avg CPU | Peak CPU | Avg MB | Peak MB | Remote MB |
| --- | --- | --- | --- | --- | --- | --- |
| pure-php | 0 | — | — | — | — | 0.40 |
| leaf | 0 | — | — | — | — | 0.43 |
| kumbia | 0 | — | — | — | — | 0.43 |
| fatfree | 0 | — | — | — | — | 0.45 |
| slim | 0 | — | — | — | — | 0.45 |
| yii-basic | 0 | — | — | — | — | 0.76 |
| lumen | 0 | — | — | — | — | 0.45 |
| symfony | 0 | — | — | — | — | 0.51 |
| nette | 0 | — | — | — | — | 0.54 |
| cakephp | 0 | — | — | — | — | 0.58 |
| infbyte | 0 | — | — | — | — | 0.57 |
| codeigniter | 0 | — | — | — | — | 0.58 |
| laravel-api | 0 | — | — | — | — | 0.71 |
| laravel | 0 | — | — | — | — | 0.72 |
| flight | 0 | — | — | — | — | 0.96 |

## Server response telemetry

| Target | Metric | Samples | Average | Minimum | Maximum |
| --- | --- | --- | --- | --- | --- |
| pure-php | Included files | 2753172 | 1.00000 | 1.00000 | 1.00000 |
| pure-php | Server execution ms | 2753172 | 1.66984 | 0.08000 | 124.48500 |
| leaf | Included files | 2050273 | 22.00000 | 22.00000 | 22.00000 |
| leaf | Server execution ms | 2050273 | 4.51304 | 0.14500 | 226.99100 |
| kumbia | Included files | 2338267 | 14.00000 | 14.00000 | 14.00000 |
| kumbia | Server execution ms | 2338267 | 3.57610 | 0.11800 | 184.24800 |
| fatfree | Included files | 1998068 | 7.00000 | 7.00000 | 7.00000 |
| fatfree | Server execution ms | 1998068 | 4.69215 | 0.14900 | 248.14100 |
| slim | Included files | 1454042 | 82.00000 | 82.00000 | 82.00000 |
| slim | Server execution ms | 1454042 | 7.66216 | 0.24300 | 294.66600 |
| yii-basic | Included files | 1397530 | 54.00000 | 54.00000 | 54.00000 |
| yii-basic | Server execution ms | 1397530 | 8.12233 | 0.26000 | 287.40200 |
| lumen | Included files | 949893 | 107.00000 | 107.00000 | 107.00000 |
| lumen | Server execution ms | 949893 | 16.04543 | 0.47700 | 331.43800 |
| symfony | Included files | 874124 | 184.00000 | 184.00000 | 184.00000 |
| symfony | Server execution ms | 874124 | 17.85642 | 0.52600 | 429.66300 |
| nette | Included files | 815605 | 130.00392 | 130.00000 | 134.00000 |
| nette | Server execution ms | 815605 | 16.80087 | 0.60700 | 467.59000 |
| cakephp | Included files | 822092 | 167.00000 | 167.00000 | 167.00000 |
| cakephp | Server execution ms | 822092 | 16.90596 | 0.58000 | 464.20300 |
| infbyte | Included files | 585101 | 133.00000 | 133.00000 | 133.00000 |
| infbyte | Server execution ms | 585101 | 33.42252 | 0.96000 | 1,322.70500 |
| codeigniter | Included files | 522885 | 113.00000 | 113.00000 | 113.00000 |
| codeigniter | Server execution ms | 522885 | 39.71703 | 1.21100 | 427.77600 |
| laravel-api | Included files | 420686 | 372.00000 | 372.00000 | 372.00000 |
| laravel-api | Server execution ms | 420686 | 38.61056 | 1.47600 | 530.71700 |
| laravel | Included files | 359130 | 369.00000 | 369.00000 | 369.00000 |
| laravel | Server execution ms | 359130 | 29.97553 | 1.35200 | 561.81500 |
| flight | Included files | 622423 | 76.00000 | 76.00000 | 76.00000 |
| flight | Server execution ms | 622423 | 14.19314 | 0.32500 | 9,974.14100 |

## Common configuration

| Setting | Value |
| --- | --- |
| Method | GET |
| Expected status | 200 |
| Count per phase | 5000 |
| Max concurrency | 250 |
| Concurrency levels | 2, 63, 125, 250 |
| Repetitions | 3 |
| Maximum rpm spread percent | 5 |
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
| Php version | 8.4.24 |
| Php sapi | cli |
| Memory limit | -1 |
| Opcache enabled | no |
| Opcache jit | 1235 |
| Xdebug loaded | no |
| Curl version | 8.5.0 |
| Operating system | Linux 6.17.0-1022-azure |

## Target-specific configuration

| Setting | pure-php | leaf | kumbia | fatfree | slim | yii-basic | lumen | symfony | nette | cakephp | infbyte | codeigniter | laravel-api | laravel | flight |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| Url | http://127.0.0.1:32768/frameworks/pure-php/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/leaf/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/kumbia/default/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/fatfree/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/slim/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/yii-basic/web/index.php?r=hello/index | http://127.0.0.1:32768/frameworks/lumen/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/symfony/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/nette/www/index.php/hello/index | http://127.0.0.1:32768/frameworks/cakephp/webroot/index.php/hello/index | http://127.0.0.1:32768/frameworks/infbyte/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/codeigniter/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/laravel-api/public/index.php/api/hello/index | http://127.0.0.1:32768/frameworks/laravel/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/flight/public/index.php/hello/index |
