# Use the latest Ubuntu base image
FROM nginx:latest

# Install php7 packages
RUN apt-get install -y php7.0-fpm \
    php7.0-cli \
    php7.0-common \
    php7.0-curl \
    php7.0-json \
    php7.0-gd \
    php7.0-mcrypt \
    php7.0-mbstring \
    php7.0-odbc \
    php7.0-pgsql \
    php7.0-mysql \
    php7.0-sqlite3 \
    php7.0-xmlrpc \
    php7.0-opcache \
    php7.0-intl \
    php7.0-xml \
    php7.0-zip \
	php7.0-bz2

# Install other software
RUN apt-get install -qqy \
    mysql-client \

# tweak nginx config
RUN sed -i -e "s/worker_processes  1/worker_processes 5/" /etc/nginx/nginx.conf && \
    sed -i -e "s/keepalive_timeout\s*65/keepalive_timeout 2/" /etc/nginx/nginx.conf && \
    sed -i -e "s/keepalive_timeout 2/keepalive_timeout 2;\n\tclient_max_body_size 100m/" /etc/nginx/nginx.conf && \
    echo "daemon off;" >> /etc/nginx/nginx.conf

# fix ownership of sock file for php-fpm
RUN sed -i -e "s/;listen.mode = 0660/listen.mode = 0750/g" /etc/php/7.0/fpm/pool.d/www.conf && \
    find /etc/php/7.0/cli/conf.d/ -name "*.ini" -exec sed -i -re 's/^(\s*)#(.*)/\1;\2/g' {} \;

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