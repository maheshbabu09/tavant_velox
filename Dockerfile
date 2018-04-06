# Use the latest Ubuntu base image
FROM ubuntu:16.04
RUN apt-get update -y
RUN apt-get install apache2 -y
RUN apt-get -y install php libapache2-mod-php php-mcrypt php-mysql mysql-client	
RUN usermod -u 1000 www-data
RUN usermod -a -G users www-data
RUN chown -R www-data:www-data /var/www
RUN chmod -R 777 /tmp
WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www/html/
COPY ./app/* /var/www/html/
RUN chmod -R 555 /var/www/html/
# Expose Ports
EXPOSE 8000
ENTRYPOINT ["/bin/bash", "-c", "service apache2 restart"]