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
        // Retrieve the user's roles from session or determine it if not set
        $selectedRoles = session('user_role') ?? $this->getUserRoles(Auth::user()->role);

        // Ensure $selectedRoles is an array
        if (!is_array($selectedRoles)) {
            $selectedRoles = [$selectedRoles];
        }

        // If the roles do not include 'akademik', redirect based on their primary role
        if (!in_array('akademik', $selectedRoles)) {
            return $this->redirectBasedOnRole($selectedRoles[0]);
        }

        return $next($request);
    }

    /**
     * Mengambil peran pengguna berdasarkan ID peran.
     */
    private function getUserRoles(int $role): array
    {
        $roles = [];

        // Menentukan peran berdasarkan ID
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
            case 6:
                $roles[] = 'dekan';
                $roles[] = 'dosenwali';
                break;
            case 7:
                $roles[] = 'kaprodi';
                $roles[] = 'dosenwali';
                break;
        }

        return $roles;
    }

    /**
     * Redirect based on the user's role.
     */
    private function redirectBasedOnRole(string $role)
    {
        switch ($role) {
            case 'dekan':
                return redirect()->route('dekan.dashboard');
            case 'kaprodi':
                return redirect()->route('kaprodi.dashboard');
            case 'dosenwali':
                return redirect()->route('dosenwali.dashboard');
            case 'mahasiswa':
                return redirect()->route('mahasiswa.dashboard');
            default:
                return redirect()->route('login')->with('error', 'Unauthorized access.');
        }
    }
}