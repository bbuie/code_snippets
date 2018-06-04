#!/bin/sh

echo "Running laravel-container's entrypoint file..."

echo "Modifying user (hack for mac)..."
usermod -u 1000 www-data #a hack for macs

echo "Copying config file if it isn't already present...."
cp -n /var/www/html/docker/laravel/.env.docker /var/www/html/.env

echo "Waiting for mysql-service..."
while ! mysqladmin ping -h"mysql-service" --silent; do
    echo "Waiting for mysql-service"
    sleep 1
done
echo "mysql-service is running..."

echo "Deleting existing apache pid if present..."
if [ -f "$APACHE_PID_FILE" ]; then
    rm "$APACHE_PID_FILE"
fi

echo "Build the autoload file..."
composer dump-autoload

echo "Installing oauth keys..."
php artisan passport:keys

echo "Running db migrations..."
php artisan --verbose migrate --seed

echo "laravel-container is ready!"
php artisan serve --host=0.0.0.0 --port=80