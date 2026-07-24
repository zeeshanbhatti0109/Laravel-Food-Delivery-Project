<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = \App\Models\User::whereHas('roles', function($q) {
    $q->where('name', 'admin');
})->first();

dump($user->permissions());
dump("Can viewAny: " . ($user->can('restaurant.viewAny') ? 'Yes' : 'No'));
dump("Can create: " . ($user->can('restaurant.create') ? 'Yes' : 'No'));
dump("Can edit: " . ($user->can('restaurant.update') ? 'Yes' : 'No'));
dump("Can delete: " . ($user->can('restaurant.delete') ? 'Yes' : 'No'));
