#!/bin/sh

echo "Running company-laravel-container's entrypoint file..."

echo "Modifying user (hack for mac)..."
usermod -u 1000 www-data #a hack for macs

echo "Copying wordpress config file if it isn't already present...."
cp -n /var/www/html/docker/company-laravel/.env.docker /var/www/html/.env

echo "Waiting for company-mysql-service..."
while ! mysqladmin ping -h"company-mysql-service" --silent; do
	echo "Waiting for company-mysql-service"
    sleep 1
done
echo "company-mysql-service is running..."

echo "Starting up mysql..."
/etc/init.d/mysql start

echo "updating sql_mode... (hack for Laravel)"
mysql -h company-mysql-service -u root -p123 -se "SET GLOBAL sql_mode = 'ALLOW_INVALID_DATES';"

echo "Deleting existing apache pid if present..."
if [ -f "$APACHE_PID_FILE" ]; then
	rm "$APACHE_PID_FILE"
fi

echo "company-laravel-container is ready!"
/usr/sbin/apache2ctl -D FOREGROUND