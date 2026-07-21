<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('email', 'admin@admin.com')->first();
var_dump($user->hasPermission('restaurant.update'));
var_dump(Illuminate\Support\Facades\Gate::forUser($user)->allows('restaurant.update'));
