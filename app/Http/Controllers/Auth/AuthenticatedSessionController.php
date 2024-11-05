<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
    public function store(LoginRequest $request)
    {
        $request->authenticate(); // Melakukan autentikasi pengguna
        $request->session()->regenerate(); // Menghasilkan ulang sesi untuk mencegah serangan session fixation

        $user = $request->user();
        $roles = $this->getUserRoles($user->role); // Mendapatkan peran pengguna

        // Jika pengguna memiliki lebih dari satu peran, arahkan ke halaman pemilihan peran
        if (count($roles) > 1) {
            return redirect()->route('role.selection');
        }
        
        // Arahkan pengguna ke dashboard sesuai dengan peran mereka
        return redirect($this->getDashboardUrl($roles[0]));
    }

    /**
     * Mengambil peran pengguna berdasarkan ID peran.
     */
    private function getUserRoles(int $role): array
    {
        // Catatan peran:
        // Mahasiswa role = 1
        // Akademik role = 2
        // Dosen Wali role = 3
        // Kaprodi role = 4
        // Dekan role = 5
        // Dekan dan Dosen Wali role = 6
        // Kaprodi dan Dosen Wali role = 7
        // Dosen role = 8
        
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
        $role = $request->input('role'); // Mengambil peran yang dipilih dari permintaan
        $user = auth()->user();
        $roles = $this->getUserRoles($user->role); // Mengambil peran pengguna

        // Memastikan peran yang dipilih valid
        if (!in_array($role, $roles)) {
            return redirect()->route('role.selection')->withErrors('Role yang dipilih tidak valid.'); // Kembali jika tidak valid
        }

        session(['user_role' => $role]); // Menyimpan peran pengguna dalam sesi
        return redirect($this->getDashboardUrl($role)); // Arahkan ke dashboard sesuai peran
    }

    /**
     * Menghancurkan sesi yang terautentikasi.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout(); // Melakukan logout pengguna
        $request->session()->invalidate(); // Menghapus sesi
        $request->session()->regenerateToken(); // Menghasilkan ulang token sesi
        return redirect('/'); // Arahkan ke halaman utama
    }
}