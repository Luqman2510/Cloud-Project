#!/bin/sh

sed -i "s,LISTEN_PORT,$PORT,g" /etc/nginx/nginx.conf

# Start PHP-FPM
php-fpm -D

# Wait for PHP-FPM to start
while ! nc -w 1 -z 127.0.0.1 9000; do sleep 0.1; done;

# Initialize database
cd /app

# Create database directory if it doesn't exist
mkdir -p /app/database

# Create SQLite database file if it doesn't exist
touch /app/database/database.sqlite

# Set proper permissions
chmod 664 /app/database/database.sqlite
chmod 775 /app/database

# Run database migrations
php artisan migrate --force

# Run database seeder (optional, with error handling)
php artisan db:seed --force || echo "Seeding failed or already completed"

# Start Nginx
nginx