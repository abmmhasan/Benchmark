FROM php:8.5-cli

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        $PHPIZE_DEPS curl git libcurl4-openssl-dev libicu-dev libonig-dev libzip-dev nginx unzip \
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

COPY .docker/swoole/nginx.conf /etc/nginx/nginx.conf
COPY .docker/swoole/entrypoint.sh /usr/local/bin/benchmark-swoole

RUN chmod 0755 /usr/local/bin/benchmark-swoole

WORKDIR /app/frameworks

EXPOSE 9500

ENTRYPOINT []
CMD ["/usr/local/bin/benchmark-swoole"]
