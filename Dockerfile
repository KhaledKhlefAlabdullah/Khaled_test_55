FROM php:8.2-apache
LABEL authors="SMA Group"

COPY ./src/000-default.conf /etc/apache2/sites-available/000-default.conf


ENTRYPOINT ["top", "-b"]
