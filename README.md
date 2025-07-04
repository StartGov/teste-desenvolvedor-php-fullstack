# 🧾 StartGov - Supplier Management Platform

Este projeto é uma aplicação fullstack construída com **Laravel 9** no backend e **Vue 3 + Vite + TailwindCSS** no frontend, com foco em cadastro e gestão de fornecedores. A documentação da API está disponível via **Swagger**.

---

## 🚀 Tecnologias

- PHP 8.3 / Laravel 9.x
- Laravel Sail (Docker)
- MySQL
- Vue 3 (Composition API)
- Vite + TailwindCSS
- Swagger (l5-swagger)
- Axios
- i18n

---

## 📦 Requisitos

- Docker e Docker Compose
- Node.js 20+
- Composer 2+

---

## ⚙️ Instalação

### 🔧 1. Clonar o repositório

```bash
git clone https://github.com/seu-usuario/teste-desenvolvedor-php-fullstack.git
cd teste-desenvolvedor-php-fullstack
```

### 🐳 2. Subir containers com Sail

```bash
cp .env.example .env
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed
```

> O backend estará disponível em: http://localhost

---

## 🖥️ Rodar Frontend

Abra a pasta `supplier-frontend`:

```bash
cd supplier-frontend
npm install
npm run dev
```

> O frontend estará em: http://localhost:5173

---

## 🔄 Estrutura dos diretórios

```
├── app/
│   ├── Http/Controllers/Api/SupplierController.php
│   ├── Interfaces/SupplierRepositoryInterface.php
│   ├── Repositories/SupplierRepository.php
│   ├── Http/Resources/SupplierResource.php
│   └── Swagger/ (schemas + info OpenAPI)
├── routes/api.php
├── config/l5-swagger.php
├── supplier-frontend/
│   ├── views/SupplierIndex.vue
│   ├── api/supplier.js
│   └── main.js
```

---

## ✅ Funcionalidades

- CRUD completo de fornecedores
- Busca por nome/documento com debounce
- Busca de CNPJ via BrasilAPI
- Internacionalização com i18n
- Documentação Swagger
- Tailwind UI responsiva

---

## 🧪 Testes

```bash
./vendor/bin/sail test
```

---