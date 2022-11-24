install:
	composer install

lint:
	composer exec --verbose phpcs -- --standard=PSR12 src bin tests

lint-fix:
	composer exec --verbose phpcbf -- --standard=PSR12 src bin tests

test:
	composer exec --verbose phpunit tests

test-coverage:
	composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml