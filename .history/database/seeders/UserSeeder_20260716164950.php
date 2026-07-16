<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\City;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createAdminUser();
        $this->createVendorUser(); 
    }

    public function createAdminUser(): void
    {
        $adminRole = Role::where('name', RoleName::ADMIN->value)->first();

        $user = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
            ]
        );

        if ($adminRole) {
            $user->roles()->syncWithoutDetaching($adminRole->id);
        }
    }

    public function createVendorUser() 
    { 
        $vendor = User::create([ 
            'name'     => 'Restaurant owner', 
            'email'    => 'vendor@admin.com', 
            'password' => bcrypt('password'), 
        ]); 
 
        $vendor->roles()->sync(Role::where('name', RoleName::VENDOR->value)->first()); 
 
        $vendor->restaurant()->create([ 
            'city_id' => City::where('name', 'Vilnius')->value('id'), 
            'name'    => 'Restaurant 001', 
            'address' => 'Address SJV14', 
        ]); 
    } 
}