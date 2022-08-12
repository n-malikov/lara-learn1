@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Docker</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <p>
                            собрать и разобрать сборки<br>
                            <code>docker-compose up -d</code><br>
                            <code>docker-compose up --build -d</code><br>
                            <code>docker-compose down</code><br>
                            <em>-d</em> указывает, что нужно в фоновом режиме
                        </p>

                        <p>
                            вывести все контейнеры, и запущенные и не запущенные<br>
                            <code>docker ps -a</code><br>
                            остановить и удалить контейнер / принудительно<br>
                            <code>docker rm &lt;container_id></code><br>
                            <code>docker rm -f &lt;container_id></code><br>
                            остановить все запущенные контейнеры<br>
                            <code>docker kill $(docker ps -q)</code><br>
                            удаляем все<br>
                            <code>docker rm -f $(docker ps -a -q)</code>
                        </p>

                        <p>
                            список образов<br>
                            <code>docker images</code><br>
                            остановить и удалить образ / принудительно<br>
                            <code>docker rmi &lt;image_id></code><br>
                            <code>docker rmi -f &lt;image_id></code><br>
                            сразу все:<br>
                            <code>docker rmi $(docker images -q)</code>
                        </p>

                        <h4>docker-compose</h4>
                        <p>пример <em>docker-compose.yml</em> :</p>
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
                        <p>
                            подключимся к этой БД:<br>
                            <code>mysql -uapp -psecret --port 33061 --host 127.0.0.1</code>
                        </p>
                        <p>
                            зелезем внуть контейнера для выполнения консольных команд<br>
                            <code>docker ps -a</code><br>
                            <code>docker exec -it &lt;container_id> bash</code>
                        </p>

                        <h4>установка docker</h4>
                        <p>
                            подготовка<br>
                            <code>sudo apt update</code><br>
                            <code>sudo apt install apt-transport-https ca-certificates curl software-properties-common</code><br>
                            <code>curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -</code><br>
                            <code>sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu focal stable"</code><br>
                            <code>sudo apt update</code><br>
                            <code>apt-cache policy docker-ce</code><br>
                            установка<br>
                            <code>sudo apt install docker-ce</code><br>
                            <code>sudo systemctl status docker</code>
                        </p>
                        <p>
                            установка DOCKER COMPOSE<br>
                            <code>sudo curl -L "https://github.com/docker/compose/releases/download/1.25.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose</code><br>
                            <code>sudo chmod +x /usr/local/bin/docker-compose</code><br>
                            <code>docker-compose --version</code><br>
                            без sudo<br>
                            <code>sudo usermod -aG docker nail</code><br>
                            <code>su - nail</code><br>
                            <code>id -nG</code>
                        </p>

                        <h4>тестим чистый docker (не compose)</h4>
                        <p>
                            поднять для теста MySQL образ:<br>
                            <code>docker run -e MYSQL_ROOT_PASSWORD=root mysql</code><br>
                            залезем внутрь образа и выполним там команду <em>ls</em> :<br>
                            <code>docker run -e MYSQL_ROOT_PASSWORD=root mysql ls</code>
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
