FROM dunglas/frankenphp:php8.5

RUN apt-get update \
    && apt-get install -y --no-install-recommends nginx \
    && install-php-extensions intl pcntl pdo_mysql sockets zip \
    && rm -rf /var/lib/apt/lists/*

RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && printf 'display_errors=Off\nlog_errors=On\nopcache.enable=1\nopcache.enable_cli=1\n' \
        > "$PHP_INI_DIR/conf.d/benchmark.ini"

ENV APP_ENV=production \
    APP_DEBUG=false \
    BENCHMARK_DRIVER=frankenphp \
    BENCHMARK_ENVIRONMENT=frankenphp-production

COPY .docker/persistent/nginx.conf /etc/nginx/nginx.conf
COPY .docker/frankenphp/Caddyfile /etc/frankenphp/benchmark.Caddyfile
COPY .docker/frankenphp/entrypoint.sh /usr/local/bin/benchmark-frankenphp
RUN chmod 0755 /usr/local/bin/benchmark-frankenphp

WORKDIR /app/frameworks
EXPOSE 9500
ENTRYPOINT []
CMD ["/usr/local/bin/benchmark-frankenphp"]
