FROM php:8.2-apache

WORKDIR /var/www/html/satreps

# Copy your Apache2 configuration file
COPY apache2/default.conf /etc/apache2/sites-available/000-default.conf

# Enable necessary Apache modules
RUN a2enmod rewrite
RUN a2enmod headers

# Copy your PHP application files
COPY src .

# Set up permissions (adjust as needed)
RUN chown -R www-data:www-data /var/www/html/satreps

# Start Apache in the foreground
CMD ["apache2-foreground"]
