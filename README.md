# Laravel learning

### Docker

собрать и разобрать:
~~~
docker-compose up -d
docker-compose down
~~~

будет доступен тут: [https://localhost:8080/](https://localhost:8080/) <br>

выполнить команды внутри образа: <br>
~~~
docker exec artello_php-fpm_1 php artisan migrate
~~~

если нужно сменить префикс создаваемых образов, то в .env добавляем такую строчку:
~~~
COMPOSE_PROJECT_NAME=app
~~~

### Установка

~~~
cp .env.example .env
composer install
make perm
php artisan key:generate
php artisan migrate
php artisan storage:link
~~~
~~~
nvm use 16.14.2
yarn
npm install
npm run dev #npm run prod
~~~

*make - берет команды из Makefile

установка без пакетов для разработчика
~~~
composer install --no-dev
~~~

### Настройка PhpStorm
ставим плагин:<br>
`File -> Settings -> Plugins -> Marketplace -> Laravel`<br>
активируем:<br>
`File -> Settings -> PHP -> Laravel -> Enable plugin for this project`<br>
после установки любого пакета нужно выполнить:<br>
`php artisan ide-helper:generate`

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

### сниппет для прода
~~~
server {
listen 80;
listen [::]:80;

    server_name <Ваш домен> www.<Ваш домен>;
    return 301 https://$server_name$request_uri;
}

server {
listen 443 ssl http2;
listen [::]:443 ssl http2;
server_name <Ваш домен> www.<Ваш домен>;
root /var/www/html/<Имя проекта>/public;

    ssl_certificate /etc/letsencrypt/live/<Ваш домен>/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/<Ваш домен>/privkey.pem;

    ssl_protocols TLSv1.2;
    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA512:DHE-RSA-AES256-GCM-SHA512:ECDHE-RSA-AES256-GCM-SHA384:DHE-RSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-SHA384;
    ssl_prefer_server_ciphers on;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.php index.html index.htm index.nginx-debian.html;

    charset utf-8;

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

    location ~ /.well-known {
            allow all;
    }
}
~~~
