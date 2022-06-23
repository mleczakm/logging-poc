FROM php:8.1-cli-alpine as php-base

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /var/www/.composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apk add --update icu libpq && \
    apk add --no-cache --virtual .build-deps $PHPIZE_DEPS icu-dev libpq-dev curl && \
    docker-php-ext-configure intl && \
    docker-php-ext-install opcache intl pdo_pgsql && \
    pecl install ds inotify openswoole && \
    docker-php-ext-enable ds inotify openswoole && \
    cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini && \
    apk del .build-deps && \
    rm -Rf /tmp/*

CMD php -e /var/www/html/public/index.php

WORKDIR /var/www/html

#COPY composer.json composer.lock symfony.lock ./
#
#RUN composer install --no-dev --no-progress -anq --no-scripts

FROM php-base AS php-prod

EXPOSE 80

COPY config ./config
COPY src ./src
COPY bin ./bin
COPY .env ./

RUN composer install --no-dev --no-progress -anq && \
    composer dump-env prod

ARG APP_VERSION
ENV APP_VERSION=$APP_VERSION

FROM php-base AS php-dev-base

EXPOSE 8080

RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS && \
    pecl install pcov xdebug && \
    docker-php-ext-enable pcov xdebug && \
    apk del .build-deps && \
    rm -rf /tmp/*

FROM php-dev-base AS php-dev

COPY config ./config
COPY public ./public
COPY src ./src
COPY tests ./tests
COPY bin ./bin
COPY .env  ./

RUN echo "APP_ENV=dev" > .env.local && composer install --no-progress -anq && composer dump-env prod
