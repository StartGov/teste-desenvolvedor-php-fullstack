# 🚀 Teste StartGov - Thales Vasconcelos

---

## 📦 Requisitos

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

---

## ⚙️ Configuração
  -Clone o repositório
  -Copie o arquivo .env.example e ajuste as variáveis de banco, se necessário (DB_HOST=db, DB_PASSWORD=secret etc.)
  -Vá para a pasta backend: cd ./backend/
  -Suba os containers: docker compose up -d --build
  -Instale as dependências do Laravel: docker exec laravelapp composer install
  -Gere a key da aplicação: docker exec laravelapp php artisan key:generate
  -Rode as migrations: docker exec laravelapp php artisan migrate
  -Vá para a pasta do frontend: cd ../frontend
  -Instale as dependências necessárias para executar o programa: npm install
  -Inicie o servidor: npm run dev
  -Acesse a aplicação em https://localhost:5173

