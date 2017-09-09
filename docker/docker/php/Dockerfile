FROM ubuntu:14.04
MAINTAINER Buink Web Development <online@buink.biz>

# Set locale
RUN locale-gen en_US.UTF-8 \
  && export LANG=en_US.UTF-8

# add other dependencies
RUN apt-get update && apt-get install -yq \
	git-core \
	vim \
	curl \
	nodejs \
	mysql-client \
	apache2 \
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
	acl

# Run php setup
RUN php5enmod mcrypt
RUN a2enmod rewrite

# Install composer
RUN curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer

# Install NodeJS
RUN curl -sL https://deb.nodesource.com/setup_4.x | sudo -E bash -

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
COPY ./docker/company-php/apache.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

# Install compass
RUN gem install --no-rdoc --no-ri compass

# Add start file to new environment
COPY ./docker/company-php/start.sh /var/www/docker/company-php/start.sh
RUN sed -i 's/\r//' /var/www/docker/company-php/start.sh # Modify the executable to have the linux line endings
RUN chmod u+x /var/www/docker/company-php/start.sh # Give permissions to run executable
