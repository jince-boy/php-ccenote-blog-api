<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class Users extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'password',
        'name',
        'email',
        'url',
        'profile',
        'token',
        'avatar',
        'status',
    ];
    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return ['role'=>'user'];
    }

}
