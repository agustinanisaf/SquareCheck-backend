FROM php:7.4-fpm-alpine
# lumen packages
RUN set -ex \
    && apk --no-cache add postgresql-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install tokenizer pdo pdo_pgsql pgsql
# RUN apt-get update && apt-get install -y libpq-dev zip unzip \
#     && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
#     && docker-php-ext-install tokenizer pdo pdo_pgsql pgsql
# RUN docker-php-ext-install tokenizer pdo_pgsql pgsql
# memcached
# ENV MEMCACHED_DEPS zlib-dev libmemcached-dev cyrus-sasl-dev
# RUN apk add --no-cache --update libmemcached-libs zlib
# RUN set -xe \
#     && apk add --no-cache --update --virtual .phpize-deps $PHPIZE_DEPS \
#     && apk add --no-cache --update --virtual .memcached-deps $MEMCACHED_DEPS \
#     && pecl install memcached \
#     && echo "extension=memcached.so" > /usr/local/etc/php/conf.d/20_memcached.ini \
#     && rm -rf /usr/share/php7 \
#     && rm -rf /tmp/* \
#     && apk del .memcached-deps .phpize-deps

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version