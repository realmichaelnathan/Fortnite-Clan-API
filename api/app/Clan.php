<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Clan extends Model {

    public function owner() {
        return $this->belongsTo('App\User', 'userid');
    }

}