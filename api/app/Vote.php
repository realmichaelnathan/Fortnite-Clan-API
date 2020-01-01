<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model {

    public function clan() {
        return $this->belongsTo('App\Clan', 'clanid');
    }

    public function voter() {
        return $this->belongsTo('App\User', 'userid');
    }
}