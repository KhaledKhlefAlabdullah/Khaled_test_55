FROM php:8.2-fpm-alpine

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN set -ex \
    	&& apk --no-cache add mysql-client nodejs yarn npm \
    	&& docker-php-ext-install pdo pdo_mysql

RUN apk --no-cache add mysql-client nodejs yarn npm


WORKDIR /var/www/html
