# PLANNING.md — WebMy Services

## 1. Architecture Overview

```
┌─────────────────────────────────────────────────────────────┐
│                      BROWSER / CLIENT                       │
├───────────────────────────┬─────────────────────────────────┤
│   Public Website (/)      │   Admin Panel (/admin)          │
│   Inertia.js + React SPA  │   Filament 3.x (Blade)          │
│   Tailwind CSS (dark)     │   Tailwind CSS (dark, indigo)   │
│   Framer Motion           │   Heroicons                     │
│   Lucide React icons      │                                 │
└───────────────┬───────────┴──────────────┬──────────────────┘
                │                          │
        Inertia Protocol           Blade / Livewire
     (JSON page props)           (Server-rendered)
                │                          │
                ▼                          ▼
┌─────────────────────────────────────────────────────────────┐
│                    LARAVEL 12 BACKEND                       │
├─────────────────────────────────────────────────────────────┤
│  Controllers (Home, Booking, Invoice, Document, Shop/*)    │
│  Middleware (Auth, Guest, Admin)                            │
│  Filament Resources (Projects, Clients, Invoices, etc.)    │
│  Services (Telegram, Analytics, Cookie Consent)             │
│  Notifications (Email, Telegram Channels)                   │
└───────────────┬─────────────────────────────────────────────┘
                │
        Eloquent ORM
                │
                ▼
┌─────────────────────────────────────────────────────────────┐
│                    MySQL 8 / MariaDB 10.6                   │
│                    18 tables (5.1 – 5.18)                   │
└─────────────────────────────────────────────────────────────┘
```

| Layer | Teknologi | Peranan |
|-------|-----------|---------|
| Client | Inertia.js + React 18 | SPA tanpa full page reload, page props dari server |
| Admin UI | Filament 3.x | CRUD auto-generation, widgets, dark theme |
| Backend | Laravel 12 | Routing, Eloquent ORM, Queue, Validation |
| PDF | barryvdh/laravel-dompdf | Invoice & document PDF generation |
| Payment | webimpian/bayarcash-php-sdk | FPX online banking gateway |
| CSS | Tailwind CSS via Vite | Utility-first styling, dark theme |
| Icons | Lucide React (frontend), Heroicons (admin) | Dual icon sets ikut context |

---

## 2. Key Technical Decisions & Why

| # | Keputusan | Alternatif Yang Ditolak | Sebab Pilih |
|---|-----------|------------------------|-------------|
| 1 | **Inertia.js + React** sebagai frontend SPA | Blade Multi-Page (full reload) | Navigasi lancar tanpa full reload. React ekosistem besar — hooks, Framer Motion, state management flexible. Inertia handle routing server-side tanpa perlu REST API berasingan. |
| 2 | **React** (bukan Vue) | Vue.js, Alpine.js | Developer lebih selesa dengan React. Ekosistem library lebih besar untuk komponen kompleks (Framer Motion, react-hook-form). |
| 3 | **Filament 3.x** sebagai admin panel | Nova (berbayar), custom admin dari scratch | Filament percuma, open-source, CRUD auto-generation, widget system built-in, dark theme support, dan tightly integrated dengan Laravel. Jimat masa pembangunan 70%+ berbanding custom admin. |
| 4 | **MySQL 8** (bukan PostgreSQL) | PostgreSQL, SQLite | MySQL tersedia secara default di semua shared hosting Malaysia. MariaDB backward-compatible. Tak perlu extension khas. |
| 5 | **Tailwind CSS** (bukan Bootstrap) | Bootstrap 5, Material UI | Utility-first — saiz bundle kecil selepas purge. Dark theme custom guna `slate-900/950` dan `indigo-400/500` lebih mudah dengan arbitrary values. |
| 6 | **DomPDF** (bukan wkhtmltopdf) | wkhtmltopdf, Headless Chrome PDF | DomPDF pure PHP — tak perlu binary tambahan di server. Sesuai untuk shared hosting yang tak boleh install binary. |
| 7 | **Bayarcash** (bukan Stripe/PayPal) | Stripe, PayPal, Billplz | Fokus pasaran Malaysia — FPX online banking direct. Lebih rendah transaction fee berbanding gateway antarabangsa. SDK rasmi tersedia (`webimpian/bayarcash-php-sdk`). |
| 8 | **Ziggy** untuk route names di frontend | Manual hardcode URL | Route name sentiasa sync dengan backend. Elak broken link bila route structure berubah. |
| 9 | **Cookie Consent localStorage** (bukan DB) | Store preference di DB | Consent tak perlu server round-trip. localStorage cukup untuk toggle banner visibility. Analytics scripts di-load conditionally berdasarkan localStorage value. |
| 10 | **Shop Cart localStorage** (bukan DB session) | Database cart, Redis session | Fasa demo — localStorage paling ringkas untuk PoC. Senang migrate ke server-side cart bila production-ready. |
| 11 | **Closure routes** untuk page statik | Controller method untuk semua | Page mudah seperti Terms, Privacy, Maintenance tak perlu controller khusus. Kurangkan boilerplate. Namun TASKS.md menanda ini sebagai technical debt (D2). |

---

## 3. Folder Structure (Key Folders Sahaja)

```
webmyservices/
├── .github/workflows/
│   └── deploy.yml                     ← CI/CD GitHub Actions
│
├── app/
│   ├── Console/Commands/              ← Artisan commands
│   ├── Filament/
│   │   ├── Pages/                     ← Custom admin pages (Settings)
│   │   ├── Resources/                 ← Semua CRUD resources (Projects, Clients, Invoices...)
│   │   └── Widgets/                   ← Dashboard widgets (Stats, Charts, Alerts)
│   ├── Http/
│   │   ├── Controllers/               ← HomeController, BookingController, Shop controllers
│   │   └── Middleware/                ← Auth, Guest, Admin middleware
│   ├── Models/
│   │   └── Shop/                      ← Shop-specific models (Category, Product, Order, etc.)
│   ├── Notifications/
│   │   └── Channels/                  ← Custom notification channels (Telegram)
│   ├── Providers/
│   │   └── Filament/                  ← Filament panel provider
│   └── Services/
│       └── Telegram/                  ← Telegram notification service
│
├── config/
│   ├── bayarcash.php                  ← Bayarcash payment gateway config
│   ├── deepseek.php                   ← AI integration config
│   └── telegram.php                   ← Telegram bot config
│
├── database/
│   └── migrations/                    ← Semua migration files (18+ tables)
│
├── resources/
│   └── js/
│       ├── components/
│       │   ├── Booking/               ← Catalog, Room, Summary, Checkout, Success
│       │   ├── sections/              ← Hero, TrustBar, Services, TechStack, Portfolio, Testimonials...
│       │   ├── Shop/                  ← Cart, Checkout, Orders, Products
│       │   ├── ui/                    ← Reusable UI components (buttons, modals, cards)
│       │   ├── CookieBanner.jsx       ← GDPR cookie consent banner
│       │   ├── Footer.jsx             ← Footer dengan SSM details, payment logos
│       │   ├── Header.jsx             ← Fixed top nav dengan smooth scroll
│       │   └── Layout.jsx             ← Shared layout wrapper
│       ├── hooks/
│       │   ├── useCookieConsent.js    ← Cookie consent state management
│       │   └── useShopCart.js         ← localStorage-based cart hook
│       ├── lib/
│       │   ├── analytics.js           ← GTM / Meta Pixel conditional loader
│       │   ├── utils.js               ← Helper functions
│       │   └── ziggy.js               ← Route name bridge (Laravel → React)
│       ├── Pages/
│       │   ├── Booking/               ← Booking flow pages
│       │   ├── Shop/                  ← Shop catalog & user/admin pages
│       │   ├── Home.jsx               ← Landing page utama (semua sections)
│       │   ├── Portfolio.jsx          ← Portfolio grid
│       │   ├── ProjectDetail.jsx      ← Single project detail
│       │   ├── Contact.jsx            ← Contact page
│       │   ├── Terms.jsx              ← Terms of Service
│       │   ├── Privacy.jsx            ← Privacy Policy
│       │   └── Maintenance.jsx        ← Maintenance calculator
│       ├── app.js                     ← Inertia app bootstrap
│       └── app.jsx                    ← React root component
│
├── routes/
│   ├── web.php                        ← Public website routes (landing, portfolio, contact, booking...)
│   ├── shop.php                       ← Shop routes (catalog, cart, checkout, auth, user/admin dashboard)
│   ├── api.php                        ← API routes (if any)
│   └── console.php                    ← Console routes (scheduled tasks)
│
├── booking-dummy/                     ← Room booking dummy data/assets
├── agency-dummy/                      ← Agency dummy data/assets
├── portfolio-webmyservices/           ← Portfolio dummy data/assets
│
├── AGENTS.md                          ← AI agent rules
├── PRD.md                             ← Product requirement document
├── TASKS.md                           ← Task tracking & backlog
├── PLANNING.md                        ← Architectural decisions (fail ini)
└── README.md                          ← Project overview (perlu ditulis semula)
```

---

## 4. Integration Points

### 4.1 Bayarcash (Payment Gateway)
| Aspek | Detail |
|-------|--------|
| SDK | `webimpian/bayarcash-php-sdk` |
| Config | `config/bayarcash.php` |
| Kegunaan | Shop checkout, Room booking checkout |
| Method | FPX online banking (Malaysia) |
| Flow | Client-side cart → POST checkout → Bayarcash API → redirect to bank → callback → update order status |

### 4.2 DOMPDF (PDF Generation)
| Aspek | Detail |
|-------|--------|
| Package | `barryvdh/laravel-dompdf` |
| Kegunaan | Invoice PDF download (`/invoices/{invoice}/pdf`), Document print view (`/documents/{document}/print`) |
| Trigger | Manual download dari Filament admin atau public route |
| Output | PDF file streamed to browser download |

### 4.3 Google Analytics / Meta Pixel (Analytics)
| Aspek | Detail |
|-------|--------|
| Config | `resources/js/lib/analytics.js` |
| Kegunaan | GTM & Meta Pixel scripts |
| Keizinan | Hanya di-load selepas user consent "Analytics" dalam Cookie Banner |
| Storage | `localStorage` key `cookie-consent` |

### 4.4 Telegram (Notifications)
| Aspek | Detail |
|-------|--------|
| Config | `config/telegram.php` |
| Service | `app/Services/Telegram/` |
| Channel | `app/Notifications/Channels/` — custom notification channel |
| Kegunaan | Notifikasi admin (inquiry baru, payment success, error alert) |

### 4.5 DeepSeek AI (AI Integration)
| Aspek | Detail |
|-------|--------|
| Config | `config/deepseek.php` |
| Kegunaan | AI-assisted features (to be defined) |
| Catatan | Belum didokumenkan dalam PRD — perlu clarification |

### 4.6 Ziggy (Route Bridge)
| Aspek | Detail |
|-------|--------|
| Package | `tightenco/ziggy` |
| Config | `resources/js/lib/ziggy.js` (auto-generated) |
| Kegunaan | Laravel named routes accessible di React via `route('home')`, `route('project.detail', { project: slug })` |

### 4.7 GitHub Actions (CI/CD)
| Aspek | Detail |
|-------|--------|
| Workflow | `.github/workflows/deploy.yml` |
| Trigger | Push ke branch utama |
| Langkah | `git pull`, `composer install`, `npm run build`, `php artisan migrate`, `php artisan optimize:clear` |

### 4.8 Vite (Asset Bundling)
| Aspek | Detail |
|-------|--------|
| Config | `vite.config.js` |
| Kegunaan | HMR semasa development, minified build untuk production |
| Plugin | `@vitejs/plugin-react`, Tailwind CSS, Ziggy |

---

## 5. Authentication & Authorization

| Kawasan | Mekanisme | Middleware |
|---------|-----------|------------|
| Public Website | Tetamu (guest) — tiada auth diperlukan | `web` |
| Admin Panel (`/admin`) | Laravel Auth (email + password) | `auth` + Filament |
| Shop Public (`/shop/*`) | Tetamu untuk browse, auth untuk checkout | `web` + `auth` (checkpoint) |
| Shop User Dashboard | Laravel Auth | `auth` |
| Shop Admin Dashboard | Laravel Auth + role | `auth` + `admin` |

**Catatan:** Tiada multi-role system disebut dalam PRD. Semua admin user share Filament panel yang sama. Shop admin routes mungkin guna guard berasingan atau policy-based access.

---

## 6. Deployment Architecture

```
┌──────────────────┐     ┌──────────────────┐     ┌──────────────────┐
│   DEVELOPMENT    │     │       VPS        │     │    SHARED HOST   │
│   Laragon (Win)  │     │   (cPanel/LAMP)  │     │   (cPanel/LAMP)  │
├──────────────────┤     ├──────────────────┤     ├──────────────────┤
│ PHP 8.2+         │     │ PHP 8.2+         │     │ PHP 8.2+         │
│ MySQL 8          │     │ MySQL 8 / Maria  │     │ MySQL 8 / Maria  │
│ Node 20+ (Vite)  │     │ Node 20+ (build) │     │ (build di VPS)   │
│ Composer 2       │     │ Composer 2       │     │ Composer 2       │
├──────────────────┤     ├──────────────────┤     ├──────────────────┤
│ Push → GitHub    │────▶│ GitHub Actions   │────▶│ GitHub Actions   │
│                  │     │ CI/CD deploy.yml │     │ CI/CD deploy.yml │
└──────────────────┘     └──────────────────┘     └──────────────────┘
```

| Environment | Target | URL |
|-------------|--------|-----|
| Local Dev | Laragon | `webmyservices.test` |
| Production | VPS / Shared cPanel | (TBD) |

---

*Last updated: 25 Jun 2026*
