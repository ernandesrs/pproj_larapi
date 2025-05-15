<?php

namespace App\Interfaces;

interface PermissionInterface
{
    /**
     * Permission group resourceName
     * @return string
     */
    public static function resourceName(): string;

    /**
     * Permission label
     * @return string
     */
    public function label(): string;
}
