<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internal Login - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-slate-950 via-emerald-950 to-slate-950 min-h-screen flex items-center justify-center p-4 font-sans text-white">
    <div class="w-full max-w-md bg-white/10 backdrop-blur-md rounded-3xl shadow-2xl p-8 border border-white/10">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-emerald-600/30 text-emerald-400 mb-3 border border-emerald-500/30">
                <i class="fa-solid fa-user-shield text-2xl"></i>
            </div>
            <h2 class="text-2xl font-black tracking-tight">Otoritas Internal</h2>
            <p class="text-sm text-slate-400 mt-1">Gunakan Akun Kredensial Admin Anda</p>
        </div>

        @if($errors->any())
            <div class="bg-rose-500/10 border border-rose-500/20 text-rose-400 text-xs p-3 rounded-xl mb-4 flex items-center">
                <i class="fa-solid fa-circle-exclamation mr-2"></i> {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ url('/internal-login') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Email Admin / ID</label>
                <input type="email" name="email" placeholder="admin@scholarhub.com" class="w-full bg-slate-950/40 border border-white/10 rounded-xl p-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none text-white transition" required>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Kata Sandi</label>
                <input type="password" name="password" placeholder="••••••••" class="w-full bg-slate-950/40 border border-white/10 rounded-xl p-3 text-sm focus:ring-2 focus:ring-emerald-500 outline-none text-white transition" required>
            </div>
            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold p-3.5 rounded-xl transition shadow-lg shadow-emerald-600/20 text-sm mt-2">
                Masuk Sistem Verifikasi <i class="fa-solid fa-unlock-keyhole ml-1"></i>
            </button>
        </form>
    </div>
</body>
</html>
