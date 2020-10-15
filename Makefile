DOCKER_RUN = docker-compose run --rm fpm

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
	PHP_XDEBUG_ENABLED=1 $(DOCKER_RUN) vendor/bin/phpunit --coverage-html coverage
