composer-install-tools:
	composer install --working-dir=tools/php-cs-fixer
php-cs-version:
	./tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --version
php-cs-dry:
	./tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --verbose --dry-run
php-cs-dry-diff:
	./tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --verbose --diff --dry-run
php-cs-fix:
	./tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --verbose
test:
	./vendor/bin/phpunit
