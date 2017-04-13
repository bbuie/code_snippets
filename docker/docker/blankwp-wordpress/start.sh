#!/bin/sh

echo "Running company-wordpress-container's entrypoint file..."

# echo "Modifying user (hack for mac)..."
# usermod -u 1000 www-data #a hack for macs

echo "Waiting for company-mysql-service..."
while ! mysqladmin ping -h"company-mysql-service" --silent; do
	echo "Still waiting for company-mysql-service..."
    sleep 1
done
echo "company-mysql-service is running..."

echo "Copying wordpress config file if it isn't already present...."
cp -n /var/www/html/docker/company-wordpress/wp-config.docker.php /var/www/html/wp-config.php

echo "Deleting existing apache pid if present..."
if [ -f "$APACHE_PID_FILE" ]; then
	rm "$APACHE_PID_FILE"
fi

echo "company-wordpress-container is ready!"
/usr/sbin/apache2ctl -D FOREGROUND