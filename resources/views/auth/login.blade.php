@extends('auth.layout', ['title' => 'Login - ScholarGate'])

@section('content')
<div class="rounded-[28px] border border-slate-200 bg-white shadow-[0_20px_60px_rgba(15,23,42,0.08)] p-7 sm:p-9">
    <div class="mb-8">
        <div class="inline-flex items-center gap-2 rounded-full bg-blue-50 text-blue-700 px-3 py-1 text-xs font-semibold mb-4">
            <i class="fa-solid fa-lock"></i>
            <span>Secure Login</span>
        </div>
        <h2 class="text-3xl font-extrabold tracking-tight">Masuk ke akun Anda</h2>
        <p class="text-slate-500 mt-2">Masukkan email dan password untuk mengakses dashboard ScholarGate.</p>
    </div>

    @if (session('success'))
        <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

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
                    placeholder="masukkan email anda"
                    required
                    class="w-full rounded-2xl border border-slate-300 bg-white pl-12 pr-4 py-3.5 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
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
                    id="password"
                    type="password"
                    name="password"
                    placeholder="masukkan password"
                    required
                    class="w-full rounded-2xl border border-slate-300 bg-white pl-12 pr-12 py-3.5 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                >
                <button type="button" onclick="togglePassword('password', 'toggleIcon')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700">
                    <i id="toggleIcon" class="fa-regular fa-eye"></i>
                </button>
            </div>
        </div>

        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center gap-2 text-slate-600">
                <input type="checkbox" class="rounded border-slate-300">
                <span>Remember me</span>
            </label>

            <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700">
                Buat akun
            </a>
        </div>

        <button
            type="submit"
            class="w-full rounded-2xl bg-slate-900 px-5 py-3.5 text-sm font-semibold text-white transition hover:bg-slate-800"
        >
            Masuk
        </button>
    </form>

    <div class="my-6 flex items-center gap-3">
        <div class="h-px flex-1 bg-slate-200"></div>
        <span class="text-xs uppercase tracking-wider text-slate-400">atau</span>
        <div class="h-px flex-1 bg-slate-200"></div>
    </div>

    <a href="{{ url('/auth/google') }}"
       class="w-full inline-flex items-center justify-center gap-3 rounded-2xl border border-slate-300 bg-white px-5 py-3.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
        <svg class="w-5 h-5" viewBox="0 0 48 48" aria-hidden="true">
            <path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303C33.654 32.657 29.215 36 24 36c-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.27 4 24 4 12.955 4 4 12.955 4 24s8.955 20 20 20 20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z"/>
            <path fill="#FF3D00" d="M6.306 14.691l6.571 4.819C14.655 16.108 19.001 13 24 13c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.27 4 24 4c-7.682 0-14.347 4.337-17.694 10.691z"/>
            <path fill="#4CAF50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238C29.143 35.091 26.715 36 24 36c-5.196 0-9.625-3.327-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z"/>
            <path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303a12.05 12.05 0 0 1-4.084 5.571l.003-.002 6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917z"/>
        </svg>
        <span>Login with Google</span>
    </a>
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
