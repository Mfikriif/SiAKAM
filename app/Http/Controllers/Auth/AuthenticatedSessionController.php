<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Models\Mahasiswa;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Menampilkan tampilan login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Menangani permintaan autentikasi yang masuk.
     */
    public function store(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        if (filter_var($request->login, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->login)->first();
        } elseif (strlen($request->login) == 14) {
            $mahasiswa = Mahasiswa::where('nim', $request->login)->first();
            if ($mahasiswa) {
                $user = User::where('email', $mahasiswa->email)->first(); 
            } else {
                return back()->withErrors([
                    'login' => 'NIM not found in the database.',
                ]);
            }
        } else {
            return back()->withErrors([
                'login' => 'Invalid login credentials.',
            ]);
        }

        // Check if user exists and password matches
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user); 
            $request->session()->regenerate(); 
            $roles = $this->getUserRoles($user->role);

            if (count($roles) > 1) {
                return redirect()->route('role.selection');
            }

            return redirect($this->getDashboardUrl($roles[0]));
        }
        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ]);
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
            default:
                $roles[] = 'guest';
                break;
        }

        return $roles;
    }

    /**
     * Fungsi pembantu untuk mengembalikan URL dashboard yang benar berdasarkan peran yang dipilih.
     */
    private function getDashboardUrl($role)
    {
        switch ($role) {
            case 'dekan':
                return 'dekan/dashboard';
            case 'dosenwali':
                return 'dosenwali/dashboard';
            case 'akademik':
                return 'akademik/dashboard';
            case 'kaprodi':
                return 'kaprodi/dashboard';
            default:
                return 'mahasiswa/dashboard';
        }
    }

    /**
     * Menampilkan halaman pemilihan peran bagi pengguna dengan beberapa peran.
     */
    public function showRoleSelection()
    {
        $user = auth()->user(); // Mengambil pengguna yang terautentikasi

        $roles = $this->getUserRoles($user->role); // Mengambil peran pengguna
        return view('auth.select-role', ['roles' => $roles]); // Mengembalikan tampilan pemilihan peran
    }

    /**
     * Menangani pemilihan peran setelah pengguna memilih peran.
     */
    public function selectRole(Request $request)
    {
        $role = $request->input('role');
        $user = auth()->user();
        $roles = $this->getUserRoles($user->role);

        if (!in_array($role, $roles)) {
            return redirect()->route('role.selection')->withErrors('Role yang dipilih tidak valid.'); 
        }

        session(['user_role' => $role]);
        return redirect($this->getDashboardUrl($role));
    }

    /**
     * Menghancurkan sesi yang terautentikasi.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}