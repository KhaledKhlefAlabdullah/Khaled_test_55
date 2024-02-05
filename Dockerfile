FROM php:8.2-fpm

# Install required packages
RUN apt-get update && apt-get install -y \
    curl \
    git \
    vim \
    zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html/satreps

# Copy application files
COPY . /var/www/html/satreps

# Install PHP dependencies
RUN composer install

# Expose the port
EXPOSE 81
