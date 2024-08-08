FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
                                       zlib1g-dev \
                                       libicu-dev g++ \
                                       vim \
                                       libfreetype6-dev \
                                       libjpeg62-turbo-dev \
                                       libmcrypt-dev \
                                       libpng-dev \
                                       zlib1g-dev \
                                       libxml2-dev \
                                       libzip-dev \
                                       libonig-dev \
                                       graphviz \
                                       libcurl4-openssl-dev \
                                       pkg-config \
                                       libpq-dev\
                                       libyaml-dev \
&& docker-php-ext-install pdo pdo_mysql \
&& apt install -y libmagickwand-dev --no-install-recommends \
&& pecl install imagick \
&& docker-php-ext-enable imagick \
&& docker-php-ext-configure gd --with-freetype --with-jpeg \
&& docker-php-ext-install -j$(nproc) gd \
&& docker-php-ext-install exif \
&& docker-php-ext-install zip

RUN docker-php-ext-configure pcntl --enable-pcntl \
  && docker-php-ext-install \
    pcntl

RUN  pecl install yaml && docker-php-ext-enable yaml

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/app

