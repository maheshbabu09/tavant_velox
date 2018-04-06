# Use the latest Ubuntu base image
FROM ubuntu:16.04

# Set the locale
ENV LANG en_US.UTF-8  
ENV LANGUAGE en_US:en  
ENV LC_ALL en_US.UTF-8  

RUN apt-get update -qqy && apt-get install -qqy software-properties-common python-software-properties

# Add colours to bashrc
RUN  sed -i -e "s/#force_color_prompt=yes/force_color_prompt=yes/g" /root/.bashrc

# Install nginx
RUN apt-get -y install nginx

#install syslog
RUN apt-get install rsyslog -qqy

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
    python-setuptools \
    curl \
    mysql-client \
    git \
    vim \
	unzip \
	zip \
    supervisor \
    sendmail \
	wget

# tweak nginx config
RUN sed -i -e "s/worker_processes  1/worker_processes 5/" /etc/nginx/nginx.conf && \
    sed -i -e "s/keepalive_timeout\s*65/keepalive_timeout 2/" /etc/nginx/nginx.conf && \
    sed -i -e "s/keepalive_timeout 2/keepalive_timeout 2;\n\tclient_max_body_size 100m/" /etc/nginx/nginx.conf && \
    echo "daemon off;" >> /etc/nginx/nginx.conf

# tweak php-fpm config
RUN sed -i -e "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g" /etc/php/7.0/fpm/php.ini && \
    sed -i -e "s/upload_max_filesize\s*=\s*2M/upload_max_filesize = 100M/g" /etc/php/7.0/fpm/php.ini && \
    sed -i -e "s/post_max_size\s*=\s*8M/post_max_size = 100M/g" /etc/php/7.0/fpm/php.ini && \
    sed -i -e "s/log_errors\s*=\s*Off/log_errors = On/g" /etc/php/7.0/fpm/php.ini && \
    sed -i -e "s/display_startup_errors\s*=\s*Off/display_startup_errors = On/g" /etc/php/7.0/fpm/php.ini && \
    sed -i -e "s/display_errors\s*=\s*Off/display_errors = On/g" /etc/php/7.0/fpm/php.ini && \
	sed -i -e "s/memory_limit\s*=\s*128M/memory_limit = 1600M/g" /etc/php/7.0/fpm/php.ini && \
    sed -i -e "s/max_execution_time\s*=\s*30/max_execution_time = 300/g" /etc/php/7.0/fpm/php.ini && \
    sed -i -e "s/max_input_time\s*=\s*60/max_input_time = 300/g" /etc/php/7.0/fpm/php.ini && \
    sed -i -e "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g" /etc/php/7.0/cli/php.ini && \
    sed -i -e "s/upload_max_filesize\s*=\s*2M/upload_max_filesize = 100M/g" /etc/php/7.0/cli/php.ini && \
    sed -i -e "s/post_max_size\s*=\s*8M/post_max_size = 100M/g" /etc/php/7.0/cli/php.ini && \
	sed -i -e "s/memory_limit\s*=\s*128M/memory_limit = 1600M/g" /etc/php/7.0/cli/php.ini && \
    sed -i -e "s/max_execution_time\s*=\s*30/max_execution_time = 300/g" /etc/php/7.0/cli/php.ini && \
    sed -i -e "s/max_input_time\s*=\s*60/max_input_time = 300/g" /etc/php/7.0/cli/php.ini && \
    sed -i -e "s/;daemonize\s*=\s*yes/daemonize = no/g" /etc/php/7.0/fpm/php-fpm.conf && \
    sed -i -e "s/;catch_workers_output\s*=\s*yes/catch_workers_output = yes/g" /etc/php/7.0/fpm/pool.d/www.conf && \
    sed -i -e "s/pm.max_children = 5/pm.max_children = 100/g" /etc/php/7.0/fpm/pool.d/www.conf && \
    sed -i -e "s/pm.start_servers = 2/pm.start_servers = 20/g" /etc/php/7.0/fpm/pool.d/www.conf && \
    sed -i -e "s/pm.min_spare_servers = 1/pm.min_spare_servers = 10/g" /etc/php/7.0/fpm/pool.d/www.conf && \
    sed -i -e "s/pm.max_spare_servers = 3/pm.max_spare_servers = 50/g" /etc/php/7.0/fpm/pool.d/www.conf && \
    sed -i -e "s/pm.max_requests = 500/pm.max_requests = 800/g" /etc/php/7.0/fpm/pool.d/www.conf

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