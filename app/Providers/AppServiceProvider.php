<?php

namespace App\Providers;

use App\Notifications\Channels\TelegramChannel;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Notification::extend('telegram', fn () => new TelegramChannel);
    }
}
