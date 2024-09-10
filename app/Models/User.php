<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    const ROLE_CUSTOMER = 1;
    const ROLE_SELLER = 2;
    const ROLE_DRIVER = 3;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
    function getRoleName() {
        return [
            self::ROLE_CUSTOMER => "Pembeli",
            self::ROLE_SELLER => "Penjual",
            self::ROLE_DRIVER => "Driver"
        ];
    }
    function getRoleNameAttribute() {
        return $this->getRoleName()[$this->role];
    }
    function products() {
        return $this->hasMany(Product::class,"user_id");
    }
}
