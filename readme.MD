
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

