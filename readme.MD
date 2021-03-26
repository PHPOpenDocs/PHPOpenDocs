
# PHP Open Docs

An experiment in diversifying the PHP docs ecosystem.

## How to get the dev box up

Get the code with:

`git clone  git@github.com:PHPOpenDocs/PHPOpenDocs.git`

or 

`git clone https://github.com/PHPOpenDocs/PHPOpenDocs`

Then:

`docker-compose up --build npm_dev_build varnish`

The site should be up at:

* http://local.phpopendocs.com/ going through Varnish
* http://local.phpopendocs.com:8000/ directly hitting the Nginx webserver
* http://local.phpopendocs.com:8001/ directly hitting the Nginx webserver, with xdebug enabled.

## Where stuff is

* Site CSS generated from: app/public/scss
* Basic routes: routes/app_routes.php
* Where pages are converted into HTML src/site_html.php
* Section list: createSectionList in src/factories.php:180
* Injection params: injectionParams/app.php

## How to deploy

Just push to main and it should appear quite soon...


## Random docker things to run

docker-compose exec php_fpm php vendor/bin/phpunit -c test/phpunit.xml

docker-compose exec php_fpm_debug php vendor/bin/phpunit -c test/phpunit.xml

docker rm $(docker ps -a -q)
docker rmi $(docker images -q)
docker network rm $(docker network ls -q)

docker kill $(docker ps -q)

docker exec -it example_web_admin_1 bash


## Useful links

https://domchristie.github.io/turndown/