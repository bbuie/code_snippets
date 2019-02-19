FROM company-node-image

# add start file to new environment
COPY ./docker/ios/start.sh /var/www/docker/ios/start.sh

# Modify the executable to have the linux line endings
RUN sed -i 's/\r//' /var/www/docker/ios/start.sh

# Give permissions to run executable
RUN chmod u+x /var/www/docker/ios/start.sh