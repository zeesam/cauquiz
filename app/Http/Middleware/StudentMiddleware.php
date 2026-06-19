<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserMap;
use App\Models\User;
use Auth;

class StudentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user())
        {
            $user = User::where('id',Auth::user()->id)->first();
            if(optional($user->userlevel)->level == "4" || Auth::user()->id == 1)
            {
                return $next($request);
            }
            else
            {
                return back()->with('message','Unauthorized Access!');
            }
        }
        else
        {
            return redirect('login');
        }
    }
}
