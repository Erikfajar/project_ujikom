<?php

namespace App\Http\Controllers\auth;

use App\Models\History;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login() // MENAMPILKAN HALAMAN LOGIN
    {
        return view('auth.login');
    }

    // PROSES LOGIN
    public function authentication(Request $request)
    {
        // VALIDASI DATA
        $validasi = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ], [
            'email.required' => 'Email harus di isi',
            'password.required' => 'Password harus di isi',
            'password.min' => 'Password minimal 8 karakter'
        ]);

        // PROSES AUTH
        if (Auth::attempt($validasi)) {
            $request->session()->regenerate();

            #PROSES SIMPAN HISTORY----------------------------------------
            $user = Auth::user()->id;
            $history = [
                'user_id' => $user,
                'aktivitas' => 'Melakukan Login'
            ];
            History::create($history);
            #END PROSES SIMPAN HISTORY----------------------------------------

            // DI ARAHKAN KE HALAMAN DASHBOARD
            return redirect()->route('dashboard')->with('success', 'Berhasil Login');
        }

        // KEMBALI KE HALAMAN SEMULA
        return back()->with('failed', 'Gagal Login');
    }

    // PROSES LOGOUT
    public function logout()
    {
        #PROSES SIMPAN HISTORY----------------------------------------
        $user = Auth::user()->id;
        $history = [
            'user_id' => $user,
            'aktivitas' => 'Melakukan Logout'
        ];
        History::create($history);
        #END PROSES SIMPAN HISTORY----------------------------------------
        Auth::logout(); // PROSES LOGOUT USER
        return redirect()->route('login')->with('success', 'Berhasil Logout!!'); // DI ARAHKKAN KE HALAMAN LOGIN
    }
}
