# Use the latest Ubuntu base image
FROM ubuntu:16.04

RUN apt-get update -y

# Install nginx
RUN apt-get -y install httpd

RUN apt-get install -y php5.6

# Install other software
RUN apt-get install -y mysql-client
	
RUN usermod -u 1000 www-data
RUN usermod -a -G users www-data
RUN chown -R www-data:www-data /var/www
RUN chmod -R 777 /tmp

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html/

COPY ./source/* /var/www/html/

RUN chmod -R 555 /var/www/html/

# Expose Ports
EXPOSE 8000

ENTRYPOINT ["/bin/bash", "-c", "service rsyslog start & service cron start & service php7.0-fpm restart & chown -R www-data:www-data /var/www/html & service nginx start"]