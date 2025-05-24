<?php

namespace App\Rules;

use App\Interfaces\RuleInterface;

class RoleRules implements RuleInterface
{
    /**
     * Creation rules
     * @return array{name: string[]}
     */
    public static function creationRules(): array
    {
        return [
            'name' => ['required', 'string', 'unique:roles,name'],
            'admin_access' => ['required', 'boolean']
        ];
    }

    /**
     * Update rules
     * @param \Illuminate\Database\Eloquent\Model|null $model
     * @param array $args
     * @return array{name: string[]}
     */
    public static function updateRules(\Illuminate\Database\Eloquent\Model|null $model = null, array $args = []): array
    {
        $rules = self::creationRules();

        if ($model) {
            $rules['name'] = ['required', 'string', 'unique:roles,name,' . $model->id];
        }

        return $rules;
    }
}
