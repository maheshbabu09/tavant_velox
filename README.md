1) follow steps in below link to setup docker

	https://docs.docker.com/engine/installation/
	
2) open command prompt run below command 

	docker build -t drupal-php7-nginx PATH 

	note: PATH variable should replace with as per below example instructions

	Example: if you have placed the folder in user home folder

	docker build -t drupal-php7-nginx c:/Users/username/mydockerbuild/ (for windows)
	docker build -t drupal-php7-nginx /home/username/mydockerbuild/ (for linux)

3) Installation  mysql and import required schema and data

    docker run --name fgmc-cms-mysql -p 3306:3306 -e MYSQL_ROOT_PASSWORD=fgmc@2017cms -d mysql:5.7
	
	Go to mydockerbuild folder & Run below command to import db schema:
	
	docker exec -i fgmc-cms-mysql mysql -uroot -pfgmc@2017cms < dbschema.sql
	

	Run below command to import data:
	
	docker exec -i fgmc-cms-mysql mysql -uroot -pfgmc@2017cms drupalfgmc < drupal-fgmc.sql
	
4) Link Mysql container to drupal app container

	docker run -tid -p 8080:80 --name fgmc-cms-php7nginx --link fgmc-cms-mysql:mysqldb drupal-php7-nginx
	
5) run the docker using below command

	docker exec -i -t fgmc-cms-php7nginx bash
	
6) start php7.0-fpm and nginx services in docker instance using below commands
	
	service php7.0-fpm restart
	
	service nginx start &
	
	chown -R www-data:www-data /var/www/html
	
7) access recently created docker image from browser using below url

	http://localhost:8080
