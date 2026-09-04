#!/usr/bin/env bash
set -euo pipefail

workers="$(nproc)"
declare -a benchmark_pids=()
config_dir="/tmp/benchmark-roadrunner"
mkdir -p "$config_dir"

stop_servers() {
    if [[ "${#benchmark_pids[@]}" -gt 0 ]]; then
        kill -TERM "${benchmark_pids[@]}" 2>/dev/null || true
        wait "${benchmark_pids[@]}" 2>/dev/null || true
    fi
}
trap stop_servers EXIT INT TERM

start_worker() {
    local name="$1" asset="$2" port="$3" rpc="$4"
    local config="$config_dir/$name.yaml"
    printf '%s\n' \
        "version: '3'" \
        "rpc:" \
        "  listen: tcp://127.0.0.1:$rpc" \
        "server:" \
        "  command: php $asset/benchmark-worker.php roadrunner" \
        "  relay: pipes" \
        "http:" \
        "  address: 127.0.0.1:$port" \
        "  pool:" \
        "    num_workers: $workers" \
        "logs:" \
        "  level: error" \
        "  mode: production" > "$config"
    rr serve -c "$config" & benchmark_pids+=("$!")
}

start_worker infbyte /app/frameworks/infbyte/asset 9502 6002
start_worker infbyte-full /app/frameworks/infbyte-full/asset 9503 6003
start_worker webrick-sharded /app/frameworks/webrick-sharded/asset 9504 6004
start_worker webrick-fused /app/frameworks/webrick-fused/asset 9505 6005
start_worker webrick-generated /app/frameworks/webrick-generated/asset 9509 6009

ln -sf /usr/local/bin/rr /app/frameworks/laravel/asset/rr
ln -sf /usr/local/bin/rr /app/frameworks/laravel-api/asset/rr
php /app/frameworks/laravel/asset/artisan octane:start --server=roadrunner --host=127.0.0.1 --port=9506 --rpc-port=6006 --workers="$workers" --max-requests=100000 --no-interaction & benchmark_pids+=("$!")
php /app/frameworks/laravel-api/asset/artisan octane:start --server=roadrunner --host=127.0.0.1 --port=9507 --rpc-port=6007 --workers="$workers" --max-requests=100000 --no-interaction & benchmark_pids+=("$!")
nginx -c /etc/nginx/nginx.conf -g 'daemon off;' & benchmark_pids+=("$!")

wait -n "${benchmark_pids[@]}"
