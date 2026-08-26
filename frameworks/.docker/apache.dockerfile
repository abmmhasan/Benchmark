FROM php:8.5-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git libicu-dev libzip-dev unzip \
    && docker-php-ext-install intl pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

RUN a2enmod rewrite \
    && printf 'ServerName 127.0.0.1\n' > /etc/apache2/conf-available/benchmark.conf \
    && a2enconf benchmark \
    && cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && printf 'display_errors=Off\nlog_errors=On\nopcache.enable=1\n' \
        > "$PHP_INI_DIR/conf.d/benchmark.ini"

ENTRYPOINT []
CMD ["apache2-foreground"]
