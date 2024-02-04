### Desafio PHP FullStack


# Para resolver o desafio foi utilizado laravel versão 10, vue versão 2, MYSQL, bootrap-vue


# Para começar, siga o tutorial abaixo:
# Clone o projeto

# Para rodar o projeto, siga os passos que foram divididos em duas etapas:
# 1 - Etapa subir o backend
# 2 - Startar o frontend


# Backend -------------:

# Certifique-se de que tenha docker e que ele esteja rodando atraves do comando:
```sh
docker ps
```

# Apos fazer o clone do projeto, entre na pasta do backend com o comando
```sh
cd backend
```
e execute:
```sh
docker compose build
```
# Copie o .env:
```sh
cp .env.example .env
```
# Atualize o .env se necessario
```sh
DB_CONNECTION=db
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root
```
# Em seguida, execute o comando:
```sh
docker compose up -d
```
# Em seguida, execute o comando para entrar dentro do container:
```sh
docker exec -it backend-app-1 bash
```
# Apos isso, instale as dependencias do projeto:
```sh
composer install
```
# Gere a chave:
```sh
php artisan key:generate
```

# dê permissoes para a pasta:
```sh
sudo chmod -R 755 /var/www
```

# Rode as migrations:
```sh
php artisan migrate:fresh --seed
```

# Verifique se consegue Acessar o backend na seguinte url:
```sh
http://localhost:8989
```
# Informações adicionais:

# Para rodar os testes execute:
```sh
php artisan test
```
# Para rodar o analizador de código estatico (phpstan):
```sh
vendor/bin/phpstan analyze
```
# Coleção publica dos endpoints:
```sh
https://www.postman.com/ivovilar1/workspace/supplierapi/collection/21873994-71746498-4751-4022-aefb-12458ef2603d
```
# Frontend ---------------------:

# Verifique se você está na pasta do frontend digitando o comando:
```sh
Linux: pwd | Windows: cd
```
# Caso não esteja, navega até o diretorio do frontend utilizando:
```sh
para voltar um nivel: cd .. | para navegar ao diretorio: cd frontend
```

# instale as dependencias:
# Obs para rodar o frontend é necessario as versoes do node : v10.19.0 e npm: 6.14.4

```sh
npm install
```
# Starte o servidor:
```sh
npm run serve
```

# Verifique se a aplicação está rodando na url:
```sh
http://localhost:8080
```
