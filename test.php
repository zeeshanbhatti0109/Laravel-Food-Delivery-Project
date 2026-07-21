<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::where('email', 'admin@admin.com')->first();
Illuminate\Support\Facades\Auth::login($user);
$request = Illuminate\Http\Request::create('/admin/restaurants', 'GET');
$request->setUserResolver(function() use ($user) { return $user; });
$middleware = new App\Http\Middleware\HandleInertiaRequests();
var_dump($middleware->share($request)['auth']);
