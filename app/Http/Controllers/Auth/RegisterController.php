<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegister()
    {
        if (Auth::check() && Auth::user()->isTenant()) {
            return redirect()->route('organization.dashboard');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => ['required', 'string', 'regex:/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/'],
            'inn' => 'required|string|max:12',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'phone.regex' => 'Телефон должен быть в формате +7 (XXX) XXX-XX-XX.',
        ]);

        $user = DB::transaction(function () use ($request) {
            $tenantRole = Role::where('name', 'tenant')->first();

            $user = User::create([
                'role_id' => $tenantRole->id,
                'name' => $request->contact_person,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
            ]);

            Tenant::create([
                'user_id' => $user->id,
                'company_name' => $request->company_name,
                'contact_person' => $request->contact_person,
                'phone' => $request->phone,
                'email' => $request->email,
                'inn' => $request->inn,
            ]);

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('organization.dashboard');
    }
}
