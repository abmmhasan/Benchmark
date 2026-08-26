<?php

declare(strict_types=1);

printf(
    "\n%' 8d:%f:%'.03d",
    memory_get_peak_usage(),
    microtime(true) - (float) ($_SERVER['REQUEST_TIME_FLOAT'] ?? microtime(true)),
    max(0, count(get_included_files()) - 1),
);
