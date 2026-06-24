<?php

namespace App\Http\Controllers;

use App\Services\Telegram\InvoiceCommand;
use App\Services\Telegram\NlpReceiptCommand;
use App\Services\Telegram\StatsCommand;
use App\Services\Telegram\StatusCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    public function handle(Request $request)
    {
        $chatId = (int) ($request->input('message.chat.id') ?? 0);
        $text = trim($request->input('message.text') ?? '');

        if (!$chatId || !$text) {
            return response()->json(['ok' => true]);
        }

        // Security: only allow configured chat_id
        if ((string) $chatId !== config('telegram.chat_id')) {
            Log::warning('Telegram webhook: unauthorized chat_id', ['chat_id' => $chatId]);
            return response()->json(['ok' => true]);
        }

        Log::info('Telegram command received', ['chat_id' => $chatId, 'text' => $text]);

        $cmd = $this->parseCommand($text);
        $handler = $this->resolveCommand($cmd['command'], $cmd['argument'], $chatId);

        if ($handler) {
            if ($handler->authorize()) {
                $handler->execute();
            }
        } else {
            // Plain text — bukan arahan. Hantar ke NLP pipeline.
            (new NlpReceiptCommand($chatId))->execute($text);
        }

        // Always return 200 to Telegram
        return response()->json(['ok' => true]);
    }

    private function parseCommand(string $text): array
    {
        if (!str_starts_with($text, '/')) {
            return ['command' => '', 'argument' => ''];
        }

        $text = ltrim($text, '/');
        $parts = explode(' ', $text, 2);
        return [
            'command' => strtolower($parts[0]),
            'argument' => $parts[1] ?? '',
        ];
    }

    private function resolveCommand(string $command, string $argument, int $chatId): ?object
    {
        return match ($command) {
            'status', 's' => new StatusCommand($argument, $chatId),
            'inv', 'invoice' => new InvoiceCommand($argument, $chatId),
            'stats' => new StatsCommand('', $chatId),
            'start' => $this->startReply($chatId),
            default => null,
        };
    }

    private function startReply(int $chatId): ?object
    {
        $lines = [
            "🤖 *WebMy Services Bot*",
            "",
            "Arahan:",
            "",
            "📌 `/status [nama]` — Semak status client",
            "🧾 `/inv buat [id]` — Jana invois & hantar PDF",
            "📊 `/stats` — Ringkasan dashboard",
            "",
            "🤖 Atau hantar mesej biasa untuk jana resit sewaan Barakah Transport secara automatik!",
            "",
            "Contoh: `22-23/4/2026 Masrina +6018-2384123 2 Skuter rm80`",
        ];

        $token = config('telegram.bot_token');
        \Illuminate\Support\Facades\Http::timeout(10)
            ->post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => implode("\n", $lines),
                'parse_mode' => 'Markdown',
                'disable_web_page_preview' => true,
            ]);

        return null;
    }
}
