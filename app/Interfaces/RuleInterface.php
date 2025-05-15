<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface RuleInterface
{
    /**
     * Creation rules
     * @return array
     */
    public static function creationRules(): array;

    /**
     * Update rules
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array $args
     * @return array
     */
    public static function updateRules(Model $model, array $args = []): array;
}
