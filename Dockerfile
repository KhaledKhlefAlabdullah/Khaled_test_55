FROM quay.io/vesica/php:latest
LABEL authors="SMA Group"



# Copy files
RUN cd ../ && rm -rf /var/www/html
COPY . /var/www/
COPY /etc/apache2/mods-enabled/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf

# Run Composer
RUN cd /var/www && composer install --no-dev

ENV LOAD_BALANCER_KEY "LB_KEY"

# 0 = false, 1 = true
ENV LOAD_BALANCER_MODE "0"


ENTRYPOINT ["top", "-b"]
