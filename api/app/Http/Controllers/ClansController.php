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
    public function index(Request $request) {
        $userclan = Clan::whereUserid($request->auth->id)->first();
        if (!$userclan) {
            return response('No clan found for this user.', 404);
        } else {
            return $userclan;
        }
    }

    public function create (Request $request) {
        $checkClan = Clan::where('name', $request->name)->first();
        if ($checkClan) {
            if ($checkClan->userid != $request->auth->id) {
                
                return response("Clan name already taken.", 403);
            }
        }

        $clan = new Clan;
        $clan->name = $request->name;
        $clan->description = $request->description;
        $clan->discord = $request->discord;
        $clan->website = $request->website;
        $clan->userid = $request->auth->id;

        //Lets handle the image upload here
        if ($request->hasFile('image')) {

            $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            ]);

            //Check to see if an image was uploaded.
            if (Input::file('image')->isValid()) {
                $file = Input::file('image');
                $destination = '../images/clans';
                $ext= $file->getClientOriginalExtension();
                $mainFilename = str_slug($clan->name);
                $file->move($destination, $mainFilename.".".$ext);

            }

            $clan->picture = $mainFilename.".".$ext;
        }
        if($clan->save()) {
            return 'Clan created.';
        } else {
            return response('',400);
        }
    }

    public function update(Request $request) {
         $checkClan = Clan::where('name', $request->name)->first();
            if ($checkClan) {
                if ($checkClan->userid != $request->auth->id) {
                   
                    return response("Clan name already taken.", 403);
                }
            }

            $clan = Clan::where('userid', $request->auth->id)->first();
            $clan->name = $request->name;
            $clan->description = $request->description;
            $clan->discord = $request->discord;
            $clan->website = $request->website;

            //Lets handle the image upload here
            if ($request->hasFile('image')) {

                $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            ]);

            //Check to see if an image was uploaded.
            if (Input::file('image')->isValid()) {
                $file = Input::file('image');
                $destination = '../images/clans';
                $ext= $file->getClientOriginalExtension();
                $mainFilename = str_slug($clan->name);
                $file->move($destination, $mainFilename.".".$ext);

            }

            $clan->picture = $mainFilename.".".$ext;
            }

            if($clan->save()) {
                return 'Clan updated.';
            } else {
                return response('',400);
            }
    }

    public function destroy (Request $request) {
        $clan = Clan::whereUserid($request->auth->id)->first();

        if (!$clan) {
            return response('Clan for this user not found.', 404);
        } else {
            $clan->delete();
            return 'Clan deleted.';
        }
    }

    public function userclan(Request $request) {
        $clan = Clan::whereUserid($request->auth->id)->first();
        if (!$clan) {
            return response('', 404);
        } else {
            return $clan;
        }
    }
}
