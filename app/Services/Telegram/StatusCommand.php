<?php

namespace App\Services\Telegram;

use App\Models\Client;

class StatusCommand extends BaseCommand
{
    public function execute(): void
    {
        $keyword = trim($this->text);
        if (empty($keyword)) {
            $this->reply("❌ Guna format: `/status [nama client]`\n\nContoh: `/status terasu`");
            return;
        }

        $clients = Client::where('is_subscription_active', true)
            ->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('company', 'like', "%{$keyword}%")
                  ->orWhere('domain_name', 'like', "%{$keyword}%");
            })
            ->limit(5)
            ->get();

        if ($clients->isEmpty()) {
            $this->reply("❌ Tiada client ditemui untuk *{$keyword}*");
            return;
        }

        $lines = [];
        foreach ($clients as $c) {
            $lines[] = "📌 *{$c->name}*" . ($c->company ? " ({$c->company})" : '');
            if ($c->domain_name) {
                $baki = $c->baki_domain;
                $status = $baki === null ? '' : ($baki < 0 ? ' 🔴 TAMAT' : ($baki <= 7 ? ' 🟡 ' . $baki . ' hari' : " ✅ {$baki} hari"));
                $lines[] = "   🌐 *Domain:* {$c->domain_name}";
                $lines[] = "   📅 Tamat: " . optional($c->domain_expiry_date)->format('d/m/Y') . $status;
            }
            if ($c->hosting_name) {
                $baki = $c->baki_hosting;
                $status = $baki === null ? '' : ($baki < 0 ? ' 🔴 TAMAT' : ($baki <= 7 ? ' 🟡 ' . $baki . ' hari' : " ✅ {$baki} hari"));
                $lines[] = "   🖥️ *Hosting:* {$c->hosting_name}";
                $lines[] = "   📅 Tamat: " . optional($c->hosting_expiry_date)->format('d/m/Y') . $status;
            }
            if ($c->wp_last_plugin_update) {
                $hari = now()->diffInDays($c->wp_last_plugin_update);
                $stat = $hari >= 40 ? ' 🔴 ' . $hari . ' hari' : " ✅ {$hari} hari";
                $lines[] = "   🔌 Plugin: " . $c->wp_last_plugin_update->format('d/m/Y') . $stat;
            }
            $prices = [];
            if ($c->domain_price_sell > 0) $prices[] = "Domain RM{$c->domain_price_sell}";
            if ($c->hosting_price_sell > 0) $prices[] = "Hosting RM{$c->hosting_price_sell}";
            if (!empty($prices)) $lines[] = "   💰 " . implode(' | ', $prices);
            $lines[] = "   🆔 Client #{$c->id}";
            $lines[] = '';
        }

        $this->reply(implode("\n", $lines));
    }
}
