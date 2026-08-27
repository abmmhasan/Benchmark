#!/usr/bin/env bash

set -euo pipefail

action="${1:-}"
target="${2:-}"
support_dir="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" && pwd -P)"
suite_dir="$(cd -- "$support_dir/.." && pwd -P)"
target_dir="$suite_dir/$target"
benchmark_dir="$target_dir/_benchmark"
asset_dir="$target_dir/asset"
build_dir=""

cleanup_build() {
    if [[ -n "$build_dir" && -d "$build_dir" ]]; then
        rm -rf -- "$build_dir"
    fi
}
trap cleanup_build EXIT

case "$target" in
    cakephp) package="cakephp/app" ;;
    codeigniter) package="codeigniter4/appstarter" ;;
    fatfree) package="bcosca/fatfree-core" ;;
    flight) package="flightphp/skeleton" ;;
    infbyte) package="infocyph/infbyte" ;;
    kumbia) package="kumbia/framework" ;;
    laravel|laravel-api) package="laravel/laravel" ;;
    leaf) package="leafs/leaf" ;;
    nette) package="nette/web-project" ;;
    pure-php) package="" ;;
    slim) package="slim/slim-skeleton" ;;
    symfony) package="symfony/skeleton" ;;
    yii-basic) package="yiisoft/yii2-app-basic" ;;
    *) printf 'Unknown framework target: %s\n' "$target" >&2; exit 2 ;;
esac

assert_target() {
    if [[ ! -d "$benchmark_dir" || ! -f "$target_dir/.gitignore" ]]; then
        printf 'Refusing lifecycle operation outside a managed target: %s\n' "$target_dir" >&2
        exit 2
    fi
}

clean_generated() {
    assert_target
    find "$target_dir" -mindepth 1 -maxdepth 1 \
        ! -name '.gitignore' ! -name '_benchmark' -exec rm -rf -- {} +
}

clear_directory() {
    local directory="$1"
    [[ -d "$directory" ]] || return 0
    case "$(cd -- "$directory" && pwd -P)" in
        "$asset_dir"/*) find "$directory" -mindepth 1 -maxdepth 1 -exec rm -rf -- {} + ;;
        *) printf 'Refusing to clear path outside target asset: %s\n' "$directory" >&2; exit 2 ;;
    esac
}

apply_overlay() {
    if [[ -d "$benchmark_dir/overlay" ]]; then
        cp -a "$benchmark_dir/overlay/." "$asset_dir/"
    fi
}

set_env_value() {
    local file="$1"
    local key="$2"
    local value="$3"
    [[ -f "$file" ]] || return 0

    if grep -q "^${key}=" "$file"; then
        sed -i "s|^${key}=.*|${key}=${value}|" "$file"
    else
        printf '\n%s=%s\n' "$key" "$value" >> "$file"
    fi
}

configure_production_environment() {
    case "$target" in
        cakephp)
            set_env_value "$asset_dir/.env" APP_ENV production
            set_env_value "$asset_dir/.env" DEBUG false
            ;;
        codeigniter)
            if [[ ! -f "$asset_dir/.env" && -f "$asset_dir/env" ]]; then
                cp "$asset_dir/env" "$asset_dir/.env"
            fi
            set_env_value "$asset_dir/.env" CI_ENVIRONMENT production
            ;;
        flight)
            set_env_value "$asset_dir/.env" APP_ENV production
            set_env_value "$asset_dir/.env" APP_DEBUG false
            ;;
        infbyte|laravel|laravel-api)
            set_env_value "$asset_dir/.env" APP_ENV production
            set_env_value "$asset_dir/.env" APP_DEBUG false
            ;;
        symfony)
            set_env_value "$asset_dir/.env" APP_ENV prod
            set_env_value "$asset_dir/.env" APP_DEBUG 0
            ;;
        fatfree|kumbia|leaf|nette|pure-php|slim|yii-basic)
            # These fixtures define production behavior directly in their overlays.
            ;;
    esac
}

prepare_runtime_directories() {
    case "$target" in
        cakephp)
            rm -f -- "$asset_dir/webroot/.htaccess"
            chmod -R a+rwX "$asset_dir/logs" "$asset_dir/tmp"
            ;;
        codeigniter)
            rm -f -- "$asset_dir/public/.htaccess"
            chmod -R a+rwX "$asset_dir/writable"
            ;;
        flight)
            chmod -R a+rwX "$asset_dir/app/cache" "$asset_dir/app/log"
            ;;
        infbyte)
            rm -f -- "$asset_dir/public/.htaccess"
            chmod a+r "$asset_dir/.env"
            chmod -R a+rwX "$asset_dir/bootstrap/cache" "$asset_dir/storage"
            ;;
        kumbia)
            find "$asset_dir" -name '.htaccess' -type f -delete
            ;;
        laravel|laravel-api)
            rm -f -- "$asset_dir/public/.htaccess"
            set_env_value "$asset_dir/.env" SESSION_DRIVER array
            set_env_value "$asset_dir/.env" CACHE_STORE array
            set_env_value "$asset_dir/.env" QUEUE_CONNECTION sync
            chmod a+r "$asset_dir/.env"
            chmod -R a+rwX "$asset_dir/bootstrap/cache" "$asset_dir/storage"
            ;;
        nette)
            chmod -R a+rwX "$asset_dir/log" "$asset_dir/temp"
            ;;
        symfony)
            chmod -R a+rwX "$asset_dir/var"
            ;;
        yii-basic)
            chmod -R a+rwX "$asset_dir/runtime" "$asset_dir/web/assets"
            ;;
        fatfree|leaf|pure-php|slim)
            ;;
    esac
}

optimize_production() {
    case "$target" in
        cakephp)
            php "$asset_dir/bin/cake.php" cache clear_all
            ;;
        codeigniter)
            php "$asset_dir/spark" optimize
            ;;
        infbyte)
            php "$asset_dir/infbyte" optimize
            chmod -R a+rX "$asset_dir/bootstrap/cache"
            ;;
        laravel|laravel-api)
            php "$asset_dir/artisan" optimize
            ;;
        symfony)
            composer --working-dir="$asset_dir" dump-env prod --ansi
            APP_ENV=prod APP_DEBUG=0 php "$asset_dir/bin/console" cache:clear --no-debug
            ;;
        fatfree|flight|kumbia|leaf|nette|pure-php|slim|yii-basic)
            ;;
    esac
}

setup_project() {
    clean_generated
    mkdir -p -- "$asset_dir"

    if [[ -n "$package" ]]; then
        build_dir="$target_dir/.benchmark-create-project"
        composer create-project --prefer-dist --no-cache --no-interaction \
            --no-dev --remove-vcs --stability=stable \
            "$package" "$build_dir" --ansi
        rm -rf -- "$build_dir/_benchmark"
        cp -a "$build_dir/." "$asset_dir/"
        rm -rf -- "$build_dir"
        build_dir=""
    fi

    if [[ "$target" == 'symfony' ]]; then
        composer --working-dir="$asset_dir" require --no-interaction \
            --update-no-dev --classmap-authoritative --no-progress \
            symfony/framework-bundle symfony/runtime symfony/yaml
    fi

    apply_overlay
    configure_production_environment
    printf 'production\n' > "$suite_dir/.benchmark-profile"

    if [[ -f "$asset_dir/composer.json" ]]; then
        composer --working-dir="$asset_dir" install --prefer-dist --no-interaction \
            --no-dev --classmap-authoritative --no-progress --ansi
    fi

    prepare_runtime_directories
    optimize_production
}

clear_cache() {
    assert_target
    case "$target" in
        cakephp) php "$asset_dir/bin/cake.php" cache clear_all ;;
        codeigniter) clear_directory "$asset_dir/writable/cache" ;;
        infbyte)
            php "$asset_dir/infbyte" optimize:clear
            php "$asset_dir/infbyte" optimize
            chmod -R a+rX "$asset_dir/bootstrap/cache"
            ;;
        kumbia) clear_directory "$asset_dir/default/app/tmp/cache" ;;
        laravel|laravel-api) php "$asset_dir/artisan" optimize:clear; php "$asset_dir/artisan" optimize ;;
        nette) clear_directory "$asset_dir/temp/cache" ;;
        slim) clear_directory "$asset_dir/var/cache" ;;
        symfony) APP_ENV=prod APP_DEBUG=0 php "$asset_dir/bin/console" cache:clear --no-debug ;;
        yii-basic) clear_directory "$asset_dir/runtime/cache" ;;
        flight) clear_directory "$asset_dir/app/cache" ;;
        fatfree|leaf|pure-php) : ;;
    esac
}

case "$action" in
    setup|update) setup_project ;;
    clean) clean_generated ;;
    clear-cache) clear_cache ;;
    *) printf 'Unknown lifecycle action: %s\n' "$action" >&2; exit 2 ;;
esac
