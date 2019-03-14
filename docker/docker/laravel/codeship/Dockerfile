FROM company-laravel-image

# Add start file to new environment
COPY ./docker/laravel/codeship/start.sh /var/www/docker/laravel/codeship/start.sh
RUN sed -i 's/\r//' /var/www/docker/laravel/codeship/start.sh # Modify the executable to have the linux line endings
RUN chmod u+x /var/www/docker/laravel/codeship/start.sh # Give permissions to run executable