DOCKER_RUN = docker-compose run -e PHP_XDEBUG_ENABLED=0 --rm fpm
DOCKER_RUN_XDEBUG = docker-compose run -e PHP_XDEBUG_ENABLED=1 --rm fpm

.env.local: .env
	cp -n .env .env.local

vendor:
	$(DOCKER_RUN) composer install --prefer-dist

.PHONY: setup
setup:
	make .env.local
	rm -rf vendor
	make vendor

.PHONY: tests
tests:
	$(DOCKER_RUN) ./vendor/bin/php-cs-fixer fix --diff --config=.php_cs.php
	$(DOCKER_RUN) ./vendor/bin/phpunit ${path}

.PHONY: coverage
coverage:
	$(DOCKER_RUN_XDEBUG) vendor/bin/phpunit --coverage-html var/coverage
