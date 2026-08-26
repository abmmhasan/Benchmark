#!/usr/bin/env bash

set -euo pipefail

action="${1:-}"
target="${2:-}"
support_dir="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" && pwd -P)"
suite_dir="$(cd -- "$support_dir/.." && pwd -P)"
target_dir="$suite_dir/$target"
benchmark_dir="$target_dir/_benchmark"
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
    infbyte) package="infocyph/infbyte" ;;
    kumbia) package="kumbia/framework" ;;
    laravel|laravel-api) package="laravel/laravel" ;;
    leaf) package="leafs/leaf" ;;
    lumen) package="laravel/lumen" ;;
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
        "$target_dir"/*) find "$directory" -mindepth 1 -maxdepth 1 -exec rm -rf -- {} + ;;
        *) printf 'Refusing to clear path outside target: %s\n' "$directory" >&2; exit 2 ;;
    esac
}

apply_overlay() {
    if [[ -d "$benchmark_dir/overlay" ]]; then
        cp -a "$benchmark_dir/overlay/." "$target_dir/"
    fi
}

setup_project() {
    clean_generated

    if [[ -n "$package" ]]; then
        build_dir="$target_dir/.benchmark-create-project"
        composer create-project --prefer-dist --no-cache --no-interaction \
            --no-dev --remove-vcs --stability=stable \
            "$package" "$build_dir" --ansi
        rm -f -- "$build_dir/.gitignore"
        rm -rf -- "$build_dir/_benchmark"
        cp -a "$build_dir/." "$target_dir/"
        rm -rf -- "$build_dir"
        build_dir=""
    fi

    if [[ "$target" == 'symfony' ]]; then
        composer --working-dir="$target_dir" require --no-interaction \
            symfony/framework-bundle symfony/runtime symfony/yaml
    fi

    apply_overlay

    if [[ -f "$target_dir/composer.json" ]]; then
        composer --working-dir="$target_dir" dump-autoload \
            --no-dev --classmap-authoritative --ansi
    fi

    case "$target" in
        cakephp)
            rm -f -- "$target_dir/webroot/.htaccess"
            chmod -R a+rwX "$target_dir/logs" "$target_dir/tmp"
            ;;
        codeigniter)
            rm -f -- "$target_dir/public/.htaccess"
            chmod -R a+rwX "$target_dir/writable"
            ;;
        infbyte)
            rm -f -- "$target_dir/public/.htaccess"
            php "$target_dir/infbyte" optimize
            chmod -R a+rwX "$target_dir/bootstrap/cache" "$target_dir/storage"
            ;;
        kumbia)
            find "$target_dir" -name '.htaccess' -type f -delete
            ;;
        laravel|laravel-api)
            rm -f -- "$target_dir/public/.htaccess"
            php "$target_dir/artisan" optimize
            chmod -R a+rwX "$target_dir/bootstrap/cache" "$target_dir/storage"
            ;;
        lumen)
            rm -f -- "$target_dir/public/.htaccess"
            chmod -R a+rwX "$target_dir/storage"
            ;;
        nette)
            chmod -R a+rwX "$target_dir/log" "$target_dir/temp"
            ;;
        symfony)
            composer --working-dir="$target_dir" dump-env prod --ansi
            APP_ENV=prod APP_DEBUG=0 php "$target_dir/bin/console" cache:clear --no-debug
            chmod -R a+rwX "$target_dir/var"
            ;;
        yii-basic)
            chmod -R a+rwX "$target_dir/runtime" "$target_dir/web/assets"
            ;;
    esac
}

clear_cache() {
    assert_target
    case "$target" in
        cakephp) php "$target_dir/bin/cake.php" cache clear_all ;;
        codeigniter) clear_directory "$target_dir/writable/cache" ;;
        infbyte) php "$target_dir/infbyte" optimize:clear; php "$target_dir/infbyte" optimize ;;
        kumbia) clear_directory "$target_dir/default/app/tmp/cache" ;;
        laravel|laravel-api) php "$target_dir/artisan" optimize:clear; php "$target_dir/artisan" optimize ;;
        lumen) php "$target_dir/artisan" cache:clear ;;
        nette) clear_directory "$target_dir/temp/cache" ;;
        slim) clear_directory "$target_dir/var/cache" ;;
        symfony) APP_ENV=prod APP_DEBUG=0 php "$target_dir/bin/console" cache:clear --no-debug ;;
        yii-basic) clear_directory "$target_dir/runtime/cache" ;;
        fatfree|leaf|pure-php) : ;;
    esac
}

case "$action" in
    setup|update) setup_project ;;
    clean) clean_generated ;;
    clear-cache) clear_cache ;;
    *) printf 'Unknown lifecycle action: %s\n' "$action" >&2; exit 2 ;;
esac
