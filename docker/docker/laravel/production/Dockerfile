FROM company-node-production-image

# Add start file to new environment
COPY ./docker/laravel/production/start.sh /var/www/docker/laravel/production/start.sh
RUN sed -i 's/\r//' /var/www/docker/laravel/production/start.sh # Modify the executable to have the linux line endings
RUN chmod u+x /var/www/docker/laravel/production/start.sh # Give permissions to run executable

RUN composer dump-autoload

COPY . /var/www/html