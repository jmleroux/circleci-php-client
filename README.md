### Docker

Run docker development environment:

```bash
docker-compose up -d
```

Install the library:

```bash
docker-compose exec fpm composer install --prefer-dist
```

Run tests:

```bash
docker-compose exec fpm ./vendor/bin/php-cs-fixer  fix  --config=.php_cs.php --diff --dry-run -v
docker-compose exec fpm ./vendor/bin/phpunit
```
