# Use the official, public PHP 8.2 FPM image on Alpine Linux (lightweight)
FROM php:8.2-fpm-alpine

# Set working directory
WORKDIR /var/www/html

# Install system dependencies needed for Laravel and Nginx
RUN apk add --no-cache \
    nginx \
    gettext \
    postgresql-dev \
    libzip-dev \
    zlib-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev

# Install the required PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo pdo_pgsql zip gd

# Copy the official Composer installer into our image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the entire application source code
COPY . .

# THIS IS THE FIX: Make the startup script executable
RUN chmod +x /var/www/html/start.sh

# Install Composer dependencies without dev packages
RUN composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader

# Set correct permissions on folders Laravel needs to write to
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Expose port 80 - This is metadata telling Docker the container will listen on this port
EXPOSE 80

# The command to run when the container starts. This hands control to our startup script.
CMD ["/var/www/html/start.sh"]
