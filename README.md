[![](https://startgov.com.br/wp-content/uploads/2023/11/LOGO_VETOR.png)](https://www.startgov.com.br)

# Plataforma de Gestão de Fornecedores

Este é um projeto de teste para a StartGov que consiste em uma plataforma para o cadastro e gerenciamento de fornecedores, utilizando Laravel para o backend e Vue.js para o frontend.

## Tecnologias Utilizadas

O projeto é construído com as seguintes tecnologias:

- **Backend**:
  - PHP 8.3
  - Laravel 12.0
  - MySQL
  - Pest (Testes Automatizados)
- **Frontend**:
  - Vue.js
  - Vite
  - Tailwind CSS
  - Axios
  - Zod
  - Maska
- **Ambiente de Desenvolvimento**:
  - Docker
  - Docker Compose

## Funcionalidades

A plataforma permite o gerenciamento completo de fornecedores, incluindo as seguintes operações:

- **Cadastro de Fornecedores**: Adicionar novos fornecedores com informações como CNPJ, nome, e-mail, telefone e endereço.
- **Listagem de Fornecedores**: Visualizar todos os fornecedores cadastrados em uma tabela.
- **Edição de Fornecedores**: Atualizar as informações de um fornecedor existente.
- **Exclusão de Fornecedores**: Remover um fornecedor do sistema.
- **Validação de Dados**: Validação dos dados de entrada tanto no frontend quanto no backend para garantir a consistência.
- **Filtragem de Fornecedores**: Filtre entre os fornecedores por nome, tipo de documento, data de criação
- **Busca de CPNJ**: Possibilidade de fazer uma busca por um determinado CNPJ na BrasilAPI.

## Esquema do Banco de Dados

A aplicação utiliza uma tabela principal, `suppliers`, para armazenar as informações dos fornecedores. A estrutura da tabela, conforme a migration, é a seguinte:

**Tabela: `suppliers`**

| Coluna            | Tipo                             | Descrição                               |
| ----------------- | -------------------------------- | --------------------------------------- |
| `id`              | `BIGINT UNSIGNED AUTO_INCREMENT` | Chave primária.                         |
| `name`            | `VARCHAR(255)`                   | Nome do fornecedor.                     |
| `phone`           | `VARCHAR(255)`                   | Telefone único do fornecedor.           |
| `address`         | `VARCHAR(255)`                   | Endereço (Rua/Avenida).                 |
| `house_number`    | `VARCHAR(255)`                   | Número do endereço.                     |
| `neighborhood`    | `VARCHAR(255)`                   | Bairro.                                 |
| `city`            | `VARCHAR(255)`                   | Cidade.                                 |
| `uf`              | `VARCHAR(2)`                     | Estado (UF).                            |
| `document_type`   | `VARCHAR(255)`                   | Tipo de documento (CNPJ ou CPF).        |
| `document_number` | `VARCHAR(255)`                   | Número do documento único.              |
| `created_at`      | `TIMESTAMP`                      | Data de criação do registro.            |
| `updated_at`      | `TIMESTAMP`                      | Data da última atualização do registro. |

## Estrutura do Projeto

O projeto é organizado em uma arquitetura monorepo, com o backend e o frontend em diretórios separados para maior clareza e manutenibilidade.

```
/
├── backend/                # Aplicação Backend (Laravel)
│   ├── app/
│   ├── config/
│   ├── database/
│   ├── routes/
│   ├── tests/              # Testes automatizados (Pest)
│   ├── composer.json
│   └── Dockerfile
│
├── frontend/               # Aplicação Frontend (Vue.js)
│   ├── src/
│   │   ├── components/
│   │   └── services/
│   │
│   ├── package.json
│   └── Dockerfile
│
├── docker-compose.yml      # Orquestração dos contêineres
└── README.md               # Documentação do projeto
```

## Pré-requisitos

Antes de começar, certifique-se de ter o Docker e o Docker Compose instalados em sua máquina.

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Como Rodar o Projeto

Siga os passos abaixo para configurar e executar o ambiente de desenvolvimento.

1.  **Clone o repositório:**

    ```sh
    git clone https://github.com/belloLucas/teste-desenvolvedor-php-fullstack.git
    cd teste-desenvolvedor-php-fullstack
    ```

2.  **Configurar Variáveis de Ambiente:**

    Copie os arquivos de exemplo `.env.example` para criar seus próprios arquivos `.env` para o backend e para o frontend.

    Para o backend:

    ```sh
    cp backend/.env.example backend/.env
    ```

    Para o frontend:

    ```sh
    cp frontend/.env.example frontend/.env
    ```

    Após copiar, verifique se a variável `VITE_API_URL` no arquivo `frontend/.env` aponta para o endereço correto da sua API do backend (o padrão é `http://localhost:8000/api`).

3.  **Subir os contêineres com Docker Compose:**

    Este comando irá construir as imagens e iniciar os serviços do backend, frontend e banco de dados.

    ```sh
    docker-compose up -d --build
    ```

4.  **Instalar dependências do Backend e gerar a chave da aplicação:**

    Execute os seguintes comandos para entrar no contêiner do backend e instalar as dependências do Composer e gerar a chave do Laravel.

    ```sh
    docker-compose exec backend composer install
    docker-compose exec backend php artisan key:generate
    ```

5.  **Executar as Migrations do Banco de Dados:**

    Para criar as tabelas no banco de dados, execute o comando de migration do Laravel.

    ```sh
    docker-compose exec backend php artisan migrate
    ```

## Rodando os Testes

O backend utiliza [Pest](https://pestphp.com/) para os testes de unidade e de funcionalidade. Para executar a suíte de testes, utilize o seguinte comando:

```sh
docker-compose exec backend php artisan test
```

## Acessando a Aplicação

Após seguir todos os passos, a aplicação estará disponível nos seguintes endereços:

- **Frontend (Vue.js):** [http://localhost:5173](http://localhost:5173)
- **Backend (API Laravel):** [http://localhost:8000](http://localhost:8000)

Agora você pode acessar a interface do frontend no seu navegador para interagir com a aplicação.

## Endpoints da API

Todos os endpoints estão prefixados com `/api`.

### Fornecedores (`/suppliers`)

#### `GET /suppliers`

Lista todos os fornecedores com paginação.

- **Query Params (Opcionais):**
  - `per_page` (int): Número de itens por página. Padrão: `5`.
  - `page` (int): Número da página.
  - `name` (string): Filtra por nome do fornecedor.
  - `document_type` (string): Filtra por tipo de documento (`CPF` ou `CNPJ`).
  - `sort_by` (string): Ordena os resultados. Valores possíveis: `name`, `document_type`, `createdAt`.
- **Retorno (200 OK):**
  ```json
  {
      "current_page": 1,
      "data": [
          {
              "id": 1,
              "name": "Fornecedor Exemplo",
              "phone": "11999998888",
              "address": "Rua Exemplo",
              "house_number": "123",
              "neighborhood": "Bairro Teste",
              "city": "São Paulo",
              "uf": "SP",
              "document_type": "CNPJ",
              "document_number": "75574868000102",
              "created_at": "2025-07-06T18:00:00.000000Z",
              "updated_at": "2025-07-06T18:00:00.000000Z"
          }
      ],
      "first_page_url": "http://localhost:8000/api/suppliers?page=1",
      "from": 1,
      "last_page": 1,
      "last_page_url": "http://localhost:8000/api/suppliers?page=1",
      "links": [...],
      "next_page_url": null,
      "path": "http://localhost:8000/api/suppliers",
      "per_page": 5,
      "prev_page_url": null,
      "to": 1,
      "total": 1
  }
  ```

#### `GET /suppliers/{id}`

Busca um fornecedor específico pelo ID.

- **Retorno (200 OK):** Objeto do fornecedor.
- **Retorno (404 Not Found):** Se o fornecedor não for encontrado.

#### `GET /suppliers/document`

Busca um fornecedor pelo tipo e número do documento.

- **Query Params (Obrigatórios):**
  - `document_type` (string): `CPF` ou `CNPJ`.
  - `document_number` (string): Número do documento.
- **Retorno (200 OK):** Objeto do fornecedor.
- **Retorno (404 Not Found):** Se o fornecedor não for encontrado.
- **Retorno (400 Bad Request):** Se os parâmetros não forem fornecidos.

#### `GET /suppliers/fetch-cnpj/{cnpj}`

Busca dados de uma empresa a partir de um CNPJ em uma API externa (BrasilAPI).

- **Retorno (200 OK):** Objeto com os dados da empresa.
- **Retorno (404 Not Found):** Se o CNPJ não for encontrado na API externa.

#### `POST /suppliers`

Cria um novo fornecedor.

- **Corpo da Requisição (JSON):**
  ```json
  {
    "name": "Novo Fornecedor",
    "phone": "11987654321",
    "address": {
      "street": "Rua Nova",
      "house_number": "456",
      "neighborhood": "Bairro Novo",
      "city": "Rio de Janeiro",
      "state": "RJ"
    },
    "document_type": "CPF",
    "document_number": "12345678901"
  }
  ```
- **Retorno (201 Created):** Objeto do fornecedor criado.
- **Retorno (422 Unprocessable Entity):** Em caso de erro de validação.

#### `PATCH /suppliers/{id}`

Atualiza um fornecedor existente.

- **Corpo da Requisição (JSON):** Campos a serem atualizados.
  ```json
  {
    "name": "Nome Atualizado",
    "phone": "11911112222"
  }
  ```
- **Retorno (200 OK):** Objeto do fornecedor atualizado.
- **Retorno (404 Not Found):** Se o fornecedor não for encontrado.
- **Retorno (422 Unprocessable Entity):** Em caso de erro de validação.

#### `DELETE /suppliers/{id}`

Exclui um fornecedor.

- **Retorno (200 OK):**
  ```json
  {
    "message": "Supplier deleted successfully"
  }
  ```
- **Retorno (404 Not Found):** Se o fornecedor não for encontrado.
