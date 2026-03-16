# VPPR - Sistema de Gestão de Serviços

Sistema de gestão de serviços jurídicos com autenticação JWT e CRUD completo.

## Tecnologias

| Tecnologia | Versão |
|------------|--------|
| PHP | ^8.2 |
| Laravel | ^12.0 |
| MySQL | 8.0+ |
| Node.js | 18+ |
| Tailwind CSS | ^4.0 |
| Vite | ^7.0 |
| JWT Auth | ^2.3 |
| Axios | ^1.11 |
| Toastify.js | ^1.12 |

## Instalação

### Pré-requisitos
- PHP 8.2+
- Composer
- Node.js 18+
- MySQL 8.0+

### Passos

```bash
# Clonar repositório
git clone https://github.com/DaviQuaresma/desafio_tecnico_VPPR.git
cd desafio_tecnico_VPPR/vppr_test

# Instalar dependências
composer install
npm install

# Configurar ambiente
cp .env.example .env
php artisan key:generate
php artisan jwt:secret

# Configurar banco de dados no .env
# DB_DATABASE=vppr
# DB_USERNAME=root
# DB_PASSWORD=

# Executar migrations
php artisan migrate

# Compilar assets
npm run build

# Iniciar servidor
php artisan serve
```

Acesse: `http://localhost:8000`

## Estrutura do Projeto

```
app/
├── Http/Controllers/
│   ├── AuthController.php     # Autenticação JWT
│   └── ServiceController.php  # CRUD de serviços
├── Models/
│   ├── User.php
│   └── Service.php
resources/
├── js/
│   ├── api/                   # Chamadas de API (Axios)
│   ├── helpers/               # Funções utilitárias
│   ├── auth/                  # Scripts de autenticação
│   ├── dashboard.js
│   └── services.js
├── views/
│   ├── auth/                  # Login, Register, Forgot Password
│   ├── components/icons/      # Ícones Lucide SVG
│   ├── dashboard.blade.php
│   └── services.blade.php
```

## Rotas da API

### Autenticação
| Método | Rota | Descrição |
|--------|------|-----------|
| POST | `/api/auth/register` | Cadastro de usuário |
| POST | `/api/auth/login` | Login (retorna JWT) |
| POST | `/api/auth/logout` | Logout (autenticado) |
| POST | `/api/auth/reset-password` | Redefinir senha |
| GET | `/api/auth/me` | Dados do usuário (autenticado) |

### Serviços (requer autenticação)
| Método | Rota | Descrição |
|--------|------|-----------|
| GET | `/api/services` | Listar serviços |
| POST | `/api/services` | Criar serviço |
| GET | `/api/services/{id}` | Buscar serviço |
| PUT | `/api/services/{id}` | Atualizar serviço |
| DELETE | `/api/services/{id}` | Excluir serviço |

## Páginas

| Rota | Descrição |
|------|-----------|
| `/login` | Tela de login |
| `/register` | Cadastro de conta |
| `/forgot-password` | Redefinição de senha |
| `/dashboard` | Painel principal |
| `/services` | Gestão de serviços |

## Comandos Úteis

```bash
# Desenvolvimento (servidor + vite)
composer dev

# Apenas servidor
php artisan serve

# Apenas vite (hot reload)
npm run dev

# Build produção
npm run build

# Rodar testes
php artisan test

# Limpar cache
php artisan optimize:clear
```

## Autenticação

O sistema utiliza JWT (JSON Web Token) para autenticação:

1. Login retorna um token JWT
2. Token é armazenado no localStorage/sessionStorage
3. Requisições autenticadas enviam header: `Authorization: Bearer {token}`
4. Token expira em 60 minutos (configurável em `config/jwt.php`)

## Coleção Postman

Importe `postman_collection.json` no Postman para testar a API.

## Licença

MIT
