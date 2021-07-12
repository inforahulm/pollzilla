<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class IsUserVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if(Auth::user()->verify_status == 0) {
                return Response::json(['success' => 'false', 'message' => __('messages.user.unverified')], 403);
            }
            if(Auth::user()->status == 0) {
                return Response::json(['success' => 'false', 'message' => __('messages.user.blocked')], 423);
            }
        }
        return $next($request);
    }
}
