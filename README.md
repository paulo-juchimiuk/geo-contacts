# GeoContacts

Sistema full-stack de gerenciamento de contatos. (UEX)

## Tecnologias Utilizadas
- **Backend:** Laravel 12 (PHP 8.3) + Sanctum
- **Frontend:** React 18 + TypeScript + Vite
- **Infraestrutura:** Docker Compose (Nginx, PHP-FPM, MySQL, Node.js)
- **CI/CD:** GitHub Actions
- **Outros:** Google Maps API, ViaCEP API

## Como rodar o projeto

### Pré-requisitos
- Docker
- Docker Compose
- Make

### Subir o ambiente
```bash
make up
```

## Acessar

- **Backend API:** http://localhost:8000

- **Frontend App:** http://localhost:5173


## Estrutura de Pastas

```bash
geo-contacts/
├── backend/   # API Laravel
├── frontend/  # Frontend React
├── docker/    # Configurações Docker
├── .github/   # Workflows de CI
├── docker-compose.yml
├── Makefile
└── README.md

```

## Funcionalidades (em desenvolvimento)
- [x] Docker + Estrutura inicial
- [ ] Autenticação de usuários
- [ ] CRUD de Contatos
- [ ] Integração ViaCEP
- [ ] Geolocalização com Google Maps
- [ ] Exclusão de Conta
