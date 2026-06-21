<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Document;
use App\Models\DocumentItem;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Plugin;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'basyid90@gmail.com',
            'password' => bcrypt('901022aspura'),
        ]);

        ProjectCategory::create(['name' => 'Web App', 'slug' => 'web-app', 'sort_order' => 1]);
        ProjectCategory::create(['name' => 'E-Commerce', 'slug' => 'e-commerce', 'sort_order' => 2]);
        ProjectCategory::create(['name' => 'Landing Page', 'slug' => 'landing-page', 'sort_order' => 3]);
        ProjectCategory::create(['name' => 'Branding', 'slug' => 'branding', 'sort_order' => 4]);

        Service::create(['title' => 'Web Development', 'icon' => 'heroicon-o-code-bracket', 'description' => 'Custom web applications built with modern technologies including Laravel, Vue.js, and React.', 'sort_order' => 1]);
        Service::create(['title' => 'UI/UX Design', 'icon' => 'heroicon-o-paint-brush', 'description' => 'Beautiful, intuitive interfaces designed to delight users and drive engagement.', 'sort_order' => 2]);
        Service::create(['title' => 'SEO Optimization', 'icon' => 'heroicon-o-magnifying-glass', 'description' => 'Data-driven SEO strategies to improve search rankings and drive organic traffic.', 'sort_order' => 3]);

        // Client 1: WordPress + domain + hosting (aktif, domain expiring soon)
        $acme = Client::create([
            'name' => 'John Smith',
            'company' => 'Acme Corp',
            'email' => 'john@acmecorp.com',
            'phone' => '555-0101',
            'website' => 'https://acmecorp.com',
            'address' => '100 Main St, New York, NY 10001',
            'website_type' => 'wordpress',
            'domain_name' => 'acmecorp.com',
            'domain_provider_url' => 'https://www.exabytes.my',
            'domain_login' => 'john_acme',
            'domain_password' => 'domP@ss1',
            'domain_price_cost' => 35.00,
            'domain_price_sell' => 80.00,
            'domain_start_date' => now()->subYear(),
            'domain_expiry_date' => now()->addDays(20),
            'hosting_name' => 'Exabytes',
            'hosting_provider_url' => 'https://billing.exabytes.my',
            'hosting_login' => 'john_acme',
            'hosting_password' => 'hostP@ss1',
            'hosting_price_cost' => 250.00,
            'hosting_price_sell' => 500.00,
            'hosting_start_date' => now()->subYear(),
            'hosting_expiry_date' => now()->addDays(60),
            'wp_login' => 'admin',
            'wp_password' => 'wpP@ss1',
            'wp_last_plugin_update' => now()->subDays(50),
            'status_renew' => 'aktif',
            'is_subscription_active' => true,
        ]);

        Plugin::create(['client_id' => $acme->id, 'plugin_name' => 'Yoast SEO', 'version' => '21.0', 'last_update_at' => now()->subDays(50)]);
        Plugin::create(['client_id' => $acme->id, 'plugin_name' => 'WooCommerce', 'version' => '8.5.2', 'last_update_at' => now()->subDays(55)]);
        Plugin::create(['client_id' => $acme->id, 'plugin_name' => 'Elementor', 'version' => '3.19.0', 'last_update_at' => now()->subDays(45)]);

        // Client 2: WordPress + hosting only (sudah_renew)
        $techstart = Client::create([
            'name' => 'Sarah Johnson',
            'company' => 'TechStart Inc',
            'email' => 'sarah@techstart.io',
            'phone' => '555-0102',
            'website' => 'https://techstart.io',
            'address' => '200 Innovation Dr, San Francisco, CA 94105',
            'website_type' => 'wordpress',
            'domain_name' => 'techstart.io',
            'domain_provider_url' => 'https://www.namecheap.com',
            'domain_login' => 'sarah_ts',
            'domain_password' => 'domP@ss2',
            'domain_price_cost' => 45.00,
            'domain_price_sell' => 95.00,
            'domain_start_date' => now()->subYears(2),
            'domain_expiry_date' => now()->addYears(1),
            'hosting_name' => 'SiteGround',
            'hosting_provider_url' => 'https://my.siteground.com',
            'hosting_login' => 'sarah_ts',
            'hosting_password' => 'hostP@ss2',
            'hosting_price_cost' => 350.00,
            'hosting_price_sell' => 700.00,
            'hosting_start_date' => now()->subYear(),
            'hosting_expiry_date' => now()->addDays(30),
            'wp_login' => 'sarah_admin',
            'wp_password' => 'wpP@ss2',
            'wp_last_plugin_update' => now()->subDays(10),
            'status_renew' => 'aktif',
            'is_subscription_active' => true,
        ]);

        Plugin::create(['client_id' => $techstart->id, 'plugin_name' => 'Jetpack', 'version' => '13.2', 'last_update_at' => now()->subDays(10)]);
        Plugin::create(['client_id' => $techstart->id, 'plugin_name' => 'Contact Form 7', 'version' => '5.9.3', 'last_update_at' => now()->subDays(8)]);

        // Client 3: Custom website + domain only (tamat)
        $digitaledge = Client::create([
            'name' => 'Mike Chen',
            'company' => 'DigitalEdge',
            'email' => 'mike@digitaledge.co',
            'phone' => '555-0103',
            'website' => 'https://digitaledge.co',
            'address' => '300 Tech Park, Austin, TX 73301',
            'website_type' => 'custom',
            'domain_name' => 'digitaledge.co',
            'domain_provider_url' => 'https://www.godaddy.com',
            'domain_login' => 'mike_de',
            'domain_password' => 'domP@ss3',
            'domain_price_cost' => 40.00,
            'domain_price_sell' => 85.00,
            'domain_start_date' => now()->subYears(1)->subMonths(2),
            'domain_expiry_date' => now()->subDays(10),
            'status_renew' => 'tamat',
            'is_subscription_active' => false,
        ]);

        Project::create(['title' => 'E-Commerce Platform Redesign', 'slug' => 'ecommerce-platform-redesign', 'client_id' => $acme->id, 'category' => 'Web Development', 'description' => 'Complete redesign of the e-commerce platform with modern UI and improved performance.', 'technologies' => ['Laravel', 'Vue.js', 'Tailwind CSS', 'MySQL'], 'live_url' => 'https://acmecorp.com/shop', 'completion_date' => now()->subMonths(2), 'is_published' => true, 'sort_order' => 1]);
        Project::create(['title' => 'SaaS Dashboard UI', 'slug' => 'saas-dashboard-ui', 'client_id' => $techstart->id, 'category' => 'UI/UX Design', 'description' => 'Modern analytics dashboard with real-time data visualization.', 'technologies' => ['React', 'TypeScript', 'Chart.js', 'Tailwind CSS'], 'live_url' => 'https://techstart.io/dashboard', 'completion_date' => now()->subMonth(), 'is_published' => true, 'sort_order' => 2]);
        Project::create(['title' => 'SEO & Content Strategy', 'slug' => 'seo-content-strategy', 'client_id' => $digitaledge->id, 'category' => 'SEO Optimization', 'description' => 'Comprehensive SEO audit and content strategy resulting in 200% organic traffic increase.', 'technologies' => ['WordPress', 'Google Analytics', 'SEMrush', 'Yoast SEO'], 'live_url' => 'https://digitaledge.co/blog', 'completion_date' => now()->subMonths(3), 'is_published' => true, 'sort_order' => 3]);

        Testimonial::create(['client_name' => 'John Smith', 'role' => 'CEO, Acme Corp', 'quote' => 'WebMy Services delivered an exceptional e-commerce platform that exceeded our expectations.', 'sort_order' => 1]);

        $invoice = Invoice::create(['client_id' => $acme->id, 'project_id' => 1, 'issue_date' => now()->subDays(30), 'due_date' => now()->addDays(15), 'status' => 'sent', 'tax_rate' => 10, 'discount' => 0, 'notes' => 'Payment is due within 15 days. Bank transfer or credit card accepted.']);
        InvoiceItem::create(['invoice_id' => $invoice->id, 'description' => 'Frontend Development - E-Commerce Platform', 'quantity' => 80, 'unit_price' => 75.00, 'sort_order' => 1]);
        InvoiceItem::create(['invoice_id' => $invoice->id, 'description' => 'Backend API Development & Integration', 'quantity' => 60, 'unit_price' => 100.00, 'sort_order' => 2]);

        // Sample Document (QUOTE)
        $quote = Document::create(['doc_type' => 'QUOTE', 'doc_date' => now()->subDays(14), 'valid_until' => now()->addDays(16), 'status' => 'Draft', 'client_id' => $techstart->id, 'bill_to_name' => $techstart->name, 'bill_to_email' => $techstart->email, 'bill_to_phone' => $techstart->phone, 'notes' => 'Quotation untuk servis hosting & maintenance.', 'tax_percent' => 6.00]);
        DocumentItem::create(['document_id' => $quote->id, 'item_desc' => 'Hosting Renewal - SiteGround (1 Tahun)', 'qty' => 1, 'unit_price' => 700.00, 'line_discount' => 0, 'line_total' => 700.00, 'sort_order' => 1]);
        DocumentItem::create(['document_id' => $quote->id, 'item_desc' => 'Domain Renewal - techstart.io (1 Tahun)', 'qty' => 1, 'unit_price' => 95.00, 'line_discount' => 0, 'line_total' => 95.00, 'sort_order' => 2]);
        $quote->load('items'); $quote->save();

        // Sample Document (INVOICE)
        $docInvoice = Document::create(['doc_type' => 'INVOICE', 'doc_date' => now()->subDays(7), 'due_date' => now()->addDays(7), 'status' => 'Issued', 'client_id' => $acme->id, 'bill_to_name' => $acme->name, 'bill_to_email' => $acme->email, 'bill_to_phone' => $acme->phone, 'notes' => 'Bayaran dalam masa 14 hari.', 'discount_amount' => 50.00, 'tax_percent' => 6.00]);
        DocumentItem::create(['document_id' => $docInvoice->id, 'item_desc' => 'Domain Renewal - acmecorp.com', 'qty' => 1, 'unit_price' => 80.00, 'line_discount' => 0, 'line_total' => 80.00, 'sort_order' => 1]);
        DocumentItem::create(['document_id' => $docInvoice->id, 'item_desc' => 'Hosting Renewal - Exabytes', 'qty' => 1, 'unit_price' => 500.00, 'line_discount' => 0, 'line_total' => 500.00, 'sort_order' => 2]);
        DocumentItem::create(['document_id' => $docInvoice->id, 'item_desc' => 'Plugin Update & Maintenance', 'qty' => 2, 'unit_price' => 150.00, 'line_discount' => 0, 'line_total' => 300.00, 'sort_order' => 3]);
        $docInvoice->load('items'); $docInvoice->save();
    }
}
