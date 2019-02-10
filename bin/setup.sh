#!/usr/bin/env bash

docker-compose up -d
docker-compose exec fpm composer install --prefer-dist
docker-compose exec fpm ./vendor/bin/php-cs-fixer  fix  --config=.php_cs.php --diff --dry-run -v
docker-compose exec fpm ./vendor/bin/phpunit
