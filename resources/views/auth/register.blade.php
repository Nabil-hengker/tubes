@extends('auth.layout', ['title' => 'Register - ScholarGate'])

@section('content')
<div class="rounded-[28px] border border-slate-200 bg-white shadow-[0_20px_60px_rgba(15,23,42,0.08)] p-7 sm:p-9">
    <div class="mb-8">
        <div class="inline-flex items-center gap-2 rounded-full bg-emerald-50 text-emerald-700 px-3 py-1 text-xs font-semibold mb-4">
            <i class="fa-solid fa-user-plus"></i>
            <span>Create Account</span>
        </div>
        <h2 class="text-3xl font-extrabold tracking-tight">Buat akun baru</h2>
        <p class="text-slate-500 mt-2">Daftar untuk mulai mencari, menyimpan, dan mengajukan beasiswa.</p>
    </div>

    @if ($errors->any())
        <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-semibold mb-2">Nama Lengkap</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                    <i class="fa-regular fa-user"></i>
                </span>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="masukkan nama lengkap"
                    required
                    class="w-full rounded-2xl border border-slate-300 bg-white pl-12 pr-4 py-3.5 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100"
                >
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-2">Email</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                    <i class="fa-regular fa-envelope"></i>
                </span>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="masukkan email"
                    required
                    class="w-full rounded-2xl border border-slate-300 bg-white pl-12 pr-4 py-3.5 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100"
                >
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-2">Password</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                    <i class="fa-solid fa-lock"></i>
                </span>
                <input
                    id="register_password"
                    type="password"
                    name="password"
                    placeholder="buat password"
                    required
                    class="w-full rounded-2xl border border-slate-300 bg-white pl-12 pr-12 py-3.5 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100"
                >
                <button type="button" onclick="togglePassword('register_password', 'registerToggleIcon')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700">
                    <i id="registerToggleIcon" class="fa-regular fa-eye"></i>
                </button>
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold mb-2">Konfirmasi Password</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                    <i class="fa-solid fa-shield-halved"></i>
                </span>
                <input
                    id="register_password_confirmation"
                    type="password"
                    name="password_confirmation"
                    placeholder="ulangi password"
                    required
                    class="w-full rounded-2xl border border-slate-300 bg-white pl-12 pr-12 py-3.5 outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100"
                >
                <button type="button" onclick="togglePassword('register_password_confirmation', 'registerConfirmToggleIcon')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700">
                    <i id="registerConfirmToggleIcon" class="fa-regular fa-eye"></i>
                </button>
            </div>
        </div>

        <button
            type="submit"
            class="w-full rounded-2xl bg-emerald-600 px-5 py-3.5 text-sm font-semibold text-white transition hover:bg-emerald-700"
        >
            Daftar Sekarang
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700">Masuk di sini</a>
    </p>
</div>

<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection
