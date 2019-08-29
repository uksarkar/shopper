<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class UrlAndActivityMiddleware
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
        if(auth()->check()){
            $expiresAt = Carbon::now()->addMinutes(5);
            $now = Carbon::now();
            Cache::put('user-is-online-' . auth()->user()->id, true, $expiresAt);
            Cache::put('user-active-time-' . auth()->user()->id, $now);
        }
        
        if($request->getRequestUri() != '/login' && $request->getRequestUri() != '/test'){
            session()->put('rq_url', $request->getRequestUri());
            // Cache::put('rq_url',$request->getRequestUri(),-5);
        }

        return $next($request);
    }
}
