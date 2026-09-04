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

php /app/frameworks/infbyte/asset/benchmark-worker.php workerman 9502 & benchmark_pids+=("$!")
php /app/frameworks/infbyte-full/asset/benchmark-worker.php workerman 9503 & benchmark_pids+=("$!")
php /app/frameworks/webrick-sharded/asset/benchmark-worker.php workerman 9504 & benchmark_pids+=("$!")
php /app/frameworks/webrick-fused/asset/benchmark-worker.php workerman 9505 & benchmark_pids+=("$!")
php /app/frameworks/webrick-generated/asset/benchmark-worker.php workerman 9509 & benchmark_pids+=("$!")
nginx -c /etc/nginx/nginx.conf -g 'daemon off;' & benchmark_pids+=("$!")

wait -n "${benchmark_pids[@]}"
