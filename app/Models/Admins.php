<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

/**
 * App\Models\Admins
 *
 */
class Admins extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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
        'role_id'
    ];
    protected $with=['roles'];

    public function roles(){
        return $this->belongsTo(Roles::class,'role_id');
    }
    public function Articles(){
        return $this->hasMany(Articles::class,'id');
    }
    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return ['role'=>'admin'];
    }

}
