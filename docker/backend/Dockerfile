FROM php:8.3-fpm-alpine

RUN apk add --no-cache bash git unzip curl

RUN apk add --no-cache bash git unzip curl \
    && docker-php-ext-install pdo pdo_mysql

COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

COPY ./docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

RUN addgroup -g 1000 app && adduser -D -G app -u 1000 app

USER app

WORKDIR /var/www

ENTRYPOINT ["/entrypoint.sh"]
