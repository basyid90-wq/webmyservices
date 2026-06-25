# WebMy Services

Sistem portfolio, pengurusan klien, invois, dan e‑commerce untuk entiti freelance/agensi — dibina dengan Laravel 12.

**[https://webmyservices.my](https://webmyservices.my)**

---

## Tech Stack

| Layer | Teknologi |
|-------|-----------|
| Backend | Laravel 12 (PHP 8.2+) |
| Frontend | Inertia.js + React (SPA) |
| Admin Panel | Filament 3.x |
| CSS | Tailwind CSS (Vite) |
| Database | MySQL 8 / MariaDB 10.6 |
| PDF | barryvdh/laravel-dompdf |
| Payment | Bayarcash (FPX) |

---

## Quick Start (Local)

```bash
# 1. Clone
git clone git@github.com:<username>/webmyservices.git
cd webmyservices

# 2. Pasang dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Sediakan database (MySQL) dan kemaskini .env

# 5. Migration + seed
php artisan migrate --seed

# 6. Storage link
php artisan storage:link

# 7. Build frontend + start dev server
npm run dev
php artisan serve
```

Buka `http://localhost:8000` untuk public site.  
Buka `http://localhost:8000/admin` untuk admin panel.

---

## Deployment

Deployment diuruskan automatik oleh **GitHub Actions** (`.github/workflows/deploy.yml`).

```
Push ke main → CI/CD trigger → git pull → composer install → npm run build
→ php artisan migrate → php artisan optimize:clear
```

Tiada langkah manual di VPS diperlukan — kecuali konfigurasi server awal (Nginx, SSL, database).

---

## Dokumentasi

| Fail | Fungsi |
|------|--------|
| [`PRD.md`](PRD.md) | Product requirement — skop penuh feature, database schema, routes |
| [`AGENTS.md`](AGENTS.md) | Rules untuk AI agent yang bekerja dalam projek ini |
| [`PLANNING.md`](PLANNING.md) | Architectural decisions, integration points, folder structure |
| [`TASKS.md`](TASKS.md) | Task tracking — completed features, backlog, technical debt |
| `CHANGELOG.md` | Log perubahan versi *(coming soon)* |

---

## License

Hak milik — projek peribadi.
