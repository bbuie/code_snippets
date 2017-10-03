FROM ubuntu:14.04
MAINTAINER Buink Web Development <online@buink.biz>

# Set locale
RUN locale-gen en_US.UTF-8 \
  && export LANG=en_US.UTF-8

# update linux
RUN apt-get update

# add important linux tools
RUN apt-get update && apt-get install -yq \
	git-core \
	vim \
	curl \
	libssl-dev \
	acl \
	software-properties-common

# add packages for version specific php
RUN add-apt-repository ppa:ondrej/php

# add other dependencies
RUN apt-get update && apt-get install -yq --force-yes \
	mysql-client \
	apache2 \
	php5.6 \
	php5.6-mcrypt \
	php5.6-mbstring \
	php5.6-curl \
	php5.6-cli \
	php5.6-mysql \
	php5.6-gd \
	php5.6-intl \
	php5.6-xsl \
	php5.6-zip \
	ruby \
	ruby-dev \
	ruby-bundler

# Install composer and dependencies initial laravel dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY ./docker/laravel/composer.json /var/www/html/composer.json
RUN cd  /var/www/html/ && composer install --prefer-dist --no-scripts --no-interaction --no-autoloader

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

# add apache configs
COPY ./docker/laravel/apache.conf /etc/apache2/sites-available/000-default.conf

# set work directory
WORKDIR /var/www/html

# Install our projects dependencies
COPY ./composer.json /var/www/html/composer.json
COPY ./composer.lock /var/www/html/composer.lock
RUN composer install --prefer-dist --no-scripts --no-interaction --no-autoloader

# Add start file to new environment
COPY ./docker/laravel/start.sh /var/www/docker/laravel/start.sh
RUN sed -i 's/\r//' /var/www/docker/laravel/start.sh # Modify the executable to have the linux line endings
RUN chmod u+x /var/www/docker/laravel/start.sh # Give permissions to run executable


