FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    unzip curl zip git \
    libpq-dev libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_pgsql zip gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader

# Node build (aman)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

RUN npm install
RUN npm run build

EXPOSE 10000

CMD php artisan config:clear && \
    php artisan cache:clear && \
    php artisan migrate --force && \
    php -S 0.0.0.0:10000 -t public