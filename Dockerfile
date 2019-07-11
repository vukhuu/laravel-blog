FROM php:7.2

RUN mkdir /code
WORKDIR /code

RUN apt-get update

# Install some dependencies
RUN apt-get update && apt-get install -y \
    mysql-client \
    locales \
    zip \
    vim \
    unzip \
    curl \
    dnsutils \
    zlib1g-dev \
    libzip-dev \
    procps \
    libcurl4-openssl-dev pkg-config libssl-dev

RUN echo 'extension=mongodb.so' >> /usr/local/etc/php/conf.d/docker-php-ext-exif.ini

RUN pecl install mongodb

# Install packages required by Laravel
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl


# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

# Make "laravel" command globally available for current user
RUN ln -s ~/.composer/vendor/bin/laravel /usr/local/bin/laravel

# Install Laravel
RUN composer global require laravel/installer

EXPOSE 8000
