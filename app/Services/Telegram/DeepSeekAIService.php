<?php

namespace App\Services\Telegram;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DeepSeekAIService
{
    private string $apiKey;
    private string $apiUrl;
    private string $model;
    private int $timeout;

    private const SYSTEM_PROMPT = <<<'EOT'
Anda adalah pembantu AI untuk sistem resit sewaan Barakah Transport.
Tugas anda: Ekstrak SATU ATAU LEBIH resit sewaan dari teks bahasa Melayu (termasuk slanga & singkatan) dan return dalam format JSON yang TEPAT.

PENTING - Bilangan resit:
- Teks mungkin mengandungi maklumat untuk BEBERAPA pelanggan sekaligus (contohnya disenaraikan satu demi satu, setiap entri mungkin bermula dengan simbol seperti "✅" atau dipisahkan baris kosong).
- SETIAP nama pelanggan yang berlainan = SATU resit berasingan dalam array "receipts".
- Jika hanya satu pelanggan disebut, array "receipts" tetap mengandungi SATU elemen sahaja.

Peraturan untuk SETIAP resit dalam array "receipts":
1. customer_name: Nama penuh pelanggan.
2. customer_phone: Nombor telefon dalam format +60XXXXXXXXX. Jika tiada kod negara, tambah +60.
3. items: Array objek sewaan untuk pelanggan ini. Setiap objek ada:
   - category: Salah satu dari ["scooter", "motorcycle", "car", "homestay"].
     Kenal pasti dari kata kunci: "skuter"/"scooter"/"scoot"=scooter, "motor"/"motorcycle"/"motosikal"/"ex5"/"lc"/"lc135"/"rxz"/"y15"/"wave"/"lagenda"=motorcycle,
     "kereta"/"car"/"kancil"/"myvi"/"bezza"/"axia"/"alza"/"viva"/"saga"/"vios"/"city"=car,
     "homestay"/"rumah"/"chalet"/"bilik"/"inap"=homestay.
     Jika tak dapat kenal pasti (cth "extra time", caj tambahan), default = "motorcycle".
   - model_unit: Model atau nama unit (contoh: "Skuter", "EX5", "Myvi", "Extra Time"). Default kategori jika tak dinyatakan.
   - quantity: Bilangan unit (default 1).
   - price_per_day: Harga dalam RM yang dinyatakan untuk item ini (default 0 jika tak dinyatakan).
   - price_type: "per_day" (default), atau "flat" jika ia caj sekali sahaja (cth: "extra time", caj tambahan, bukan harga sehari).
   - duration_days: Bilangan hari sewa. Jika tak dinyatakan, kira dari start_date ke end_date.
   - start_date: Format YYYY-MM-DD.
   - end_date: Format YYYY-MM-DD.
4. deposit_amount: Jumlah deposit untuk pelanggan ini (default 0 jika tak dinyatakan).

Return HANYA JSON object. TIADA teks lain. TIADA markdown. TIADA backticks.

{
  "receipts": [
    {
      "customer_name": "...",
      "customer_phone": "...",
      "items": [...],
      "deposit_amount": 0
    }
  ]
}
EOT;

    public function __construct()
    {
        $this->apiKey = config('deepseek.api_key');
        $this->apiUrl = config('deepseek.api_url');
        $this->model = config('deepseek.model', 'deepseek-chat');
        $this->timeout = (int) config('deepseek.timeout', 30);
    }

    /**
     * Parse mesej teks kepada satu atau lebih resit sewaan.
     * Pulangkan list resit yang sudah dinormalisasi, atau null jika gagal.
     */
    public function parseReceipts(string $text): ?array
    {
        if (empty($this->apiKey)) {
            Log::warning('DeepSeek API key not configured');
            return null;
        }

        try {
            $response = Http::timeout($this->timeout)
                ->withToken($this->apiKey)
                ->post($this->apiUrl, [
                    'model' => $this->model,
                    'messages' => [
                        ['role' => 'system', 'content' => self::SYSTEM_PROMPT],
                        ['role' => 'user', 'content' => $text],
                    ],
                    'temperature' => 0.1,
                    'max_tokens' => 4000,
                ]);

            if (!$response->successful()) {
                Log::error('DeepSeek API error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return null;
            }

            $content = $response->json('choices.0.message.content');
            if (!$content) {
                Log::error('DeepSeek empty response');
                return null;
            }

            // Bersihkan sebarang markdown atau backticks
            $content = trim($content);
            $content = preg_replace('/^```(?:json)?\s*/', '', $content);
            $content = preg_replace('/\s*```$/', '', $content);

            $data = json_decode($content, true);

            if (!is_array($data)) {
                Log::error('DeepSeek invalid JSON response', ['content' => $content]);
                return null;
            }

            // Sokong response tanpa wrapper "receipts" (objek resit tunggal terus)
            $receipts = $data['receipts'] ?? (isset($data['customer_name']) ? [$data] : null);

            if (!is_array($receipts) || empty($receipts)) {
                Log::error('DeepSeek invalid JSON response', ['content' => $content]);
                return null;
            }

            Log::info('DeepSeek parsed receipts', ['count' => count($receipts), 'data' => $receipts]);

            $normalized = collect($receipts)
                ->filter(fn ($r) => is_array($r) && !empty($r['customer_name']))
                ->map(fn ($r) => $this->normalize($r))
                ->values()
                ->all();

            return empty($normalized) ? null : $normalized;

        } catch (\Throwable $e) {
            Log::error('DeepSeek exception: ' . $e->getMessage());
            return null;
        }
    }

    private function normalize(array $data): array
    {
        // Normalize phone
        $phone = $data['customer_phone'] ?? '';
        $phone = preg_replace('/[^\d+]/', '', $phone);
        if (!str_starts_with($phone, '+')) {
            if (str_starts_with($phone, '60')) {
                $phone = '+' . $phone;
            } elseif (str_starts_with($phone, '0')) {
                $phone = '+6' . $phone;
            } else {
                $phone = '+60' . $phone;
            }
        }

        // Normalize items
        $items = $data['items'] ?? [];
        if (!is_array($items) || empty($items)) {
            return $data;
        }

        $validCategories = ['scooter', 'motorcycle', 'car', 'homestay'];
        $normalizedItems = [];

        foreach ($items as $item) {
            $category = strtolower($item['category'] ?? 'motorcycle');
            if (!in_array($category, $validCategories)) {
                $category = 'motorcycle';
            }

            $hasExplicitDates = !empty($item['start_date']) && !empty($item['end_date']);
            $startDate = $item['start_date'] ?? date('Y-m-d');
            $endDate = $item['end_date'] ?? $startDate;

            if ($hasExplicitDates) {
                // Tarikh diberi - kira tempoh terus dari tarikh, jangan percaya kiraan AI
                // (cth: "27-28/6/2026" = 1 hari, bukan 2 hari).
                $start = \Carbon\Carbon::parse($startDate);
                $end = \Carbon\Carbon::parse($endDate);
                $duration = max(1, (int) $start->diffInDays($end));
            } else {
                $duration = max(1, (int) ($item['duration_days'] ?? 1));
            }

            $pricePerDay = (float) ($item['price_per_day'] ?? 0);
            $quantity = (int) ($item['quantity'] ?? 1);
            $priceType = $item['price_type'] ?? 'per_day';

            $totalPrice = $priceType === 'flat'
                ? $pricePerDay
                : $pricePerDay * $duration * $quantity;

            $normalizedItems[] = [
                'category' => $category,
                'model_unit' => $item['model_unit'] ?? ucfirst($category),
                'quantity' => max(1, $quantity),
                'start_date' => $startDate,
                'end_date' => $endDate,
                'duration_days' => $duration,
                'price_per_day' => $pricePerDay,
                'price_type' => $priceType,
                'total_price' => $totalPrice,
            ];
        }

        return [
            'customer_name' => $data['customer_name'] ?? 'Tanpa Nama',
            'customer_phone' => $phone,
            'deposit_amount' => (float) ($data['deposit_amount'] ?? 0),
            'items' => $normalizedItems,
        ];
    }
}
