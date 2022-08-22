<pre>
version: '2' # в зависимости от версии меняется синтаксис
  services:
    mysql: # название образа
      image: mysql:5.7 # что будет внутри и его версия
      environment: # настройки env для прокидки внутрь
        - "MYSQL_ROOT_PASSWORD=secret"
        - "MYSQL_USER=app"
        - "MYSQL_PASSWORD=secret"
        - "MYSQL_DATABASE=app"
      ports: # внешний и внутренний порт
        - "33061:3306"
</pre>
