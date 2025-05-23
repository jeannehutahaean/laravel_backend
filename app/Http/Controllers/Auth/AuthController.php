<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        // Middleware untuk mencegah akses form login kalau sudah login
        $this->middleware('guest:admin')->except('logout');
    }

    /**
     * Tampilkan halaman login admin
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Proses login admin
     */
    public function login(Request $request)
    {
        // Validasi form
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            // Jika berhasil login
            return redirect()->route('admin.dashboard');
        }

        // Jika gagal login
        return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
    }

    /**
     * Logout admin
     */
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
