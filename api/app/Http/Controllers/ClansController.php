<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
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
            return abort(404);
        } else {
            return $userclan;
        }
    }

    public function update(Request $request) {
         $checkClan = Clan::where('name', $request->name)->first();
            if ($checkClan) {
                if ($checkClan->userid != $request->auth->id) {
                    $error = "Clan name already taken.";
                    return $error;
                }
            }

            $clan = Clan::where('userid', $request->auth->id)->first();
            $clan->name = $request->name;
            $clan->description = $request->description;
            $clan->discord = $request->discord;
            $clan->website = $request->website;
            // $clan->userid = $request->auth->id;

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
                return 'Update failed.';
            }
    }
}
