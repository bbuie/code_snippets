FROM ubuntu:16.04
MAINTAINER Buink Web Development <online@buink.biz>

# set ubuntu front-end for remote work
ENV DEBIAN_FRONTEND noninteractive

# use Google's Public DNS to resolve dns lookups: bug fix for "Failed to fetch...archive.ubuntu.com...404 Bad Request"
RUN echo nameserver 8.8.8.8 > /etc/resolv.conf
RUN echo nameserver 8.8.8.4 > /etc/resolv.conf

# set locale
RUN apt-get update && apt-get install -yq locales
RUN locale-gen en_US.UTF-8 \
    && export LANG=en_US.UTF-8

# add foundational linux packages
RUN apt-get update && apt-get install -yq \
	git-core \
	vim \
	curl \
	wget

# install servers and server specific linux packages
RUN apt-get update && apt-get install -yq \
	apache2 \
	redis-server \
	mysql-client

# add php specific linux packages
RUN apt-get update && apt-get install -yq \
    software-properties-common

# add packages for version specific php
# RUN add-apt-repository ppa:ondrej/php
RUN apt-get update && LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php #this is a workaround noted here https://github.com/oerdnj/deb.sury.org/issues/56

# install linux packages for php 7.1
RUN apt-get update && apt-get install -yq \
	php7.1 \
	php7.1-mcrypt \
	php7.1-xml \
	php7.1-gd \
	php7.1-opcache \
	php7.1-mbstring \
	php7.1-mysql \
	libapache2-mod-php7.1

# instal linux packages required by composer
RUN apt-get update && apt-get install -yq \
	zip \
	unzip \
	php-zip

# install composer initial laravel dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY ./docker/laravel/composer.json /var/www/html/composer.json
RUN cd /var/www/html/ && composer install --prefer-dist --no-scripts --no-interaction --no-autoloader

# setup apache
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid
ENV APACHE_RUN_DIR /var/run/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
RUN ln -sf /dev/stdout /var/log/apache2/access.log && \
    ln -sf /dev/stderr /var/log/apache2/error.log
RUN mkdir -p $APACHE_RUN_DIR $APACHE_LOCK_DIR $APACHE_LOG_DIR
COPY ./docker/laravel/apache.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# set work directory
WORKDIR /var/www/html

# install composer packages
COPY ./composer.json /var/www/html/composer.json
COPY ./composer.lock /var/www/html/composer.lock
RUN composer install --prefer-dist --no-scripts --no-interaction --no-autoloader

# add start file to new environment
COPY ./docker/laravel/start.sh /var/www/docker/laravel/start.sh
RUN sed -i 's/\r//' /var/www/docker/laravel/start.sh # Modify the executable to have the linux line endings
RUN chmod u+x /var/www/docker/laravel/start.sh # Give permissions to run executable

# cleanup machine
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
