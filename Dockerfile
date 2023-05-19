FROM php:7.4-fpm-alpine

RUN apk add --no-cache linux-headers  \
    && apk add --update --no-cache --virtual .build-dependencies $PHPIZE_DEPS \
    && pecl install xdebug-3.1.5 \
    && docker-php-ext-enable xdebug \
    && pecl clear-cache \
    && apk del .build-dependencies
