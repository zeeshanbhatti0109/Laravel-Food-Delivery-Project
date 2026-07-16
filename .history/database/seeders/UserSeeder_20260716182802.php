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

    public function createVendorUser(): void
    {
        $vendor = User::firstOrCreate(
            ['email' => 'vendor@admin.com'],
            [
                'name' => 'Restaurant owner',
                'password' => bcrypt('password'),
            ]
        );

        $vendorRole = Role::where('name', RoleName::VENDOR->value)->first();

        if ($vendorRole) {
            $vendor->roles()->syncWithoutDetaching([$vendorRole->id]);
        }

        $city = City::firstOrCreate(['name' => 'Vilnius']);

        $vendor->restaurant()->firstOrCreate(
            ['name' => 'Restaurant 001'],
            [
                'city_id' => $city->id,
                'address' => 'Address SJV14',
            ]
        );
    }
}