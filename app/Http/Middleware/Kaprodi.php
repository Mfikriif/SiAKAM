<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Kaprodi
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

        // Jika role belum ada di session, cek dari user yang login
        if (!$selectedRole) {
            $user = Auth::user();

            if ($user->kaprodi == 1) {
                $selectedRole = 'kaprodi';
            } else {
                $selectedRole = $this->getUserPrimaryRole($user);
            }

            // Simpan role ke session untuk penggunaan berikutnya
            session(['user_role' => $selectedRole]);
        }

        // Jika role yang dipilih bukan kaprodi, redirect sesuai role lain
        if ($selectedRole !== 'kaprodi') {
            return $this->redirectBasedOnRole($selectedRole);
        }

        return $next($request);
    }

    /**
     * Fungsi untuk menentukan role utama user.
     */
    private function getUserPrimaryRole($user)
    {
        if ($user->dekan == 1) {
            return 'dekan';
        }
        if ($user->dosenwali == 1) {
            return 'dosenwali';
        }
        if ($user->akademik == 1) {
            return 'akademik';
        }
        if ($user->mahasiswa == 1) {
            return 'mahasiswa';
        }

        // Default ke kaprodi jika tidak ada role lain
        return 'kaprodi';
    }

    /**
     * Redirect berdasarkan role yang dipilih.
     */
    private function redirectBasedOnRole($role)
    {
        switch ($role) {
            case 'dekan':
                return redirect('dekan/dashboard');
            case 'dosenwali':
                return redirect('dosenwali/dashboard');
            case 'akademik':
                return redirect('akademik/dashboard');
            case 'mahasiswa':
                return redirect('mahasiswa/dashboard');
            default:
                return redirect('login')->with('error', 'Unauthorized access.');
        }
    }
}