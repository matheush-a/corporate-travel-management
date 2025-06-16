# Projeto Fullstack - Laravel + Vue.js

Este projeto é composto por um **Backend em Laravel** e um **Frontend em Vue.js**.

---


## ⚙️ Etapa 1: Pré-Build

Antes de iniciar os containers, é necessário configurar corretamente os arquivos de ambiente.

### 1. Clone o repositório

```bash
git clone https://github.com/matheush-a/corporate-travel-management.git
```

### 2. Crie o arquivo .env na raiz do projeto
  
  - Copie o conteúdo de .env.example para um novo arquivo .env:

  ```bash
  cp .env.example .env
  ```
  
  - Defina um valor para a variável DB_PASSWORD.

### 3. Configure o backend

  - Acesse o diretório /backend
  - Crie o arquivo .env
  
  ```bash
  cp .env.example .env
  ```

  - Certifique-se de que o valor de DB_PASSWORD seja o mesmo definido no .env da raiz.

### 4. Configure o frontend

  - Acesse o diretório /frontend
  - Crie o arquivo .env

  ```bash
  cp .env.example .env
  ```

## 🛠️ Etapa 2: Build (Docker)
### 📋 Pré-requisitos
  - Docker instalado em sua máquina
  - Docker Compose (caso necessário, dependendo da versão do Docker)

### 🚀 Execução
Na raiz do projeto, execute o seguinte comando:

```bash
docker compose up --build
```
Isso irá:

  - Iniciar o Backend (Laravel) em http://localhost:8000
  - Iniciar o Frontend (Vue.js) em http://localhost:5173
  - Subir o banco de dados e demais serviços necessários

### ✅ Funcionalidades
  
  - Autenticação com JWT
  - Gerenciamento de solicitações de viagem
  - Integração entre Laravel e Vue.js via API REST

### 📁 Estrutura de Pastas
```bash
corporate-travel-management/
├── backend/        # Projeto Laravel
├── frontend/       # Projeto Vue.js
├── .env            # Configuração global (ex: Docker)
├── docker-compose.yml
└── ...
```
