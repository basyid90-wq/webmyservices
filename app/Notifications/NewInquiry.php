<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewInquiry extends Notification
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
        return ['database'];
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
}
