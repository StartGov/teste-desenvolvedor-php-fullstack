
# API de Fornecedores

Esta é uma API simples para gerenciamento de fornecedores, incluindo funcionalidades CRUD (Create, Read, Update, Delete), validação de CNPJ utilizando a API Brasil e funcionalidades de filtragem, paginação e ordenação dos fornecedores cadastrados.

## Requisitos

- PHP 8.1
- Composer versão 2.6.5
- Docker e Docker Compose versão 27.0.3
- Git

## Instalação

1. Clone o repositório:

   ```bash
   git clone https://github.com/Joallisson/start-gov-crud-fornecedores.git
   ```

2. Entre na pasta do projeto e troque para a branch correta:

   ```bash
   cd start-gov-crud-fornecedores
   git checkout feature/CRUD-Fornecedores
   ```

3. Instale as dependências do projeto:

   ```bash
   composer install
   ```

4. Inicie os containers Docker:

   ```bash
   ./vendor/bin/sail up -d
   ```

5. Execute as migrações do banco de dados:

   ```bash
   ./vendor/bin/sail artisan migrate
   ```

## Uso

A API possui endpoints para a criação, leitura, atualização e exclusão de fornecedores. Além disso, permite a validação de CNPJ usando a API Brasil e a filtragem, paginação e ordenação dos fornecedores cadastrados.

### Endpoints

- `GET /api/providers` - Lista os fornecedores com suporte a paginação, filtragem por nome ou CNPJ, e ordenação dinâmica.
- `POST /api/providers` - Cria um novo fornecedor com validação de CNPJ.
- `GET /api/providers/{id}` - Exibe os detalhes de um fornecedor específico.
- `PUT /api/providers/{id}` - Atualiza os dados de um fornecedor específico.
- `DELETE /api/providers/{id}` - Exclui um fornecedor específico.

### Parâmetros de Filtragem e Ordenação

- `name` - Filtra fornecedores pelo nome.
- `cnpj` - Filtra fornecedores pelo CNPJ.
- `sort_field` - Campo para ordenação (ex: `name`, `cnpj`).
- `sort_direction` - Direção da ordenação (`ASC` ou `DESC`).
- `per_page` - Número de fornecedores por página.

### Exemplo de Requisição

```bash
curl -X GET "http://localhost/api/providers?name=Joao&sort_field=name&sort_direction=ASC&per_page=10"
```

## Contribuição

Sinta-se à vontade para abrir issues e enviar pull requests. Para mudanças maiores, por favor, abra uma issue primeiro para discutir o que você gostaria de mudar.

## Licença

Distribuído sob a licença MIT. Veja `LICENSE` para mais informações.
