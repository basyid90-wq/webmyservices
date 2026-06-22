<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Models\User;
use App\Notifications\ExpiryAlert;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckExpiryAlerts extends Command
{
    protected $signature = 'app:check-expiry-alerts';
    protected $description = 'Check domain, hosting, and WP plugin expiry and send notifications';

    public function handle()
    {
        $admin = User::first();
        if (!$admin) return;
        $today = Carbon::today();

        $clients = Client::all();

        foreach ($clients as $client) {

            // Domain expiry checks
            if ($client->domain_expiry_date && $client->domain_name) {
                $expiry = Carbon::parse($client->domain_expiry_date);
                $daysLeft = (int) $today->diffInDays($expiry, false);

                if ($daysLeft < 0) {
                    $admin->notify(new ExpiryAlert('domain_critical', 'critical', $client->name, $client->domain_name, $expiry->format('d/m/Y')));
                } elseif ($daysLeft <= 7) {
                    $admin->notify(new ExpiryAlert('domain_warning', 'warning', $client->name, $client->domain_name, $expiry->format('d/m/Y')));
                } elseif ($daysLeft <= 30) {
                    $admin->notify(new ExpiryAlert('domain_soon', 'soon', $client->name, $client->domain_name, $expiry->format('d/m/Y')));
                }
            }

            // Hosting expiry checks
            if ($client->hosting_expiry_date && $client->hosting_name) {
                $expiry = Carbon::parse($client->hosting_expiry_date);
                $daysLeft = (int) $today->diffInDays($expiry, false);

                if ($daysLeft < 0) {
                    $admin->notify(new ExpiryAlert('hosting_critical', 'critical', $client->name, $client->hosting_name, $expiry->format('d/m/Y')));
                } elseif ($daysLeft <= 7) {
                    $admin->notify(new ExpiryAlert('hosting_warning', 'warning', $client->name, $client->hosting_name, $expiry->format('d/m/Y')));
                } elseif ($daysLeft <= 30) {
                    $admin->notify(new ExpiryAlert('hosting_soon', 'soon', $client->name, $client->hosting_name, $expiry->format('d/m/Y')));
                }
            }

            // WP Plugin overdue
            if ($client->wp_last_plugin_update) {
                $lastUpdate = Carbon::parse($client->wp_last_plugin_update);
                $daysSince = (int) $lastUpdate->diffInDays($today);

                if ($daysSince > 40) {
                    $admin->notify(new ExpiryAlert('plugin', 'plugin', $client->name, '', ''));
                }
            }
        }

        $this->info('Expiry alerts checked.');
    }
}
