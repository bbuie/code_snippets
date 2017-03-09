#!/bin/sh

echo "Running php-container's entrypoint file..."

echo "Modifying user (hack for mac)..."
# usermod -u 1000 www-data #a hack for macs

echo "Starting up mysql..."
/etc/init.d/mysql start

echo "updating sql_mode... (hack for Laravel)"
mysql -h bl-mysql-service -u root -p123 -se "SET GLOBAL sql_mode = 'ALLOW_INVALID_DATES';"

echo "Deleting existing apache pid if present..."
if [ -f "$APACHE_PID_FILE" ]; then
	rm "$APACHE_PID_FILE"
fi

echo "Bestline is ready!"
/usr/sbin/apache2ctl -D FOREGROUND