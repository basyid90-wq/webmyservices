<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewInquiry extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $type,
        public string $name,
        public string $planOrSubject,
        public string $company = '',
    ) {}

    public function via($notifiable): array
    {
        return ['database', 'telegram'];
    }

    public function toDatabase($notifiable): array
    {
        $icon = $this->type === 'pricing' ? '🔔' : '📧';
        $title = $this->type === 'pricing'
            ? "{$icon} [{$this->planOrSubject}] Permohonan baru daripada {$this->name}"
            : "{$icon} Mesej baru daripada {$this->name} — {$this->planOrSubject}";

        return [
            'title' => $title,
            'body' => $this->company ? "Syarikat: {$this->company}" : '',
            'icon' => $icon,
            'type' => 'inquiry',
        ];
    }

    public function toTelegram($notifiable): array|string
    {
        $icon = $this->type === 'pricing' ? '🔔' : '📧';
        $lines = ["{$icon} *Inquiry Baru*"];
        $lines[] = "Nama: {$this->name}";
        if ($this->company) $lines[] = "Syarikat: {$this->company}";
        $lines[] = $this->type === 'pricing' ? "Pakej: {$this->planOrSubject}" : "Subjek: {$this->planOrSubject}";

        return ['text' => implode("\n", $lines)];
    }
}
