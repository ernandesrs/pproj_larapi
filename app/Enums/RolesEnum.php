<?php

namespace App\Enums;

use App\Interfaces\RoleInterface;

/**
 * Enum to define all application roles
 */
enum RolesEnum: string implements RoleInterface
{
    case SUPERUSER = 'super_user';

    case ADMINUSER = 'admin_user';

    /**
     * Label
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::SUPERUSER => 'Super user',
            self::ADMINUSER => 'Admin user',
        };
    }
}
