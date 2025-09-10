# Use the official, public PHP 8.2 FPM image on Alpine Linux (lightweight)
FROM php:8.2-fpm-alpine

# Set working directory
WORKDIR /var/www/html

# Install system dependencies needed for Laravel
# - nginx for the web server
# - postgresql-dev for connecting to the Render database
# - common libraries for image processing, zip, etc.
RUN apk add --no-cache \
    nginx \
    postgresql-dev \
    libzip-dev \
    zlib-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev

# Install the PHP extensions Laravel needs
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo pdo_pgsql zip gd

# Copy our custom Nginx configuration into the container
COPY nginx.conf /etc/nginx/http.d/default.conf

# Copy the start-up script into the container
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the application code
COPY . .

# Install Composer dependencies
RUN composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader

# Set correct permissions
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Expose port 80 for Nginx
EXPOSE 80

# The command to run when the container starts
CMD ["start.sh"]
