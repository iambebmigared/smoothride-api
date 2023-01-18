#!/usr/bin/env bash

chown -R www-data:www-data /var/www/html
composer install
php artisan config:cache
php artisan route:cache
php artisan migrate

echo "Memory Information"
free -m

chmod -R 777 /var/log
mkdir -p /var/log/apache2 && \
chown -R www-data:www-data /var/log/apache2 && \
chmod -R 750 /var/log/apache2

mkdir -p /var/log/application/smoothrideapi
chown -R www-data:www-data /var/log/application/smoothrideapi && \
chmod -R 750 /var/log/application/smoothrideapi

service apache2 start
touch /var/log/apache2/access.log

tail -f /var/log/apache2/access.log
