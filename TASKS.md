# TASKS.md — WebMy Services

## Legend
✅ Done | 🔄 In Progress | ⏳ Pending | 🐛 Bug | 🔒 On Hold

---

## Active Sprint
_(Kosong — belum diisi)_

---

## Completed Features

### Halaman Awam (Public Website)
| # | Feature | Status |
|---|---------|--------|
| 2.1 | Hero Section — full-screen hero dengan headline, CTA buttons, fake dashboard preview | ✅ |
| 2.2 | Trust Bar — statistik (50+ Projek, 30+ Klien, 5+ Tahun) | ✅ |
| 2.3 | Services Grid — kad servis dinamik dari DB | ✅ |
| 2.4 | Tech Stack — logo grid teknologi dari DB | ✅ |
| 2.5 | Portfolio Grid — kad portfolio dengan category filter tabs + detail page | ✅ |
| 2.6 | Testimonials — kad testimoni dengan avatar, nama, role, rating, quote | ✅ |
| 2.7 | Pricing Plans + Pricing Modal — 3-tier kad + modal inquiry form (auto-uppercase, phone format) | ✅ |
| 2.8 | FAQ — accordion statik | ✅ |
| 2.9 | CTA Section — "Let's Build Your Website" | ✅ |
| 2.10 | Contact Section — form + info sidebar | ✅ |
| 2.11 | Portfolio Detail Page — halaman projek individu | ✅ |
| 2.12 | Terms of Service & Privacy Policy — laman perundangan lengkap dengan SSM details | ✅ |
| 2.13 | Cookie Consent Banner — GDPR-compliant (Essential + Analytics toggle) | ✅ |
| 2.15 | Footer — SSM registration number, dynamic payment logos, social icons, links | ✅ |
| 2.16 | Maintenance Plans Page — kalkulator interaktif (slider jam, perbandingan harga, auto savings) | ✅ |
| 2.17 | Room Booking (Demo) — catalog, room detail, calendar availability, checkout, Bayarcash FPX | ✅ |

### Navigasi & Reka Bentuk
| # | Feature | Status |
|---|---------|--------|
| — | Fixed Top Nav dengan smooth scroll ke semua section | ✅ |
| — | Dark Theme (slate-900/950) + indigo accent + glassmorphism + Framer Motion | ✅ |

### Admin Panel Filament — Kumpulan Frontend
| # | Resource | Status |
|---|----------|--------|
| 3.1 | Projects CRUD — title, slug, client, category, thumbnail, description, tech tags, live URL, completion date, publish toggle | ✅ |
| 3.1 | Project Categories CRUD — name, slug, sort order | ✅ |
| 3.1 | Services CRUD — title, icon (heroicon), description, sort order | ✅ |
| 3.1 | Tech Stacks CRUD — name, logo upload, sort order | ✅ |
| 3.1 | Testimonials CRUD — client name, role, quote, avatar, sort order | ✅ |
| 3.1 | Pricing Plans CRUD — name, price (RM), period, popular toggle, features tags, active toggle | ✅ |
| 3.1 | Contacts — baca sahaja senarai inquiries, filter by plan & unread, label Bahasa Melayu | ✅ |
| 3.1 | Payment Logos CRUD — name, image upload, is_active, sort_order | ✅ |

### Admin Panel Filament — Kumpulan Client Management
| # | Resource | Status |
|---|----------|--------|
| 3.2 | Clients CRUD — comprehensive fields (PIC, domain details, hosting details, WP credentials, renew status) | ✅ |
| 3.2 | Invoices CRUD — auto-numbering, client, project, line items repeater, status, PDF download (DomPDF) | ✅ |
| 3.2 | Documents CRUD — multi-type (QUOTE/INVOICE/RECEIPT), auto-numbering per type, type conversion workflow | ✅ |

### Admin Panel Filament — Kumpulan Shop
| # | Resource | Status |
|---|----------|--------|
| 3.3 | Shop Categories CRUD — name, slug, description, icon, active toggle | ✅ |
| 3.3 | Shop Products CRUD — name, slug, price, compare price, images, stock, featured toggle | ✅ |
| 3.3 | Shop Orders — baca/urus order, line items, payment status, shipping | ✅ |
| 3.3 | Shop Customers — user management untuk pelanggan kedai | ✅ |
| 3.3 | Coupons CRUD — code, type (percent/fixed), value, min order, max discount, usage limit, expiry | ✅ |

### Admin Panel Filament — Settings & Dashboard
| # | Feature | Status |
|---|---------|--------|
| 3.4 | Site Settings — custom Filament page, key-value configuration | ✅ |
| 3.6 | DashboardStats Widget — total projects, clients, invoices, contacts | ✅ |
| 3.6 | PerluRenew Widget — klien dengan domain/hosting tamat tempoh | ✅ |
| 3.6 | WpPluginOverdue Widget — status update plugin WordPress | ✅ |
| 3.6 | HostingByProvider Widget — carta taburan hosting | ✅ |
| 3.6 | ExpiryAlerts Widget — notifikasi tamat tempoh | ✅ |
| 3.6 | LatestContacts Widget — inquiries terkini | ✅ |
| 3.6 | SalesChart Widget — revenue dari masa ke semasa | ✅ |
| 3.6 | ShopStatsOverview Widget — metrik prestasi kedai | ✅ |

### Admin Panel Filament — Kumpulan Booking (Demo)
| # | Resource | Status |
|---|----------|--------|
| 3.5 | Rooms CRUD — name, slug (auto), description (RichEditor), price, max guests, images, amenities, active | ✅ |
| 3.5 | Bookings — senarai/urus tempahan dengan booking number (HL-BKG-YYYYMMDDXXXX), status bayaran | ✅ |
| 3.5 | Blocked Dates CRUD — sekatan tarikh per bilik dengan reason | ✅ |

### E-Commerce Shop Module
| # | Feature | Status |
|---|---------|--------|
| 4.1 | Product Catalog — kategori filter + search | ✅ |
| 4.1 | Shopping Cart — session-based (localStorage) | ✅ |
| 4.1 | Checkout — shipping info collection | ✅ |
| 4.1 | Order Management — user dashboard + admin dashboard | ✅ |
| 4.1 | Shipment Tracking | ✅ |
| 4.1 | Coupon/Discount System | ✅ |
| 4.1 | Bayarcash Payment Gateway Integration | ✅ |
| 4.2 | Shop Auth — Login, Register, Logout | ✅ |

### Route & Infrastruktur
| # | Feature | Status |
|---|---------|--------|
| 6.0 | Web Routes — `/`, `/portfolio`, `/contact`, `/terms`, `/privacy`, `/maintenance`, `/booking/*` | ✅ |
| 6.0 | Shop Routes — `/shop/*` (catalog, cart, checkout, auth, user dashboard) | ✅ |
| 6.0 | API Routes — `routes/api.php` | ✅ |
| 6.0 | Admin Routes — `/admin/*` (semua Filament resources) | ✅ |
| 7.0 | Inertia.js + React SPA dengan Vite | ✅ |
| 7.0 | Ziggy route names ke React | ✅ |
| 7.0 | CSRF Axios configuration | ✅ |
| 7.0 | PDF generation via DomPDF | ✅ |
| 7.0 | Document type conversion workflow (QUOTE → INVOICE → RECEIPT) | ✅ |
| 7.0 | GitHub Actions CI/CD — `.github/workflows/deploy.yml` | ✅ |
| 7.0 | Telegram Notification Service — `app/Services/Telegram/` + custom channel | ✅ |
| 7.0 | DeepSeek AI Integration — `config/deepseek.php` | ✅ |

### Database (18 Tables)
| # | Table | Status |
|---|-------|--------|
| 5.1 | `users` | ✅ |
| 5.2 | `clients` | ✅ |
| 5.3 | `projects` | ✅ |
| 5.4 | `project_categories` | ✅ |
| 5.5 | `services` | ✅ |
| 5.6 | `tech_stacks` | ✅ |
| 5.7 | `testimonials` | ✅ |
| 5.8 | `pricing_plans` | ✅ |
| 5.9 | `contacts` | ✅ |
| 5.10 | `invoices` + `invoice_items` | ✅ |
| 5.11 | `documents` + `document_items` + `document_counters` | ✅ |
| 5.12 | `plugins` | ✅ |
| 5.13 | `site_settings` | ✅ |
| 5.14 | Shop: `categories`, `products`, `carts`, `cart_items`, `orders`, `order_items`, `shipping_providers`, `shipments`, `coupons` | ✅ |
| 5.15 | `payment_logos` | ✅ |
| 5.16 | `rooms` | ✅ |
| 5.17 | `blocked_dates` | ✅ |
| 5.18 | `bookings` | ✅ |

---

## Backlog / Planned
_(Feature yang belum wujud dalam PRD — untuk perancangan masa depan)_

| # | Feature | Keutamaan | Catatan |
|---|---------|-----------|---------|
| B1 | Blog / Articles Section | Rendah | Untuk SEO content marketing |
| B2 | Multi-language Support (BM/EN) | Rendah | Major refactor — tukar semua static text ke translation keys |
| B3 | Email Notification System | Sederhana | Auto-reply untuk contact form, invoice email ke client, booking confirmation |
| B4 | SEO Meta Tags Management | Sederhana | Dynamic title/description per page dari Filament settings |
| B5 | Sitemap.xml Auto-generation | Rendah | Untuk SEO indexing |
| B6 | WhatsApp Business API Integration | Sederhana | Auto-notify bila ada inquiry baru atau payment success |
| B7 | Google Analytics Dashboard dalam Filament | Rendah | Embed GA data terus ke admin dashboard |
| B8 | Automated Database Backup | Sederhana | Daily backup ke cloud storage (S3/DO Spaces) |
| B9 | Activity / Audit Log | Sederhana | Track perubahan admin (siapa buat apa, bila) |
| B10 | Dark/Light Mode Toggle (Public) | Rendah | Buat masa ni dark theme sahaja |
| B11 | Unit & Feature Tests | **Tinggi** | Tiada langsung test suite disebut dalam PRD |
| B12 | ~~CI/CD Pipeline~~ → dipindah ke Completed | — | Wujud di `.github/workflows/deploy.yml` |
| B13 | Invoice Email Sending | Sederhana | PDF invoice auto-attach dan hantar ke client |
| B14 | Client Portal | Rendah | Client login untuk tengok invoice & dokumen sendiri |
| B15 | Receipt Auto-generation upon Payment | Sederhana | Auto-create receipt bila invoice marked as paid |

---

## Known Issues / Bugs
| # | Bug | Severity | Status |
|---|-----|----------|--------|
| — | _(Kosong — akan diisi bila jumpa bug)_ | — | — |

---

## Technical Debt
_(Perkara yang patut di-refactor atau ditambah baik — bukan priority sekarang)_

| # | Item | Impak | Catatan |
|---|------|-------|---------|
| D1 | Shop Cart guna localStorage | Rendah | PRD sebut "demo purposes". Perlu migrate ke server-side cart untuk production. |
| D2 | Beberapa route guna Closure | Rendah | Portfolio, Terms, Privacy, Maintenance, Booking/Checkout route guna closure — patut migrate ke Controller method untuk consistency dan caching. |
| D3 | Pricing Modal guna axios terus | Rendah | Sengaja untuk avoid page reload, tapi bercanggah dengan pattern Inertia form yang digunakan di tempat lain. |
| D4 | Tiada test suite | **Tinggi** | Tiada PHPUnit/Pest test, tiada frontend test. Risiko tinggi untuk regression. |
| D5 | _(dikeluarkan — CI/CD workflow wujud di `.github/workflows/deploy.yml`)_ | — | — |
| D6 | Tiada logging / monitoring | Sederhana | Tiada sebutan Laravel Telescope, Sentry, atau sebarang error tracking. |
| D7 | Tiada rate limiting pada form | Sederhana | Contact form & pricing inquiry form tiada throttling — risiko spam. |
| D8 | Database migrations tak tersenarai penuh dalam PRD | Rendah | PRD hanya senaraikan schema columns, bukan migration filenames. |
