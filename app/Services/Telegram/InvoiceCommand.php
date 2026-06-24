<?php

namespace App\Services\Telegram;

use App\Models\Client;
use App\Models\Document;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class InvoiceCommand extends BaseCommand
{
    public function execute(): void
    {
        preg_match('/^(\d+)/', trim($this->text), $m);
        $clientId = (int) ($m[1] ?? 0);

        if (!$clientId) {
            $this->reply("❌ Guna format: `/inv buat [client_id]`\n\nContoh: `/inv buat 3`");
            return;
        }

        $client = Client::where('is_subscription_active', true)->find($clientId);
        if (!$client) {
            $this->reply("❌ Client #{$clientId} tidak dijumpai atau tidak aktif.");
            return;
        }

        $items = [];
        if ($client->domain_price_sell > 0 && $client->domain_name) {
            $items[] = [
                'item_desc' => "Domain Renewal: {$client->domain_name}",
                'qty' => 1,
                'unit_price' => $client->domain_price_sell,
                'line_discount' => 0,
                'line_total' => $client->domain_price_sell,
                'sort_order' => 1,
            ];
        }
        if ($client->hosting_price_sell > 0 && $client->hosting_name) {
            $items[] = [
                'item_desc' => "Hosting Renewal: {$client->hosting_name}",
                'qty' => 1,
                'unit_price' => $client->hosting_price_sell,
                'line_discount' => 0,
                'line_total' => $client->hosting_price_sell,
                'sort_order' => 2,
            ];
        }

        if (empty($items)) {
            $this->reply("❌ Tiada harga ditetapkan untuk {$client->name}.\nSila tetapkan *domain_price_sell* atau *hosting_price_sell* di dashboard.");
            return;
        }

        $subtotal = array_sum(array_column($items, 'line_total'));

        $doc = Document::create([
            'doc_type' => 'INVOICE',
            'doc_date' => now(),
            'due_date' => now()->addDays(14),
            'status' => 'Draft',
            'client_id' => $client->id,
            'bill_to_name' => $client->pic_name ?? $client->name,
            'bill_to_email' => $client->email,
            'bill_to_phone' => $client->phone,
            'bill_to_address' => $client->address,
            'currency' => 'MYR',
        ]);

        foreach ($items as $i => $data) {
            $doc->items()->create($data);
        }

        // Trigger saving hook to recalculate
        $doc->save();

        // Generate PDF
        $doc->load('items', 'client');
        $pdf = Pdf::loadView('pdf.document', ['document' => $doc]);
        $fileName = "{$doc->doc_no}.pdf";
        $dir = storage_path('app/temp');
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        $filePath = "{$dir}/{$fileName}";
        file_put_contents($filePath, $pdf->output());

        $caption = "✅ *Invois Dijana*\n\n"
                 . "📄 {$doc->doc_no}\n"
                 . "👤 {$client->name}\n"
                 . "💰 RM " . number_format($doc->grand_total, 2) . "\n"
                 . "📅 Due: " . $doc->due_date->format('d/m/Y');

        $this->sendDocument($filePath, $caption);
        unlink($filePath);
    }
}
