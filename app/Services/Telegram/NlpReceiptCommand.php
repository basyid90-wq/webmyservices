<?php

namespace App\Services\Telegram;

use App\Models\RentalReceipt;
use Barryvdh\DomPDF\Facade\Pdf;

class NlpReceiptCommand extends BaseCommand
{
    private string $rawText;

    public function __construct(int $chatId)
    {
        parent::__construct('', $chatId);
    }

    public function execute(string $rawText = ''): void
    {
        $this->rawText = $rawText;
        if (empty(trim($rawText))) return;

        $this->reply('⏳ Memproses mesej anda... Sila tunggu sebentar.');

        $ai = new DeepSeekAIService;
        $data = $ai->parseReceipt($rawText);

        if (!$data) {
            $this->reply(
                "❌ Maaf, tidak dapat memahami mesej.\n\n"
                . "Sila hantar dalam format seperti:\n"
                . "*Nama Telefon Unit Harga Tarikh*\n\n"
                . "Contoh:\n"
                . "`22-23/4/2026 Masrina +6018-2384123 2 Skuter rm80`"
            );
            return;
        }

        // Validasi minimum
        if (empty($data['customer_name']) || empty($data['customer_phone']) || empty($data['items'])) {
            $this->reply("❌ Data tidak lengkap. Pastikan ada nama, nombor telefon, dan item sewaan.");
            return;
        }

        // Cipta RentalReceipt
        $receipt = RentalReceipt::create([
            'customer_name' => $data['customer_name'],
            'customer_phone' => $data['customer_phone'],
            'payment_method' => 'cash',
            'deposit_amount' => $data['deposit_amount'],
        ]);

        foreach ($data['items'] as $item) {
            $receipt->items()->create($item);
        }

        // Trigger ulang kira total & baki
        $receipt->refresh()->save();

        // Jana PDF
        $receipt->load('items');
        $pdf = Pdf::loadView('pdf.rental-receipt-dompdf', ['receipt' => $receipt]);
        $fileName = "{$receipt->receipt_number}.pdf";
        $dir = storage_path('app/temp');
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        $filePath = "{$dir}/{$fileName}";
        file_put_contents($filePath, $pdf->output());

        // Hantar PDF ke Telegram
        $caption = "✅ *Resit Dijana*\n\n"
                 . "📄 {$receipt->receipt_number}\n"
                 . "👤 {$receipt->customer_name}\n"
                 . "📞 {$receipt->customer_phone}\n";

        $itemSummary = collect($data['items'])->map(function ($i) {
            $cat = match ($i['category']) {
                'scooter' => '🛵', 'motorcycle' => '🏍️', 'car' => '🚗', 'homestay' => '🏠', default => '📦'
            };
            return "{$cat} {$i['quantity']}x {$i['model_unit']} | {$i['duration_days']} Hari | RM {$i['total_price']}";
        })->implode("\n");

        $caption .= "\n{$itemSummary}\n\n"
                 . "💰 Jumlah: RM " . number_format($receipt->total_amount, 2);

        if ($receipt->deposit_amount > 0) {
            $caption .= "\n🏧 Deposit: RM " . number_format($receipt->deposit_amount, 2);
        }
        $caption .= "\n🧾 Baki: RM " . number_format($receipt->balance_amount, 2);

        $this->sendDocument($filePath, $caption);
        unlink($filePath);
    }
}
