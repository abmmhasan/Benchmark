FROM php:8.5-cli

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        $PHPIZE_DEPS curl git libcurl4-openssl-dev libicu-dev libonig-dev libzip-dev unzip \
    && docker-php-ext-install bcmath curl intl mbstring pcntl pdo_mysql sockets zip \
    && MAKEFLAGS="-j2" pecl install swoole \
    && docker-php-ext-enable swoole \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && printf 'display_errors=Off\nlog_errors=On\nopcache.enable_cli=0\n' \
        > "$PHP_INI_DIR/conf.d/benchmark.ini"

ENV APP_ENV=prod \
    SCAN_CACHEABLE=true \
    BENCHMARK_ENVIRONMENT=swoole-production

WORKDIR /app/frameworks/hyperf/asset

EXPOSE 9501

ENTRYPOINT []
CMD ["php", "bin/hyperf.php", "start"]
