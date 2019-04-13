<?php

namespace App\Http\Middleware;

use Closure;
use App\Clan;

class ClanOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userid = $request->auth->id;
        $clanid = $request->id;

        $clanowner = Clan::find($clanid)->userid;

        // $request->status = "User: $userid, Clan Owner: $clanowner";
        if ($userid != $clanowner) {
            return 'Error: Logged in user does not own this clan.';
        } else {
            return $next($request);
        }
        
    }
}
