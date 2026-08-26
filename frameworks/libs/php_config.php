<?php

declare(strict_types=1);

echo 'PHP: ' . PHP_VERSION . PHP_EOL;
echo 'OPCache: ' . (is_array(opcache_get_status(false)) ? 'On' : 'Off') . PHP_EOL;
