# 🎥 Laravel Movies API

Projeto Laravel para gerenciar usuários, convites, favoritos de filmes/séries (via OMDb API), avaliações e permissões de usuários.

---

## 🚀 Tecnologias

- Laravel 10+
- Sanctum (Auth API)
- MySQL
- OMDb API
- Docker

---

## 📆 Como rodar

### ✅ Com Docker

1. Copie o arquivo `.env.example` para `.env` e configure a conexão com o banco.
2. Rode:

```bash
docker-compose up -d
```

3. Acesse o container:

```bash
docker exec -it app bash
```

4. Dentro do container, execute:

```bash
composer install
php artisan migrate --seed
php artisan key:generate
php artisan serve
```

---

### ✅ Sem Docker (modo local)

1. Instale as dependências:

```bash
composer install
```

2. Crie o banco e configure `.env`

3. Execute as migrations e seeders:

```bash
php artisan migrate --seed
```

4. Gere a chave:

```bash
php artisan key:generate
```

5. Rode o servidor local:

```bash
php artisan serve
```

---

## 🔐 Autenticação

- Login e registro com Sanctum
- Convites só podem ser enviados por administradores
- Algumas rotas requerem autenticação (token Bearer)

---

## 📡 Endpoints da API

### 📌 Autenticação

| Método | Rota                 | Ação                        |
|--------|----------------------|-----------------------------|
| POST   | `/auth/register`     | Registrar usuário           |
| POST   | `/auth/login`        | Login do usuário            |
| POST   | `/auth/logout`       | Logout                      |
| POST   | `/auth/sendInvite`   | Enviar convite (Admin)      |
| POST   | `/auth/reset`        | Enviar e-mail de reset      |
| POST   | `/auth/reset/confirm`| Redefinir senha             |

---

### 👤 Usuário

| Método | Rota                     | Ação                              |
|--------|--------------------------|-----------------------------------|
| GET    | `/user`                  | Info do usuário autenticado       |
| PUT    | `/users/{id}/role`       | Alterar permissão (Admin)         |

---

### 🎮 Filmes / Séries (OMDb)

| Método | Rota                   | Ação                                  |
|--------|------------------------|---------------------------------------|
| GET    | `/movies/search`       | Buscar por título                     |
| POST   | `/movies/favorite`     | Adicionar aos favoritos               |
| GET    | `/movies/favorites`    | Listar favoritos do usuário           |
| DELETE | `/movies/favorite/{id}`| Remover dos favoritos                 |

---

### 📝 Avaliações

| Método | Rota                    | Ação                                 |
|--------|-------------------------|--------------------------------------|
| POST   | `/reviews`              | Criar avaliação                      |
| GET    | `/reviews/{title}`      | Listar avaliações de um título       |
| DELETE | `/reviews/{id}`         | Deletar avaliação (dono/Admin)       |

---

## ⏱️ Jobs e Tarefas Programadas

- Envio de convite por job
- Cache de filmes populares via Job programado
- Limpeza de convites expirados
- Limpeza de avaliações antigas ou de usuários inativos

---

## 🐳 Docker (docker-compose.yml)

```yaml
version: '3.8'

services:
  app:
    build:
      context: .
    container_name: app
    volumes:
      - .:/var/www
    ports:
      - 8000:8000
    depends_on:
      - db
    working_dir: /var/www
    command: >
      sh -c "composer install &&
             php artisan migrate --seed &&
             php artisan serve --host=0.0.0.0 --port=8000"

  db:
    image: mysql:5.7
    container_name: db
    restart: unless-stopped
    environment:
      MYSQL_DATABASE: laravel
      MYSQL_USER: user
      MYSQL_PASSWORD: secret
      MYSQL_ROOT_PASSWORD: root
    ports:
      - 3306:3306
    volumes:
      - db_data:/var/lib/mysql

volumes:
  db_data:
```

---

## ✅ Usuário Padrão

| Email            | Senha |
|------------------|-------|
| admin@admin.com  | 123   |

---

Qualquer dúvida ou melhoria, sinta-se à vontade para contribuir! 🎉

