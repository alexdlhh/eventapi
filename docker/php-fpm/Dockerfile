FROM php:7.4-fpm

# Arguments defined in docker-compose.yml
#ARG user
#ARG uid

RUN apt-get update

# Some basic extensions
RUN apt-get -y install git
RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-install zip
RUN docker-php-ext-install pdo_mysql
# Curl
RUN apt-get install -y libcurl4-openssl-dev
RUN docker-php-ext-install -j$(nproc) curl

# GD
RUN apt-get install -y libpng-dev libjpeg-dev
RUN docker-php-ext-install -j$(nproc) gd

# Intl
RUN apt-get install -y libicu-dev
RUN docker-php-ext-install -j$(nproc) intl

# memcached
RUN apt-get update \
    && apt-get install -y libmemcached-dev zlib1g-dev \
    && pecl install memcached-3.2.0 \
    && docker-php-ext-enable memcached

# Install PHP extensions
RUN docker-php-ext-install pcntl bcmath gd

RUN cd /usr/local/etc/php/conf.d/ && \
  echo 'memory_limit = -1' >> /usr/local/etc/php/conf.d/docker-php-ram-limit.ini

# Get latest Composer
COPY --from=composer:2.0.8 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/events

