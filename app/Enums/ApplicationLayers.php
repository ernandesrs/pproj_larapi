<?php

namespace App\Enums;

/**
 * Define all application layer
 */
enum ApplicationLayers: string
{
    case ADMIN = 'admin';

    /**
     * Label
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrator',
        };
    }
}
