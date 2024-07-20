#!/bin/bash
chown -R docker_app_user:docker_app_user storage bootstrap
chmod -R ug+rwx storage
chmod -R ug+rwx bootstrap
composer install
service supervisor start
service cron start
php-fpm
