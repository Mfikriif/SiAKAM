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
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = $request->user();
        $roles = $this->getUserRoles($user->role);

        // Jika user memiliki lebih dari satu role, arahkan ke halaman pemilihan role
        if (count($roles) > 1) {
            return redirect()->route('role.selection');
        }

        return redirect($this->getDashboardUrl($roles[0]));
    }

    private function getUserRoles(int $role): array
    {
            // NOTES!!!!!!!
            // Mahasiswa role = 1;
            // Akademik role = 2;
            // Dosen Wali role = 3;
            // Kaprodi role = 4;
            // Dekan role = 5;
            // Dekan and Dosen Wali role = 6;
            // Kaprodi and Dosen Wali role = 7;
            // Dosen role = 9;
        $roles = [];
        if ($role === 1) {
            $roles[] = 'mahasiswa';
        }
        if ($role === 2) {
            $roles[] = 'akademik';
        }
        if ($role === 3) {
            $usertype[] = 'dosenwali';
        }
        if ($role === 4) {
            $roles[] = 'kaprodi';
        }
        if ($role === 5) {
            $roles[] = 'dekan';
        }
        if ($role === 6){
            $roles[] = 'dekan';
            $roles[] = 'dosenwali';
        }
        if ($role === 7){
            $roles[] = 'kaprodi';
            $roles[] = 'dosenwali';
        }

        return $roles;
    }

    /**
     * Helper function to return the correct dashboard URL based on the selected role.
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
     * Display the role selection page for users with multiple roles.
     */
    public function showRoleSelection()
    {
        $user = auth()->user();

        $roles = $this->getUserRoles($user->role);
        return view('auth.select-role', ['roles' => $roles]);
    }

    /**
     * Handle the role selection after user chooses a role.
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
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}