FROM php:8.1-fpm-alpine

# Install system dependencies
RUN apk add --no-cache nginx wget netcat-openbsd sqlite sqlite-dev

# Install PHP extensions needed for Laravel
RUN docker-php-ext-install pdo pdo_mysql pdo_sqlite

RUN mkdir -p /run/nginx

COPY docker/nginx.conf /etc/nginx/nginx.conf

RUN mkdir -p /app
COPY . /app

# Create production environment file
RUN echo 'APP_NAME="Laravel Event Project"' > /app/.env && \
    echo 'APP_ENV=production' >> /app/.env && \
    echo 'APP_KEY=base64:AANP2bxq/L1XCkyuJY01qW2Z7bHhfgMU6CzBUjFCoGs=' >> /app/.env && \
    echo 'APP_DEBUG=false' >> /app/.env && \
    echo 'APP_URL=https://laravel-events-972131782399.us-central1.run.app' >> /app/.env && \
    echo 'LOG_CHANNEL=stderr' >> /app/.env && \
    echo 'DB_CONNECTION=sqlite' >> /app/.env && \
    echo 'DB_DATABASE=/app/database/database.sqlite' >> /app/.env && \
    echo 'CACHE_DRIVER=file' >> /app/.env && \
    echo 'QUEUE_CONNECTION=sync' >> /app/.env && \
    echo 'SESSION_DRIVER=file' >> /app/.env && \
    echo 'SESSION_LIFETIME=120' >> /app/.env && \
    echo 'MAIL_MAILER=log' >> /app/.env

# Install Composer
RUN sh -c "wget http://getcomposer.org/composer.phar && chmod a+x composer.phar && mv composer.phar /usr/local/bin/composer"

# Install PHP dependencies
RUN cd /app && \
    /usr/local/bin/composer install --no-dev --optimize-autoloader

# Laravel optimizations
RUN cd /app && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Create SQLite database directory and file
RUN mkdir -p /app/database && \
    touch /app/database/database.sqlite

# Create storage directories and set permissions
RUN mkdir -p /app/storage/logs /app/storage/framework/cache /app/storage/framework/sessions /app/storage/framework/views /app/bootstrap/cache

# Set permissions
RUN chown -R www-data: /app && \
    chmod -R 775 /app/storage /app/bootstrap/cache /app/database

# Expose port (Cloud Run uses PORT environment variable)
EXPOSE 8080

CMD sh /app/docker/startup.sh