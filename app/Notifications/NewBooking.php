<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewBooking extends Notification
{
    use Queueable;

    public function __construct(
        public string $type,
        public string $bookingNumber,
        public string $roomName,
        public string $checkIn,
        public string $checkOut,
        public string $total = '',
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        $icons = ['new' => '🏡', 'paid' => '✅', 'cancelled' => '❌'];
        $labels = ['new' => 'Tempahan baru', 'paid' => 'Bayaran tempahan diterima', 'cancelled' => 'Tempahan dibatalkan'];

        return [
            'title' => ($icons[$this->type] ?? '🏡') . ' ' . ($labels[$this->type] ?? '') . " #{$this->bookingNumber}",
            'body' => "{$this->roomName} | {$this->checkIn} → {$this->checkOut}" . ($this->total ? " | RM {$this->total}" : ''),
            'icon' => $icons[$this->type] ?? '🏡',
            'type' => 'booking',
        ];
    }
}
