#!/bin/sh

echo "Running wordpress-container's entrypoint file..."

# echo "Modifying user (hack for mac)..."
usermod -u 1000 www-data #a hack for macs

echo "Waiting for mysql-service..."
while ! mysqladmin ping -h"mysql-service" --silent; do
	echo "Still waiting for mysql-service..."
    sleep 1
done
echo "mysql-service is running..."

echo "Copying wordpress config file if it isn't already present...."
cp -n /var/www/html/docker/wordpress/wp-config.docker.php /var/www/html/wp-config.php

echo "Deleting existing apache pid if present..."
if [ -f "$APACHE_PID_FILE" ]; then
	rm "$APACHE_PID_FILE"
fi

echo "wordpress-container is ready!"
/usr/sbin/apache2ctl -D FOREGROUND