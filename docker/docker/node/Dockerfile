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

# add node specific linux packages
RUN apt-get update && apt-get install -yq \
    build-essential

# install servers: node
RUN curl -sL https://deb.nodesource.com/setup_8.x -o nodesource_setup.sh
RUN bash nodesource_setup.sh
RUN apt-get update && apt-get install -yq nodejs

# install global node packages
RUN npm install --quiet -g gulp jshint

# set work directory
WORKDIR /var/www/html

# add linux packages needed for npm install
RUN apt-get update && apt-get install -yq \
   autoconf \
   libpng-dev

# install all node packages
ADD ./package.json /var/www/html/package.json
RUN npm install --quiet

# add start file to new environment
COPY ./docker/node/start.sh /var/www/docker/node/start.sh
RUN sed -i 's/\r//' /var/www/docker/node/start.sh # Modify the executable to have the linux line endings
RUN chmod u+x /var/www/docker/node/start.sh # Give permissions to run executable

# clean up machine
RUN npm cache clean --force
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
