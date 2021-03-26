#!/usr/bin/env bash


# docker-compose build

docker-compose up --build installer

docker-compose up --build varnish nginx php_fpm php_fpm_debug redis
