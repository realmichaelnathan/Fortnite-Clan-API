<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    public function users() {
        return $this->belongsToMany('App\User', 'roles_users');
    }
}