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

        $usertype = explode(',', $request->user()->usertype);

        if (count($usertype) > 1) {
            return redirect()->route('role.selection');
        }
        return redirect($this->getDashboardUrl($usertype[0]));
    }
    
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
                return 'user/dashboard';
        }
    }
    /**
     * Digunakan untuk menampilkan rolenya user
     */
    public function showRoleSelection()
    {
        $usertype = explode(',', auth()->user()->usertype);
        return view('auth.select-role', ['roles' => $usertype]);
    }
    
    public function selectRole(Request $request)
    {
        $role = $request->input('role');
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
