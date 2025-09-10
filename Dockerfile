# Use the official, public PHP 8.2 FPM image on Alpine Linux (lightweight)
FROM php:8.2-fpm-alpine

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
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

# Copy the official Composer installer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the application source code and Nginx template
COPY . .

# Install Composer dependencies
RUN composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Create the start.sh script inside the container to avoid formatting issues.
# This script creates a complete, standalone nginx.conf from our template.
RUN echo '#!/bin/sh' > /var/www/html/start.sh && \
    echo 'set -e' >> /var/www/html/start.sh && \
    echo "envsubst '\${PORT}' < /var/www/html/nginx.conf.template > /etc/nginx/nginx.conf" >> /var/www/html/start.sh && \
    echo 'php artisan config:cache' >> /var/www/html/start.sh && \
    echo 'php artisan route:cache' >> /var/www/html/start.sh && \
    echo 'php artisan view:cache' >> /var/www/html/start.sh && \
    echo 'php-fpm &' >> /var/www/html/start.sh && \
    echo "nginx -c /etc/nginx/nginx.conf -g 'daemon off;'" >> /var/www/html/start.sh

# Make the newly created script executable
RUN chmod +x /var/www/html/start.sh

# Expose port 80
EXPOSE 80

# The command to run when the container starts
CMD ["/var/www/html/start.sh"]
