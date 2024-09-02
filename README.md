<div align="center">

# Teamer App

An application designed for efficient team task management. Developed specifically for the recruitment process at AdSite.pro.

[Features](#features) •
[Tools](#tools) •
[Installation](#installation) •
[Documentation](#documentation)

</div>

## Features

- Easily create and manage your own teams within the application, tailored to your project’s needs.

- Invite users to join your teams seamlessly, ensuring the right people are always involved in the right projects.
 
- Add new tasks and assign them to specific team members with just a few clicks, ensuring everyone knows their responsibilities.

- Organize your workflow by creating custom task categories, making it simple to keep track of different types of work.

## Tools
- Backend:
  - [PHP](https://www.php.net/)
  - [Laravel](https://laravel.com/)
  - [Laravel Breeze](https://github.com/laravel/breeze)
  - [PHPUnit](https://phpunit.de/index.html)
- Frontend:
  - [TypeScript](https://www.typescriptlang.org/)
  - [Vue.js](https://vuejs.org/)
  - [Tailwind](https://tailwindcss.com/)
  - [Tanstack Query](https://tanstack.com/)
  - [Shadcn](https://www.shadcn-vue.com/)
- Others:
  - [Docker](https://www.docker.com/)
  - [PostgreSQL](https://www.postgresql.org/)
  - [Turborepo](https://turbo.build/repo/docs)
  
## Installation

1. Clone the repository
```sh
gh repo clone Wojtazzzz/adsite-pro && cd adsite-pro
```

2. Setup env variables and fill them with your custom credentials

Root:
```sh
cp .env.example .env
```
Backend:
```sh
cp apps/api/.env.example apps/api/.env
```
Frontend:
```sh
cp apps/web/.env.example apps/web/.env
```

3. Install backend dependendies and generate app key
```sh
cd apps/api && composer install && php artisan key:generate
```

4. Run migrations and seed table
```
php artisan migrate && php artisan db:seed
```

5. Install frontend dependendies
```sh
cd ../web && pnpm install
```

6. Run docker compose
**Warning!** For convenience postgres default port 5432 is mapped to local 5437
```sh
cd ../../ && docker compose up -d
```

7. Run backend
```sh
cd apps/api && php artisan serve
```

8. Run frontend
```sh
cd ../web && pnpm run dev
```

Now your application runs in:
- backend: http://localhost:8000/
- frontend: http://localhost:5173/
- postgres: on local port 5437

You can login to an auto-generated account with credentials:
email: `john@smith.com`
password: `password`

## Documentation
Database schema: https://drawsql.app/teams/teamer-4/diagrams/teamer-app
