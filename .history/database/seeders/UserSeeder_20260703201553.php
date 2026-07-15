<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createAdminUser();
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
}