# Use the official PHP 8.2 FPM image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libpq-dev \
    libzip-dev \
    zip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    bash \
    && docker-php-ext-install pdo pdo_pgsql zip mbstring exif pcntl bcmath

# Install Composer (copy from official composer image)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Install PHP dependencies with Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Fix permissions for Laravel storage and cache directories
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www \
    && mkdir -p storage/logs \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Copy startup script
COPY start.sh /start.sh
RUN chmod +x /start.sh

# Expose Laravel dev server port
EXPOSE 8000

# Run startup script to wait for DB, migrate, and serve
CMD ["/start.sh"]
