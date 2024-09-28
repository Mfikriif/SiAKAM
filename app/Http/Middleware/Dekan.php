<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Dekan
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

        // Jika role belum ada di session, coba ambil dari Auth user berdasarkan kolom boolean di DB
        if (!$selectedRole) {
            $user = Auth::user();

            if ($user->dekan == 1) {
                $selectedRole = 'dekan';
            } else {
                $selectedRole = $this->getUserPrimaryRole($user);
            }
        }

        // Jika role yang dipilih bukan mahasiswa, redirect sesuai role
        if ($selectedRole !== 'dekan') {
            return $this->redirectBasedOnRole($selectedRole);
        }
        return $next($request);
    }

    /**
     * Mendapatkan role utama pengguna jika bukan mahasiswa
     */
    private function getUserPrimaryRole($user)
    {
        if ($user->mahasiswa == 1) {
            return 'mahasiswa';
        }
        if ($user->kaprodi == 1) {
            return 'kaprodi';
        }
        if ($user->dosenwali == 1) {
            return 'dosenwali';
        }
        if ($user->akademik == 1) {
            return 'akademik';
        }

        return 'dekan';
    }

    /**
     * Redirect berdasarkan role yang dipilih atau default role
     */
    private function redirectBasedOnRole($role)
    {
        switch ($role) {
            case 'mahasiswa':
                return redirect('mahasiswa/dashboard');
            case 'kaprodi':
                return redirect('kaprodi/dashboard');
            case 'akademik':
                return redirect('akademik/dashboard');
            case 'dosenwali':
                return redirect('dosenwali/dashboard');
            default:
                return redirect('login')->with('error', 'Unauthorized access.');
        }
    }
}