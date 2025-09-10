#!/bin/sh

# Exit immediately if any command fails
set -e

# Substitute the ${PORT} variable in the Nginx template with the real port
# provided by Render and create the final config file.
envsubst '${PORT}' < /var/www/html/nginx.conf.template > /etc/nginx/nginx.conf

# Run Laravel's production optimizations.
# THIS IS THE CORRECT PLACE for these commands because the real
# production environment variables (from Render's dashboard) are now available.
echo "Caching Laravel configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting services..."
# Start PHP-FPM in the background
php-fpm &

# Start Nginx in the foreground. This keeps the container running.
# We point it to our newly created config file.
nginx -c /etc/nginx/nginx.conf -g "daemon off;"
