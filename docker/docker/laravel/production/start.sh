#!/bin/sh

echo "Running laravel-container's entrypoint file..."

echo "Deleting existing apache pid if present..."
if [ -f "$APACHE_PID_FILE" ]; then
    rm "$APACHE_PID_FILE"
fi

echo "Adding Oauth Keys For Laravel..."
echo $OAUTH_PUBLIC_KEY > /var/www/html/storage/oauth-public.key
sed -i 's/\r /\n/g' /var/www/html/storage/oauth-public.key
echo $OAUTH_PRIVATE_KEY > /var/www/html/storage/oauth-private.key
sed -i 's/\r /\n/g' /var/www/html/storage/oauth-private.key
echo "Keys added."

echo "Build the autoload file..."
composer dump-autoload
echo "autoload dumped."

echo "Running db migrations..."
php artisan --verbose migrate --force
echo "Migrations done."

echo "Starting queue listener..."
php artisan queue:work --tries=3 &

echo "laravel-container is ready!"
php artisan serve --host=0.0.0.0 --port=80