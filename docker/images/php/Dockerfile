FROM php:7.4-fpm-alpine

# lumen packages
RUN set -ex \
    && apk --no-cache add postgresql-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install tokenizer pdo pdo_pgsql pdo_pgsql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version