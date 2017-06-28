FROM ubuntu:14.04
MAINTAINER Buink Web Development <online@buink.biz>

# Set locale
RUN locale-gen en_US.UTF-8 \
  && export LANG=en_US.UTF-8

# add other dependencies
RUN apt-get update && apt-get install -yq \
	apache2 \
	mysql-server \
	php5 \
	php5-cli \
	php5-mcrypt \
	php5-gd \
	php5-json \
	php5-memcached \
	php5-curl \
	php5-sqlite \
	php5-dev \
	php5-intl \
	php5-mysqlnd \
	php-apc \
	php-pear \
	ruby \
	ruby-dev \
	ruby-bundler \
	libapache2-mod-php5 \
	libssl-dev \
	curl \
	git-core \
	acl \
	vim

RUN php5enmod mcrypt
RUN a2enmod rewrite

# add apache configs
COPY ./docker/company-wordpress/apache.conf /etc/apache2/sites-available/000-default.conf

# Install composer
RUN curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer

# Install compass
RUN gem install --no-rdoc --no-ri compass

# Install gem sass for grunt-contrib-sass
# RUN apt-get install -y ruby
RUN gem install sass

# Install NodeJS
RUN curl -sL https://deb.nodesource.com/setup_4.x | sudo -E bash -
RUN sudo apt-get install -yq nodejs

# Install Helpful Node Packages
RUN npm install --quiet -g gulp bower jshint

# Copies the local package.json file to the container
# and utilities docker container cache to not needing to rebuild
# and install node_modules/ everytime we build the docker, but only
# when the local package.json file changes.
# Install npm packages
WORKDIR /var/www/html/wp-content/themes/company
ADD wp-content/themes/company/package.json /var/www/html/wp-content/themes/company/package.json
RUN npm install --quiet
WORKDIR /var/www/html

# set apache variables
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid
ENV APACHE_RUN_DIR /var/run/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
RUN ln -sf /dev/stdout /var/log/apache2/access.log && \
    ln -sf /dev/stderr /var/log/apache2/error.log
RUN mkdir -p $APACHE_RUN_DIR $APACHE_LOCK_DIR $APACHE_LOG_DIR

# Add start file to new environment
COPY ./docker/company-wordpress/start.sh /var/www/docker/company-wordpress/start.sh

# Modify the executable to have the linux line endings
RUN sed -i 's/\r//' /var/www/docker/company-wordpress/start.sh

# Give permissions to run executable
RUN chmod u+x /var/www/docker/company-wordpress/start.sh

# Port 3000 for browsersync
EXPOSE 3000:3000
