# Use the latest Ubuntu base image
FROM ubuntu:16.04
RUN apt-get update -y
# Install httpd
RUN apt-get -y install apache2

# Install php7 packages
RUN apt-get install -y php5.6

# Install other software
RUN apt-get install -y mysql-client git vim

COPY ./app/* /var/www/html/

RUN chmod -R 555 /var/www/html/

# Expose Ports
EXPOSE 8000
ENTRYPOINT ["/bin/bash", "-c", "/etc/init.d/apache2 start"]