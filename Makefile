composer-install-tools:
	composer install --working-dir=tools/php-cs-fixer
	composer install --working-dir=tools/phpstan
php-cs-version:
	./tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --version
php-cs-dry:
	./tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --verbose --dry-run
php-cs-dry-diff:
	./tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --verbose --diff --dry-run
php-cs-fix:
	./tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --verbose
phpstan:
	./tools/phpstan/vendor/bin/phpstan analyse -c phpstan.neon
test:
	./vendor/bin/phpunit
