<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Akademik
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $selectedRole = session('user_role');

        if (!$selectedRole) {
            $selectedRole = Auth::user()->usertype;
        }

        if ($selectedRole !== 'akademik') {
            switch ($selectedRole) {
                case 'dekan':
                    return redirect('dekan/dashboard');
                case 'user':
                    return redirect('user/dashboard');
                case 'kaprodi':
                    return redirect('kaprodi/dashboard');
                case 'dosenwali':
                    return redirect('dosenwali/dashboard');
                default:
                    return redirect('login')->with('error', 'Unauthorized access.');
            }
        }

        return $next($request);
    }
}