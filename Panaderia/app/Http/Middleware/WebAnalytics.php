<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Log;
use MatomoTracker;

class WebAnalytics
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

       /* Matomo Tracker
        $user = auth()->user();
        $uri = $request->route()->getName();
        $method = $request->method();
        $page_name = $method . "-" . $uri;
        MatomoTracker::doTrackPageView($page_name);
        if($user!=null) {
            Log::info("Set User id");
            MatomoTracker::setUserId($user->email);
        }*/
        return $next($request);
    }
}
