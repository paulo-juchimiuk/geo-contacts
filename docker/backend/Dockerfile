FROM php:8.3-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql

RUN addgroup -g 1000 app && adduser -D -G app -u 1000 app

USER app

WORKDIR /var/www
