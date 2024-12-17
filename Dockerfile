FROM ubuntu:20.04

ENV DEBIAN_FRONTEND=noninteractive


RUN apt-get update && apt-get install -y \
    apache2 \
    libapache2-mod-php \
    php-cli \
    php-json \
    php-mbstring \
    php-xml \
    php-curl \
    php-dev \
    php-pear \
    curl \
    git \
    zip \
    unzip \
    libssl-dev \
    && apt-get clean

RUN a2enmod php7.4


RUN pecl install mongodb && \
    echo "extension=mongodb.so" > /etc/php/7.4/cli/conf.d/20-mongodb.ini && \
    echo "extension=mongodb.so" > /etc/php/7.4/apache2/conf.d/20-mongodb.ini


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


WORKDIR /var/www/html


COPY index.php /var/www/html/index.php

RUN composer require mongodb/mongodb


RUN echo "DirectoryIndex index.php index.html" > /etc/apache2/mods-enabled/dir.conf


EXPOSE 80

CMD ["apachectl", "-D", "FOREGROUND"]
