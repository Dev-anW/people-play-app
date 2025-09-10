#!/bin/sh

# Use envsubst to replace the ${PORT} variable in the template
# and create the final nginx configuration file.
envsubst < /etc/nginx/http.d/nginx.conf.template > /etc/nginx/http.d/default.conf

# Start PHP-FPM in the background
php-fpm &

# Start Nginx in the foreground
nginx -g "daemon off;"
