# Laravel learning

### Docker

собрать и разобрать:
~~~
docker-compose up -d
docker-compose down
~~~

будет доступен тут: [https://localhost:8080/](https://localhost:8080/) <br>

если нужно сменить префикс создаваемых образов, то в .env добавляем такую строчку:
~~~
COMPOSE_PROJECT_NAME=app
~~~

### Установка

через докер:
~~~
cp .env.example .env
docker-compose up -d
docker-compose exec php-fpm composer install
docker-compose exec php-fpm php artisan key:generate
docker-compose exec php-fpm php artisan migrate
docker-compose exec php-fpm php artisan storage:link
docker-compose exec node yarn install
docker-compose exec node yarn run dev
make perm
~~~
ручная:
~~~
cp .env.example .env
composer install
make perm
php artisan key:generate
php artisan migrate
php artisan storage:link
nvm use 16.14.2
yarn
npm install
npm run dev #npm run prod
~~~

*make - берет команды из Makefile<br>

установка без пакетов для разработчика
~~~
composer install --no-dev
~~~

### Запуск тестов
~~~
php vendor/bin/phpunit
~~~

### Настройка PhpStorm
ставим плагин:<br>
`File -> Settings -> Plugins -> Marketplace -> Laravel`<br>
активируем:<br>
`File -> Settings -> PHP -> Laravel -> Enable plugin for this project`<br>
после установки любого пакета нужно выполнить:<br>
`php artisan ide-helper:generate`<br>
`docker-compose exec php-fpm php artisan ide-helper:generate`

### Nginx ручная установка

~~~
sudo nano /etc/nginx/sites-available/lara-learn
~~~

~~~
server {
    listen 80;
    server_name lara-learn.test;
    root /var/www/lara-learn/public;
    index index.php index.html index.htm;
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
    }
    location ~ /\.ht {
        deny all;
    }
}
~~~

~~~
sudo ln -s /etc/nginx/sites-available/lara-learn /etc/nginx/sites-enabled/
~~~

~~~
sudo systemctl reload nginx
~~~
