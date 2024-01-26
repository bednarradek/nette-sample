FROM php:8.2-apache

# setup apache document folder in env
ENV APACHE_DOCUMENT_ROOT /var/www/html/www

# setting up apache document folder
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# install system libs
RUN apt-get update -y && \
    apt-get install -y \
    zip \
    unzip \
    libfreetype-dev \
    libjpeg62-turbo-dev \
    libpng-dev

# install php extensions
RUN docker-php-ext-install \
    mysqli \
    pdo \
    pdo_mysql

# enable apache mod_rewrite
RUN a2enmod rewrite

# change user
USER www-data

# setup workdir
WORKDIR /var/www/html

# copy composer files
COPY composer* .

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN composer install

# copy all files
COPY . .


