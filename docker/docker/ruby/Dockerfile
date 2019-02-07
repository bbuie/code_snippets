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
    ruby \
    ruby-dev \
    ruby-bundler \
    ruby-rb-inotify

# Install compass
RUN gem install --no-rdoc --no-ri compass

# Install gem sass for grunt-contrib-sass
RUN gem install --no-rdoc --no-ri sass -v 3.4.23

# set work directory
WORKDIR /var/www/html/public/css/source/

# cleanup machine
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*