<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'ScholarGate' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-[#f4f6f8] text-slate-800">
    <div class="min-h-screen grid lg:grid-cols-2">
        <div class="hidden lg:flex relative overflow-hidden bg-slate-900">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-slate-900 to-blue-900"></div>
            <div class="absolute -top-20 -left-20 w-72 h-72 bg-blue-500/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-cyan-400/10 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex flex-col justify-between p-10 xl:p-14 text-white w-full">
                <div>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-white text-slate-900 flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-graduation-cap text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl font-extrabold tracking-tight">ScholarGate</h1>
                            <p class="text-white/70">Academic Excellence Platform</p>
                        </div>
                    </div>
                </div>

                <div class="max-w-xl">
                    <div class="inline-flex items-center gap-2 rounded-full bg-white/10 border border-white/10 px-4 py-2 text-sm text-white/80 mb-6">
                        <i class="fa-solid fa-sparkles"></i>
                        <span>Portal Beasiswa Modern</span>
                    </div>

                    <h2 class="text-4xl xl:text-5xl font-extrabold leading-tight mb-5">
                        Wujudkan masa depan akademik Anda bersama beasiswa terbaik.
                    </h2>

                    <p class="text-white/70 text-lg leading-8 mb-8">
                        Temukan peluang beasiswa, kelola pengajuan, simpan favorit, dan pantau perkembangan aplikasi Anda dalam satu platform yang rapi dan mudah digunakan.
                    </p>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="rounded-2xl bg-white/10 border border-white/10 p-4">
                            <div class="text-2xl font-extrabold">100+</div>
                            <div class="text-sm text-white/70 mt-1">Beasiswa aktif</div>
                        </div>
                        <div class="rounded-2xl bg-white/10 border border-white/10 p-4">
                            <div class="text-2xl font-extrabold">24/7</div>
                            <div class="text-sm text-white/70 mt-1">Akses dashboard</div>
                        </div>
                        <div class="rounded-2xl bg-white/10 border border-white/10 p-4">
                            <div class="text-2xl font-extrabold">Easy</div>
                            <div class="text-sm text-white/70 mt-1">Apply & track</div>
                        </div>
                    </div>
                </div>

                <div class="text-sm text-white/50">
                    © {{ date('Y') }} ScholarGate. All rights reserved.
                </div>
            </div>
        </div>

        <div class="flex items-center justify-center px-5 py-10 sm:px-8 lg:px-10">
            <div class="w-full max-w-md">
                <div class="lg:hidden mb-8 text-center">
                    <div class="mx-auto mb-4 w-16 h-16 rounded-2xl bg-slate-900 text-white flex items-center justify-center shadow-lg">
                        <i class="fa-solid fa-graduation-cap text-2xl"></i>
                    </div>
                    <h1 class="text-3xl font-extrabold">ScholarGate</h1>
                    <p class="text-slate-500 mt-1">Academic Excellence Platform</p>
                </div>

                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
