#!/usr/bin/env bash
set -euo pipefail

php-fpm --nodaemonize &
fpm_pid="$!"

stop_server() {
    kill -TERM "$fpm_pid" 2>/dev/null || true
    wait "$fpm_pid" 2>/dev/null || true
}
trap stop_server EXIT INT TERM

nginx -c /etc/nginx/nginx.conf -g 'daemon off;'
