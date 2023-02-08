FROM php:8.1-fpm-alpine as app

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin

# RUN docker-php-ext-install pdo pdo_mysql оставляем на всякий случай
RUN set -eux: \
    install-php-extensions pdo mysql;

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer

COPY ./app/composer.* ./

RUN composer install --prefer-dist --no-dev --no-scripts --no-progress --no-interaction

COPY ./app .

RUN composer dump-autoload  --optimize

FROM app as app_dev

ENV XDEBUG_MODE=off

COPY ./php/conf.d/xdebug.ini /usr/local/php/conf.d/xdebug.ini

RUN set -eux; \
    install-php-extensions xdebug