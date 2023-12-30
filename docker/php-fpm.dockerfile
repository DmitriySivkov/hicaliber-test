FROM php:8.2-fpm

ARG PROJECT_NAME=PROJECT_NAME
# Set working directory
WORKDIR /var/www/$PROJECT_NAME

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libgmp-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle webp \
    vim \
    unzip \
    git \
    curl \
    default-mysql-client

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

#GD package setup
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd

# Install extensions
RUN docker-php-ext-install pdo_mysql zip exif pcntl bcmath gmp sockets

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
#RUN groupadd -g 1000 www
#RUN useradd -u 1000 -ms /bin/bash -g www www