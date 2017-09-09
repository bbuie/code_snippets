FROM ubuntu:14.04
MAINTAINER Buink Web Development <online@buink.biz>

# update linux
RUN apt-get update

# Set locale
RUN locale-gen en_US.UTF-8 \
  && export LANG=en_US.UTF-8

# add important linux tools
RUN apt-get update && apt-get install -yq \
	git-core \
	vim \
	curl \
	build-essential

# Install NodeJS
RUN curl -sL https://deb.nodesource.com/setup_6.x | sudo -E bash - #
RUN apt-get update && apt-get install -yq nodejs

# install Ruby
# add other dependencies
RUN apt-get update && apt-get install -yq \
	ruby \
	ruby-dev \
	ruby-bundler

# Install compass
RUN gem install --no-rdoc --no-ri compass

# Install gem sass for grunt-contrib-sass
# RUN apt-get install -y ruby
RUN gem install --no-rdoc --no-ri sass -v 3.4.23

# Install Helpful Node Packages Globally
RUN npm install --quiet -g gulp bower jshint

# set work directory
WORKDIR /var/www/html

# Install npm packages
ADD ./package.json /var/www/html/package.json
RUN npm install --quiet

# Add start file to new environment
COPY ./docker/company-node/start.sh /var/www/docker/company-node/start.sh
RUN sed -i 's/\r//' /var/www/docker/company-node/start.sh # Modify the executable to have the linux line endings
RUN chmod u+x /var/www/docker/company-node/start.sh # Give permissions to run executable
