default:
    @just --list

dev-up:
    docker-compose up -d

dev-down:
    docker-compose kill

dev-restart:
    @just dev-down
    @just dev-up

fix-rights:
    sudo chown $USER:docker -R ./*
    sudo chmod -R a+w ./*

composer-install:
    docker exec workout-php bash -c "composer install --no-scripts"

shell-nginx:
    docker exec -it workout-webserver sh

shell-php:
    docker exec -it workout-php bash

mysql-client:
    mysql -h 127.0.0.1 -P 39003 -u workout -pworkout_password workout-api