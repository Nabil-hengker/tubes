<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request)
    {
    // 1. Validasi input form
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // 2. Coba autentikasi pengguna
    if (Auth::attempt($credentials)) {
    $request->session()->regenerate();

    // Arahkan ke rute yang sesuai berdasarkan role, jangan langsung ke /dashboard
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard'); // Masuk ke /admin
    }

    return redirect()->route('student.dashboard'); // Masuk ke /dashboard
    }

    // Jika gagal, kembalikan ke form dengan pesan error
    return back()->withErrors([
        'email' => 'Email atau password yang Anda masukkan salah.',
    ])->onlyInput('email');
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request)
    {
    // 1. Validasi input (Hapus validasi role jika sebelumnya ada)
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // 2. Simpan ke database dengan mengunci role sebagai 'student'
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'student', // <-- KUNCI DI SINI: Siapa pun yang daftar otomatis jadi student
    ]);

    // 3. Langsung loginkan user baru dan lempar ke dashboard mahasiswa
    Auth::login($user);

    return redirect()->route('student.dashboard')
        ->with('success', 'Registrasi berhasil! Selamat datang.');
    }
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
    // Menampilkan Form Login Tersembunyi untuk Admin
    public function showAdminLogin() {
        return view('auth.admin_login');
    }

    // Memproses Login Akun Admin
    public function adminLogin(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            // Validasi: Jika yang login ternyata bukan admin, tendang keluar
            if (Auth::user()->role !== 'admin') {
                Auth::logout();
                return back()->withErrors(['email' => 'Akses ditolak. Ini adalah pintu masuk khusus pengelolaan berkas Admin!']);
            }

            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Username Admin atau password salah.']);
    }
}
