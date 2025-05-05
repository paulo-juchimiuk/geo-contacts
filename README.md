# GeoContacts

Sistema full-stack de gerenciamento de contatos, com foco em arquitetura limpa, testes e integração contínua.

## Tecnologias Utilizadas

* **Backend:** Laravel 12 (PHP 8.3) com Laravel Sanctum para autenticação via tokens.
* **Frontend:** React 18 + TypeScript, utilizando Vite para bundling.
* **Arquitetura:** Clean Architecture / Hexagonal, aplicando princípios SOLID e TDD.
* **Infraestrutura:** Docker Compose (Nginx, PHP-FPM, MySQL, Node.js).
* **CI/CD:** GitHub Actions.
* **Serviços Externos:** Google Maps API para geolocalização e ViaCEP para busca de endereços.

## Como Rodar o Projeto

### Pré-requisitos

* Docker
* Docker Compose

### Subir o Ambiente

```bash
docker compose up -d --build
```

O projeto será acessível em:

* **Backend API:** [http://localhost:8000](http://localhost:8000)
* **Frontend App:** [http://localhost:5173](http://localhost:5173)

> O `entrypoint` já está configurado para instalar dependências, rodar migrations e seeders automaticamente.

### Rodar Testes

```bash
docker exec -it --user app geo-contacts-app sh
php artisan test
```

## Cobertura de Testes

* Testes unitários e de integração cobrindo autenticação, CRUD de contatos, serviços externos e exclusão de conta.
* Cobertura atual: 70%.

## Estrutura de Pastas

```bash
geo-contacts/
├── backend/   # API Laravel
├── frontend/  # Frontend React
├── docker/    # Configurações Docker
├── .github/   # Workflows de CI
├── docker-compose.yml
└── README.md
```

## Arquitetura

Adotamos **Arquitetura Hexagonal (Ports & Adapters)**:

* **Domain:** Entidades e Value Objects puros.
* **Application:** Casos de uso (UseCases) que orquestram a lógica de negócios.
* **Infrastructure:**

    * **Adapter In:** Controllers HTTP, Requests e Middlewares.
    * **Adapter Out:** Repositórios Eloquent e serviços externos (Google Maps, ViaCEP).

> Essa abordagem facilita testes, manutenção e escalabilidade.

## Autenticação

* **Laravel Sanctum** para autenticação via tokens simples para SPAs e APIs.
* Registro, login, proteção de rotas, logout e exclusão de conta.

## Serviços Externos

* **ViaCEP:** Busca de endereços a partir do CEP informado.
* **Google Maps API:** Geocodificação para obter latitude e longitude de endereços.

> Configure `GOOGLE_KEY` no `.env` para utilizar a API do Google.

## Integração Contínua (CI)

Este projeto já possui **GitHub Actions** configurado para validar:

- **Backend:** Composer validate, Pint (code style) e PHPUnit
- **Frontend:** Build e verificação do React com Vite

A pipeline é disparada automaticamente em cada `push` e `pull request` para a branch `main`, garantindo a estabilidade e qualidade do projeto.

Exemplo de validação automática:

✔ Pint - Passed
✔ PHPUnit - Passed (24 tests, 75 assertions)

## Documentação da API (Postman)

Importe a collection no Postman:

* **Collection:** `collection.json`
* **Visualização da Documentação:** [http://localhost:8000/api-doc/collection.json](http://localhost:8000/api-doc/collection.json)

## Endpoints Principais

### Autenticação

* `POST /api/register` → Registro
* `POST /api/login` → Login
* `POST /api/logout` → Logout
* `DELETE /api/account` → Exclusão de conta

### Contatos

* `GET /api/contacts` → Listar contatos
* `POST /api/contacts` → Criar contato
* `PUT /api/contacts/{id}` → Atualizar contato
* `DELETE /api/contacts/{id}` → Deletar contato

### Serviços Externos

* `GET /api/cep/{cep}` → Buscar endereço pelo CEP

## Variáveis de Ambiente

Copie `.env.example` para `.env` e configure:

```env
APP_NAME=GeoContacts
APP_URL=http://localhost:8000
GOOGLE_KEY=your_google_maps_api_key
```

---
