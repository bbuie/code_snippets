FROM company-node-image
MAINTAINER Buink Web Development <online@buink.biz>

# Copies the local package.json file to the container
# and utilities docker container cache to not needing to rebuild
# and install node_modules/ everytime we build the docker, but only
# when the local package.json file changes.
# Install npm packages
WORKDIR /var/www/html/wp-content/themes/blankwp
ADD wp-content/themes/blankwp/package.json /var/www/html/wp-content/themes/blankwp/package.json
RUN npm install --quiet