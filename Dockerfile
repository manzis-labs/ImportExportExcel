
    FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        zip \
        gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy semua file project
COPY . .

# Install dependency Laravel
RUN composer install --no-dev --optimize-autoloader

# Setup Laravel
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

RUN npm install
RUN npm run build
# RUN php artisan key:generate
# RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Storage link (penting untuk file upload)
RUN php artisan storage:link || true

# Expose port Render
EXPOSE 10000

# Run Laravel + migrate otomatis
CMD php artisan migrate --force && \
    php -S 0.0.0.0:10000 -t public