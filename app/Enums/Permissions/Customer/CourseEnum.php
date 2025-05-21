<?php

namespace App\Enums\Permissions\Customer;

use App\Interfaces\PermissionInterface;

enum CourseEnum: string implements PermissionInterface
{
    case WATCH = 'wacth';

    /**
     * Label
     * @return string
     */
    public function label(): string
    {
        return match ($this) {};
    }

    /**
     * Resource name
     * @return string
     */
    public static function resourceName(): string
    {
        return 'course';
    }
}
