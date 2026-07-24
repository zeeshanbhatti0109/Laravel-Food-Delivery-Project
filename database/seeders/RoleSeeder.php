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
        $this->createVendorRole();
            $this->createCustomerRole(); 
                $this->createStaffRole(); 

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
            ->orWhere('name', 'like', 'category.%')
            ->orWhere('name', 'like', 'product.%')
            ->pluck('id');

        $this->createRole(RoleName::ADMIN, $permissions);
    }

    protected function createVendorRole(): void
    {
        $permissions = Permission::query()
            ->whereIn('name', ['restaurant.update', 'restaurant.view'])
            ->orWhere('name', 'like', 'category.%')
            ->orWhere('name', 'like', 'product.%')
            ->orWhereIn('name', [
                'user.viewAny',
                'user.create',
                'user.delete',
            ])
            ->pluck('id');

        $this->createRole(RoleName::VENDOR, $permissions);
    }
    protected function createCustomerRole(): void
    {
        $permissions = Permission::whereIn('name', [
            'cart.add',
            'order.viewAny',
            'order.create',
        ])->pluck('id');
        $this->createRole(RoleName::CUSTOMER, $permissions);
    }
public function createStaffRole() 
{
    $this->createRole(RoleName::STAFF, collect());
}
}
