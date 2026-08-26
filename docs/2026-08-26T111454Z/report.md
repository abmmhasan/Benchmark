## Sustainable ranking

| Rank | Target | Best stable RPM | Stable concurrency | Peak observed RPM | Peak concurrency | Peak stability | Duration s |
| --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | leaf | 471,476 | 63 | 471,476 | 63 | Stable | 387.7 |
| 2 | fatfree | 466,869 | 63 | 466,869 | 63 | Stable | 388.0 |
| 3 | flight | 407,596 | 63 | 407,596 | 63 | Stable | 388.4 |
| 4 | kumbia | 303,977 | 2 | 646,053 | 125 | Unstable | 386.8 |
| 5 | slim | 286,965 | 125 | 289,417 | 63 | Unstable | 390.8 |
| 6 | lumen | 185,868 | 63 | 185,868 | 63 | Stable | 394.7 |
| 7 | infbyte | 114,447 | 63 | 114,447 | 63 | Stable | 402.5 |
| 8 | codeigniter | 103,214 | 63 | 103,214 | 63 | Stable | 404.5 |
| 9 | cakephp | 100,552 | 2 | 158,592 | 63 | Unstable | 397.9 |
| 10 | nette | 98,823 | 2 | 158,389 | 63 | Unstable | 397.7 |
| 11 | laravel-api | 77,914 | 63 | 77,914 | 63 | Stable | 412.5 |
| 12 | laravel | 65,847 | 63 | 65,847 | 63 | Stable | 418.5 |
| — | pure-php | — | — | 826,794 | 63 | Unstable | 385.8 |
| — | yii-basic | — | — | 269,420 | 125 | Unstable | 391.5 |
| — | symfony | — | — | 157,577 | 63 | Unstable | 397.1 |

## Throughput — concurrency 2

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM | Run 3 RPM |
| --- | --- | --- | --- | --- | --- | --- |
| pure-php | 371,825 | 6.87% | Unstable | 371,825 | 372,314 | 346,769 |
| kumbia | 303,977 | 4.49% | Stable | 304,200 | 290,555 | 303,977 |
| leaf | 246,347 | 1.67% | Stable | 246,347 | 247,417 | 243,299 |
| fatfree | 244,477 | 0.29% | Stable | 244,477 | 243,871 | 244,590 |
| flight | 224,386 | 0.26% | Stable | 224,640 | 224,064 | 224,386 |
| slim | 172,834 | 8.92% | Unstable | 172,834 | 174,918 | 159,507 |
| yii-basic | 151,726 | 14.31% | Unstable | 146,571 | 168,287 | 151,726 |
| lumen | 122,455 | 0.33% | Stable | 122,378 | 122,455 | 122,782 |
| symfony | 107,678 | 12.06% | Unstable | 98,360 | 111,348 | 107,678 |
| cakephp | 100,552 | 0.73% | Stable | 100,784 | 100,552 | 100,053 |
| nette | 98,823 | 3.39% | Stable | 98,823 | 99,396 | 96,042 |
| infbyte | 74,754 | 2.68% | Stable | 74,802 | 72,800 | 74,754 |
| codeigniter | 67,597 | 1.10% | Stable | 68,011 | 67,597 | 67,267 |
| laravel-api | 51,050 | 2.00% | Stable | 50,945 | 51,965 | 51,050 |
| laravel | 44,280 | 3.97% | Stable | 44,814 | 44,280 | 43,057 |

## Throughput — concurrency 63

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM | Run 3 RPM |
| --- | --- | --- | --- | --- | --- | --- |
| pure-php | 826,794 | 11.49% | Unstable | 826,794 | 832,037 | 737,077 |
| kumbia | 632,437 | 15.72% | Unstable | 643,477 | 544,076 | 632,437 |
| leaf | 471,476 | 1.83% | Stable | 471,476 | 478,721 | 470,085 |
| fatfree | 466,869 | 1.47% | Stable | 466,869 | 468,572 | 461,712 |
| flight | 407,596 | 2.57% | Stable | 404,645 | 415,106 | 407,596 |
| slim | 289,417 | 9.17% | Unstable | 289,417 | 300,913 | 274,365 |
| yii-basic | 264,008 | 14.76% | Unstable | 264,008 | 284,240 | 245,271 |
| lumen | 185,868 | 0.81% | Stable | 186,637 | 185,130 | 185,868 |
| cakephp | 158,592 | 6.54% | Unstable | 161,720 | 158,592 | 151,352 |
| nette | 158,389 | 5.85% | Unstable | 158,389 | 158,588 | 149,328 |
| symfony | 157,577 | 21.09% | Unstable | 134,788 | 168,024 | 157,577 |
| infbyte | 114,447 | 0.81% | Stable | 114,447 | 114,052 | 114,982 |
| codeigniter | 103,214 | 1.76% | Stable | 102,229 | 103,214 | 104,045 |
| laravel-api | 77,914 | 3.92% | Stable | 78,282 | 77,914 | 75,230 |
| laravel | 65,847 | 0.98% | Stable | 66,218 | 65,847 | 65,570 |

## Throughput — concurrency 125

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM | Run 3 RPM |
| --- | --- | --- | --- | --- | --- | --- |
| pure-php | 821,147 | 7.44% | Unstable | 821,147 | 846,507 | 785,428 |
| kumbia | 646,053 | 25.69% | Unstable | 650,359 | 484,376 | 646,053 |
| leaf | 467,267 | 5.91% | Unstable | 467,267 | 475,274 | 447,666 |
| fatfree | 463,757 | 0.69% | Stable | 464,126 | 460,940 | 463,757 |
| flight | 403,480 | 4.01% | Stable | 403,480 | 413,302 | 397,139 |
| slim | 286,965 | 1.74% | Stable | 286,965 | 288,798 | 283,810 |
| yii-basic | 269,420 | 13.17% | Unstable | 270,767 | 269,420 | 235,297 |
| lumen | 175,537 | 1.39% | Stable | 176,684 | 175,537 | 174,248 |
| nette | 148,929 | 5.74% | Unstable | 150,108 | 148,929 | 141,562 |
| cakephp | 144,378 | 13.78% | Unstable | 146,485 | 144,378 | 126,586 |
| symfony | 141,640 | 23.00% | Unstable | 126,648 | 159,231 | 141,640 |
| infbyte | 108,078 | 1.16% | Stable | 107,625 | 108,874 | 108,078 |
| codeigniter | 97,411 | 2.35% | Stable | 96,015 | 97,411 | 98,302 |
| laravel-api | 73,414 | 2.91% | Stable | 73,414 | 74,100 | 71,965 |
| laravel | 62,049 | 7.67% | Unstable | 62,049 | 62,554 | 57,798 |

## Throughput — concurrency 250

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM | Run 3 RPM |
| --- | --- | --- | --- | --- | --- | --- |
| pure-php | 625,911 | 9.16% | Unstable | 620,297 | 677,619 | 625,911 |
| kumbia | 526,799 | 28.32% | Unstable | 526,799 | 385,580 | 534,759 |
| leaf | 388,775 | 1.82% | Stable | 389,420 | 388,775 | 382,341 |
| fatfree | 386,515 | 4.88% | Stable | 386,515 | 388,128 | 369,261 |
| flight | 327,479 | 3.25% | Stable | 322,813 | 333,471 | 327,479 |
| yii-basic | 217,106 | 19.84% | Unstable | 217,106 | 217,945 | 174,871 |
| slim | 210,768 | 23.26% | Unstable | 180,707 | 229,739 | 210,768 |
| lumen | 140,661 | 2.35% | Stable | 142,289 | 140,661 | 138,990 |
| nette | 113,542 | 7.45% | Unstable | 113,542 | 115,832 | 107,372 |
| symfony | 111,489 | 24.46% | Unstable | 96,941 | 124,217 | 111,489 |
| cakephp | 109,644 | 14.21% | Unstable | 112,461 | 109,644 | 96,881 |
| infbyte | 82,972 | 4.31% | Stable | 79,792 | 83,368 | 82,972 |
| codeigniter | 74,501 | 3.12% | Stable | 72,450 | 74,501 | 74,772 |
| laravel-api | 55,727 | 2.84% | Stable | 55,727 | 56,314 | 54,733 |
| laravel | 46,709 | 5.14% | Unstable | 46,709 | 47,842 | 45,440 |

## Latency — serial

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| pure-php | 0.22 | 0.32 | 0.47 | 0.00 | 0.22 |
| kumbia | 0.29 | 0.38 | 0.58 | 0.00 | 0.28 |
| leaf | 0.36 | 0.45 | 0.71 | 0.00 | 0.36 |
| fatfree | 0.37 | 0.48 | 0.83 | 0.00 | 0.37 |
| flight | 0.41 | 0.50 | 0.72 | 0.00 | 0.40 |
| slim | 0.56 | 0.65 | 1.06 | 0.00 | 0.55 |
| yii-basic | 0.62 | 0.72 | 1.18 | 0.00 | 0.62 |
| lumen | 0.83 | 0.91 | 1.35 | 0.00 | 0.74 |
| symfony | 1.00 | 1.10 | 1.82 | 0.00 | 0.90 |
| cakephp | 1.01 | 1.12 | 1.96 | 0.00 | 1.01 |
| nette | 1.02 | 1.10 | 1.97 | 0.00 | 1.03 |
| infbyte | 1.34 | 1.44 | 2.36 | 0.00 | 1.34 |
| codeigniter | 1.48 | 1.57 | 2.27 | 0.00 | 1.47 |
| laravel-api | 1.98 | 2.11 | 2.90 | 0.00 | 1.80 |
| laravel | 2.34 | 2.48 | 4.85 | 0.00 | 2.14 |

## Latency — concurrency 2

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| pure-php | 0.25 | 0.34 | 0.49 | 0.00 | 0.25 |
| kumbia | 0.32 | 0.41 | 0.58 | 0.00 | 0.32 |
| leaf | 0.40 | 0.49 | 0.67 | 0.00 | 0.40 |
| fatfree | 0.40 | 0.50 | 0.67 | 0.00 | 0.40 |
| flight | 0.45 | 0.55 | 0.73 | 0.00 | 0.45 |
| slim | 0.60 | 0.72 | 0.96 | 0.00 | 0.60 |
| yii-basic | 0.68 | 0.82 | 1.13 | 0.00 | 0.69 |
| lumen | 0.88 | 1.04 | 1.41 | 0.00 | 0.83 |
| symfony | 1.02 | 1.23 | 1.61 | 0.00 | 0.95 |
| cakephp | 1.07 | 1.27 | 1.59 | 0.00 | 1.10 |
| nette | 1.10 | 1.32 | 1.74 | 0.00 | 1.12 |
| infbyte | 1.43 | 1.77 | 2.17 | 0.00 | 1.51 |
| codeigniter | 1.58 | 1.99 | 2.39 | 0.00 | 1.68 |
| laravel-api | 2.16 | 2.76 | 3.06 | 0.00 | 2.04 |
| laravel | 2.48 | 3.18 | 3.81 | 0.00 | 2.38 |

## Latency — concurrency 63

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| pure-php | 2.71 | 6.10 | 8.94 | 0.00 | 3.02 |
| kumbia | 4.91 | 10.76 | 16.99 | 0.00 | 5.40 |
| leaf | 7.03 | 16.65 | 26.82 | 0.00 | 7.76 |
| fatfree | 7.06 | 17.04 | 27.50 | 0.00 | 7.81 |
| flight | 8.15 | 19.88 | 30.35 | 0.00 | 9.06 |
| slim | 11.12 | 30.37 | 44.58 | 0.00 | 12.89 |
| yii-basic | 11.37 | 36.35 | 51.92 | 0.00 | 14.13 |
| lumen | 16.17 | 54.57 | 73.05 | 0.00 | 18.31 |
| cakephp | 18.26 | 63.04 | 77.79 | 0.00 | 23.67 |
| nette | 18.30 | 62.23 | 75.07 | 0.00 | 23.71 |
| symfony | 18.82 | 65.88 | 81.08 | 0.00 | 21.17 |
| infbyte | 28.10 | 75.46 | 89.76 | 0.00 | 32.87 |
| codeigniter | 36.29 | 69.96 | 85.43 | 0.00 | 36.46 |
| laravel-api | 44.66 | 119.15 | 142.61 | 0.00 | 38.49 |
| laravel | 56.41 | 124.52 | 155.18 | 0.00 | 48.51 |

## Latency — concurrency 125

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| pure-php | 4.63 | 11.18 | 17.37 | 0.01 | 5.51 |
| kumbia | 9.18 | 20.69 | 30.91 | 0.01 | 10.45 |
| leaf | 13.20 | 32.61 | 48.83 | 0.01 | 15.45 |
| fatfree | 13.29 | 32.95 | 53.58 | 0.01 | 15.55 |
| flight | 14.44 | 40.75 | 66.20 | 0.01 | 18.09 |
| slim | 19.30 | 68.71 | 104.34 | 0.01 | 25.86 |
| yii-basic | 20.45 | 70.66 | 113.96 | 0.01 | 27.52 |
| nette | 31.33 | 142.60 | 169.45 | 0.01 | 50.10 |
| lumen | 31.35 | 116.59 | 154.70 | 0.01 | 39.62 |
| symfony | 34.64 | 140.08 | 174.57 | 0.01 | 47.46 |
| cakephp | 36.25 | 144.06 | 179.91 | 0.01 | 51.69 |
| infbyte | 52.21 | 160.54 | 188.96 | 0.01 | 69.13 |
| codeigniter | 69.60 | 154.31 | 179.23 | 0.01 | 76.71 |
| laravel-api | 77.59 | 255.22 | 306.73 | 0.02 | 83.71 |
| laravel | 103.59 | 258.68 | 339.72 | 0.02 | 101.10 |

## Latency — concurrency 250

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| pure-php | 6.15 | 15.98 | 51.72 | 0.02 | 14.23 |
| kumbia | 11.76 | 25.93 | 265.45 | 0.02 | 22.93 |
| fatfree | 16.41 | 43.17 | 856.11 | 0.01 | 32.94 |
| leaf | 16.65 | 40.72 | 990.38 | 0.01 | 32.89 |
| flight | 19.46 | 52.92 | 1,023.94 | 0.01 | 39.42 |
| slim | 27.46 | 106.06 | 1,766.58 | 0.02 | 62.26 |
| yii-basic | 27.94 | 87.48 | 1,769.47 | 0.02 | 60.36 |
| nette | 44.54 | 180.46 | 278.21 | 0.03 | 113.04 |
| lumen | 44.56 | 140.73 | 1,640.87 | 0.02 | 87.83 |
| symfony | 46.12 | 180.28 | 1,960.74 | 0.03 | 106.82 |
| cakephp | 51.42 | 184.33 | 302.26 | 0.03 | 115.16 |
| infbyte | 68.62 | 207.72 | 290.48 | 0.04 | 147.42 |
| codeigniter | 90.89 | 206.72 | 312.11 | 0.03 | 153.78 |
| laravel-api | 118.96 | 357.84 | 449.52 | 0.04 | 168.70 |
| laravel | 162.06 | 346.64 | 475.64 | 0.05 | 183.23 |

## Reliability — serial

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| cakephp | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| codeigniter | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| fatfree | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
| flight | 5000 | 5000 | 0.00% | 0 | 0 | 0 | 0 |
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

## Reliability — concurrency 2

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| pure-php | 185914 | 185914 | 0.00% | 0 | 0 | 0 | 0 |
| kumbia | 151990 | 151990 | 0.00% | 0 | 0 | 0 | 0 |
| leaf | 123175 | 123175 | 0.00% | 0 | 0 | 0 | 0 |
| fatfree | 122240 | 122240 | 0.00% | 0 | 0 | 0 | 0 |
| flight | 112194 | 112194 | 0.00% | 0 | 0 | 0 | 0 |
| slim | 86419 | 86419 | 0.00% | 0 | 0 | 0 | 0 |
| yii-basic | 75864 | 75864 | 0.00% | 0 | 0 | 0 | 0 |
| lumen | 61228 | 61228 | 0.00% | 0 | 0 | 0 | 0 |
| symfony | 53841 | 53841 | 0.00% | 0 | 0 | 0 | 0 |
| cakephp | 50278 | 50278 | 0.00% | 0 | 0 | 0 | 0 |
| nette | 49412 | 49412 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte | 37378 | 37378 | 0.00% | 0 | 0 | 0 | 0 |
| codeigniter | 33800 | 33800 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api | 25525 | 25525 | 0.00% | 0 | 0 | 0 | 0 |
| laravel | 22142 | 22142 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 63

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| pure-php | 413446 | 413446 | 0.00% | 0 | 0 | 0 | 0 |
| kumbia | 316263 | 316263 | 0.00% | 0 | 0 | 0 | 0 |
| leaf | 235795 | 235795 | 0.00% | 0 | 0 | 0 | 0 |
| fatfree | 233485 | 233485 | 0.00% | 0 | 0 | 0 | 0 |
| flight | 203847 | 203847 | 0.00% | 0 | 0 | 0 | 0 |
| slim | 144749 | 144749 | 0.00% | 0 | 0 | 0 | 0 |
| yii-basic | 132051 | 132051 | 0.00% | 0 | 0 | 0 | 0 |
| lumen | 92982 | 92982 | 0.00% | 0 | 0 | 0 | 0 |
| cakephp | 79345 | 79345 | 0.00% | 0 | 0 | 0 | 0 |
| nette | 79247 | 79247 | 0.00% | 0 | 0 | 0 | 0 |
| symfony | 78833 | 78833 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte | 57258 | 57258 | 0.00% | 0 | 0 | 0 | 0 |
| codeigniter | 51653 | 51653 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api | 38998 | 38998 | 0.00% | 0 | 0 | 0 | 0 |
| laravel | 32970 | 32970 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 125

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| pure-php | 410610 | 410610 | 0.00% | 0 | 0 | 0 | 0 |
| kumbia | 323128 | 323128 | 0.00% | 0 | 0 | 0 | 0 |
| leaf | 233726 | 233726 | 0.00% | 0 | 0 | 0 | 0 |
| fatfree | 231992 | 231992 | 0.00% | 0 | 0 | 0 | 0 |
| flight | 201837 | 201837 | 0.00% | 0 | 0 | 0 | 0 |
| slim | 143582 | 143582 | 0.00% | 0 | 0 | 0 | 0 |
| yii-basic | 134813 | 134813 | 0.00% | 0 | 0 | 0 | 0 |
| lumen | 87858 | 87858 | 0.00% | 0 | 0 | 0 | 0 |
| nette | 74550 | 74550 | 0.00% | 0 | 0 | 0 | 0 |
| cakephp | 72270 | 72270 | 0.00% | 0 | 0 | 0 | 0 |
| symfony | 70898 | 70898 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte | 54121 | 54121 | 0.00% | 0 | 0 | 0 | 0 |
| codeigniter | 48787 | 48787 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api | 36784 | 36784 | 0.00% | 0 | 0 | 0 | 0 |
| laravel | 31087 | 31087 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 250

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| pure-php | 386000 | 386000 | 0.00% | 0 | 0 | 0 | 0 |
| kumbia | 325010 | 325010 | 0.00% | 0 | 0 | 0 | 0 |
| leaf | 239901 | 239901 | 0.00% | 0 | 0 | 0 | 0 |
| fatfree | 238501 | 238501 | 0.00% | 0 | 0 | 0 | 0 |
| flight | 202080 | 202080 | 0.00% | 0 | 0 | 0 | 0 |
| yii-basic | 134008 | 134008 | 0.00% | 0 | 0 | 0 | 0 |
| slim | 130095 | 130095 | 0.00% | 0 | 0 | 0 | 0 |
| lumen | 86862 | 86846 | 0.02% | 0 | 16 | 0 | 0 |
| symfony | 68865 | 68835 | 0.03% | 0 | 24 | 0 | 0 |
| nette | 70135 | 70112 | 0.05% | 0 | 36 | 0 | 0 |
| cakephp | 67740 | 67705 | 0.05% | 0 | 35 | 0 | 0 |
| infbyte | 51314 | 51257 | 0.17% | 0 | 83 | 0 | 0 |
| codeigniter | 46128 | 46021 | 0.23% | 0 | 107 | 0 | 0 |
| laravel-api | 34603 | 34448 | 0.42% | 0 | 143 | 0 | 0 |
| laravel | 29047 | 28880 | 0.58% | 0 | 170 | 0 | 0 |

## Relative comparison

| Target | Peak throughput | Remote memory | Server time | Included files |
| --- | --- | --- | --- | --- |
| leaf | 7.16× | 1.08× | 4.16× | 22.00× |
| fatfree | 7.09× | 1.13× | 4.42× | 7.00× |
| flight | 6.19× | 1.10× | 4.68× | 26.00× |
| kumbia | 9.81× | 1.08× | 2.65× | 14.00× |
| slim | 4.40× | 1.13× | 7.41× | 82.00× |
| lumen | 2.82× | 1.13× | 16.67× | 107.00× |
| infbyte | 1.74× | 1.42× | 35.87× | 133.00× |
| codeigniter | 1.57× | 1.45× | 43.63× | 113.00× |
| cakephp | 2.41× | 1.45× | 21.30× | 167.00× |
| nette | 2.41× | 1.35× | 18.37× | 130.00× |
| laravel-api | 1.18× | 1.78× | 45.00× | 372.00× |
| laravel | 1.00× | 1.80× | 34.83× | 369.00× |
| pure-php | 12.56× | 1.00× | 1.00× | 1.00× |
| yii-basic | 4.09× | 1.90× | 8.80× | 54.00× |
| symfony | 2.39× | 1.28× | 20.97× | 184.00× |

## Resource telemetry

| Target | Samples | Avg CPU | Peak CPU | Avg MB | Peak MB | Remote MB |
| --- | --- | --- | --- | --- | --- | --- |
| leaf | 0 | — | — | — | — | 0.43 |
| fatfree | 0 | — | — | — | — | 0.45 |
| flight | 0 | — | — | — | — | 0.44 |
| kumbia | 0 | — | — | — | — | 0.43 |
| slim | 0 | — | — | — | — | 0.45 |
| lumen | 0 | — | — | — | — | 0.45 |
| infbyte | 0 | — | — | — | — | 0.57 |
| codeigniter | 0 | — | — | — | — | 0.58 |
| cakephp | 0 | — | — | — | — | 0.58 |
| nette | 0 | — | — | — | — | 0.54 |
| laravel-api | 0 | — | — | — | — | 0.71 |
| laravel | 0 | — | — | — | — | 0.72 |
| pure-php | 0 | — | — | — | — | 0.40 |
| yii-basic | 0 | — | — | — | — | 0.76 |
| symfony | 0 | — | — | — | — | 0.51 |

## Server response telemetry

| Target | Metric | Samples | Average | Minimum | Maximum |
| --- | --- | --- | --- | --- | --- |
| leaf | Included files | 2505383 | 22.00000 | 22.00000 | 22.00000 |
| leaf | Server execution ms | 2505383 | 3.69269 | 0.12300 | 253.74300 |
| fatfree | Included files | 2480808 | 7.00000 | 7.00000 | 7.00000 |
| fatfree | Server execution ms | 2480808 | 3.91913 | 0.11200 | 232.88500 |
| flight | Included files | 2179709 | 26.00000 | 26.00000 | 26.00000 |
| flight | Server execution ms | 2179709 | 4.15383 | 0.13800 | 240.89600 |
| kumbia | Included files | 3158098 | 14.00000 | 14.00000 | 14.00000 |
| kumbia | Server execution ms | 3158098 | 2.34555 | 0.07600 | 276.62400 |
| slim | Included files | 1514633 | 82.00000 | 82.00000 | 82.00000 |
| slim | Server execution ms | 1514633 | 6.57358 | 0.25700 | 314.59800 |
| lumen | Included files | 1001784 | 107.00000 | 107.00000 | 107.00000 |
| lumen | Server execution ms | 1001784 | 14.78585 | 0.53000 | 412.18800 |
| infbyte | Included files | 612609 | 133.00000 | 133.00000 | 133.00000 |
| infbyte | Server execution ms | 612609 | 31.80934 | 0.98900 | 374.33500 |
| codeigniter | Included files | 554405 | 113.00000 | 113.00000 | 113.00000 |
| codeigniter | Server execution ms | 554405 | 38.69142 | 1.17500 | 386.69600 |
| cakephp | Included files | 807616 | 167.00000 | 167.00000 | 167.00000 |
| cakephp | Server execution ms | 807616 | 18.88691 | 0.68700 | 370.18000 |
| nette | Included files | 823935 | 130.00409 | 130.00000 | 134.00000 |
| nette | Server execution ms | 823935 | 16.29371 | 0.69900 | 370.71300 |
| laravel-api | Included files | 420874 | 372.00000 | 372.00000 | 372.00000 |
| laravel-api | Server execution ms | 420874 | 39.90542 | 1.70300 | 514.88800 |
| laravel | Included files | 357964 | 369.00000 | 369.00000 | 369.00000 |
| laravel | Server execution ms | 357964 | 30.88741 | 1.48900 | 486.76400 |
| pure-php | Included files | 4171909 | 1.00000 | 1.00000 | 1.00000 |
| pure-php | Server execution ms | 4171909 | 0.88678 | 0.04500 | 102.88700 |
| yii-basic | Included files | 1409739 | 54.00000 | 54.00000 | 54.00000 |
| yii-basic | Server execution ms | 1409739 | 7.80718 | 0.29700 | 328.61400 |
| symfony | Included files | 823457 | 184.00000 | 184.00000 | 184.00000 |
| symfony | Server execution ms | 823457 | 18.59549 | 0.62500 | 422.33000 |

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

| Setting | leaf | fatfree | flight | kumbia | slim | lumen | infbyte | codeigniter | cakephp | nette | laravel-api | laravel | pure-php | yii-basic | symfony |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| Url | http://127.0.0.1:32768/frameworks/leaf/asset/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/fatfree/asset/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/flight/asset/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/kumbia/asset/default/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/slim/asset/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/lumen/asset/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/infbyte/asset/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/codeigniter/asset/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/cakephp/asset/webroot/index.php/hello/index | http://127.0.0.1:32768/frameworks/nette/asset/www/index.php/hello/index | http://127.0.0.1:32768/frameworks/laravel-api/asset/public/index.php/api/hello/index | http://127.0.0.1:32768/frameworks/laravel/asset/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/pure-php/asset/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/yii-basic/asset/web/index.php?r=hello/index | http://127.0.0.1:32768/frameworks/symfony/asset/public/index.php/hello/index |
