FROM php:8.2-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    unzip curl libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy project
COPY . .

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl

# Install GD
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Baru install composer deps
RUN composer install --no-dev --optimize-autoloader

# Laravel setup
RUN php artisan key:generate
RUN php artisan config:cache

# Expose port
EXPOSE 10000

# Run server
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000