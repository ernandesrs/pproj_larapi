<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'gender',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get all user tokens check
     * @return HasMany<TokenCheck, User>
     */
    public function tokensCheck(): HasMany
    {
        return $this->hasMany(TokenCheck::class);
    }

    /**
     * Get register verification token
     * @return TokenCheck|null
     */
    public function getRegisterVerificationToken(): TokenCheck|null
    {
        return $this->tokensCheck()->where('token_to', \App\Enums\TokenCheckEnum::REGISTER_VERIFICATION)->first();
    }

    /**
     * Generate token to account register verification
     * @return TokenCheck
     */
    public function generateTokenToRegisterVerification(): TokenCheck
    {
        return $this->tokensCheck()->create([
            'token_to' => \App\Enums\TokenCheckEnum::REGISTER_VERIFICATION,
            'token' => \Str::random(60)
        ]);
    }
}
