# AGENTS.md

## AI Agent Rules for WebMy Services Project

### 1. ALWAYS UPDATE PRD.md
Setiap kali sebarang perubahan dibuat pada projek (coding, database, feature, UI, flow), **WAJIB kemaskini `PRD.md`** untuk refleksi keadaan semasa. Ini termasuk:
- Tambah feature baru
- Ubah feature sedia ada
- Tukar struktur database
- Tambah/ubah routes
- Tukar UI/UX flow
- Tambah/ubah model, controller, atau resource Filament

### 2. "VIBE CODING" RULE
Apabila aku beri arahan, **JANGAN TERUS BUAT** (kecuali arahan kecil seperti typo fix atau text update). Sebaliknya:

1. **Fahami dulu** apa yang aku nak capai
2. **Cadangkan alternatif** yang lebih baik jika ada
3. **Beritahu kelebihan & kekurangan** setiap pendekatan
4. **Tunggu pengesahan** sebelum mula coding

Contoh flow yang betul:
```
User: "Aku nak tukar semua page guna React"
Agent: "OK, approach yang ada: A) Full SPA guna React Router, B) Kekal Inertia 
tapi tambah lebih React components, C) Hybrid. A lebih modern tapi kena rewrite 
routing. B lebih selamat & faster delivery. C susah maintain. Aku cadang B — nak terus?"
User: "OK B"
Agent: [mula coding]
```

### 3. TECHNOLOGY CONSTRAINTS
- **Laravel 12** + **PHP 8.2+**
- **Inertia.js + React** (frontend SPA)
- **Filament 3.x** (admin panel)
- **MySQL 8** / MariaDB 10.6
- **Tailwind CSS** via Vite
- **DOMPDF** (PDF generation)
- **Bayarcash** (payment gateway)
- JANGAN tambah library/framework baru tanpa bertanya dulu

### 4. USE MCP TOOLS FOR DOCUMENTATION REFERENCE
Sebelum guna mana-mana library/framework/package dalam code, **WAJIB rujuk dokumentasi rasmi** guna tools yang ada:

**`context7`** — Untuk lookup documentation library pihak ketiga:
- Guna `context7_resolve-library-id` untuk dapatkan library ID yang betul
- Kemudian guna `context7_query-docs` untuk search documentation spesifik
- Contoh: nak tahu cara guna Tailwind CSS class tertentu, rujuk Context7 dulu

**`laravel-mcp-companion`** — Untuk lookup Laravel & ecosystem documentation:
- Guna `laravel-mcp-companion_verify_laravel_feature` untuk check feature wujud dalam versi Laravel yang digunakan
- Guna `laravel-mcp-companion_find_laravel_docs_for_need` untuk cari documentation yang relevan dengan task
- Guna `laravel-mcp-companion_search_laravel_docs` untuk search specific keyword
- Guna `laravel-mcp-companion_read_laravel_doc_content` untuk baca full content doc

**WHEN TO USE:**
- Nak tahu best practice untuk implement sesuatu feature → rujuk docs dulu
- Nak tahu ada breaking changes antara versi → guna `compare_laravel_versions`
- Nak guna package baru → cari info guna Context7
- Nak tahu cara setup Filament feature → search Laravel docs
- Nak guna Inertia.js API → Context7

**RULE:** JANGAN agak-agak atau guna training data lama. Sentiasa verify dengan documentation terkini.

### 5. LANGUAGE RULE
- Semua penulisan kod, struktur database, nama fail, nama class, dan teks komponen UI **mesti menggunakan standard Bahasa Inggeris**.
- Semua bentuk analisis, perancangan, penjelasan teknikal, dan komunikasi dengan user **WAJIB 100% dalam Bahasa Melayu**.

### 6. CODE STYLE
- Ikut coding style sedia ada dalam project
- JANGAN tulis comments kecuali diminta
- Guna `edit` tool untuk modify existing files, bukan rewrite seluruh file
- Bila create file baru, ikut naming convention sedia ada

### 7. DEPLOYMENT RULES
- **Default**: Proses build & deployment **diuruskan automatik oleh GitHub Actions (CI/CD)**. Setiap perubahan kod **WAJIB di-push terus ke GitHub** selepas selesai, dan CI/CD akan uruskan `git pull`, `composer install`, `npm run build`, `php artisan migrate`, `php artisan optimize:clear` dan seumpamanya secara automatik di VPS.
- **JANGAN berikan arahan VPS secara default** — kecuali dalam situasi berikut:
  - CI/CD workflow **tidak wujud** atau **gagal** (build error, timeout, etc.)
  - Perubahan memerlukan konfigurasi root server yang CI/CD tak capai (contoh: Nginx server block, create database, SSL cert, `storage:link`, file permission)
  - User secara eksplisit bertanya "apa perlu update di VPS?"
- **Jika perlu arahan VPS**, berikan command yang lengkap dan jelas dalam satu blok (bash).

### 8. BEFORE SUBMITTING
- Run `npm run build` untuk frontend changes
- Run `php artisan optimize:clear` untuk backend changes
- Test flow dari user perspective secara mental

---

*Last updated: 22 Jun 2026*
