# ---- Stage 1: Build front-end assets ----
FROM node:18-alpine AS vite_assets

WORKDIR /var/www/html
COPY package.json package-lock.json ./
RUN npm install
COPY . .
RUN npm run build


# ---- Stage 2: Build the final PHP application image ----
FROM php:8.2-fpm-alpine

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

# Install required PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo pdo_pgsql zip gd

# Copy the official Composer installer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application source code (without vendor/node_modules)
COPY . .

# Copy the custom PHP-FPM configuration
COPY www.conf /usr/local/etc/php-fpm.d/www.conf

# Copy the compiled front-end assets from the first stage
COPY --from=vite_assets /var/www/html/public/build /var/www/html/public/build

# Install Composer dependencies
RUN composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Create and make the start.sh script executable
RUN echo '#!/bin/sh' > /var/www/html/start.sh && \
    echo 'set -e' >> /var/www/html/start.sh && \
    echo "envsubst '\${PORT}' < /var/www/html/nginx.conf.template > /etc/nginx/nginx.conf" >> /var/www/html/start.sh && \
    echo 'php artisan config:cache' >> /var/www/html/start.sh && \
    echo 'php artisan route:cache' >> /var/www/html/start.sh && \
    echo 'php artisan view:cache' >> /var/www/html/start.sh && \
    echo 'php-fpm &' >> /var/www/html/start.sh && \
    echo "nginx -c /etc/nginx/nginx.conf -g 'daemon off;'" >> /var/www/html/start.sh
RUN chmod +x /var/www/html/start.sh

EXPOSE 80
CMD ["/var/www/html/start.sh"]
