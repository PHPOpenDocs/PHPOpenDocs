#!/usr/bin/env bash


if test -f "./this_is_prod.txt"; then
    echo "this_is_prod.txt exists, delete that if you want to run prod."
    exit -1
fi

touch this_is_local.txt

docker-compose build php_fpm
docker-compose build php_fpm_debug

docker-compose up --build installer

docker-compose up --build nginx php_fpm php_fpm_debug npm npm_dev_build redis
