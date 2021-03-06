<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','updated_at'
    ];

    public function clan() {
        return $this->hasOne('App\Clan', 'userid');
    }

    public function vote() {
        return $this->hasOne('App\Vote');
    }

    public function roles() {
        return $this->belongsToMany('App\Role', 'roles_users');
    }

    public function hasRole($role) {
        return null !== $this->roles->where('name', $role)->first();
    }
}
