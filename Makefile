.PHONY: build

build: vendor
	app/console server:run

composer.phar:
	curl -s https://getcomposer.org/installer | php
	touch composer.phar

vendor: composer.phar
	./composer.phar install
	touch vendor
