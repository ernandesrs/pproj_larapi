<?php

namespace Database\Seeders;

use App\Enums\Permissions\Admin\RolePermissionEnum;
use App\Enums\Permissions\Admin\UserPermissionEnum;
use App\Enums\RolesEnum;
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
        foreach (RolesEnum::cases() as $role) {
            $role = Role::createOrFirst([
                'name' => $role->value,
                'admin_access' => true
            ]);

            if ($role->name == RolesEnum::SUPERUSER->value) {
                $allPermissions = collect(Permission::getDefinedPermissions())->map(function ($resource) {
                    return collect($resource)->map(fn($permission) => $permission->value);
                });

                $role->givePermissionTo($allPermissions);
            }

            if ($role->name == RolesEnum::ADMINUSER->value) {
                $role->givePermissionTo([
                    UserPermissionEnum::VIEW_ANY->value,
                    UserPermissionEnum::VIEW->value,
                    UserPermissionEnum::CREATE->value,

                    RolePermissionEnum::VIEW_ANY->value,
                    RolePermissionEnum::VIEW->value,
                ]);
            }
        }
    }
}
