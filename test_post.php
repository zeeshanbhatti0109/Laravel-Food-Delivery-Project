<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::first();
Illuminate\Support\Facades\Auth::login($user);
$request = Illuminate\Http\Request::create('/admin/restaurants', 'POST', [
    'restaurant_name' => 'Test Rest',
    'email' => 'test@rest.com',
    'owner_name' => 'Owner',
    'city_id' => 1,
    'address' => '123 test'
]);
$response = $app->handle($request);
var_dump($response->getStatusCode());
var_dump($response->getContent());
