<?php

namespace App\Http\Middleware;

use Closure;

class authUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role = null)
    {
        $token = session('role');
        if (empty($token)){
            if ($request->is('dental-*')) {
                return redirect()->route('dental.login');
            }

            return redirect('login');
        }

        $userRole = session('role');

        
        if ($role && $userRole != $role) {
            return redirect('unauthorized'); 
        }
        
        return $next($request);
    }


}
