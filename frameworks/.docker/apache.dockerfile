FROM php:8.5-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends git libicu-dev unzip \
    && docker-php-ext-install intl opcache \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

RUN a2enmod rewrite

ENV PORT=80
ENTRYPOINT []
CMD sed -i "s/80/${PORT}/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf \
    && docker-php-entrypoint apache2-foreground
