#!/bin/sh

echo "Running dym-codeship-laravel-container's entrypoint file..."

echo "Waiting for mysql-service..."
while ! mysqladmin ping -h"mysql-service" --silent; do
    echo "Waiting for mysql-service"
    sleep 1
done
echo "mysql-service is running..."

echo "Build the autoload file..."
composer dump-autoload

echo "Copying config file if it isn't already present...."
cp -n /var/www/html/docker/laravel/DEFAULT.env /var/www/html/.env

echo "Run migrations"
php artisan migrate --force

echo "Generate encryption key"
php artisan key:generate

echo "Run PHPUnit"
vendor/bin/phpunit