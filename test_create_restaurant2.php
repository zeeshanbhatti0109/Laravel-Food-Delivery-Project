<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Role;
use App\Enums\RoleName;
use App\Notifications\RestaurantOwnerInvitation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

try {
    $user = User::create([
        'name'     => 'Test Owner',
        'email'    => 'testowner2@example.com',
        'password' => Hash::make(Str::random(64)),
    ]);

    $role = Role::where('name', RoleName::VENDOR->value)->first();
    if ($role) {
        $user->roles()->sync([$role->id]);
    }

    $restaurant = $user->restaurant()->create([
        'city_id' => 1,
        'name'    => 'Test Restaurant 2',
        'address' => 'Test Address',
    ]);
    
    $user->notify(new RestaurantOwnerInvitation('Test Restaurant 2'));
    
    echo "Restaurant created and notification sent successfully with ID: " . $restaurant->id . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
