<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TokenCheck extends Model
{
    /**
     * Table
     * @var string
     */
    protected $table = 'tokens_check';

    /**
     * Fillable
     * @var list<string>
     */
    protected $fillable = [
        'token_to',
        'token'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'token_to' => \App\Enums\TokenCheckEnum::class
        ];
    }
}
