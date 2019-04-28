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
        $clan = Clan::find($clanid);
        $clanowner = $clan->userid;

        // $request->status = "User: $userid, Clan Owner: $clanowner";
        if ($userid != $clanowner) {
            return 'Error: Logged in user does not own this clan.';
        } else {
            $request->clan = $clan;
            return $next($request);
        }
        
    }
}
