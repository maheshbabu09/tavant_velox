# Use the latest Ubuntu base image
FROM ubuntu:16.04

# Set the locale
ENV LANG en_US.UTF-8  
ENV LANGUAGE en_US:en  
ENV LC_ALL en_US.UTF-8  

RUN apt-get update -qqy && apt-get install -qqy software-properties-common python-software-properties

# Install nginx
RUN apt-get -y install nginx

#install syslog
RUN apt-get install rsyslog -qqy

# Install php7 packages
RUN apt-get install -y php7.0-fpm \
    php7.0-cli \
    php7.0-common \
    php7.0-mcrypt \
    php7.0-mbstring \
    php7.0-mysql \
    php7.0-opcache \


# Install other software
RUN apt-get install -qqy \    
    mysql-client \
    


# tweak nginx config
RUN sed -i -e "s/worker_processes  1/worker_processes 5/" /etc/nginx/nginx.conf && \
    sed -i -e "s/keepalive_timeout\s*65/keepalive_timeout 2/" /etc/nginx/nginx.conf && \
    sed -i -e "s/keepalive_timeout 2/keepalive_timeout 2;\n\tclient_max_body_size 100m/" /etc/nginx/nginx.conf && \
    echo "daemon off;" >> /etc/nginx/nginx.conf


# nginx site conf
RUN rm -Rf /etc/nginx/conf.d/* && \
    rm -Rf /etc/nginx/sites-available/default && \
    mkdir -p /etc/nginx/ssl/
ADD ./nginx-site.conf /etc/nginx/sites-available/default.conf
RUN ln -s /etc/nginx/sites-available/default.conf /etc/nginx/sites-enabled/default.conf

RUN chmod +x /etc/init.d/nginx
	
RUN usermod -u 1000 www-data
RUN usermod -a -G users www-data

RUN mkdir -p /var/www/html
RUN chown -R www-data:www-data /var/www

RUN mkdir /run/php && chown www-data:www-data -R /run/php

RUN chmod -R 777 /tmp

WORKDIR /var/www/html

RUN rm -rf /var/www/html/

RUN chown -R www-data:www-data /var/www/html/

COPY ./source/* /var/www/html/

RUN chmod -R 555 /var/www/html/

# Expose Ports
EXPOSE 8000

ENTRYPOINT ["/bin/bash", "-c", "service rsyslog start & service cron start & service php7.0-fpm restart & chown -R www-data:www-data /var/www/html & service nginx start"]