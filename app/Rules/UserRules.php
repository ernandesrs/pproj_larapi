<?php

namespace App\Rules;

use App\Interfaces\RuleInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class UserRules implements RuleInterface
{
    /**
     * User creation rules
     * @return array
     */
    public static function creationRules(): array
    {
        return [
            "first_name" => ['required', 'string', 'max:25'],
            "last_name" => ['required', 'string', 'max:50'],
            "username" => ['required', 'string', 'max:25', 'unique:users,username'],
            "email" => ['required', 'email', 'unique:users,email'],
            "gender" => ['nullable', 'string', Rule::in(['male', 'female'])],
            "password" => ['required', 'string', 'confirmed'],
        ];
    }

    /**
     * User update rules
     * @param ?\Illuminate\Database\Eloquent\Model $model
     * @param array $args
     * @return array
     */
    public static function updateRules(?Model $model = null, array $args = []): array
    {
        $rules = self::creationRules();

        $rules['username'] = ['required', 'string', 'max:25', "unique:users,username,{$model->id}"];
        $rules['email'] = ['required', 'string', "unique:users,email,{$model->id}"];
        $rules['password'] = ['nullable', 'string', 'confirmed'];

        return $rules;
    }
}
