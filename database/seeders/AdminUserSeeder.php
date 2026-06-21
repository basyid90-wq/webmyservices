<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = User::where('email', 'admin@hasillaut.com')->first();
if (! $user) {
    User::create([
        'name' => 'Admin',
        'email' => 'admin@hasillaut.com',
        'password' => Hash::make('demo123'),
        'phone' => '0123456789',
    ]);
    echo "Admin user created!\n";
} else {
    echo "Admin user already exists.\n";
}
