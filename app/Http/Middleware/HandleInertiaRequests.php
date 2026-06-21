<?php

namespace App\Http\Middleware;

use App\Models\PaymentLogo;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
            ],
            'auth' => [
                'user' => fn () => $request->user(),
            ],
            'paymentLogos' => fn () => PaymentLogo::where('is_active', true)->orderBy('sort_order')->get(),
        ];
    }
}
