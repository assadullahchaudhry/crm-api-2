<?php

namespace App\Models;


use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;


class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use  Notifiable,  Authenticatable, Authorizable, HasFactory, HasApiTokens;

    protected $table = 'auc_users';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'firstName', 'lastName', 'email', 'password', 'roleId'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    protected $with = ['role', 'phones'];


    public function role()
    {
        return $this->belongsTo(Role::class, 'roleId', 'id');
    }

    public function phones()
    {
        return $this->hasMany(UserPhone::class, 'userId', 'id');
    }
}
