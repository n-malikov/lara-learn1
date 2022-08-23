@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Docker</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

собрать и разобрать сборки
<pre>
docker-compose up -d
docker-compose up --build -d
docker-compose down
</pre>
<em>-d</em> указывает, что нужно в фоновом режиме
<hr>

<code>список контейнеров</code>, и запущенные и не запущенные
<pre>docker ps -a</pre>
остановить и удалить контейнер / принудительно
<pre>docker rm &lt;container_id></pre>
<pre>docker rm -f &lt;container_id></pre>
остановить все запущенные контейнеры
<pre>docker kill $(docker ps -q)</pre>
удаляем все
<pre>docker rm -f $(docker ps -a -q)</pre>
<hr>

<code>список образов</code>
<pre>docker images</pre>
остановить и удалить образ / принудительно
<pre>
docker rmi &lt;image_id>
docker rmi -f &lt;image_id>
</pre>
сразу все:
<pre>docker rmi $(docker images -q)</pre>

<h4>docker-compose</h4>
пример <em>docker-compose.yml</em> :
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
подключимся к этой БД:
<pre>mysql -uapp -psecret --port 33061 --host 127.0.0.1</pre>

зелезем внуть контейнера для выполнения консольных команд
<pre>
docker ps -a
docker exec -it &lt;container_id> bash
</pre>


<h4>установка docker</h4>
подготовка<br>
<pre>
sudo apt update
sudo apt install apt-transport-https ca-certificates curl software-properties-common
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu focal stable"
sudo apt update
apt-cache policy docker-ce
</pre>
установка
<pre>
sudo apt install docker-ce
sudo systemctl status docker
</pre>
установка DOCKER COMPOSE
<pre>
sudo curl -L "https://github.com/docker/compose/releases/download/1.25.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
docker-compose --version
</pre>
без sudo
<pre>
sudo usermod -aG docker nail
su - nail
id -nG
</pre>


<h4>тестим чистый docker (не compose)</h4>
поднять для теста MySQL образ:
<pre>docker run -e MYSQL_ROOT_PASSWORD=root mysql</pre>
залезем внутрь образа и выполним там команду <em>ls</em> :
<pre>docker run -e MYSQL_ROOT_PASSWORD=root mysql ls</pre>

                </div>
            </div>
        </div>
    </div>
@endsection
