FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    curl \
    git \
    vim \
    zip

WORKDIR /var/www

COPY . /var/www

RUN composer install

EXPOSE 81
