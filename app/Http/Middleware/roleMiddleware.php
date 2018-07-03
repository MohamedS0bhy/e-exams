<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

class roleMiddleware
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
        
        if(isset($_COOKIE['token'])){

            JWTAuth::setToken($_COOKIE['token']);
            $usr = JWTAuth::toUser();
            
            if($usr->role == '10')
                return redirect()->route('adminDashboard' , compact('usr'));
            elseif($usr->role == '1')
                return redirect()->route('doctorDashboard' , compact('usr'));
            else
                return response(view('student.index'));
          }
        return $next($request);
    }
}

