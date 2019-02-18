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
    nano \
    curl \
    cron \
    wget

# install servers and server specific linux packages
RUN apt-get update && apt-get install -yq \
	apache2 \
	redis-server \
	mysql-client

# add php specific linux packages
RUN apt-get update && apt-get install -yq \
    software-properties-common \
    python-software-properties

# add packages for version specific php
# RUN add-apt-repository ppa:ondrej/php
RUN apt-get update && LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php #this is a workaround noted here https://github.com/oerdnj/deb.sury.org/issues/56

# add other dependencies
RUN apt-get update && apt-get install -yq \
	php7.2 \
	php7.2-fpm \
	php7.2-common \
	php7.2-cli \
	php7.2-gd \
	php7.2-json \
	php7.2-memcached \
	php7.2-curl \
	php7.2-common \
	php7.2-intl \
	php7.2-mbstring \
	php7.2-mysql \
	php7.2-xml \
	php7.2-zip \
	php7.2-xmlrpc \
	php7.2-soap \
	libapache2-mod-php7.2

# add wp-cli
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
RUN chmod +x wp-cli.phar
RUN mv wp-cli.phar /usr/local/bin/wp

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
COPY ./docker/wordpress/default.000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# make changes to php ini file
RUN echo "file_uploads = On" >> /etc/php/7.2/apache2/php.ini
RUN echo "allow_url_fopen = On" >> /etc/php/7.2/apache2/php.ini
RUN echo "memory_limit = 256M" >> /etc/php/7.2/apache2/php.ini
RUN echo "upload_max_filesize = 100M" >> /etc/php/7.2/apache2/php.ini
RUN echo "max_execution_time = 360" >> /etc/php/7.2/apache2/php.ini
RUN echo "date.timezone = America/Denver" >> /etc/php/7.2/apache2/php.ini

# set work directory
WORKDIR /var/www/html

# add start file to new environment
COPY ./docker/wordpress/start.sh /var/www/docker/wordpress/start.sh
RUN sed -i 's/\r//' /var/www/docker/wordpress/start.sh # Modify the executable to have the linux line endings
RUN chmod u+x /var/www/docker/wordpress/start.sh # Give permissions to run executable
