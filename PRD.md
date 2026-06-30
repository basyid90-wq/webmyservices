# Product Requirement Document (PRD)

## WebMy Services — Portfolio, Invoicing & E-Commerce System

---

### 1. PROJECT OVERVIEW

**WebMy Services** is a full-stack web application built on **Laravel 12** for a freelance/agency entity to showcase portfolio, manage clients & billing, receive pricing inquiries, and run an e-commerce shop.

| Goal | Description |
|------|-------------|
| Public Portfolio | Showcase completed client projects, services, pricing plans, and collect leads via pricing inquiry form |
| Internal Dashboard | Manage projects, clients, invoices, documents, and shop orders through a modern admin panel (Filament) |
| Invoicing & Documents | Create, track, export professional PDF invoices, quotes, and receipts |
| E-Commerce Shop | Sell digital services/products with cart, checkout, Bayarcash payment gateway |
| Pricing Inquiry System | Modal-based form that collects comprehensive client requirements and saves to Contacts |

**Tech Stack**

| Layer | Technology |
|-------|------------|
| Backend | Laravel 12 (PHP 8.2+) |
| Frontend | Inertia.js + React (SPA) |
| Admin Panel | Filament PHP 3.x |
| CSS | Tailwind CSS via Vite |
| Database | MySQL 8 / MariaDB 10.6 |
| PDF | barryvdh/laravel-dompdf |
| Payment | webimpian/bayarcash-php-sdk |
| Icons | Lucide React (frontend), Heroicons (admin) |

**Deployment Target** – Laragon (local) → shared VPS / cPanel production.

---

### 2. FRONTEND FEATURES (Public Website — Inertia.js + React)

The public site is a single-page application built with **Inertia.js + React** and styled with **Tailwind CSS** (dark theme).

| # | Section | Component | Description |
|---|---------|-----------|-------------|
| 2.1 | **Hero** | `Hero.jsx` | Full-screen hero with headline, CTA buttons (View Our Work, Contact Us), and a fake dashboard preview animation |
| 2.2 | **Trust Bar** | `TrustBar.jsx` | Stats: 50+ Projects Completed, 30+ Happy Clients, 5+ Years Experience |
| 2.3 | **Services** | `Services.jsx` | Grid cards listing services from DB. Each has icon, title, description. |
| 2.4 | **Tech Stack** | `TechStack.jsx` | Logo grid showing technologies used. Managed via Filament. |
| 2.5 | **Portfolio** | `Portfolio.jsx` | Dynamic grid with category filter tabs. Shows thumbnail, category badge, client name. Links to detail page. |
| 2.6 | **Testimonials** | `Testimonials.jsx` | Card grid with client avatar, name, role, 5-star rating, quote. |
| 2.7 | **Pricing Plans** | `Pricing.jsx` + `PricingModal.jsx` | Three-tier pricing cards (Starter/Professional/Enterprise) managed via Filament. Clicking "Choose" opens a modal inquiry form that collects: plan name, full name, company, WhatsApp, email, industry, website goal, reference URLs, content status, additional budget, and notes. Auto-uppercase on name fields. Malaysian phone auto-format. Submissions go to Contacts. |
| 2.8 | **FAQ** | `FAQ.jsx` | Accordion FAQ section (static content). |
| 2.9 | **CTA** | `CTA.jsx` | "Let's Build Your Website" call-to-action with contact button. |
| 2.10 | **Contact** | `ContactSection.jsx` | Contact form (name, email, subject, message) with company info sidebar. |
| 2.11 | **Portfolio Detail** | `ProjectDetail.jsx` | Individual project page with full details. |
| 2.12 | **Terms / Privacy** | `Terms.jsx`, `Privacy.jsx` | Comprehensive legal pages. Terms of Service covers definitions, scope of services, project timelines, client responsibilities, payment terms, refund policy, intellectual property, liability, termination, and governing law. Privacy Policy covers data collection (contact & pricing inquiry forms), cookies (essential vs analytics via consent banner), third-party services (Bayarcash, Google Analytics, Meta Pixel), data retention, security, user rights, and children's privacy. Company details embedded: SSM 202403295472 (RA0118450-H), No 2-2A Taman Desa Pangkor, 32300 Pulau Pangkor, Perak. |
| 2.13 | **Cookie Consent** | `CookieBanner.jsx` + `useCookieConsent.js` | GDPR-compliant bottom banner with Essential (always on) and Analytics (opt-in) toggles. Saves preference to localStorage. Conditionally loads GTM/Meta Pixel only after analytics consent. Footer "Cookie Settings" link reopens banner. |
| 2.15 | **Footer Enhancements** | `Footer.jsx` | Professional footer with SSM registration number (SSM: 202403295472 (RA0118450-H)), FAQ link, social media icons (LinkedIn, GitHub, Facebook), and dynamic payment gateway logos managed via Filament. Services column shows static text list of 6 services offered. Company column links: Portfolio, Maintenance, FAQ, Contact, Terms, Privacy, Cookie Settings. |
| 2.16 | **Maintenance Plans** | `Maintenance.jsx` | Interactive pricing calculator page at `/maintenance`. Slider selects maintenance hours (10–50h). Left card shows traditional freelancer cost (hours × RM 150/h) with strikethrough pricing. Right card shows WebMy Services flat rate (RM 150/month). Auto-calculated savings banner: "Anda Jimat RM X!". Section B lists 6 included features with icons (SSL, uptime monitoring, security updates, analytics reports, Cloudflare CDN, WhatsApp support). CTA button to contact page. |
| 2.17 | **Room Booking (Demo)** | `Booking/Catalog.jsx`, `Booking/Room.jsx`, `Booking/Summary.jsx`, `Booking/Checkout.jsx`, `Booking/Success.jsx` | Demo booking flow: Browse rooms with image cards → Room detail with calendar availability check → Booking summary → Checkout form (customer info, guest count) → Success page. Uses Bayarcash FPX payment. Supports blocked dates and overlapping booking detection. |

**Design:** Dark theme (slate-900/950 background), indigo-400/500 accent, glassmorphism cards (bg-white/5 backdrop-blur), Framer Motion animations.

**Header/Nav:** Fixed top nav with smooth scroll links to sections: Services, Portfolio, Testimonials, Pricing Plans, FAQ + "Get In Touch" CTA.

---

### 3. BACKEND FEATURES (Filament Admin Panel)

Accessible at `/admin`. Navigation groups:

#### 3.1 Frontend Group
| Resource | Model | Description |
|----------|-------|-------------|
| **Projects** | `Project` | CRUD with title, slug, client, category (from ProjectCategory), thumbnail, description, technologies (tags), live URL, completion date, published toggle, sort order |
| **Project Categories** | `ProjectCategory` | CRUD with name, slug, sort order. Used as filter tabs on portfolio page. |
| **Services** | `Service` | CRUD with title, icon (heroicon select), description, sort order |
| **Tech Stacks** | `TechStack` | CRUD with name, logo upload, sort order |
| **Testimonials** | `Testimonial` | CRUD with client name, role, quote, avatar, sort order |
| **Pricing Plans** | `PricingPlan` | CRUD with name, price (RM), period, popular toggle, features (tags input), active toggle, sort order |
| **Contacts** | `Contact` | Read-only list of all inquiries. Fields: plan name (badge), name, company, WhatsApp, email, industry, website goal, content status, additional budget, message, read status. Filter by plan & unread. Labels in Malay. |
| **Payment Logos** | `PaymentLogo` | CRUD with name, image upload (payment-logos directory), is_active toggle, sort_order. Displayed dynamically in Footer. |

#### 3.2 Client Management Group
| Resource | Model | Description |
|----------|-------|-------------|
| **Clients** | `Client` | Full CRUD with comprehensive fields: name, company, PIC, email, phone, website, address, logo, website type, domain details (name, provider, login, cost/sell price, dates), hosting details (name, provider, login, cost/sell price, dates), WP credentials, renew status, subscription active toggle |
| **Invoices** | `Invoice` | CRUD with invoice number (auto), client, project (optional), dates, status (draft/sent/paid/overdue/cancelled), tax, discount, notes. Has repeater for invoice items. PDF download via DomPDF. |
| **Documents** | `Document` | CRUD for quotes, invoices, receipts with auto-generated document numbers. Supports document type conversion (quote→invoice→receipt). Items repeater. Print view. Table row actions: Edit, Delete, Print, Convert. Bulk delete available. |

#### 3.3 Shop Group
| Resource | Model | Description |
|----------|-------|-------------|
| **Categories** | `Shop\Category` | CRUD with name, slug, description, icon, sort order, active toggle |
| **Products** | `Shop\Product` | CRUD with name, slug, description, price, compare price, images, unit, weight, stock, active/featured toggles, sort order |
| **Orders** | `Shop\Order` | Read/manage orders with customer info, line items, payment status, shipping |
| **Customers** | `Shop\Customer` | User management for shop customers |
| **Coupons** | `Shop\Coupon` | CRUD with code, type (percent/fixed), value, min order, max discount, usage limit, expiry |

#### 3.4 Settings
| Page | Description |
|------|-------------|
| **Settings** | Custom Filament page for site-wide configuration (key-value) |

#### 3.5 Booking (Demo) Group
| Resource | Model | Description |
|----------|-------|-------------|
| **Rooms** | `Room` | CRUD with name, slug (auto from name, debounce 250ms), description (RichEditor), price_per_night (RM/night), max_guests (default 2), primary image (FileUpload, 1200×800px), gallery images (multiple FileUpload, 800×600px), amenities (TagsInput), is_active toggle, sort_order |
| **Bookings** | `Booking` | List/manage bookings with booking number (HL-BKG-YYMMDDXXXX), room, customer info, check-in/out dates, adults/kids count, pricing (subtotal/discount/total), payment status (pending/paid/failed/cancelled), payment channel, transaction ID |
| **Blocked Dates** | `BlockedDate` | CRUD to block specific dates per room with reason. Used for maintenance, holidays, or unavailable periods. |

#### 3.6 Dashboard Widgets
- `DashboardStats` – total projects, clients, invoices, contacts
- `PerluRenew` – clients with expiring domain/hosting
- `WpPluginOverdue` – WordPress plugin update status
- `HostingByProvider` – hosting distribution chart
- `ExpiryAlerts` – upcoming expirations
- `LatestContacts` – recent contact inquiries
- `SalesChart` – revenue over time
- `ShopStatsOverview` – shop performance metrics

---

### 4. E-COMMERCE SHOP MODULE

#### 4.1 Features
- Product catalog with category filtering and search
- Shopping cart (session-based)
- Checkout with shipping info collection
- Order management (user + admin dashboards)
- Shipment tracking
- Coupon/discount system
- Bayarcash payment gateway integration

#### 4.2 Shop Routes (`/shop/*`)
| Area | Routes |
|------|--------|
| Public | Catalog, Product detail, Cart (add/update/remove), Checkout, Order success |
| Auth | Login, Register, Logout |
| User Dashboard | Orders list, Order detail, Shipment tracking |
| Admin Dashboard | Dashboard, Orders, Products, Shipping, Payments, Coupons, Customers |

---

### 5. DATABASE SCHEMA (Current)

#### 5.1 `users`
id, name, email, phone, email_verified_at, password, remember_token, timestamps

#### 5.2 `clients`
id, name, company, pic_name, email, phone, website, address, logo, notes, website_type, domain_name, domain_provider_url, domain_login, domain_password, domain_price_cost, domain_price_sell, domain_start_date, domain_expiry_date, hosting_name, hosting_provider_url, hosting_login, hosting_password, hosting_price_cost, hosting_price_sell, hosting_start_date, hosting_expiry_date, wp_login, wp_password, wp_last_plugin_update, status_renew, is_subscription_active, timestamps

#### 5.3 `projects`
id, title, slug, client_id (FK), category, thumbnail, description, technologies (JSON), live_url, completion_date, is_published, sort_order, timestamps

#### 5.4 `project_categories`
id, name, slug, sort_order, timestamps

#### 5.5 `services`
id, title, icon, description, sort_order, timestamps

#### 5.6 `tech_stacks`
id, name, logo, sort_order, timestamps

#### 5.7 `testimonials`
id, client_name, role, quote, avatar, sort_order, timestamps

#### 5.8 `pricing_plans`
id, name, price (decimal), period, popular (bool), features (JSON), sort_order, is_active (bool), timestamps

#### 5.9 `contacts`
id, plan_name, name, company_name, email, whatsapp, subject, industry, website_goal, reference_urls (text), content_status, additional_budget (decimal), message (text), is_read (bool), timestamps

#### 5.10 `invoices` + `invoice_items`
Standard invoice with auto-numbering, line items with description, qty, unit_price, sort_order

#### 5.11 `documents` + `document_items` + `document_counters`
Multi-type documents (QUOTE, INVOICE, RECEIPT) with auto-numbering per type

#### 5.12 `plugins`
id, client_id (FK), plugin_name, version, last_update_at, timestamps

#### 5.13 `site_settings`
id, key (unique), value (text), type, timestamps

#### 5.14 Shop Tables
`shop_categories`, `shop_products`, `shop_carts`, `shop_cart_items`, `shop_orders`, `shop_order_items`, `shipping_providers`, `shipments`, `coupons`

#### 5.15 `payment_logos`
id, name, image (string path), is_active (bool), sort_order, timestamps

#### 5.16 `rooms`
id, name, slug (unique), description (text|null), price_per_night (decimal 10,2), max_guests (int, default 2), image (string|null), images (json|null), amenities (json|null), is_active (bool, default true), sort_order (int, default 0), timestamps

#### 5.17 `blocked_dates`
id, room_id (FK→rooms), date, reason (string|null), timestamps

#### 5.18 `bookings`
id, booking_number (unique, format HL-BKG-YYMMDDXXXX), room_id (FK→rooms), customer_name, customer_email, customer_phone, check_in, check_out, guests_adults (int), guests_kids (int, default 0), total_nights (int), subtotal (decimal), discount (decimal, default 0), total (decimal), status (pending/paid/failed/cancelled), payment_channel (string|null), transaction_id (string|null), paid_at (datetime|null), timestamps

---

### 6. ROUTES

#### Web Routes (`routes/web.php`)
| Method | URL | Name | Handler |
|--------|-----|------|---------|
| GET | `/` | home | HomeController@index |
| GET | `/portfolio` | portfolio | Closure → Portfolio page |
| GET | `/portfolio/{project:slug}` | project.detail | Closure → ProjectDetail |
| GET | `/contact` | contact | HomeController@contact |
| POST | `/contact` | contact.submit | HomeController@contactSubmit |
| POST | `/pricing-inquiry` | pricing.inquiry | HomeController@pricingInquiry |
| GET | `/invoices/{invoice}/pdf` | invoices.pdf | InvoiceController@download |
| GET | `/documents/{document}/print` | documents.print | DocumentController@print |
| POST | `/documents/{document}/convert` | documents.convert | DocumentController@convert |
| GET | `/terms` | terms | Closure → Terms page |
| GET | `/privacy` | privacy | Closure → Privacy page |
| GET | `/maintenance` | maintenance | Closure → Maintenance page |
| GET | `/booking` | booking.catalog | BookingController@catalog |
| GET | `/booking/room/{room:slug}` | booking.room | BookingController@room |
| POST | `/booking/availability/{room}` | booking.availability | BookingController@checkAvailability |
| GET | `/booking/summary` | booking.summary | BookingController@summary |
| GET | `/booking/checkout` | booking.checkout | Closure → Checkout page |
| POST | `/booking/checkout` | booking.checkout.submit | BookingController@checkout |
| GET | `/booking/orders/{booking:booking_number}/success` | booking.success | BookingController@success |

#### Shop Routes (`routes/shop.php`)
Catalog, Product, Cart CRUD, Checkout, Payment callback, Auth (login/register/logout), User dashboard (orders/tracking), Admin dashboard (orders/products/shipping/payments/coupons/customers)

#### Admin Routes (Filament auto)
`/admin` → Dashboard, `/admin/projects`, `/admin/clients`, `/admin/invoices`, `/admin/documents`, `/admin/services`, `/admin/testimonials`, `/admin/tech-stacks`, `/admin/project-categories`, `/admin/pricing-plans`, `/admin/contacts`, `/admin/rooms`, `/admin/bookings`, `/admin/blocked-dates`, `/admin/shop/*`, `/admin/settings`

---

### 7. ARCHITECTURE NOTES

- Frontend uses **Inertia.js + React** with Vite bundling. No Blade views for main pages.
- **Ziggy** provides route names to React via `@/lib/ziggy`.
- Admin panel at `/admin` is Filament 3.x with dark theme, indigo primary color.
- **CSRF**: Axios configured in `bootstrap.js` with XSRF cookie handling.
- **PDF**: DomPDF generates downloadable invoice PDFs.
- **Documents**: Support type workflow (QUOTE → INVOICE → RECEIPT) with auto-numbering.
- **Pricing Modal**: Uses axios directly (not Inertia form) to post to `/pricing-inquiry`, returns JSON, shows success state without page reload.
- **Shop**: Client-side cart (localStorage) for demo purposes, Bayarcash payment, shipment tracking.
- **Cookie Consent**: GDPR-compliant cookie banner with Essential (always on) and Analytics (opt-in) categories. Preferences stored in localStorage. Analytics scripts (GTM, Meta Pixel) load ONLY after user consents. Cart state persists via localStorage. Footer includes "Cookie Settings" link to reopen banner.

---

*Last updated: 22 Jun 2026*
