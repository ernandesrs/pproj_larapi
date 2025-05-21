<?php

namespace App\Enums\Permissions\Admin;

use App\Interfaces\PermissionInterface;

enum RolePermissionEnum: string implements PermissionInterface
{
    case VIEW_ANY = 'view_any_role';
    case VIEW = 'view_role';
    case CREATE = 'create_role';
    case UPDATE = 'update_role';
    case DELETE = 'delete_role';
    case DELETE_MANY = 'delete_many_role';
    case RESTORE = 'restore_role';
    case FORCE_DELETE = 'force_delete_role';
    case PROMOTE_USER = 'promote_role';
    case DEMOTE_USER = 'demote_role';

    /**
     * Label
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::VIEW_ANY => 'View roles',
            self::VIEW => 'View role',
            self::CREATE => 'Create role',
            self::UPDATE => 'Update role',
            self::DELETE => 'Delete role',
            self::DELETE_MANY => 'Delete roles',
            self::RESTORE => 'Restore role',
            self::FORCE_DELETE => 'Force delete role',
        };
    }

    /**
     * Resource name
     * @return string
     */
    public static function resourceName(): string
    {
        return "role";
    }
}
