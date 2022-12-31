composer-install-tools:
	composer install --working-dir=tools/pint
	composer install --working-dir=tools/phpstan
pint:
	./tools/pint/vendor/bin/pint -v
phpstan:
	./tools/phpstan/vendor/bin/phpstan analyse -c phpstan.neon
test:
	./vendor/bin/phpunit
