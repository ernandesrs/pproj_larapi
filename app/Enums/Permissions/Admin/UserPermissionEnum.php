<?php

namespace App\Enums\Permissions\Admin;

use App\Interfaces\PermissionInterface;

enum UserPermissionEnum: string implements PermissionInterface
{
    case VIEW_ANY = 'view_any_user';
    case VIEW = 'view_user';
    case CREATE = 'create_user';
    case UPDATE = 'update_user';
    case DELETE = 'delete_user';
    case DELETE_MANY = 'delete_many_user';
    case RESTORE = 'restore_user';
    case FORCE_DELETE = 'force_delete_user';

    /**
     * Label
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::VIEW_ANY => 'View users',
            self::VIEW => 'View user',
            self::CREATE => 'Create user',
            self::UPDATE => 'Update user',
            self::DELETE => 'Delete user',
            self::DELETE_MANY => 'Delete users',
            self::RESTORE => 'Restore user',
            self::FORCE_DELETE => 'Force delete user',
        };
    }

    /**
     * Resource Name
     * @return string
     */
    public static function resourceName(): string
    {
        return "user";
    }
}
