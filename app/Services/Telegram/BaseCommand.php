<?php

namespace App\Services\Telegram;

use Illuminate\Support\Facades\Http;

abstract class BaseCommand
{
    protected string $text;
    protected int $chatId;

    public function __construct(string $text, int $chatId)
    {
        $this->text = $text;
        $this->chatId = $chatId;
    }

    public function authorize(): bool
    {
        return (string) $this->chatId === config('telegram.chat_id');
    }

    abstract public function execute(): void;

    protected function reply(string $message, string $parseMode = 'Markdown'): void
    {
        $token = config('telegram.bot_token');

        Http::timeout(10)->post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $this->chatId,
            'text' => $message,
            'parse_mode' => $parseMode,
            'disable_web_page_preview' => true,
        ]);
    }

    protected function sendDocument(string $filePath, string $caption = ''): void
    {
        $token = config('telegram.bot_token');

        Http::timeout(15)->attach('document', file_get_contents($filePath), basename($filePath))
            ->post("https://api.telegram.org/bot{$token}/sendDocument", [
                'chat_id' => $this->chatId,
                'caption' => $caption,
            ]);
    }
}
