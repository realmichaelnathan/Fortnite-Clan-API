<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\User;
 
class UserController extends Controller
{
    /**
     * Register new user
     *
     * @param $request Request
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'name' => 'required|unique:users',
            'password' => 'required'
        ]);
 
        $hasher = app()->make('hash');
        $email = $request->input('email');
        $name = $request->name;
        $password = $hasher->make($request->input('password'));
        $user = User::create([
            'email' => $email,
            'name' => $name,
            'password' => $password,
        ]);
 
        $res['success'] = true;
        $res['message'] = 'Success register!';
        $res['data'] = $user;
        return response($res);
    }
    
}
