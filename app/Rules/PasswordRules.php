<?php

namespace App\Rules;

use App\Interfaces\RuleInterface;

class PasswordRules implements RuleInterface
{
    /**
     * Password creation rules
     * @return array{password: string[]}
     */
    public static function creationRules(): array
    {
        return [
            'password' => ['nullable', 'string', 'confirmed']
        ];
    }

    /**
     * Password update rules
     * @param mixed $model
     * @param array $args
     * @return array{password: string[]}
     */
    public static function updateRules(?\Illuminate\Database\Eloquent\Model $model = null, array $args = []): array
    {
        return [
            ...self::creationRules()
        ];
    }
}
