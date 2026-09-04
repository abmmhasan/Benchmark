FROM php:8.5-cli

ARG TARGETARCH
ARG ROADRUNNER_VERSION=2025.1.15

RUN apt-get update \
    && apt-get install -y --no-install-recommends ca-certificates curl libicu-dev libzip-dev nginx \
    && docker-php-ext-install intl pcntl pdo_mysql sockets zip \
    && curl --fail --location --silent --show-error \
        "https://github.com/roadrunner-server/roadrunner/releases/download/v${ROADRUNNER_VERSION}/roadrunner-${ROADRUNNER_VERSION}-linux-${TARGETARCH}.tar.gz" \
        | tar -xz -C /usr/local/bin --strip-components=1 \
            "roadrunner-${ROADRUNNER_VERSION}-linux-${TARGETARCH}/rr" \
    && rm -rf /var/lib/apt/lists/*

RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && printf 'display_errors=Off\nlog_errors=On\nopcache.enable_cli=1\n' \
        > "$PHP_INI_DIR/conf.d/benchmark.ini"

ENV APP_ENV=production \
    APP_DEBUG=false \
    BENCHMARK_DRIVER=roadrunner \
    BENCHMARK_ENVIRONMENT=roadrunner-production

COPY .docker/persistent/nginx.conf /etc/nginx/nginx.conf
COPY .docker/roadrunner/entrypoint.sh /usr/local/bin/benchmark-roadrunner
RUN chmod 0755 /usr/local/bin/benchmark-roadrunner

WORKDIR /app/frameworks
EXPOSE 9500
ENTRYPOINT []
CMD ["/usr/local/bin/benchmark-roadrunner"]
