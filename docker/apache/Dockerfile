FROM php:8.4-apache

# Habilita módulos do Apache
RUN a2enmod rewrite

# Instala dependências e extensões PHP necessárias para Laravel
RUN apt-get update && apt-get install -y \
    zip unzip git curl libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql zip mbstring

# Instala Composer 2.8.3
RUN curl -sS https://getcomposer.org/download/2.8.3/composer.phar -o /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer

# Define o DocumentRoot para Laravel
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/000-default.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/sites-available/default-ssl.conf
