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
project_version_log=""

cleanup_build() {
    if [[ -n "$build_dir" && -d "$build_dir" ]]; then
        rm -rf -- "$build_dir"
    fi
    if [[ -n "$project_version_log" && -f "$project_version_log" ]]; then
        rm -f -- "$project_version_log"
    fi
}
trap cleanup_build EXIT

case "$target" in
    cakephp) package="cakephp/app" ;;
    codeigniter) package="codeigniter4/appstarter" ;;
    fatfree) package="bcosca/fatfree-core" ;;
    fast-route) package="nikic/fast-route" ;;
    flight) package="flightphp/skeleton" ;;
    hyperf) package="hyperf/hyperf-skeleton" ;;
    infbyte|infbyte-full) package="infocyph/infbyte" ;;
    kumbia) package="kumbia/framework" ;;
    laravel|laravel-api) package="laravel/laravel" ;;
    leaf) package="leafs/leaf" ;;
    nette) package="nette/web-project" ;;
    pure-php) package="" ;;
    slim) package="slim/slim-skeleton" ;;
    symfony) package="symfony/skeleton" ;;
    webrick-sharded|webrick-fused|webrick-generated) package="infocyph/webrick:~5.1.0" ;;
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
    local shared_overlay=""

    case "$target" in
        infbyte-full) shared_overlay="$suite_dir/infbyte/_benchmark/overlay" ;;
        webrick-sharded|webrick-fused|webrick-generated) shared_overlay="$support_dir/webrick" ;;
    esac

    if [[ -n "$shared_overlay" && -d "$shared_overlay" ]]; then
        cp -a "$shared_overlay/." "$asset_dir/"
    fi
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
        hyperf)
            if [[ ! -f "$asset_dir/.env" && -f "$asset_dir/.env.example" ]]; then
                cp "$asset_dir/.env.example" "$asset_dir/.env"
            fi
            set_env_value "$asset_dir/.env" APP_ENV prod
            set_env_value "$asset_dir/.env" SCAN_CACHEABLE true
            ;;
        infbyte|infbyte-full|laravel|laravel-api)
            set_env_value "$asset_dir/.env" APP_ENV production
            set_env_value "$asset_dir/.env" APP_DEBUG false
            ;;
        symfony)
            set_env_value "$asset_dir/.env" APP_ENV prod
            set_env_value "$asset_dir/.env" APP_DEBUG 0
            ;;
        fast-route|fatfree|kumbia|leaf|nette|pure-php|slim|webrick-sharded|webrick-fused|webrick-generated|yii-basic)
            # These fixtures define production behavior directly in their overlays.
            ;;
    esac
}

install_all_infbyte_modules() {
    local manifest
    local module
    local -a modules=()
    local -a packages=()

    manifest="$(php "$asset_dir/infbyte" module:list --json --no-interaction)"
    mapfile -t modules < <(php -r '
        $modules = json_decode(stream_get_contents(STDIN), true, 512, JSON_THROW_ON_ERROR);
        foreach ($modules as $module) {
            if (is_array($module) && is_string($module["name"] ?? null)) {
                echo $module["name"], PHP_EOL;
            }
        }
    ' <<< "$manifest")
    mapfile -t packages < <(php -r '
        $modules = json_decode(stream_get_contents(STDIN), true, 512, JSON_THROW_ON_ERROR);
        foreach ($modules as $module) {
            foreach (is_array($module["packages"] ?? null) ? $module["packages"] : [] as $package => $metadata) {
                $constraint = is_array($metadata) ? ($metadata["constraint"] ?? null) : null;
                if (is_string($package) && is_string($constraint)) {
                    echo $package, ":", $constraint, PHP_EOL;
                }
            }
        }
    ' <<< "$manifest")

    if [[ "${#modules[@]}" -eq 0 ]]; then
        printf 'InfByte did not advertise any installable modules\n' >&2
        exit 1
    fi
    if [[ "${#packages[@]}" -gt 0 ]]; then
        composer --working-dir="$asset_dir" require --prefer-dist --no-interaction \
            --update-no-dev --classmap-authoritative --no-progress --with-all-dependencies \
            "${packages[@]}"
    fi
    for module in "${modules[@]}"; do
        php "$asset_dir/infbyte" module:config:publish "$module" --no-interaction
    done
    php "$asset_dir/infbyte" module:schema:sync --no-interaction

    manifest="$(php "$asset_dir/infbyte" module:list --json --no-interaction)"
    php -r '
        $modules = json_decode(stream_get_contents(STDIN), true, 512, JSON_THROW_ON_ERROR);
        $missing = [];
        foreach ($modules as $module) {
            if (is_array($module) && ($module["installed"] ?? false) !== true) {
                $missing[] = (string) ($module["name"] ?? "unknown");
            }
        }
        if ($missing !== []) {
            fwrite(STDERR, "InfByte modules not installed: " . implode(", ", $missing) . PHP_EOL);
            exit(1);
        }
    ' <<< "$manifest"
}

verify_webrick_version() {
    local metadata="$asset_dir/.benchmark-project-version"
    local installed_package
    local installed_version

    if [[ ! -f "$metadata" ]]; then
        printf 'Missing Webrick project-version metadata: %s\n' "$metadata" >&2
        exit 1
    fi

    installed_package="$(sed -n '1p' "$metadata")"
    installed_version="$(sed -n '2p' "$metadata")"
    installed_version="${installed_version#v}"

    if [[ "$installed_package" != 'infocyph/webrick' ]]; then
        printf 'Unexpected Webrick benchmark package: %s\n' "$installed_package" >&2
        exit 1
    fi

    case "$installed_version" in
        5.1|5.1.[0-9]*)
            case "$installed_version" in
                *-dev*|*alpha*|*beta*|*RC*)
                    printf 'Expected stable Webrick 5.1.x, installed: %s\n' "$installed_version" >&2
                    exit 1
                    ;;
            esac
            printf 'Webrick benchmark version: %s\n' "$installed_version"
            ;;
        *)
            printf 'Expected stable Webrick 5.1.x, installed: %s\n' "$installed_version" >&2
            exit 1
            ;;
    esac
}

verify_webrick_release() {
    local runtime_manifest="$asset_dir/.benchmark-release/release.php"

    if [[ ! -f "$runtime_manifest" ]]; then
        printf 'Missing Webrick runtime release manifest: %s\n' "$runtime_manifest" >&2
        exit 1
    fi

    php -r '
        $assetDirectory = $argv[1];
        require $assetDirectory . "/vendor/autoload.php";

        $release = (new Infocyph\Webrick\Router\Build\ReleaseManifestLoader())
            ->load($assetDirectory . "/.benchmark-release/release.json");
        if (($release["format"] ?? null) !== 2) {
            fwrite(STDERR, "Expected Webrick release manifest format 2\n");
            exit(1);
        }

        $intermix = $release["intermix"] ?? null;
        $webrick = $release["webrick"] ?? null;
        if (!is_array($intermix) || !is_array($webrick)) {
            fwrite(STDERR, "Missing InterMix/Webrick release metadata\n");
            exit(1);
        }
        if (array_key_exists("sha256", $intermix) || array_key_exists("sha256", $webrick)) {
            fwrite(STDERR, "Legacy SHA-256 release metadata detected\n");
            exit(1);
        }

        foreach (["InterMix" => $intermix, "Webrick" => $webrick] as $name => $artifact) {
            $path = $artifact["path"] ?? null;
            $digest = $artifact["digest"] ?? null;
            if (!is_string($path) || !is_file($path) || !is_string($digest)) {
                fwrite(STDERR, "Missing {$name} release artifact\n");
                exit(1);
            }
            $actual = hash_file("xxh128", $path);
            if (!is_string($actual) || !hash_equals($digest, $actual)) {
                fwrite(STDERR, "Invalid {$name} xxh128 artifact digest\n");
                exit(1);
            }
        }
    ' "$asset_dir"
}

rebuild_webrick_route_cache() {
    local matcher
    local cache

    case "$target" in
        webrick-sharded)
            matcher="sharded"
            cache="$asset_dir/.route-cache"
            ;;
        webrick-fused)
            matcher="fused"
            cache="$asset_dir/.route-cache/fused.php"
            ;;
        webrick-generated)
            matcher="generated"
            cache="$asset_dir/.route-cache/generated.php"
            ;;
        *)
            printf 'Cannot build a Webrick route cache for: %s\n' "$target" >&2
            exit 2
            ;;
    esac

    mkdir -p -- "$asset_dir/.route-cache"
    if [[ "$matcher" == 'sharded' ]]; then
        php "$asset_dir/webrick" route:clear \
            --matcher="$matcher" --cache="$cache" --aggressive=1
    else
        php "$asset_dir/webrick" route:clear \
            --matcher="$matcher" --cache="$cache"
    fi
    php "$asset_dir/webrick" route:cache \
        --matcher="$matcher" --cache="$cache" \
        --routes="$asset_dir/routes.php"
    php "$asset_dir/build-release.php"
    verify_webrick_release
    chmod -R a+rX "$asset_dir/.route-cache"
    chmod -R a+rX "$asset_dir/.benchmark-release"
}

rebuild_fast_route_cache() {
    php "$asset_dir/build-cache.php"
    chmod a+r "$asset_dir/.route-cache.php"
}

strip_fast_route_development_requirements() {
    php -r '
        $file = $argv[1];
        $manifest = json_decode(file_get_contents($file), true, 512, JSON_THROW_ON_ERROR);
        unset($manifest["require-dev"], $manifest["autoload-dev"]);
        file_put_contents(
            $file,
            json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR) . PHP_EOL,
        );
    ' "$asset_dir/composer.json"
    rm -f -- "$asset_dir/composer.lock"
}

strip_hyperf_installer() {
    php -r '
        $file = $argv[1];
        $manifest = json_decode(file_get_contents($file), true, 512, JSON_THROW_ON_ERROR);
        unset($manifest["require-dev"], $manifest["autoload-dev"]);
        unset($manifest["autoload"]["psr-4"]["Installer\\"]);
        foreach (["pre-install-cmd", "pre-update-cmd", "test", "cs-fix", "analyse"] as $script) {
            unset($manifest["scripts"][$script]);
        }
        $manifest["minimum-stability"] = "stable";
        file_put_contents(
            $file,
            json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR) . PHP_EOL,
        );
    ' "$asset_dir/composer.json"
    rm -rf -- "$asset_dir/installer" "$asset_dir/test" "$asset_dir/tests"
    rm -f -- "$asset_dir/composer.lock"
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
        hyperf)
            chmod a+r "$asset_dir/.env"
            mkdir -p -- "$asset_dir/runtime/container"
            chmod -R a+rwX "$asset_dir/runtime"
            ;;
        fast-route)
            rm -f -- "$asset_dir/public/.htaccess"
            ;;
        infbyte|infbyte-full)
            rm -f -- "$asset_dir/public/.htaccess"
            chmod a+r "$asset_dir/.env"
            chmod -R a+rwX "$asset_dir/bootstrap/cache" "$asset_dir/storage"
            ;;
        kumbia)
            sed -i "s|^[[:space:]]*//'routes' => '1',|        'routes' => '1',|" \
                "$asset_dir/default/app/config/config.php"
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
        webrick-sharded|webrick-fused|webrick-generated)
            rm -f -- "$asset_dir/public/.htaccess"
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
        fast-route)
            rebuild_fast_route_cache
            ;;
        infbyte|infbyte-full)
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
        hyperf)
            composer --working-dir="$asset_dir" dump-autoload --no-dev --classmap-authoritative --no-interaction
            ;;
        webrick-sharded|webrick-fused|webrick-generated)
            rebuild_webrick_route_cache
            ;;
        fatfree|flight|kumbia|leaf|nette|pure-php|slim|yii-basic)
            ;;
    esac
}

install_persistent_runtime_adapter() {
    case "$target" in
        infbyte|infbyte-full|webrick-sharded|webrick-fused|webrick-generated)
            composer --working-dir="$asset_dir" require \
                nyholm/psr7 spiral/roadrunner-http workerman/workerman \
                --prefer-dist --no-interaction --update-no-dev --classmap-authoritative \
                --no-progress --with-all-dependencies
            ;;
        laravel|laravel-api)
            composer --working-dir="$asset_dir" require laravel/octane spiral/roadrunner-http \
                --prefer-dist --no-interaction --update-no-dev --classmap-authoritative \
                --no-progress --with-all-dependencies --ignore-platform-req=ext-swoole
            ;;
        symfony)
            composer --working-dir="$asset_dir" require runtime/swoole \
                --prefer-dist --no-interaction --update-no-dev --classmap-authoritative \
                --no-progress --with-all-dependencies --ignore-platform-req=ext-swoole
            ;;
        *) : ;;
    esac
}

setup_project() {
    local project_package="${package%%:*}"
    local -a create_project_options=(
        --prefer-dist --no-cache --no-interaction
        --no-dev --remove-vcs --stability=stable
    )

    clean_generated
    mkdir -p -- "$asset_dir"

    if [[ -n "$package" ]]; then
        build_dir="$target_dir/.benchmark-create-project"
        project_version_log="$target_dir/.benchmark-create-project.log"
        if [[ "$target" == 'fast-route' ]]; then
            create_project_options+=(--no-install)
        fi
        if [[ "$target" == 'hyperf' ]]; then
            # The skeleton's interactive installer enables Redis/database by
            # default under --no-interaction. Keep the HTTP benchmark minimal.
            create_project_options+=(--no-scripts --ignore-platform-req=ext-swoole)
        fi
        composer create-project "${create_project_options[@]}" \
            "$package" "$build_dir" --no-ansi 2>&1 | tee "$project_version_log"

        project_version=""
        while IFS= read -r line; do
            case "$line" in
                *"Installing $project_package ("*")"*)
                    project_version="${line#*"Installing $project_package ("}"
                    project_version="${project_version%%)*}"
                    break
                    ;;
            esac
        done < "$project_version_log"
        if [[ -z "$project_version" ]]; then
            printf 'Unable to determine the stable release installed for %s\n' "$package" >&2
            exit 1
        fi

        rm -rf -- "$build_dir/_benchmark"
        cp -a "$build_dir/." "$asset_dir/"
        printf '%s\n%s\n' "$project_package" "$project_version" > "$asset_dir/.benchmark-project-version"
        rm -rf -- "$build_dir"
        rm -f -- "$project_version_log"
        build_dir=""
        project_version_log=""
    fi

    if [[ "$target" == 'fast-route' ]]; then
        strip_fast_route_development_requirements
    fi
    if [[ "$target" == 'hyperf' ]]; then
        strip_hyperf_installer
    fi

    if [[ "$target" == 'symfony' ]]; then
        composer --working-dir="$asset_dir" require --no-interaction \
            --update-no-dev --classmap-authoritative --no-progress \
            symfony/framework-bundle symfony/runtime symfony/yaml
    fi

    apply_overlay
    configure_production_environment
    install_persistent_runtime_adapter
    if [[ "$target" == 'infbyte-full' ]]; then
        install_all_infbyte_modules
    fi
    printf 'production\n' > "$suite_dir/.benchmark-profile"

    if [[ -f "$asset_dir/composer.json" ]]; then
        install_options=(
            --prefer-dist --no-interaction --no-dev
            --classmap-authoritative --no-progress --ansi
        )
        if [[ "$target" == 'hyperf' ]]; then
            install_options+=(--no-scripts --ignore-platform-req=ext-swoole)
        elif [[ "$target" == 'laravel' || "$target" == 'laravel-api' || "$target" == 'symfony' ]]; then
            install_options+=(--ignore-platform-req=ext-swoole)
        fi
        composer --working-dir="$asset_dir" install "${install_options[@]}"
    fi

    case "$target" in
        webrick-sharded|webrick-fused|webrick-generated) verify_webrick_version ;;
    esac

    prepare_runtime_directories
    optimize_production
}

clear_cache() {
    assert_target
    case "$target" in
        cakephp) php "$asset_dir/bin/cake.php" cache clear_all ;;
        codeigniter) clear_directory "$asset_dir/writable/cache" ;;
        fast-route) rebuild_fast_route_cache ;;
        infbyte|infbyte-full)
            php "$asset_dir/infbyte" optimize:clear
            php "$asset_dir/infbyte" optimize
            chmod -R a+rX "$asset_dir/bootstrap/cache"
            ;;
        kumbia) clear_directory "$asset_dir/default/app/tmp/cache" ;;
        laravel|laravel-api) php "$asset_dir/artisan" optimize:clear; php "$asset_dir/artisan" optimize ;;
        nette) clear_directory "$asset_dir/temp/cache" ;;
        slim) clear_directory "$asset_dir/var/cache" ;;
        symfony) APP_ENV=prod APP_DEBUG=0 php "$asset_dir/bin/console" cache:clear --no-debug ;;
        webrick-sharded|webrick-fused|webrick-generated) rebuild_webrick_route_cache ;;
        yii-basic) clear_directory "$asset_dir/runtime/cache" ;;
        flight) clear_directory "$asset_dir/app/cache" ;;
        hyperf) clear_directory "$asset_dir/runtime/container" ;;
        fatfree|leaf|pure-php) : ;;
    esac
}

case "$action" in
    setup|update) setup_project ;;
    clean) clean_generated ;;
    clear-cache) clear_cache ;;
    *) printf 'Unknown lifecycle action: %s\n' "$action" >&2; exit 2 ;;
esac
