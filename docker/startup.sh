#!/bin/sh

sed -i "s,LISTEN_PORT,$PORT,g" /etc/nginx/nginx.conf

# Start PHP-FPM
php-fpm -D

# Wait for PHP-FPM to start
while ! nc -w 1 -z 127.0.0.1 9000; do sleep 0.1; done;

# Run database migrations
cd /app
php artisan migrate --force

# Start Nginx
nginx