#!/usr/bin/env bash

set -euo pipefail

declare -a benchmark_pids=()

stop_servers() {
    if [[ "${#benchmark_pids[@]}" -gt 0 ]]; then
        kill -TERM "${benchmark_pids[@]}" 2>/dev/null || true
        wait "${benchmark_pids[@]}" 2>/dev/null || true
    fi
}
trap stop_servers EXIT INT TERM

php /app/frameworks/hyperf/asset/bin/hyperf.php start &
benchmark_pids+=("$!")
php /app/frameworks/_support/swoole/infbyte-server.php /app/frameworks/infbyte/asset 9502 &
benchmark_pids+=("$!")
php /app/frameworks/_support/swoole/infbyte-server.php /app/frameworks/infbyte-full/asset 9503 &
benchmark_pids+=("$!")
php /app/frameworks/_support/swoole/webrick-server.php /app/frameworks/webrick-sharded/asset 9504 &
benchmark_pids+=("$!")
php /app/frameworks/_support/swoole/webrick-server.php /app/frameworks/webrick-fused/asset 9505 &
benchmark_pids+=("$!")
php /app/frameworks/_support/swoole/webrick-server.php /app/frameworks/webrick-generated/asset 9509 &
benchmark_pids+=("$!")
php /app/frameworks/laravel/asset/artisan octane:start --server=swoole --host=0.0.0.0 --port=9506 --workers="$(nproc)" --task-workers=0 --max-requests=100000 --no-interaction &
benchmark_pids+=("$!")
php /app/frameworks/laravel-api/asset/artisan octane:start --server=swoole --host=0.0.0.0 --port=9507 --workers="$(nproc)" --task-workers=0 --max-requests=100000 --no-interaction &
benchmark_pids+=("$!")
APP_ENV=prod APP_DEBUG=0 APP_RUNTIME='Runtime\Swoole\Runtime' SWOOLE_HOST=0.0.0.0 SWOOLE_PORT=9508 \
    php /app/frameworks/symfony/asset/public/index.php &
benchmark_pids+=("$!")
nginx -c /etc/nginx/nginx.conf -g 'daemon off;' &
benchmark_pids+=("$!")

wait -n "${benchmark_pids[@]}"
