#!/bin/sh

# Exit immediately if any command fails
set -e

# Create the final Nginx config in the correct directory for includes.
envsubst '${PORT}' < /var/www/html/nginx.conf.template > /etc/nginx/conf.d/default.conf

# Run Laravel's production optimizations.
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start PHP-FPM in the background
php-fpm &

# Start Nginx in the foreground using its default main config file.
# It will automatically include our default.conf.
nginx -g "daemon off;"
