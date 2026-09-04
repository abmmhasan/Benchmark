FROM php:8.5-fpm

RUN apt-get update \
    && apt-get install -y --no-install-recommends git libicu-dev libzip-dev nginx unzip \
    && docker-php-ext-install intl pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && printf 'display_errors=Off\nlog_errors=On\nopcache.enable=1\n' \
        > "$PHP_INI_DIR/conf.d/benchmark.ini"

ENV BENCHMARK_ENVIRONMENT=fpm-production

COPY .docker/fpm/nginx.conf /etc/nginx/nginx.conf
COPY .docker/fpm/entrypoint.sh /usr/local/bin/benchmark-fpm
RUN chmod 0755 /usr/local/bin/benchmark-fpm

EXPOSE 8080
ENTRYPOINT []
CMD ["/usr/local/bin/benchmark-fpm"]
