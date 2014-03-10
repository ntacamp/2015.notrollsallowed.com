SRC = src/twitter/bootstrap
ASSETS = web/assets
VENDOR = vendor/twitter/bootstrap
DEV_ASSETS = ../source/assets

#
# Build twitter bootstrap project. Compile LESS to CSS, copy other assets from src/ to web/
# make bootstrap
#
bootstrap: vendor
	@echo "Compiling..."
	@lessc ${SRC}/less/responsive.less > ${ASSETS}/css/responsive.css
	@lessc ${SRC}/less/bootstrap.less > ${ASSETS}/css/style.css
	@rm -rf ${ASSETS}/img
	@cp -r ${VENDOR}/img/ ${ASSETS}/img
	@cp -fr ${SRC}/img/* ${ASSETS}/img
	@echo "Done"

composer.phar:
	curl -s https://getcomposer.org/installer | php
	touch composer.phar

vendor: composer.phar
	./composer.phar install
	touch vendor
#
# Initializes bootstrap project structure
# make init
#
init: vendor
	mkdir -p ${SRC}
	mkdir -p ${SRC}/less
	mkdir -p ${SRC}/img
	touch ${SRC}/img/images
	mkdir -p ${ASSETS}
	mkdir -p ${ASSETS}/img
	mkdir -p ${ASSETS}/css
	mkdir -p ${ASSETS}/js
	touch ${SRC}/less/app.less 
	echo '@import "../../../../${VENDOR}/less/bootstrap.less";' > ${SRC}/less/bootstrap.less 
	echo '@import "app.less";' >> ${SRC}/less/bootstrap.less 
	echo '@import "../../../../${VENDOR}/less/responsive.less";' > ${SRC}/less/responsive.less 
	echo '@import "../../../../${VENDOR}/less/variables.less";' > ${SRC}/less/variables.less 
	touch web/index.html

#
# Creates LESS file in src/ folder to extend bootstrap
# make extend COMPONENT=<NAME>
#
extend: vendor
	@echo '@import "../../../../../vendor/twitter/bootstrap/less/component/${COMPONENT}.less";' > ${SRC}/less/component/${COMPONENT}.less
	@echo '\n@import "component/${COMPONENT}.less";' >> ${SRC}/less/bootstrap-component.less

#
# Copies JS from vendor/twitter/bootstrap/js/bootstrap-<NAME>.js to web/assets/js/bootstrap-<NAME>.js
# make usejs NAME=<NAME>
#
usejs:
	@echo "Saving to... web/assets/js/bootstrap-${NAME}.js"
	@cp ${VENDOR}/js/bootstrap-${NAME}.js web/assets/js/bootstrap-${NAME}.js

#
# Watches for changes in src/twitter/bootstrap directory and runs command 'make bootstrap'
# * watchr required https://github.com/mynyml/watchr 
# make watch
#
watch:
	echo "Watching less files..."; \
	watchr -e "watch('src/twitter/bootstrap/.*') { system 'make bootstrap' }"

#
# Shows compiled CSS from yout app.less
# make showcss
#
showcss: vendor
	lessc ${SRC}/less/app.less

#
# DEPLOY
# make deploy
#
deploy:
	cp -r ${ASSETS}/img/* ${DEV_ASSETS}/img
	cp -r ${ASSETS}/css/* ${DEV_ASSETS}/css
	cp -r ${ASSETS}/js/* ${DEV_ASSETS}/js
