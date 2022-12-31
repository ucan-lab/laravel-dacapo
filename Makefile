composer-install-tools:
	composer install --working-dir=tools/phpstan
phpstan:
	./tools/phpstan/vendor/bin/phpstan analyse -c phpstan.neon
test:
	./vendor/bin/phpunit
