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

    public function search($searchTerm) {
        $results = Clan::where('name', 'LIKE', "%$searchTerm%")->take(5)->get();
        return $results->isEmpty() ? response('', 404) : $results;
    }
}