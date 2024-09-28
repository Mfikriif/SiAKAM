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
        $usertype = $this->getUserRoles($user);

        // Jika user memiliki lebih dari satu role, arahkan ke halaman pemilihan role
        if (count($usertype) > 1) {
            return redirect()->route('role.selection');
        }

        return redirect($this->getDashboardUrl($usertype[0]));
    }

    private function getUserRoles($user)
    {
        $usertype = [];
        if ($user->mahasiswa == 1) {
            $usertype[] = 'mahasiswa';
        }
        if ($user->dekan == 1) {
            $usertype[] = 'dekan';
        }
        if ($user->kaprodi == 1) {
            $usertype[] = 'kaprodi';
        }
        if ($user->dosenwali == 1) {
            $usertype[] = 'dosenwali';
        }
        if ($user->akademik == 1) {
            $usertype[] = 'akademik';
        }

        return $usertype;
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

        $usertype = $this->getUserRoles($user);
        return view('auth.select-role', ['roles' => $usertype]);
    }

    /**
     * Handle the role selection after user chooses a role.
     */
    public function selectRole(Request $request)
    {
        $role = $request->input('role');
        $user = auth()->user();

        $usertype = $this->getUserRoles($user);
        if (!in_array($role, $usertype)) {
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