.PHONY: build

SCULPIN = vendor/bin/sculpin

build: vendor
	$(SCULPIN) generate --watch --server


composer.phar:
	curl -s https://getcomposer.org/installer | php
	touch composer.phar

vendor: composer.phar
	./composer.phar install
	touch vendor

clean:
	rm composer.phar
	rm -rf vendor
	rm -rf $(OUTPUT_DIR)/*
