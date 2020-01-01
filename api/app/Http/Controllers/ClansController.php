<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Validator;
use Illuminate\Support\Facades\Input;
use App\Clan;

class ClansController extends Controller
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
        return Clan::orderBy('created_at', 'desc')->get();
    }

}
