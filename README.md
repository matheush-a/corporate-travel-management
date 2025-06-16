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

### 🗎 Documentação

  - Importe uma coleção no Postman a partir do seguinte JSON:
  - Em Auth/Register (POST) é possível criar os usuários necessários para testes
    
```
{
	"info": {
		"_postman_id": "6c437e7b-fc40-41fc-bdbc-cd9fb677eac4",
		"name": "Travel Management",
		"schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json",
		"_exporter_id": "7548375"
	},
	"item": [
		{
			"name": "Auth",
			"item": [
				{
					"name": "Register",
					"request": {
						"method": "POST",
						"header": [
							{
								"key": "Content-Type",
								"value": "application/json",
								"type": "text"
							}
						],
						"body": {
							"mode": "raw",
							"raw": "{\n    \"email\": \"solicitante@gmail.com\",\n    \"password\": \"12345678\",\n    \"name\": \"Solicitante\"\n}",
							"options": {
								"raw": {
									"language": "json"
								}
							}
						},
						"url": {
							"raw": "http://127.0.0.1:8000/api/register",
							"protocol": "http",
							"host": [
								"127",
								"0",
								"0",
								"1"
							],
							"port": "8000",
							"path": [
								"api",
								"register"
							]
						}
					},
					"response": []
				},
				{
					"name": "Login",
					"event": [
						{
							"listen": "test",
							"script": {
								"exec": [
									"const response = pm.response.json();",
									"pm.environment.set(\"authToken\", response.token); ",
									""
								],
								"type": "text/javascript",
								"packages": {}
							}
						}
					],
					"request": {
						"method": "POST",
						"header": [
							{
								"key": "Content-Type",
								"value": "application/json",
								"type": "text"
							}
						],
						"body": {
							"mode": "raw",
							"raw": "{\n    \"email\": \"mathzalmeida@gmail.com\",\n    \"password\": \"12345678\"\n}",
							"options": {
								"raw": {
									"language": "json"
								}
							}
						},
						"url": {
							"raw": "http://127.0.0.1:8000/api/login",
							"protocol": "http",
							"host": [
								"127",
								"0",
								"0",
								"1"
							],
							"port": "8000",
							"path": [
								"api",
								"login"
							]
						}
					},
					"response": []
				}
			]
		},
		{
			"name": "Travel Requests",
			"item": [
				{
					"name": "Store",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{authToken}}",
									"type": "string"
								}
							]
						},
						"method": "POST",
						"header": [],
						"body": {
							"mode": "raw",
							"raw": "{\n    \"destination\": \"Belo Horizonte\",\n    \"departure_date\": \"2025-06-20\",\n    \"return_date\": \"2025-07-12\"\n}",
							"options": {
								"raw": {
									"language": "json"
								}
							}
						},
						"url": {
							"raw": "http://127.0.0.1:8000/api/travel-requests",
							"protocol": "http",
							"host": [
								"127",
								"0",
								"0",
								"1"
							],
							"port": "8000",
							"path": [
								"api",
								"travel-requests"
							]
						}
					},
					"response": []
				},
				{
					"name": "Update",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{authToken}}",
									"type": "string"
								}
							]
						},
						"method": "PUT",
						"header": [],
						"body": {
							"mode": "raw",
							"raw": "{\n    \"status\": \"cancelado\"\n}",
							"options": {
								"raw": {
									"language": "json"
								}
							}
						},
						"url": {
							"raw": "http://127.0.0.1:8000/api/travel-requests/3",
							"protocol": "http",
							"host": [
								"127",
								"0",
								"0",
								"1"
							],
							"port": "8000",
							"path": [
								"api",
								"travel-requests",
								"3"
							]
						}
					},
					"response": []
				},
				{
					"name": "Show",
					"protocolProfileBehavior": {
						"disabledSystemHeaders": {
							"content-type": true
						}
					},
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{authToken}}",
									"type": "string"
								}
							]
						},
						"method": "GET",
						"header": [],
						"url": {
							"raw": "http://127.0.0.1:8000/api/travel-requests/5",
							"protocol": "http",
							"host": [
								"127",
								"0",
								"0",
								"1"
							],
							"port": "8000",
							"path": [
								"api",
								"travel-requests",
								"5"
							]
						}
					},
					"response": []
				},
				{
					"name": "Index",
					"protocolProfileBehavior": {
						"disabledSystemHeaders": {
							"content-type": true
						}
					},
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{authToken}}",
									"type": "string"
								}
							]
						},
						"method": "GET",
						"header": [],
						"url": {
							"raw": "http://127.0.0.1:8000/api/travel-requests?departure_date=2025-01-01&return_date=2026-01-02",
							"protocol": "http",
							"host": [
								"127",
								"0",
								"0",
								"1"
							],
							"port": "8000",
							"path": [
								"api",
								"travel-requests"
							],
							"query": [
								{
									"key": "departure_date",
									"value": "2025-01-01"
								},
								{
									"key": "return_date",
									"value": "2026-01-02"
								}
							]
						}
					},
					"response": []
				}
			]
		}
	]
}
```

### 📁 Estrutura de Pastas
```bash
corporate-travel-management/
├── backend/        # Projeto Laravel
├── frontend/       # Projeto Vue.js
├── .env            # Configuração global (ex: Docker)
├── docker-compose.yml
└── ...
```
