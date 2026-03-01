<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan halaman login
    public function index() {
        return view('auth.login');
    }

    // Proses Autentikasi
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Cek Role Admin
            if (Auth::user()->role !== 'admin') {
                Auth::logout();
                return back()->with('error', 'Anda bukan Admin!');
            }

            // DIPAKSA ke Dashboard agar tidak terlempar ke URL lama (seperti /lagu/edit)
            return redirect()->route('content.dashboard'); 
        }

        return back()->with('error', 'Email atau Password salah!');
    }

    // Proses Logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}