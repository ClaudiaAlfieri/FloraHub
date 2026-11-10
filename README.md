# 🌿 FloraHub
Aplicação Web de botânica desenvolvida com Laravel e Livewire

![Laravel](https://img.shields.io/badge/Laravel%2013-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Livewire](https://img.shields.io/badge/Livewire%204-FB70A9?style=for-the-badge&logo=livewire&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS%204-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Redis](https://img.shields.io/badge/Redis-DC382D?style=for-the-badge&logo=redis&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![Status](https://img.shields.io/badge/Status-Conclu%C3%ADdo-brightgreen?style=for-the-badge)

> Projeto da componente prática do curso TPSI da ATEC: uma **aplicação Web em Laravel 13** com **Livewire**, **Tailwind CSS** e **Flux UI**, com base de dados **MySQL** e **Redis** a correr em **Docker**.

---

## 📌 Sobre o Projeto

O **FloraHub** é desenvolvido de forma incremental ao longo das aulas, seguindo os guias da formação. Parte de uma aplicação Laravel já configurada com autenticação e vai crescendo, etapa a etapa, até às funcionalidades completas da aplicação.

A aplicação tem duas áreas:

- **Área do utilizador:** painel pessoal, notificações, definições de conta e tokens de API.
- **Área de administração:** gestão do catálogo botânico (famílias e espécies), gestão de utilizadores, mensagens, relatórios em PDF e monitorização das filas.

O objetivo é aplicar, num projeto real, os conceitos de desenvolvimento Web com Laravel: rotas, componentes Blade e Livewire, modelação da base de dados com migrations, autorização com roles e policies, filas e notificações, integração com serviços externos e uma API própria.

---

## ✨ Funcionalidades

### Conta e segurança

| Funcionalidade | Descrição |
|---|---|
| 🔐 Registo e login | Autenticação de utilizadores com email e password (Fortify) |
| 🔑 Recuperação de password | Pedido de nova password por email |
| ✅ Verificação de email | Confirmação do email antes de aceder à aplicação |
| 🛡️ Autenticação de dois fatores | 2FA opcional, com códigos de recuperação |
| ⚙️ Definições de conta | Alteração do perfil, da password e da aparência |
| 👥 Roles | Dois perfis (`admin` e `user`) com Spatie Permission, cada um com o seu painel |
| 🌍 Idiomas | Interface em português (pt_PT) e inglês, com seletor de idioma |

### Catálogo botânico (administração)

| Funcionalidade | Descrição |
|---|---|
| 🌱 Famílias botânicas | Criar, editar, pesquisar, remover (soft delete), restaurar e eliminar definitivamente |
| 🌿 Espécies | Gestão completa das espécies, com rega, luz, dificuldade (enums) e toxicidade para animais |
| 🖼️ Imagens | Upload de imagens das famílias e das espécies, guardadas no disco `public` |
| 🔎 Consulta ao GBIF | No formulário das espécies, consulta o nome científico na API pública do GBIF e propõe o nome canónico, a família e a chave GBIF |
| 📄 Ficha da família em PDF | Descarregar a ficha de uma família (imagem, descrição e espécies), gerada com dompdf |

### Utilizadores, mensagens e relatórios (administração)

| Funcionalidade | Descrição |
|---|---|
| 👤 Gestão de utilizadores | Lista com pesquisa e filtro por role e detalhe de cada utilizador |
| ✉️ Mensagens | O admin envia mensagens aos utilizadores, entregues na aplicação e por email através de uma fila |
| 📊 Relatório de utilizadores | Exportação em PDF gerada em background por um job, guardada num disco privado e descarregada com autorização |
| 📈 Painel de administração | Contagens de famílias, espécies e utilizadores |
| 🧭 Filas | Monitorização das filas com Laravel Horizon |

### Área do utilizador

| Funcionalidade | Descrição |
|---|---|
| 🔔 Notificações | Sino com contador e página de notificações, com "marcar como lida" |
| 🔑 Tokens de API | Criar e revogar tokens pessoais para usar a API da conta |

### API REST (Sanctum)

| Endpoint | Acesso | Devolve |
|---|---|---|
| `GET /api/species` | público | Espécies do catálogo, 15 por página, com `?search=` e `?family=` |
| `GET /api/species/{slug}` | público | Uma espécie, com a família e a ligação ao GBIF |
| `GET /api/families` | público | Famílias ativas, com o número de espécies |
| `GET /api/me` | token | Dados da própria conta (nome e membro desde) |
| `GET /api/me/notifications` | token | Notificações do próprio utilizador |

Limite de pedidos: **60 por minuto** sem token (por IP) e **120 por minuto** com token (por utilizador).

### Boas práticas aplicadas

- **Autorização** com policies (`FamilyPolicy`, `SpeciesPolicy`, `UserPolicy`) e um gate (`manage-api-tokens`).
- **Logs de auditoria** num canal próprio (`audit`), só com ids e sem dados pessoais, e contexto do pedido (`request_id`, `user_id`).
- **Cache no Redis** para as respostas do GBIF, e **rate limiting** nas consultas e na API.
- **Eager loading** para evitar o problema N+1.

---

## 🗂️ Estrutura do Projeto

```
florahub/
├── app/
│   ├── Enums/             # Light, Watering, Difficulty
│   ├── Http/
│   │   ├── Controllers/   # Controladores (inclui Api/ para a API REST)
│   │   ├── Middleware/    # SetLocale, AddRequestContext
│   │   └── Resources/     # API Resources (JSON da API)
│   ├── Jobs/              # Jobs em fila (relatório de utilizadores)
│   ├── Models/            # Modelos Eloquent (User, Family, Species)
│   ├── Notifications/     # Notificações (mensagens e relatórios)
│   ├── Policies/          # Regras de autorização
│   └── Services/Gbif/     # Cliente da API do GBIF
├── config/                # Configuração (services, horizon, sanctum…)
├── database/
│   ├── factories/         # Dados de teste
│   ├── migrations/        # Estrutura das tabelas
│   └── seeders/           # Dados iniciais
├── lang/                  # Traduções (pt_PT)
├── resources/
│   ├── views/
│   │   ├── components/    # Componentes Blade
│   │   ├── layouts/       # Layouts (admin, user, auth…)
│   │   ├── pages/         # Componentes Livewire (ficheiros ⚡)
│   │   └── pdf/           # Vistas dos documentos PDF
│   ├── css/               # Tailwind CSS
│   └── js/
├── routes/                # web.php, api.php, settings.php, console.php
├── tests/                 # Testes (Pest)
└── compose.yaml           # Serviços Docker (MySQL e Redis)
```

---

## ▶️ Como Correr o Projeto

### Pré-requisitos

- **PHP 8.3+** e **Composer**
- **Node.js 18+** e **npm**
- **Docker Desktop**

### 1. Configuração

Copia o ficheiro de exemplo e ajusta a ligação à base de dados:

```bash
cp .env.example .env
```

> **Nota:** neste projeto o MySQL do Docker usa a porta **3307** (em vez da 3306), para não chocar com um MySQL já instalado no computador. Confirma que o `.env` tem `DB_PORT=3307`.

Variáveis importantes do `.env`:

| Variável | Valor | Para quê |
|---|---|---|
| `APP_LOCALE` | `pt_PT` | Idioma por omissão |
| `QUEUE_CONNECTION` | `redis` | Filas no Redis |
| `CACHE_STORE` | `redis` | Cache no Redis |
| `MAIL_MAILER` | `smtp` (Mailtrap) ou `log` | Envio dos emails em desenvolvimento |
| `GBIF_BASE_URL` | `https://api.gbif.org/v1` | API do GBIF (sem chave) |

> ⚠️ As credenciais de email ficam **só** no `.env`, que não entra no Git.

### 2. Serviços (Docker)

```bash
docker compose up -d
```

### 3. Dependências

```bash
composer install
npm install
```

### 4. Aplicação

```bash
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
composer run dev
```

A aplicação fica em `http://localhost:8000`.

O `composer run dev` arranca o servidor, o Vite e o worker das filas.

### 5. Contas de teste

O seeder cria um utilizador de cada role (apenas em desenvolvimento):

| Role | Email | Password |
|---|---|---|
| Administrador | `admin@florahub.test` | `password` |
| Utilizador | `user@florahub.test` | `password` |

Na página de login há também botões de **início de sessão rápido**, visíveis só com `APP_ENV=local`.

### 6. Notas para Windows

- O **Horizon** precisa da extensão `pcntl`, que não existe no Windows. Por isso, o `composer run dev` usa `php artisan queue:work redis --queue=notifications,default` em vez do Horizon. O painel `/horizon` continua disponível.
- Pela mesma razão, os comandos `composer require` precisam de `--ignore-platform-req=ext-pcntl --ignore-platform-req=ext-posix`.
- Se os pedidos HTTPS do PHP falharem com `cURL error 60`, configurar `curl.cainfo` e `openssl.cafile` no `php.ini` com o ficheiro [`cacert.pem`](https://curl.se/ca/cacert.pem).

### 7. Testes e qualidade do código

```bash
php artisan test
vendor/bin/pint --dirty
vendor/bin/phpstan analyse --memory-limit=1G
npm run build
```

---

## 🛠️ Tecnologias Usadas

- **Backend:** Laravel 13 (PHP), Eloquent, Fortify, Pest
- **Interface:** Livewire 4, Blade, Tailwind CSS 4 e Flux UI
- **Base de dados, cache e filas:** MySQL e Redis, Laravel Horizon
- **Autorização:** Spatie Laravel Permission, policies e gates
- **API:** Laravel Sanctum (tokens pessoais) e API Resources
- **Documentos:** barryvdh/laravel-dompdf
- **Serviços externos:** API do GBIF, Mailtrap
- **Qualidade:** Pint, PHPStan (Larastan)
- **Ferramentas:** Docker, Git, GitHub e GitLab, PhpStorm, VS Code, MySQL Workbench

---

## 👤 Autora

Trabalho desenvolvido por **Cláudia Alfieri**, no âmbito da formação TPSI ATEC.

---

Feito com 🌱, alguns `wire:model` e muitas `php artisan migrate`.
