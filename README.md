# Laravel learning

2:41:44

### Установка

~~~
cp .env.example .env
composer install
sudo chmod -R 777 storage
php artisan key:generate
php artisan migrate
php artisan storage:link
~~~

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
