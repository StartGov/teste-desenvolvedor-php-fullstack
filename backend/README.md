### Setup para dev com laravel10 + docker

*A aplicação tem apenas o basico do laravel, com pest e adicionei pint e larastan*

# Certifique-se de que tenha docker e que ele esteja rodando atraves do comando:
```sh
docker ps
```
# Apos fazer o clone do projeto, entre na pasta do mesmo com o comando
```sh
cd baseLaravelDocker
```
e execute:
```sh
docker compose build
```
# Copie o .env:
```sh
cp .env.example .env
```
# Atualize o .env de acordo com suas necessidades
```sh
APP_NAME="NOME APP"
APP_URL=http://localhost:8989

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=nome_que_desejar_db
DB_USERNAME=nome_usuario
DB_PASSWORD=senha_aqui

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```
# Em seguida, execute o comando:
```sh
docker compose up -d
```
# Em seguida, execute o primeiro comando listado e pegue o valor mostrado no container_id que tenha o php e execute:
```sh
docker exec -it container_id bash
```
# Apos isso, execute:
```sh
composer install
```
```sh
php artisan key:generate
```

# Entre dentro do container e execute o comando:

```sh
sudo chmod -R 755 /var/www
```

# Acesse a aplicação na seguinte url:
```sh
http://localhost:8989
```
