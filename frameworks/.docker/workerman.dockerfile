FROM php:8.5-cli

RUN apt-get update \
    && apt-get install -y --no-install-recommends libicu-dev libzip-dev nginx \
    && docker-php-ext-install intl pcntl pdo_mysql sockets zip \
    && rm -rf /var/lib/apt/lists/*

RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && printf 'display_errors=Off\nlog_errors=On\nopcache.enable_cli=1\n' \
        > "$PHP_INI_DIR/conf.d/benchmark.ini"

ENV APP_ENV=production \
    APP_DEBUG=false \
    BENCHMARK_DRIVER=workerman \
    BENCHMARK_ENVIRONMENT=workerman-production

COPY .docker/persistent/nginx.conf /etc/nginx/nginx.conf
COPY .docker/workerman/entrypoint.sh /usr/local/bin/benchmark-workerman
RUN chmod 0755 /usr/local/bin/benchmark-workerman

WORKDIR /app/frameworks
EXPOSE 9500
ENTRYPOINT []
CMD ["/usr/local/bin/benchmark-workerman"]
