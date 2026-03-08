<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                Auth::logout();
                return redirect()->route('admin.login');
            }
            if (Auth::user()->isTenant()) {
                return redirect()->route('organization.dashboard');
            }
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            if (Auth::user()->isAdmin()) {
                Auth::logout();
                return back()->withErrors(['email' => 'Администраторы должны входить через /admin.']);
            }

            $request->session()->regenerate();

            if (Auth::user()->isTenant()) {
                return redirect()->intended(route('organization.dashboard'));
            }

            Auth::logout();
            return back()->withErrors(['email' => 'У вашей учётной записи нет доступа.']);
        }

        return back()->withErrors(['email' => 'Неверный email или пароль.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
