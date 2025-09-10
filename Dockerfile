# Use the official Render PHP base image
FROM render/php:8.2-fpm-nginx

# Set the working directory in the container
WORKDIR /var/www/html

# Copy all application files into the container
COPY . .

# Install Composer dependencies
RUN composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader

# Set the correct permissions for storage and bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Expose port 80 for the Nginx web server
EXPOSE 80