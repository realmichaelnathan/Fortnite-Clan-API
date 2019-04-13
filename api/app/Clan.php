<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Clan extends Model {

    public static function byUserId($userId) {
        return DB::table("clans")->where('userid', $userId)->get();
    }

    public static function byId($id) {
        return DB::table("clans")->where('id', $id)->get();
    }
}