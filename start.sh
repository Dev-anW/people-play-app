#!/bin/sh

# Exit immediately if any command fails
set -e

# Create the final, complete Nginx configuration file from our template
envsubst '${PORT}' < /var/www/html/nginx.conf.template > /etc/nginx/nginx.conf

# Run Laravel's production optimizations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start PHP-FPM in the background
php-fpm &

# Start Nginx in the foreground, explicitly using our new complete configuration file
nginx -c /etc/nginx/nginx.conf -g 'daemon off;'```

### 3. Deploy the Fix

Here are the commands to deploy.

```bash
git add nginx.conf.template start.sh
git commit -m "FIX: Provide full Nginx configuration to resolve context error"
git push origin main
