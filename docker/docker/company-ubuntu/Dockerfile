FROM ubuntu:14.04
MAINTAINER Buink Web Development <online@buink.biz>

# Install custom dependencies
RUN apt-get update && apt-get install -yq \
		somepackage
	&& rm -rf /var/lib/apt/lists/*

RUN mkdir -p /usr/src/app
WORKDIR /usr/src/app

# # Add start file to new environment
COPY /docker/company-ubuntu/start.sh /usr/src/app/docker/company-ubuntu/start.sh

# # Modify the executable to have the linux line endings
RUN sed -i 's/\r//' /usr/src/app/docker/company-ubuntu/start.sh

# # Give permissions to run executable
RUN chmod u+x /usr/src/app/docker/company-ubuntu/start.sh