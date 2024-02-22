
# Passo a passo para rodar o Backend
Tendo o docker e o docker composer instalados, siga os passos abaixo
bash
# Levante os containers
`docker-compose up -d`

# Baixe as dependencias
`docker exec container-php composer install`

# Copie o arquivo .env.example para um .env

# Gere um nova key do laravel
`docker exec container-php php artisan key:generate`

# Rode as migrates
`docker exec container-php php artisan migrate`

# Dê permissão ao storage
`docker exec container-php chmod -R 777 storage`

# Para rodar os testes
`docker exec container-php php artisan test`


Documentação da API:
https://documenter.getpostman.com/view/33085479/2sA2rAy2Qf

# Passo a passo para rodar o Fron-end

Tendo o nodejs v18+ instalado, rode os comandos abaixo
bash
# install dependencies
$ npm install

# serve with hot reload at localhost:3000
$ npm run dev
