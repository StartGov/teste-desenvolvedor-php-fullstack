[![](https://startgov.com.br/wp-content/uploads/2023/11/LOGO_VETOR.png)](https://www.startgov.com.br)

# Nossa empresa

A StartGov é uma empresa que se dedica a criar soluções inovadoras focadas na gestão de contratações, especialmente voltadas para o setor público. A empresa oferece um conjunto de ferramentas destinadas a facilitar e otimizar processos burocráticos relacionados a licitações, contratações diretas, gestão de contratos, ordens de fornecimento e serviço, além do cadastro de fornecedores. Essas soluções visam aumentar a celeridade dos trâmites administrativos e permitir a implementação de fluxos e processos padronizados.

# Conheça mais sobre a StartGov

- Nosso Site - https://www.startgov.com.br/
- Nosso Instagram - https://www.instagram.com/startgov/

## Teste para Desenvolvedor PHP/Laravel e Vue.js

Bem-vindo ao teste de desenvolvimento para a posição de Desenvolvedor PHP/Laravel e Vue.js. O objetivo deste teste é desenvolver uma plataforma para o cadastro de fornecedores, permitindo a busca por CNPJ ou CPF, utilizando Laravel no backend e Vue.js no frontend.

## Descrição do Projeto

### Backend (API Laravel):

#### CRUD de Fornecedores:

- **Criar Fornecedor:**
  - Permita o cadastro de fornecedores usando CNPJ ou CPF, incluindo informações como nome/nome da empresa, contato, endereço, etc.
  - Valide a integridade e o formato dos dados, como o formato correto de CNPJ/CPF e a obrigatoriedade de campos.

- **Editar Fornecedor:**
  - Facilite a atualização das informações de fornecedores, mantendo a validação dos dados.

- **Excluir Fornecedor:**
  - Possibilite a remoção segura de fornecedores.

- **Listar Fornecedores:**
  - Apresente uma lista paginada de fornecedores, com filtragem e ordenação.

#### Migrations:

- Utilize migrations do Laravel para definir a estrutura do banco de dados, garantindo uma boa organização e facilidade de manutenção.

### Frontend (Vue.js):

- Desenvolva interfaces para todas as operações do CRUD, com validações e feedback visual adequado.

## Requisitos

### Backend:
- Implementar busca por CNPJ na [BrasilAPI](https://brasilapi.com.br/docs#tag/CNPJ/paths/~1cnpj~1v1~1{cnpj}/get) ou qualquer outro endpoint público.

## Tecnologias a serem utilizadas
- HTML
- CSS
- VueJS 2.x ou superior
- Framework Laravel (PHP) 9.x ou superior
- MySQL ou Postgres
- Pode utilizar Bootstrap ou qualquer outro UI Design

## Critérios de Avaliação

- Adesão aos requisitos funcionais e técnicos.
- Qualidade do código, incluindo organização, padrões de desenvolvimento e segurança.
- Usabilidade e design das interfaces de usuário.
- Documentação do projeto, incluindo um README detalhado com instruções de instalação e operação.

## Bônus

- Implementação de testes automatizados.
- Dockerização do ambiente de desenvolvimento.
- Implementação de cache para otimizar o desempenho.

## Entrega

- Para iniciar o teste, faça um fork deste repositório; Se você apenas clonar o repositório não vai conseguir fazer push.
- Crie uma branch com o nome que desejar;
- Altere o arquivo README.md com as informações necessárias para executar o seu teste (comandos, migrations, seeds, etc);
- Depois de finalizado, envie-nos o pull request;

## Projeto usando docker. Para executar, rode os comandos abaixo.
```bash
# Clone o projeto
$ git clone https://github.com/guilherf13/teste-desenvolvedor-php-fullstack.git
# Execute os comandos
$ cd teste-desenvolvedor-php-fullstack
$ docker compose up -d --build
$ docker exec app composer install 
```
## Configuração do .env
```bash
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root
```
## Criar a key e Rodar as migrations
```bash
$ docker exec app php artisan key:generate
$ docker exec app php artisan migrate
```