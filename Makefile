test:
	docker exec artello_php-fpm_1 vendor/bin/phpunit --colors=always

assets-install:
	docker exec artello_node_1 yarn install

assets-dev:
	docker exec artello_node_1 yarn run dev

assets-watch:
	docker exec artello_node_1 yarn run watch

perm:
	sudo chown ${USER}:${USER} bootstrap/cache -R
	sudo chown ${USER}:${USER} storage -R
	sudo chmod -R 777 storage
	if [ -d "node_modules" ]; then sudo chown ${USER}:${USER} node_modules -R; fi
	if [ -d "public/build" ]; then sudo chown ${USER}:${USER} public/build -R; fi
