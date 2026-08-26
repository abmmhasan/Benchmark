<?php

declare(strict_types=1);

echo 'opcache_reset: ' . (function_exists('opcache_reset') && opcache_reset() ? 'done' : 'disabled/pending');
