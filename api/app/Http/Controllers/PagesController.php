<?php

namespace App\Http\Controllers;
use App\Clan;

class PagesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //
    public function index() {
        return Clan::all();
    }

    public function newclans() {
        return Clan::orderBy('created_at', 'desc')->get();
    }

    public function viewclan($id) {
        $clan = Clan::whereId($id)->get();
        if (!$clan) {
            return response('',404);
        } else {
            return $clan;
        }
    }
}