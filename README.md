# Centralized Job Placement and Management System

This repository contains the source code for the Centralized Job Placement and Management System, designed for a university ecosystem. It streamlines the internship and early-career placement workflow using a dual-pipeline architecture, Role-Based Access Control (RBAC), and a dedicated NLP microservice for automated resume parsing and deterministic job matching.

## Architecture & Tech Stack

This project uses a decoupled microservice architecture orchestrated via Docker Compose:
- **Frontend & Backend**: Laravel 11 (PHP 8.5) utilizing Blade, HTML, CSS, and vanilla JavaScript.
- **NLP Microservice**: Flask (Python) with `spaCy` (NER extraction) and `scikit-learn` (TF-IDF matching).
- **Database**: PostgreSQL (capable of storing both relational data and unstructured JSONB resume data).

---

## Prerequisites

Before setting up the project, ensure you have the following installed on your machine:
- **Docker** and **Docker Compose** (Docker Desktop recommended for Windows/Mac)
- **PHP** and **Composer** (Required only for the initial Laravel vendor installation)
- **Node.js** and **npm** (For compiling frontend assets)

---

## Installation & Setup Instructions

All Docker Compose commands must be run from the repository root (the directory containing `docker-compose.yml`).

### 1. Clone the Repository
```bash
git clone <your-repository-url>
cd Centralized-Job-Placement-Management-System
```

### 2. Install Laravel Dependencies
Before starting the Docker containers, you must install the PHP dependencies to pull the Laravel runtime.
```bash
cd backend
composer install
cd ..
```

### 3. Configure Environment Variables
You need to set up the environment variables for your backend so it can talk to the Docker database.

Copy the example environment file inside the `backend` directory:
```bash
cd backend
cp .env.example .env
cd ..
```
Open `backend/.env` and update the database connection variables to match the Docker PostgreSQL container:
```env
DB_CONNECTION=pgsql
DB_HOST=pgsql
DB_PORT=5432
DB_DATABASE=centralized_job_placement
DB_USERNAME=sail
DB_PASSWORD=password
```

### 4. Build and Start the Docker Stack
From the repository root, build the Docker images and start the containers in detached mode. This process will pull PostgreSQL, Laravel, and Python, and automatically install the machine learning dependencies.

```bash
docker compose up -d --build
```
*(Note: You do not need to install Python or spaCy locally on your Windows machine. Docker handles the entire NLP environment perfectly inside its isolated Linux container).*

### 5. Generate Application Key and Run Migrations
Once the containers are up and running, generate the Laravel encryption key and execute the database migrations to build the tables.

```bash
docker compose exec laravel.test php artisan key:generate
docker compose exec laravel.test php artisan migrate
```

### 6. Install Frontend Dependencies and Build Assets
Install the required Node packages for the frontend and build them.
```bash
cd backend
npm install
npm run build
cd ..
```
*(For active frontend development, you can run `npm run dev` inside the `backend` directory).*

---

## Accessing the Services

Once running, the system exposes the following local endpoints:

| Service | Local URL | Description |
|---|---|---|
| **Main Web Application** | [http://localhost:8080](http://localhost:8080) | The primary user interface (Students, Employers, Admins) |
| **NLP Microservice API** | [http://localhost:5001](http://localhost:5001) | Flask backend handling resume parsing and matching |
| **NLP Health Check** | [http://localhost:5001/health](http://localhost:5001/health) | Verifies the NLP microservice is active |

---

## Viewing the Database (pgAdmin / DBeaver)

To visually interact with your database, you can use any free PostgreSQL GUI tool like pgAdmin or DBeaver. 

Because standard Windows machines often run their own background PostgreSQL services on port `5432`, **Docker exposes this project's database on port `5433`** to prevent collisions.

1. Open your GUI tool and create a new **PostgreSQL** connection.
2. Enter the following exact connection details:
   - **Host name/address:** `localhost`
   - **Port:** `5433`
   - **Maintenance Database:** `centralized_job_placement`
   - **Username:** `sail`
   - **Password:** `password`
3. Click "Save". You can now view all your tables, run SQL queries, and see the extracted resume data!

---

## Useful Development Commands

**Running Laravel Artisan commands:**
```bash
docker compose exec laravel.test php artisan db:seed
docker compose exec laravel.test php artisan make:controller UserController
```

**Viewing NLP Service Logs (useful for debugging Python errors):**
```bash
docker compose logs -f nlp-service
```

**Stopping the containers:**
```bash
docker compose stop
```

**Wiping the database and containers completely (Data Reset):**
```bash
docker compose down -v
```
