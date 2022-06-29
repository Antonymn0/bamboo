<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserCanEditCompany
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $company = $user->company;
        
        if(is_null($company)) return $next($request);

        if( $user->hasPermissionTo('edit_company')){
            return $next($request);
        }
        return response()->json('Permission denied');
        
       
    }
}
