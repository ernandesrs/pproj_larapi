<?php

namespace Database\Seeders;

use App\Enums\Permissions\RolePermissionEnum;
use App\Enums\Permissions\UserPermissionEnum;
use App\Enums\RoleEnum;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = Permission::getDefinedPermissions();

        // Store permissions
        foreach ($permissions as $resource => $resourcePermissions) {
            foreach ($resourcePermissions as $rp) {
                Permission::createOrFirst([
                    'name' => $rp->value
                ]);
            }
        }

        // Store roles
        foreach (RoleEnum::cases() as $role) {
            $role = Role::createOrFirst([
                'name' => $role->value
            ]);

            if ($role->name == RoleEnum::ADMINUSER) {
                $role->givePermissionTo([
                    UserPermissionEnum::VIEW_ANY,
                    UserPermissionEnum::VIEW,
                    UserPermissionEnum::CREATE,

                    RolePermissionEnum::VIEW_ANY,
                    RolePermissionEnum::VIEW,
                ]);
            }
        }
    }
}
