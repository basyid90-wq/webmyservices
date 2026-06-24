<?php

namespace App\Services\Telegram;

use App\Models\Client;
use App\Models\Document;
use App\Models\Project;

class StatsCommand extends BaseCommand
{
    public function execute(): void
    {
        $domainAktif = Client::where('is_subscription_active', true)
            ->whereNotNull('domain_name')->count();
        $hostingAktif = Client::where('is_subscription_active', true)
            ->whereNotNull('hosting_name')->count();
        $anggaran = Client::where('is_subscription_active', true)->sum('domain_price_sell')
                  + Client::where('is_subscription_active', true)->sum('hosting_price_sell');
        $totalDocs = Document::count();
        $projekAktif = Project::where('is_published', true)->count();
        $invoisTertunggak = Document::where('doc_type', 'INVOICE')
            ->whereNotIn('status', ['Paid', 'Void'])->count();
        $jumlahTertunggak = Document::where('doc_type', 'INVOICE')
            ->whereNotIn('status', ['Paid', 'Void'])->sum('grand_total');

        $lines = [
            "📊 *Ringkasan Dashboard*",
            "",
            "👥 *Client Aktif*",
            "   🌐 Domain: {$domainAktif}",
            "   🖥️ Hosting: {$hostingAktif}",
            "",
            "💰 *Kewangan*",
            "   📈 Anggaran Pendapatan: RM " . number_format($anggaran, 2),
            "   🧾 Invois Tertunggak: {$invoisTertunggak} (RM " . number_format($jumlahTertunggak, 2) . ")",
            "",
            "📦 *Kandungan*",
            "   📄 Jumlah Dokumen: {$totalDocs}",
            "   🏗️ Projek Aktif: {$projekAktif}",
            "",
            "⏰ _Dijana: " . now()->format('d/m/Y H:i') . "_",
        ];

        $this->reply(implode("\n", $lines));
    }
}
