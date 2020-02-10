#!/usr/bin/env bash

docker-compose pull
docker-compose run --rm fpm composer install --prefer-dist
docker-compose run --rm fpm ./vendor/bin/php-cs-fixer  fix  --config=.php_cs.php --diff --dry-run -v
docker-compose run --rm fpm ./vendor/bin/phpunit
