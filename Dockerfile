FROM ubuntu:latest
# Use the official PHP 8.0 image
FROM php:8.0-apache
LABEL authors="Muhmad Omar"

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory contents
COPY. /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl mysqli

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set environment variables
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
ENV PHP_MEMORY_LIMIT 512M

# Add docker custom commands
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Expose port 80
EXPOSE 80

# Start apache
CMD ["apache2-foreground"]
ENTRYPOINT ["top", "-b"]
