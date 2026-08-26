## Sustainable ranking

| Rank | Target | Best stable RPM | Stable concurrency | Peak observed RPM | Peak concurrency | Peak stability | Duration s |
| --- | --- | --- | --- | --- | --- | --- | --- |
| 1 | kumbia | 351,174 | 63 | 351,174 | 63 | Stable | 388.1 |
| 2 | fatfree | 291,864 | 63 | 291,864 | 63 | Stable | 389.0 |
| 3 | leaf | 276,702 | 125 | 282,977 | 63 | Unstable | 388.9 |
| 4 | pure-php | 242,523 | 2 | 412,838 | 63 | Unstable | 387.4 |
| 5 | slim | 200,652 | 63 | 200,652 | 63 | Stable | 391.3 |
| 6 | yii-basic | 191,735 | 63 | 191,735 | 63 | Stable | 391.6 |
| 7 | lumen | 130,805 | 63 | 130,805 | 63 | Stable | 396.3 |
| 8 | symfony | 117,796 | 63 | 117,796 | 63 | Stable | 397.7 |
| 9 | cakephp | 115,432 | 63 | 115,432 | 63 | Stable | 398.8 |
| 10 | nette | 112,728 | 63 | 112,728 | 63 | Stable | 399.2 |
| 11 | infbyte | 82,220 | 63 | 82,220 | 63 | Stable | 415.0 |
| 12 | codeigniter | 71,609 | 63 | 71,609 | 63 | Stable | 411.2 |
| 13 | laravel-api | 56,057 | 63 | 56,057 | 63 | Stable | 418.2 |
| 14 | laravel | 48,332 | 63 | 48,332 | 63 | Stable | 426.2 |
| — | flight | — | — | 92,679 | 63 | Unstable | 461.0 |

## Throughput — concurrency 2

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM | Run 3 RPM |
| --- | --- | --- | --- | --- | --- | --- |
| pure-php | 242,523 | 0.66% | Stable | 241,155 | 242,756 | 242,523 |
| kumbia | 215,996 | 0.27% | Stable | 216,077 | 215,996 | 215,488 |
| leaf | 194,441 | 0.19% | Stable | 194,228 | 194,441 | 194,590 |
| fatfree | 193,026 | 0.56% | Stable | 192,216 | 193,026 | 193,298 |
| slim | 147,085 | 0.46% | Stable | 146,448 | 147,118 | 147,085 |
| yii-basic | 142,283 | 0.39% | Stable | 142,289 | 141,727 | 142,283 |
| lumen | 98,324 | 0.62% | Stable | 97,885 | 98,496 | 98,324 |
| symfony | 89,799 | 0.22% | Stable | 89,918 | 89,799 | 89,721 |
| cakephp | 87,204 | 1.14% | Stable | 87,534 | 87,204 | 86,540 |
| nette | 85,267 | 0.26% | Stable | 85,183 | 85,267 | 85,409 |
| flight | 60,078 | 95.81% | Unstable | 91,374 | 33,811 | 60,078 |
| infbyte | 59,377 | 1.55% | Stable | 59,287 | 60,206 | 59,377 |
| codeigniter | 51,541 | 0.09% | Stable | 51,585 | 51,540 | 51,541 |
| laravel-api | 41,333 | 1.10% | Stable | 41,333 | 41,128 | 41,581 |
| laravel | 36,349 | 3.13% | Stable | 35,281 | 36,349 | 36,419 |

## Throughput — concurrency 63

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM | Run 3 RPM |
| --- | --- | --- | --- | --- | --- | --- |
| pure-php | 412,838 | 7.05% | Unstable | 390,851 | 412,838 | 419,938 |
| kumbia | 351,174 | 1.32% | Stable | 353,743 | 351,174 | 349,121 |
| fatfree | 291,864 | 2.64% | Stable | 291,864 | 284,678 | 292,386 |
| leaf | 282,977 | 5.28% | Unstable | 282,977 | 269,087 | 284,035 |
| slim | 200,652 | 3.45% | Stable | 200,652 | 197,875 | 204,804 |
| yii-basic | 191,735 | 1.26% | Stable | 191,735 | 193,856 | 191,437 |
| lumen | 130,805 | 2.87% | Stable | 130,805 | 127,272 | 131,020 |
| symfony | 117,796 | 1.13% | Stable | 117,796 | 117,055 | 118,389 |
| cakephp | 115,432 | 2.18% | Stable | 116,793 | 115,432 | 114,277 |
| nette | 112,728 | 3.26% | Stable | 112,728 | 111,060 | 114,732 |
| flight | 92,679 | 55.20% | Unstable | 92,679 | 116,088 | 64,930 |
| infbyte | 82,220 | 3.22% | Stable | 83,103 | 82,220 | 80,454 |
| codeigniter | 71,609 | 1.37% | Stable | 71,829 | 70,845 | 71,609 |
| laravel-api | 56,057 | 2.56% | Stable | 54,841 | 56,057 | 56,277 |
| laravel | 48,332 | 2.72% | Stable | 47,594 | 48,332 | 48,909 |

## Throughput — concurrency 125

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM | Run 3 RPM |
| --- | --- | --- | --- | --- | --- | --- |
| pure-php | 401,968 | 5.27% | Unstable | 384,638 | 405,831 | 401,968 |
| kumbia | 331,424 | 2.43% | Stable | 326,433 | 331,424 | 334,472 |
| fatfree | 285,695 | 5.53% | Unstable | 285,695 | 272,007 | 287,801 |
| leaf | 276,702 | 3.41% | Stable | 267,543 | 276,702 | 276,967 |
| slim | 195,849 | 2.60% | Stable | 191,014 | 195,849 | 196,114 |
| yii-basic | 187,056 | 3.68% | Stable | 182,671 | 189,547 | 187,056 |
| lumen | 123,462 | 5.38% | Unstable | 125,517 | 118,877 | 123,462 |
| symfony | 112,690 | 1.61% | Stable | 112,456 | 112,690 | 114,268 |
| cakephp | 108,525 | 0.32% | Stable | 108,552 | 108,525 | 108,205 |
| nette | 105,653 | 2.65% | Stable | 104,213 | 105,653 | 107,010 |
| flight | 81,804 | 52.46% | Unstable | 70,788 | 81,804 | 113,699 |
| infbyte | 78,627 | 1.35% | Stable | 78,627 | 78,660 | 77,601 |
| codeigniter | 67,738 | 2.35% | Stable | 67,738 | 68,732 | 67,138 |
| laravel-api | 52,176 | 6.20% | Unstable | 51,229 | 52,176 | 54,465 |
| laravel | 45,629 | 2.31% | Stable | 45,343 | 45,629 | 46,396 |

## Throughput — concurrency 250

| Target | Median RPM | RPM spread | Stability | Run 1 RPM | Run 2 RPM | Run 3 RPM |
| --- | --- | --- | --- | --- | --- | --- |
| pure-php | 320,905 | 5.57% | Unstable | 305,036 | 320,905 | 322,901 |
| kumbia | 264,051 | 3.49% | Stable | 262,904 | 272,127 | 264,051 |
| fatfree | 227,587 | 7.17% | Unstable | 227,587 | 212,633 | 228,954 |
| leaf | 226,388 | 0.87% | Stable | 226,908 | 224,941 | 226,388 |
| slim | 155,285 | 3.16% | Stable | 156,951 | 155,285 | 152,048 |
| yii-basic | 148,818 | 3.80% | Stable | 144,488 | 148,818 | 150,147 |
| lumen | 101,978 | 2.00% | Stable | 102,832 | 101,978 | 100,797 |
| symfony | 90,479 | 0.74% | Stable | 90,479 | 89,900 | 90,566 |
| cakephp | 84,477 | 2.47% | Stable | 83,515 | 85,603 | 84,477 |
| nette | 82,749 | 1.79% | Stable | 82,749 | 82,457 | 83,938 |
| flight | 78,379 | 15.91% | Unstable | 67,679 | 78,379 | 80,147 |
| infbyte | 60,105 | 3.62% | Stable | 61,502 | 60,105 | 59,328 |
| codeigniter | 52,754 | 1.86% | Stable | 51,875 | 52,855 | 52,754 |
| laravel-api | 40,641 | 9.67% | Unstable | 40,641 | 37,922 | 41,852 |
| laravel | 35,635 | 3.67% | Stable | 34,884 | 35,635 | 36,191 |

## Latency — serial

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| pure-php | 0.36 | 0.40 | 0.59 | 0.00 | 0.34 |
| kumbia | 0.40 | 0.45 | 0.65 | 0.00 | 0.39 |
| leaf | 0.45 | 0.50 | 0.86 | 0.00 | 0.44 |
| fatfree | 0.46 | 0.51 | 0.77 | 0.00 | 0.45 |
| slim | 0.61 | 0.67 | 1.16 | 0.00 | 0.60 |
| yii-basic | 0.63 | 0.69 | 1.33 | 0.00 | 0.62 |
| flight | 0.79 | 1.07 | 1.59 | 0.00 | 1.77 |
| lumen | 0.94 | 1.00 | 1.62 | 0.00 | 0.84 |
| symfony | 1.03 | 1.10 | 1.80 | 0.00 | 0.93 |
| cakephp | 1.10 | 1.17 | 2.13 | 0.00 | 1.10 |
| nette | 1.12 | 1.19 | 2.26 | 0.00 | 1.12 |
| infbyte | 1.62 | 1.78 | 2.90 | 0.00 | 1.67 |
| codeigniter | 1.90 | 2.08 | 2.96 | 0.00 | 1.91 |
| laravel-api | 2.35 | 2.52 | 3.29 | 0.00 | 2.10 |
| laravel | 2.75 | 2.93 | 5.22 | 0.00 | 2.51 |

## Latency — concurrency 2

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| pure-php | 0.41 | 0.55 | 0.74 | 0.00 | 0.41 |
| kumbia | 0.46 | 0.63 | 0.84 | 0.00 | 0.47 |
| leaf | 0.52 | 0.69 | 0.94 | 0.00 | 0.53 |
| fatfree | 0.53 | 0.69 | 0.93 | 0.00 | 0.53 |
| slim | 0.73 | 0.90 | 1.20 | 0.00 | 0.73 |
| yii-basic | 0.75 | 0.93 | 1.25 | 0.00 | 0.76 |
| flight | 0.85 | 1.10 | 1.49 | 0.00 | 1.92 |
| lumen | 1.16 | 1.31 | 1.72 | 0.00 | 1.04 |
| symfony | 1.26 | 1.43 | 1.91 | 0.00 | 1.15 |
| cakephp | 1.26 | 1.53 | 2.00 | 0.00 | 1.29 |
| nette | 1.29 | 1.57 | 2.07 | 0.00 | 1.32 |
| infbyte | 1.82 | 2.31 | 2.83 | 0.00 | 1.94 |
| codeigniter | 2.10 | 2.72 | 3.16 | 0.00 | 2.24 |
| laravel-api | 2.69 | 3.26 | 3.85 | 0.00 | 2.52 |
| laravel | 3.02 | 3.84 | 4.46 | 0.00 | 2.92 |

## Latency — concurrency 63

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| pure-php | 5.70 | 13.37 | 19.88 | 0.01 | 6.44 |
| kumbia | 7.70 | 18.27 | 28.36 | 0.01 | 8.74 |
| flight | 9.52 | 100.42 | 143.16 | 0.01 | 38.10 |
| fatfree | 10.50 | 28.22 | 42.69 | 0.01 | 12.10 |
| leaf | 11.10 | 28.90 | 44.20 | 0.01 | 12.56 |
| slim | 15.10 | 47.17 | 63.81 | 0.01 | 18.46 |
| yii-basic | 15.95 | 48.08 | 65.18 | 0.01 | 19.35 |
| lumen | 22.11 | 73.87 | 88.99 | 0.01 | 24.75 |
| cakephp | 25.86 | 77.32 | 92.46 | 0.01 | 32.51 |
| symfony | 26.41 | 75.40 | 90.03 | 0.01 | 28.41 |
| nette | 27.74 | 79.19 | 92.78 | 0.01 | 33.29 |
| infbyte | 44.09 | 97.66 | 127.96 | 0.01 | 45.75 |
| codeigniter | 49.20 | 124.50 | 155.87 | 0.01 | 52.55 |
| laravel-api | 69.41 | 129.72 | 153.09 | 0.01 | 54.47 |
| laravel | 80.56 | 148.73 | 173.10 | 0.01 | 70.12 |

## Latency — concurrency 125

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| flight | 8.01 | 207.15 | 296.63 | 0.03 | 68.04 |
| pure-php | 9.71 | 25.64 | 38.81 | 0.02 | 12.04 |
| kumbia | 14.85 | 38.00 | 57.20 | 0.02 | 17.79 |
| leaf | 20.84 | 61.00 | 91.24 | 0.01 | 25.52 |
| fatfree | 21.19 | 55.85 | 82.67 | 0.02 | 24.08 |
| slim | 27.39 | 99.42 | 137.28 | 0.01 | 37.57 |
| yii-basic | 27.87 | 108.36 | 143.31 | 0.02 | 39.20 |
| lumen | 43.02 | 152.77 | 190.57 | 0.02 | 53.37 |
| symfony | 48.09 | 157.12 | 186.03 | 0.02 | 60.93 |
| nette | 51.43 | 173.87 | 205.11 | 0.02 | 70.56 |
| cakephp | 52.50 | 159.62 | 191.11 | 0.02 | 68.69 |
| infbyte | 77.08 | 205.77 | 280.42 | 0.03 | 94.93 |
| codeigniter | 98.27 | 238.48 | 311.58 | 0.03 | 110.27 |
| laravel-api | 132.32 | 276.48 | 345.28 | 0.03 | 115.96 |
| laravel | 155.51 | 293.39 | 340.49 | 0.03 | 146.98 |

## Latency — concurrency 250

| Target | p50 ms | p95 ms | p99 ms | Connect ms | TTFB ms |
| --- | --- | --- | --- | --- | --- |
| flight | 9.49 | 268.73 | 461.79 | 0.13 | 140.19 |
| pure-php | 12.81 | 32.62 | 845.67 | 0.04 | 30.83 |
| kumbia | 17.06 | 42.46 | 774.32 | 0.05 | 37.21 |
| leaf | 25.98 | 72.73 | 1,522.79 | 0.04 | 54.70 |
| fatfree | 26.45 | 74.98 | 1,551.67 | 0.04 | 53.44 |
| slim | 37.68 | 116.74 | 1,983.68 | 0.05 | 84.07 |
| yii-basic | 38.49 | 126.22 | 2,041.26 | 0.05 | 87.69 |
| lumen | 47.62 | 201.08 | 304.78 | 0.06 | 114.17 |
| symfony | 65.91 | 200.67 | 336.40 | 0.07 | 130.92 |
| nette | 69.47 | 212.63 | 293.10 | 0.08 | 143.79 |
| cakephp | 69.55 | 214.80 | 307.34 | 0.07 | 143.06 |
| infbyte | 110.76 | 283.09 | 414.92 | 0.09 | 181.64 |
| codeigniter | 139.00 | 335.63 | 442.82 | 0.11 | 193.09 |
| laravel-api | 191.14 | 357.35 | 472.33 | 0.11 | 190.77 |
| laravel | 218.28 | 396.34 | 502.49 | 0.13 | 237.03 |

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
| flight | 5000 | 4999 | 0.02% | 0 | 1 | 0 | 0 |

## Reliability — concurrency 2

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| pure-php | 121262 | 121262 | 0.00% | 0 | 0 | 0 | 0 |
| kumbia | 108000 | 108000 | 0.00% | 0 | 0 | 0 | 0 |
| leaf | 97222 | 97222 | 0.00% | 0 | 0 | 0 | 0 |
| fatfree | 96514 | 96514 | 0.00% | 0 | 0 | 0 | 0 |
| slim | 73543 | 73543 | 0.00% | 0 | 0 | 0 | 0 |
| yii-basic | 71142 | 71142 | 0.00% | 0 | 0 | 0 | 0 |
| lumen | 49163 | 49163 | 0.00% | 0 | 0 | 0 | 0 |
| symfony | 44901 | 44901 | 0.00% | 0 | 0 | 0 | 0 |
| cakephp | 43603 | 43603 | 0.00% | 0 | 0 | 0 | 0 |
| nette | 42635 | 42635 | 0.00% | 0 | 0 | 0 | 0 |
| flight | 30874 | 30874 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte | 29690 | 29690 | 0.00% | 0 | 0 | 0 | 0 |
| codeigniter | 25773 | 25773 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api | 20668 | 20668 | 0.00% | 0 | 0 | 0 | 0 |
| laravel | 18176 | 18176 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 63

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| pure-php | 206469 | 206469 | 0.00% | 0 | 0 | 0 | 0 |
| kumbia | 175639 | 175639 | 0.00% | 0 | 0 | 0 | 0 |
| fatfree | 145986 | 145986 | 0.00% | 0 | 0 | 0 | 0 |
| leaf | 141542 | 141542 | 0.00% | 0 | 0 | 0 | 0 |
| slim | 100373 | 100373 | 0.00% | 0 | 0 | 0 | 0 |
| yii-basic | 95925 | 95925 | 0.00% | 0 | 0 | 0 | 0 |
| lumen | 65449 | 65449 | 0.00% | 0 | 0 | 0 | 0 |
| symfony | 58939 | 58939 | 0.00% | 0 | 0 | 0 | 0 |
| cakephp | 57755 | 57755 | 0.00% | 0 | 0 | 0 | 0 |
| nette | 56411 | 56411 | 0.00% | 0 | 0 | 0 | 0 |
| flight | 49676 | 49676 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte | 41153 | 41153 | 0.00% | 0 | 0 | 0 | 0 |
| codeigniter | 35842 | 35842 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api | 28071 | 28071 | 0.00% | 0 | 0 | 0 | 0 |
| laravel | 24197 | 24197 | 0.00% | 0 | 0 | 0 | 0 |

## Reliability — concurrency 125

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| pure-php | 201055 | 201055 | 0.00% | 0 | 0 | 0 | 0 |
| kumbia | 165784 | 165784 | 0.00% | 0 | 0 | 0 | 0 |
| fatfree | 142942 | 142942 | 0.00% | 0 | 0 | 0 | 0 |
| leaf | 138453 | 138453 | 0.00% | 0 | 0 | 0 | 0 |
| slim | 98028 | 98028 | 0.00% | 0 | 0 | 0 | 0 |
| yii-basic | 93618 | 93618 | 0.00% | 0 | 0 | 0 | 0 |
| lumen | 61817 | 61817 | 0.00% | 0 | 0 | 0 | 0 |
| symfony | 56436 | 56436 | 0.00% | 0 | 0 | 0 | 0 |
| cakephp | 54347 | 54347 | 0.00% | 0 | 0 | 0 | 0 |
| nette | 52913 | 52913 | 0.00% | 0 | 0 | 0 | 0 |
| infbyte | 39407 | 39407 | 0.00% | 0 | 0 | 0 | 0 |
| codeigniter | 33937 | 33937 | 0.00% | 0 | 0 | 0 | 0 |
| laravel-api | 26165 | 26165 | 0.00% | 0 | 0 | 0 | 0 |
| laravel | 22886 | 22886 | 0.00% | 0 | 0 | 0 | 0 |
| flight | 50195 | 50157 | 0.08% | 0 | 38 | 0 | 0 |

## Reliability — concurrency 250

| Target | Attempted | Successful | Error rate | Transfer | Timeout | Status | Validation |
| --- | --- | --- | --- | --- | --- | --- | --- |
| pure-php | 197907 | 197907 | 0.00% | 0 | 0 | 0 | 0 |
| kumbia | 162877 | 162877 | 0.00% | 0 | 0 | 0 | 0 |
| fatfree | 140451 | 140451 | 0.00% | 0 | 0 | 0 | 0 |
| leaf | 139721 | 139721 | 0.00% | 0 | 0 | 0 | 0 |
| slim | 95864 | 95864 | 0.00% | 0 | 0 | 0 | 0 |
| yii-basic | 91872 | 91871 | 0.00% | 0 | 1 | 0 | 0 |
| lumen | 63016 | 62981 | 0.06% | 0 | 39 | 0 | 0 |
| symfony | 55900 | 55872 | 0.07% | 0 | 41 | 0 | 0 |
| cakephp | 52245 | 52178 | 0.10% | 0 | 52 | 0 | 0 |
| nette | 51194 | 51111 | 0.12% | 0 | 64 | 0 | 0 |
| flight | 49295 | 49185 | 0.22% | 0 | 113 | 0 | 0 |
| infbyte | 37278 | 37140 | 0.37% | 0 | 138 | 0 | 0 |
| codeigniter | 32785 | 32607 | 0.54% | 0 | 178 | 0 | 0 |
| laravel-api | 25341 | 25130 | 0.83% | 0 | 211 | 0 | 0 |
| laravel | 22297 | 22050 | 1.02% | 0 | 230 | 0 | 0 |

## Relative comparison

| Target | Peak throughput | Remote memory | Server time | Included files |
| --- | --- | --- | --- | --- |
| kumbia | 7.27× | 1.08× | 1.88× | 14.00× |
| fatfree | 6.04× | 1.13× | 3.14× | 7.00× |
| leaf | 5.85× | 1.08× | 3.29× | 22.00× |
| pure-php | 8.54× | 1.00× | 1.00× | 1.00× |
| slim | 4.15× | 1.13× | 5.63× | 82.00× |
| yii-basic | 3.97× | 1.90× | 5.44× | 54.00× |
| lumen | 2.71× | 1.13× | 10.40× | 107.00× |
| symfony | 2.44× | 1.28× | 14.21× | 184.00× |
| cakephp | 2.39× | 1.45× | 15.52× | 167.00× |
| nette | 2.33× | 1.35× | 15.99× | 130.00× |
| infbyte | 1.70× | 1.42× | 13.64× | 133.00× |
| codeigniter | 1.48× | 1.45× | 25.12× | 113.00× |
| laravel-api | 1.16× | 1.78× | 39.79× | 372.00× |
| laravel | 1.00× | 1.80× | 31.16× | 369.00× |
| flight | 1.92× | 2.40× | 8.18× | 76.00× |

## Resource telemetry

| Target | Samples | Avg CPU | Peak CPU | Avg MB | Peak MB | Remote MB |
| --- | --- | --- | --- | --- | --- | --- |
| kumbia | 0 | — | — | — | — | 0.43 |
| fatfree | 0 | — | — | — | — | 0.45 |
| leaf | 0 | — | — | — | — | 0.43 |
| pure-php | 0 | — | — | — | — | 0.40 |
| slim | 0 | — | — | — | — | 0.45 |
| yii-basic | 0 | — | — | — | — | 0.76 |
| lumen | 0 | — | — | — | — | 0.45 |
| symfony | 0 | — | — | — | — | 0.51 |
| cakephp | 0 | — | — | — | — | 0.58 |
| nette | 0 | — | — | — | — | 0.54 |
| infbyte | 0 | — | — | — | — | 0.57 |
| codeigniter | 0 | — | — | — | — | 0.58 |
| laravel-api | 0 | — | — | — | — | 0.71 |
| laravel | 0 | — | — | — | — | 0.72 |
| flight | 0 | — | — | — | — | 0.96 |

## Server response telemetry

| Target | Metric | Samples | Average | Minimum | Maximum |
| --- | --- | --- | --- | --- | --- |
| kumbia | Included files | 1855244 | 14.00000 | 14.00000 | 14.00000 |
| kumbia | Server execution ms | 1855244 | 3.55016 | 0.14700 | 206.07600 |
| fatfree | Included files | 1574908 | 7.00000 | 7.00000 | 7.00000 |
| fatfree | Server execution ms | 1574908 | 5.91664 | 0.18400 | 264.87400 |
| leaf | Included files | 1554293 | 22.00000 | 22.00000 | 22.00000 |
| leaf | Server execution ms | 1554293 | 6.18748 | 0.18400 | 244.25300 |
| pure-php | Included files | 2171998 | 1.00000 | 1.00000 | 1.00000 |
| pure-php | Server execution ms | 2171998 | 1.88350 | 0.10300 | 109.26400 |
| slim | Included files | 1115539 | 82.00000 | 82.00000 | 82.00000 |
| slim | Server execution ms | 1115539 | 10.60484 | 0.31000 | 299.06600 |
| yii-basic | Included files | 1070516 | 54.00000 | 54.00000 | 54.00000 |
| yii-basic | Server execution ms | 1070516 | 10.25050 | 0.34000 | 429.68900 |
| lumen | Included files | 729952 | 107.00000 | 107.00000 | 107.00000 |
| lumen | Server execution ms | 729952 | 19.59507 | 0.60200 | 424.81400 |
| symfony | Included files | 663774 | 184.00000 | 184.00000 | 184.00000 |
| symfony | Server execution ms | 663774 | 26.76052 | 0.69700 | 406.63500 |
| cakephp | Included files | 638539 | 167.00000 | 167.00000 | 167.00000 |
| cakephp | Server execution ms | 638539 | 29.23442 | 0.77900 | 499.78900 |
| nette | Included files | 624866 | 130.00382 | 130.00000 | 134.00000 |
| nette | Server execution ms | 624866 | 30.12536 | 0.80600 | 546.47300 |
| infbyte | Included files | 456978 | 133.00000 | 133.00000 | 133.00000 |
| infbyte | Server execution ms | 456978 | 25.69658 | 1.27000 | 834.32800 |
| codeigniter | Included files | 398968 | 113.00000 | 113.00000 | 113.00000 |
| codeigniter | Server execution ms | 398968 | 47.31047 | 1.57600 | 448.32700 |
| laravel-api | Included files | 314308 | 372.00000 | 372.00000 | 372.00000 |
| laravel-api | Server execution ms | 314308 | 74.95104 | 1.96800 | 707.07700 |
| laravel | Included files | 276472 | 369.00000 | 369.00000 | 369.00000 |
| laravel | Server execution ms | 276472 | 58.69063 | 1.78900 | 588.60400 |
| flight | Included files | 563652 | 76.00000 | 76.00000 | 76.00000 |
| flight | Server execution ms | 563652 | 15.39962 | 0.41000 | 9,905.87000 |

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

| Setting | kumbia | fatfree | leaf | pure-php | slim | yii-basic | lumen | symfony | cakephp | nette | infbyte | codeigniter | laravel-api | laravel | flight |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| Url | http://127.0.0.1:32768/frameworks/kumbia/default/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/fatfree/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/leaf/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/pure-php/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/slim/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/yii-basic/web/index.php?r=hello/index | http://127.0.0.1:32768/frameworks/lumen/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/symfony/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/cakephp/webroot/index.php/hello/index | http://127.0.0.1:32768/frameworks/nette/www/index.php/hello/index | http://127.0.0.1:32768/frameworks/infbyte/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/codeigniter/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/laravel-api/public/index.php/api/hello/index | http://127.0.0.1:32768/frameworks/laravel/public/index.php/hello/index | http://127.0.0.1:32768/frameworks/flight/public/index.php/hello/index |
