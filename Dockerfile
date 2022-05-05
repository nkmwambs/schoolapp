FROM php:7.4-apache
WORKDIR /var/www/html

RUN ["apt-get", "update"]
RUN ["apt-get", "-y", "install", "nano"]

RUN ["docker-php-ext-install", "mysqli"]
RUN ["docker-php-ext-enable", "mysqli"]
RUN ["docker-php-ext-install", "pdo"]
RUN ["docker-php-ext-install", "pdo_mysql"]

RUN ["chown", "-R", "www-data:www-data", "../"]

RUN a2enmod rewrite && \
    a2dissite 000-default && \
    service apache2 restart

EXPOSE 80
