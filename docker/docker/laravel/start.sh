#!/bin/sh

echo "Running laravel-container's entrypoint file..."

echo "Modifying user (hack for mac)..."
usermod -u 1000 www-data #a hack for macs

echo "Copying config file if it isn't already present...."
cp -n /var/www/html/docker/laravel/DEFAULT.env /var/www/html/.env

echo "Waiting for mysql-service..."
while ! mysqladmin ping -h"mysql-service" --silent; do
    echo "Waiting for mysql-service..."
    sleep 1
done
echo "mysql-service is running..."

echo "Build the autoload file..."
composer dump-autoload

echo "Installing oauth keys..."
php artisan passport:keys

echo "Running db migrations..."
php artisan --verbose migrate --seed

echo "Starting Cron"
/etc/init.d/cron start

echo "Starting redis-server..."
service redis-server start

echo "Deleting existing apache pid if present..."
if [ -f "$APACHE_PID_FILE" ]; then
    rm "$APACHE_PID_FILE"
fi

echo "Running PHPUnit..."
vendor/bin/phpunit

echo "Watching for php file changes..."
node docker/laravel/script.run-phpunit-on-changes.js &

echo "Starting queue listener..."
php artisan queue:work --tries=3 --timeout=80 &

echo "laravel-container is ready!"
/usr/sbin/apache2ctl -D FOREGROUND