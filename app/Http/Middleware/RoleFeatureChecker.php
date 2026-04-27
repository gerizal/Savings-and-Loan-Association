<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleFeatureChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $feature, $access)
    {
        // Redirect specific roles from dashboard
        if($feature == 'dashboard'){
            $user_role = user_role();
            if($user_role){
                // role_id 4 = Approval Bank → redirect to /application/loan
                if($user_role->id == 4){
                    return redirect('/application/loan');
                }
                // role_id 5 = Slik Bank → redirect to /application/slik
                if($user_role->id == 5){
                    return redirect('/application/slik');
                }
                // role_id 9 = Verifikasi → redirect to /application/verification
                if($user_role->id == 9){
                    return redirect('/application/verification');
                }
            }
        }

        $has_access = check_access($feature,$access);
        if($has_access){
            return $next($request);
        }else{
            return response()->view('errors.404');
        }
    }
}
