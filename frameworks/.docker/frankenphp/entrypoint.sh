#!/usr/bin/env bash
set -euo pipefail

export BENCHMARK_WORKERS="$(nproc)"
declare -a benchmark_pids=()

stop_servers() {
    if [[ "${#benchmark_pids[@]}" -gt 0 ]]; then
        kill -TERM "${benchmark_pids[@]}" 2>/dev/null || true
        wait "${benchmark_pids[@]}" 2>/dev/null || true
    fi
}
trap stop_servers EXIT INT TERM

frankenphp run --config /etc/frankenphp/benchmark.Caddyfile --adapter caddyfile & benchmark_pids+=("$!")

(
    cd /app/frameworks/laravel/asset
    frankenphp php-cli artisan octane:frankenphp --host=127.0.0.1 --port=9506 --admin-port=2016 --workers="$BENCHMARK_WORKERS" --max-requests=100000 --no-interaction
) & benchmark_pids+=("$!")
(
    cd /app/frameworks/laravel-api/asset
    frankenphp php-cli artisan octane:frankenphp --host=127.0.0.1 --port=9507 --admin-port=2017 --workers="$BENCHMARK_WORKERS" --max-requests=100000 --no-interaction
) & benchmark_pids+=("$!")

nginx -c /etc/nginx/nginx.conf -g 'daemon off;' & benchmark_pids+=("$!")
wait -n "${benchmark_pids[@]}"
