<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistrasiController extends Controller
{
    // MENAMPILKAN TAMPILAN REGISTRASI
    public function index()
    {
        return view('auth.registrasi');
    }

    // PROSES SIMPAN DATA REGISTRASI
    public function simpan(Request $request)
    {
        // VALIDASI DATA 
        $request->validate([
            'username' => 'required|max:30',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|max:60|min:8',
            'nama_lengkap' => 'required|max:50',
            'alamat' => 'required',
        ],[
            'username.required' => 'Username harus di isi',
            'username.max' => 'Username maksimal 30 karakter',
            'email.required' => 'Email harus di isi',
            'email.unique' => 'Email sudah ada yang menggunakan',
            'password.required' => 'Password harus di isi',
            'password.min' => 'Password minimal 8 karakter',
            'password.max' => 'Password minimal 60 karakter',
            'nama_lengkap.required' => 'Nama Lengkap harus di isi',
            'nama_lengkap.max' => 'Nama Lengkap maksimal 50 karakter',
            'alamat.required' => 'Alamat harus di isi',
        ]);

        // MEMBUAT VARIABEL UNTUK MENAMPUNG ISI REQUETS
        $dataRegistrasi = [
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nama_lengkap' => $request->nama_lengkap,
            'alamat' => $request->alamat,
            'role' => 'petugas', // KARENA REGISTRASI KHUSUS UNTUK PETUGAS
        ];

        // PROSES SIMPAN DATA REGISTRASI
        User::create($dataRegistrasi);
        return redirect()->route('login')->with('success','Registrasi berhasil, Silahkan login menggunakan akun yang telah di buat!!');

    }
}
