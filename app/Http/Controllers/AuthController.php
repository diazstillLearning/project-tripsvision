<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('Admin/login');
    }

   public function login(Request $request)
{
    $credentials = $request->validate([
        'username' => ['required', 'string', 'exists:users,username'],
        'password' => ['required', 'string'],
    ]);

    if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
        $request->session()->regenerate();

        // Redirect berdasarkan role (jika dibutuhkan)
        // if (Auth::user()->role === 'admin') {
        //     return redirect()->intended('admin/dashboard');
        // }

        return redirect()->intended('Admin/dashboard');
    }

    return back()->withErrors([
        'username' => 'Username atau password salah.',
    ])->onlyInput('username');
}


    public function showRegister()
    {
        return view('Admin.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username'                  => 'required|string|max:255',
            'email'                 => 'required|string|email|max:255|unique:users',
            'password'              => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
        ]);

        // Karena di model ada casting 'password' => 'hashed', cukup langsung simpan plain password
        $user = User::create([
            'username'  => $validated['username'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'member', // default role, bisa diganti sesuai kebutuhan
        ]);

        Auth::login($user);

        return redirect('userDashboard'); // atau ke route lain sesuai role
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
