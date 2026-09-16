# Centralized Job Placement Management System

A Laravel application with PostgreSQL and a Flask NLP service. The complete development stack runs with Docker Compose.

## Stack

- Laravel 13.31 / PHP 8.5 inside Laravel Sail
- HTML, CSS, and JavaScript frontend served by Laravel Blade
- PostgreSQL 18
- Flask 3.0.3 NLP service
- Docker Desktop
- Vite for frontend asset bundling and development
- Tailwind CSS 4, available through the existing Vite setup

## Requirements For A New Machine

Install these tools before setup:

- Git
- Docker Desktop with the Linux containers backend and WSL 2 enabled on Windows
- PowerShell, Command Prompt, Git Bash, or WSL2
- Composer 2.x and PHP 8.3+ if `backend/vendor` is not included in the checkout
- Node.js and npm for building the HTML, CSS, and JavaScript assets with Vite
- pgAdmin is optional and is only needed for a graphical database interface

After installing Docker Desktop, start it and wait until Docker reports that it is running.

## First-Time Setup

All Docker Compose commands must be run from the repository root, the directory containing `docker-compose.yml`.

```powershell
cd "C:\path\to\Centralized-Job-Placement-Management-System"
```

### 1. Prepare Laravel dependencies

The repository must contain the Laravel dependencies before the Docker image can be built because the Compose file uses the Sail runtime at `backend/vendor/laravel/sail/runtimes/8.5`.

If `backend/vendor` is missing, install the dependencies from the `backend` directory:

```powershell
cd backend
composer install
composer require laravel/sail --dev
php artisan sail:install
cd ..
```

When Sail asks for services, select `pgsql`.

If `backend/vendor` already exists and contains `laravel/sail`, skip the Composer commands. Do not run `php artisan sail:install` repeatedly unless Sail has not been installed.

### 2. Configure the root environment

Create a file named `.env` in the repository root, beside `docker-compose.yml`. Use these local development values:

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=pgsql
DB_HOST=pgsql
DB_PORT=5432
DB_DATABASE=centralized_job_placement
DB_USERNAME=sail
DB_PASSWORD=password

WWWGROUP=33
WWWUSER=1000

VITE_PORT=5173
APP_PORT=8080
NLP_PORT=5001
FLASK_ENV=production
FORWARD_DB_PORT=5432
SAIL_XDEBUG_MODE=off
SAIL_XDEBUG_CONFIG=client_host=host.docker.internal
```

The Laravel application also needs matching database values in `backend/.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=pgsql
DB_PORT=5432
DB_DATABASE=centralized_job_placement
DB_USERNAME=sail
DB_PASSWORD=password
```

Generate an application key if `backend/.env` does not already have one:

```powershell
docker compose run --rm laravel.test php artisan key:generate
```

### 3. Validate and start the stack

From the repository root:

```powershell
docker compose config --quiet
docker compose up -d
```

The first startup may take several minutes while Docker builds the Laravel and NLP images.

### 4. Run migrations

```powershell
docker compose exec laravel.test php artisan migrate --force
```

## URLs And Ports

| Service | URL or port | Purpose |
|---|---:|---|
| Laravel application | http://localhost:8080 | Main web application |
| NLP service | http://localhost:5001 | Host access to Flask API |
| NLP health check | http://localhost:5001/health | Confirms the NLP service is responding |
| Vite | http://localhost:5173 | Development server for CSS and JavaScript assets |
| PostgreSQL | localhost:5432 | Database connections from Windows tools |

Port `8080` is used because port `80` may already be occupied by WAMP or another web server. If port `8080` is also occupied, change `APP_PORT` in the root `.env`, then recreate the containers:

```powershell
docker compose down
docker compose up -d
```

## Verify The Installation

Check container status:

```powershell
docker compose ps
```

Expected services:

- `laravel.test` running
- `pgsql` running and healthy
- `nlp-service` running

Check Laravel:

```powershell
docker compose exec laravel.test php artisan --version
docker compose exec laravel.test php artisan about
```

Check the NLP service:

```powershell
Invoke-WebRequest -UseBasicParsing http://localhost:5001/health
```

Open the Laravel application at http://localhost:8080.

## Frontend Development

The frontend uses standard HTML, CSS, and JavaScript. Laravel Blade templates are stored in `backend/resources/views`, while frontend assets are stored in:

```text
backend/resources/views/   HTML/Blade pages
backend/resources/css/     CSS stylesheets
backend/resources/js/      JavaScript modules
```

The existing `backend/package.json` provides Vite, the Laravel Vite plugin, and Tailwind CSS. It does not require React, Vue, or another frontend framework.

Install frontend packages from the `backend` directory if `backend/node_modules` is missing:

```powershell
cd backend
npm install
```

Build production assets:

```powershell
npm run build
```

Run the Vite development server:

```powershell
npm run dev
```

When using Docker, the Laravel application remains available at http://localhost:8080. Vite uses port `5173` for live asset development when it is running.

## Database Access

### From the PostgreSQL container

```powershell
docker compose exec pgsql psql -U sail -d centralized_job_placement
```

Useful `psql` commands:

```sql
\dt
\d users
SELECT * FROM users;
\q
```

### From pgAdmin, DBeaver, or TablePlus

Use these connection settings:

```text
Host: localhost
Port: 5432
Database: centralized_job_placement
Username: sail
Password: password
```

Use `localhost` from Windows. The hostname `pgsql` only works between containers on the Docker network.

## Common Laravel Commands

Run Artisan commands inside the Laravel container:

```powershell
docker compose exec laravel.test php artisan migrate
docker compose exec laravel.test php artisan migrate:fresh --seed
docker compose exec laravel.test php artisan route:list
docker compose exec laravel.test php artisan tinker
docker compose exec laravel.test php artisan test
```

Run Composer inside the container:

```powershell
docker compose exec laravel.test composer install
docker compose exec laravel.test composer update
```

The Windows `backend/vendor/bin/sail` wrapper is available, but using the root `docker compose` commands is recommended for this project because the root Compose file also starts the NLP service.

## Stop And Restart

Stop containers without deleting database data:

```powershell
docker compose stop
```

Start them again:

```powershell
docker compose start
```

Stop and remove containers and the network:

```powershell
docker compose down
```

The named PostgreSQL volume is retained by `docker compose down`.

To remove the database volume too, which permanently deletes local database data:

```powershell
docker compose down -v
```

## Troubleshooting

### Docker says variables are unset

Make sure the terminal is in the repository root and that the root `.env` exists beside `docker-compose.yml`:

```powershell
Get-Location
Test-Path .env
docker compose config --quiet
```

### `WWWGROUP` is not a valid group ID

Use the root Compose file from the repository root. Its `WWWGROUP` build argument is numeric. Do not start the generated `backend/compose.yaml` when you intend to run the complete stack.

### Laravel opens WAMP instead

WAMP is probably using port 80. This project uses port 8080 by default. Open:

```text
http://localhost:8080
```

### PostgreSQL connection fails

Check that PostgreSQL is healthy:

```powershell
docker compose ps
```

Then confirm that `DB_HOST=pgsql` is used in `backend/.env`. Laravel must use the Docker service name `pgsql`, not `localhost`.

### Sail reports a Bash path error on Windows

Use the root Compose commands instead:

```powershell
docker compose up -d
docker compose ps
```

The project path contains spaces, so direct Sail wrapper execution can depend on the installed Bash environment.

## Project Layout

```text
.
├── docker-compose.yml       # Complete Laravel + PostgreSQL + NLP stack
├── .env                     # Root Docker Compose variables
├── backend/                 # Laravel application
│   ├── artisan
│   ├── composer.json
│   ├── compose.yaml         # Generated Laravel-only Sail file
│   └── vendor/
└── nlp-service/             # Flask NLP microservice
    ├── app.py
    ├── Dockerfile
    └── requirements.txt
```
