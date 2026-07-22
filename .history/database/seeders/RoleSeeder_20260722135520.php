<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createAdminRole();
<<<<<<< HEAD
        $this->createVendorRole(); 
=======
        $this->createVendorRole();
>>>>>>> main
    }

    protected function createRole(RoleName $role, Collection $permissions): void
    {
        $newRole = Role::firstOrCreate(['name' => $role->value]);
        $newRole->permissions()->sync($permissions);
    }

    protected function createAdminRole(): void
    {
        $permissions = Permission::query()
            ->where('name', 'like', 'user.%')
            ->orWhere('name', 'like', 'restaurant.%')
            ->pluck('id');

        $this->createRole(RoleName::ADMIN, $permissions);
    }

<<<<<<< HEAD
    protected function createVendorRole(): void 
    { 
        $this->createRole(RoleName::VENDOR, collect()); 
    } 
}
=======
    protected function createVendorRole(): void
    {
        $permissions = Permission::query()
            ->where('name', 'like', 'restaurant.%')
            ->orWhere('name', 'like', 'category.%')
            ->orWhere('name', 'like', 'product.%')
            ->pluck('id');

        $this->createRole(RoleName::VENDOR, $permissions);
    }
}
>>>>>>> main
