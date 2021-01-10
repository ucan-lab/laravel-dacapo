php-cs-version:
	docker run --rm --volume `pwd`:/project ucanlab/php-cs-fixer fix --version
php-cs-dry:
	docker run --rm --volume `pwd`:/project ucanlab/php-cs-fixer fix --diff --diff-format udiff --verbose --dry-run
php-cs-fix:
	docker run --rm --volume `pwd`:/project ucanlab/php-cs-fixer fix --diff --diff-format udiff --verbose
test:
	./vendor/bin/phpunit
