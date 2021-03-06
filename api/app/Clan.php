<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Clan extends Model {

    public function owner() {
        return $this->belongsTo('App\User', 'userid');
    }

    public function votes() {
        return $this->hasMany('App\Vote', 'clanid')->with('voter');
    }

    public function total_votes() {
        return $this->hasMany('App\Vote', 'clanid')->count();
    }
}