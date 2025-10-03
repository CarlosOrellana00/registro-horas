# Registro de Horas — Laravel Breeze + Vite

> Simple time-tracking app with user auth, Projects and Work Entries CRUD.  
> Built with **Laravel + Breeze + Vite**, Tailwind, and MySQL.

---

## 🇺🇸 English

### Overview
This project is a small time-tracking system:
- **Auth** (login/register via Breeze)
- **Projects** (CRUD)
- **Work Entries** (CRUD + basic filters)
- UI texts localized to Spanish

### Tech stack
- **PHP ≥ 8.2** (Laravel 12)
- **Composer**
- **Node ≥ 18** (recommended 18/20/22)
- **npm** (or pnpm/yarn)
- **MySQL** (or MariaDB)

### 0) Clone
```bash
git clone https://github.com/<your-user>/registro-horas.git
cd registro-horas

1) Environment
cp .env.example .env
# Edit .env and set your DB_* credentials, e.g.:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=registro_horas
# DB_USERNAME=root
# DB_PASSWORD=
php artisan key:generate

2) Dependencies
composer install
npm install

3) Database
php artisan migrate

4) Development — Run BOTH processes
You must run Laravel (backend) and Vite (frontend dev server).
Open two terminals inside the project:

Terminal A — Laravel
php artisan serve
# -> http://127.0.0.1:8000

Terminal B — Vite
npm run dev
# -> HMR served from http://localhost:5173

If you stop npm run dev, you’ll likely get
Illuminate\Foundation\ViteManifestNotFoundException (or missing CSS/JS).
Keep both processes running during developmen

One-command option (optional)
npm i -D concurrently

package.json:
{
  "scripts": {
    "dev": "vite",
    "build": "vite build",
    "dev:full": "concurrently \"php artisan serve\" \"npm run dev\""
  }
}

Then:
npm run dev:full

5) Production
npm run build       # generates public/build/*
php artisan serve   # or serve under your web server

In production you don’t need npm run dev (Vite dev server).
Just ensure npm run build is executed and public/build/* exists.

Common scripts
npm run dev      # Vite dev server with HMR
npm run build    # Production assets
php artisan serve
php artisan migrate

roubleshooting

ViteManifestNotFoundException → run npm run dev (dev) or npm run build (prod).

Port 5173 already in use → npm run dev -- --port=5174.

CSS/JS don’t update → stop Vite and run npm run dev again; clear browser cache.

DB connection errors → check your .env DB_* variables and that MySQL is running.




