<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect('/login')
                ->with('error', 'Username atau password salah');
        }

        session()->put('login', true);
        session()->put('user_id', $user->id);
        session()->put('user_name', $user->name);

        return redirect('/dashboard');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:4'
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->username . '@umkm.com',
            'password' => Hash::make($request->password)
        ]);

        return redirect('/login')
            ->with('success', 'Register berhasil');
    }

    public function logout()
    {
        session()->flush();

        return redirect('/login');
    }
}
