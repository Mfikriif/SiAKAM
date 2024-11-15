<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Guest
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
        // Check if the user is authenticated
        if (Auth::check()) {
            // Redirect authenticated users to their appropriate dashboard
            $roles = $this->getUserRoles(Auth::user()->role);
            return redirect()->route($this->getDashboardRoute($roles[0]));
        }

        // If not authenticated, allow access
        return $next($request);
    }

    /**
     * Helper function to get the user’s roles based on their role ID.
     */
    private function getUserRoles(int $role): array
    {
        $roles = [];
        switch ($role) {
            case 1:
                $roles[] = 'mahasiswa';
                break;
            case 2:
                $roles[] = 'akademik';
                break;
            case 3:
                $roles[] = 'dosenwali';
                break;
            case 4:
                $roles[] = 'kaprodi';
                break;
            case 5:
                $roles[] = 'dekan';
                break;
            default:
                $roles[] = 'guest';
                break;
        }
        return $roles;
    }

    /**
     * Helper function to get the appropriate dashboard route based on the user's primary role.
     */
    private function getDashboardRoute(string $role): string
    {
        switch ($role) {
            case 'dekan':
                return 'dekan.dashboard';
            case 'kaprodi':
                return 'kaprodi.dashboard';
            case 'akademik':
                return 'akademik.dashboard';
            case 'dosenwali':
                return 'dosenwali.dashboard';
            default:
                return 'mahasiswa.dashboard';
        }
    }
}