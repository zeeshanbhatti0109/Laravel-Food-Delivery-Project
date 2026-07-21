<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('email', '!=', 'admin@admin.com')->latest()->first();
if ($user) {
    echo "Password Reset Link for " . $user->email . ":\n";
    echo route('password.reset', ['token' => Illuminate\Support\Facades\Password::createToken($user), 'email' => $user->email]);
} else {
    echo "No vendor user found.";
}
