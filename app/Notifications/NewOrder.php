<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewOrder extends Notification
{
    use Queueable;

    public function __construct(
        public string $type,
        public string $orderNumber,
        public string $total,
        public string $customerName,
    ) {}

    public function via($notifiable): array
    {
        return ['database', 'telegram'];
    }

    public function toDatabase($notifiable): array
    {
        $icons = ['new' => '🛍️', 'paid' => '✅', 'cancelled' => '❌'];
        $labels = ['new' => 'Pesanan baru', 'paid' => 'Bayaran diterima', 'cancelled' => 'Pesanan dibatalkan'];

        return [
            'title' => ($icons[$this->type] ?? '🛍️') . ' ' . ($labels[$this->type] ?? '') . " #{$this->orderNumber} — RM {$this->total}",
            'body' => "oleh {$this->customerName}",
            'icon' => $icons[$this->type] ?? '🛍️',
            'type' => 'shop_order',
        ];
    }

    public function toTelegram($notifiable): array|string
    {
        $icons = ['new' => '🛍️', 'paid' => '✅', 'cancelled' => '❌'];
        $labels = ['new' => '*Pesanan Baru*', 'paid' => '*Bayaran Diterima*', 'cancelled' => '*Pesanan Dibatalkan*'];

        return ['text' => ($icons[$this->type] ?? '🛍️') . ' ' . ($labels[$this->type] ?? 'Pesanan')
            . "\nNo: #{$this->orderNumber}"
            . "\nJumlah: RM {$this->total}"
            . "\nPelanggan: {$this->customerName}"];
    }
}
