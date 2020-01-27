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
        if($request->header('apitoken')!='abcdefgh'){
            
            return response()->json(['message'=>'unautorized access!'],401);
            
        }
        return $next($request);
    }
}
