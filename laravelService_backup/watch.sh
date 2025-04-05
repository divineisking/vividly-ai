#!/bin/sh

echo "watching for file changes..."
inotifywait -m -r -e modify /var/www/html | 
while read path action file; do 
    echo "file changed: $file, restarting Laravel..."
    pkill -f "php artisan serve"
    php artisan serve --host=0.0.0.0 --port=8000 &
done