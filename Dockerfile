FROM php:8.2-apache

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install necessary dependencies using apt
RUN set -ex \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
        mysql-client \
        nodejs \
        yarn \
        npm \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html
