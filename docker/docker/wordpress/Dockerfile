FROM ubuntu:14.04
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
    libssl-dev

# add other dependencies
RUN apt-get update && apt-get install -yq \
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
	libapache2-mod-php5

# Setup php dependencies
RUN php5enmod mcrypt

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
COPY ./docker/wordpress/apache.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# set work directory
WORKDIR /var/www/html

# add start file to new environment
COPY ./docker/wordpress/start.sh /var/www/docker/wordpress/start.sh
RUN sed -i 's/\r//' /var/www/docker/wordpress/start.sh # Modify the executable to have the linux line endings
RUN chmod u+x /var/www/docker/wordpress/start.sh # Give permissions to run executable
