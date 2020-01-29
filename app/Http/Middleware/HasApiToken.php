<?php

namespace App\Http\Middleware;

use Closure;

class HasApiToken
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
        $secret_key = "";
        // if($request->header('apitoken') == null)
        // return redirect('/401');
        if($request->header('apitoken') !='abcdefgh')
        { 
            return redirect('/401');
            
        }
        else
        {
           // $message = "Unauthorized";            
           return $next($request);
            
        }
       
    }
}
