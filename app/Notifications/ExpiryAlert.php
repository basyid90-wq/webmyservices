<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ExpiryAlert extends Notification
{
    use Queueable;

    public function __construct(
        public string $type,
        public string $level,
        public string $clientName,
        public string $itemName,
        public string $expiryDate,
    ) {}

    public function via($notifiable): array
    {
        return ['database', 'telegram'];
    }

    public function toDatabase($notifiable): array
    {
        $icons = ['critical' => '💀', 'warning' => '🔴', 'soon' => '⚠️', 'plugin' => '🔌'];
        $labels = [
            'domain_critical' => "Domain {$this->itemName} TELAH TAMAT",
            'domain_warning' => "SEGERA: Domain {$this->itemName} tamat dalam 7 hari",
            'domain_soon' => "Domain {$this->itemName} tamat pada {$this->expiryDate}",
            'hosting_critical' => "Hosting {$this->itemName} TELAH TAMAT",
            'hosting_warning' => "SEGERA: Hosting {$this->itemName} tamat dalam 7 hari",
            'hosting_soon' => "Hosting {$this->itemName} tamat pada {$this->expiryDate}",
            'plugin_30' => "Plugin WordPress {$this->clientName} tidak dikemaskini > 30 hari",
            'plugin_40' => "Plugin WordPress {$this->clientName} tidak dikemaskini > 40 hari",
        ];

        return [
            'title' => ($icons[$this->level] ?? '⚠️') . ' ' . ($labels[$this->type] ?? $this->itemName),
            'body' => "Client: {$this->clientName}" . ($this->expiryDate && $this->level !== 'plugin' ? " | Tamat: {$this->expiryDate}" : ''),
            'icon' => $icons[$this->level] ?? '⚠️',
            'type' => 'expiry_alert',
        ];
    }

    public function toTelegram($notifiable): array|string
    {
        $icons = ['critical' => '💀', 'warning' => '🔴', 'soon' => '⚠️', 'plugin' => '🔌'];
        $lines = [($icons[$this->level] ?? '⚠️') . ' *Amaran Sistem*'];
        $lines[] = "Client: {$this->clientName}";
        $lines[] = "{$this->itemName}";
        if ($this->expiryDate && $this->level !== 'plugin') {
            $lines[] = "Tamat: {$this->expiryDate}";
        }

        return ['text' => implode("\n", $lines)];
    }
}
