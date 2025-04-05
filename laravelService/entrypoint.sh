#!/bin/sh

# Set correct permissions for Laravel storage and cache
chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

# Clear and cache Laravel configurations
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan key:generate

#start file watcher
./watch.sh &

# Start the Laravel service
exec "$@"
