<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Models\User;
use App\Notifications\ExpiryAlert;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckExpiryAlerts extends Command
{
    protected $signature = 'app:check-expiry-alerts';
    protected $description = 'Check domain, hosting, and WP plugin expiry using exact date matching';

    public function handle()
    {
        $admin = User::first();
        if (!$admin) {
            $this->warn('No admin user found. Skipping.');
            return;
        }

        $today = now()->toDateString();
        $base = Client::where('is_subscription_active', true);

        $this->line("Running expiry checks for {$today}...");

        // 1. Domain — already expired (expiry < today)
        $expired = (clone $base)->whereDate('domain_expiry_date', '<', $today)->whereNotNull('domain_name')->get();
        foreach ($expired as $c) {
            $this->send($admin, $c, 'domain_critical', 'critical', $c->domain_name, $c->domain_expiry_date);
        }

        // 2. Domain — exactly 7 days until expiry
        $d7 = (clone $base)->whereDate('domain_expiry_date', '=', now()->addDays(7)->toDateString())->whereNotNull('domain_name')->get();
        foreach ($d7 as $c) {
            $this->send($admin, $c, 'domain_warning', 'warning', $c->domain_name, $c->domain_expiry_date);
        }

        // 3. Domain — exactly 30 days until expiry
        $d30 = (clone $base)->whereDate('domain_expiry_date', '=', now()->addDays(30)->toDateString())->whereNotNull('domain_name')->get();
        foreach ($d30 as $c) {
            $this->send($admin, $c, 'domain_soon', 'soon', $c->domain_name, $c->domain_expiry_date);
        }

        // 4. Hosting — already expired
        $hexpired = (clone $base)->whereDate('hosting_expiry_date', '<', $today)->whereNotNull('hosting_name')->get();
        foreach ($hexpired as $c) {
            $this->send($admin, $c, 'hosting_critical', 'critical', $c->hosting_name, $c->hosting_expiry_date);
        }

        // 5. Hosting — exactly 7 days until expiry
        $h7 = (clone $base)->whereDate('hosting_expiry_date', '=', now()->addDays(7)->toDateString())->whereNotNull('hosting_name')->get();
        foreach ($h7 as $c) {
            $this->send($admin, $c, 'hosting_warning', 'warning', $c->hosting_name, $c->hosting_expiry_date);
        }

        // 6. Hosting — exactly 30 days until expiry
        $h30 = (clone $base)->whereDate('hosting_expiry_date', '=', now()->addDays(30)->toDateString())->whereNotNull('hosting_name')->get();
        foreach ($h30 as $c) {
            $this->send($admin, $c, 'hosting_soon', 'soon', $c->hosting_name, $c->hosting_expiry_date);
        }

        // 7. WP Plugin — exactly 30 days since last update
        $wp30 = (clone $base)->whereDate('wp_last_plugin_update', '=', now()->subDays(30)->toDateString())->get();
        foreach ($wp30 as $c) {
            $this->send($admin, $c, 'plugin_30', 'plugin', '', $c->wp_last_plugin_update);
        }

        // 8. WP Plugin — exactly 40 days since last update
        $wp40 = (clone $base)->whereDate('wp_last_plugin_update', '=', now()->subDays(40)->toDateString())->get();
        foreach ($wp40 as $c) {
            $this->send($admin, $c, 'plugin_40', 'plugin', '', $c->wp_last_plugin_update);
        }

        $total = $expired->count() + $d7->count() + $d30->count()
               + $hexpired->count() + $h7->count() + $h30->count()
               + $wp30->count() + $wp40->count();

        $this->info("Done. {$total} notification(s) sent.");
    }

    private function send($admin, $client, string $type, string $level, string $itemName, $date): void
    {
        $formatted = $date ? Carbon::parse($date)->format('d/m/Y') : '';
        $admin->notify(new ExpiryAlert($type, $level, $client->name, $itemName, $formatted));
        Log::info('ExpiryAlert sent', [
            'type' => $type,
            'client' => $client->name,
            'item' => $itemName,
            'date' => $formatted,
        ]);
    }
}
