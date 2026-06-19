<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScholarGate - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f3f4f6] text-slate-800">
<div class="min-h-screen flex">
    <aside class="w-[278px] bg-[#eef0f3] border-r border-slate-200 hidden lg:flex flex-col justify-between">
        <div>
            <div class="px-8 py-6 border-b border-slate-200">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-black text-white flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-graduation-cap text-xl"></i>
                    </div>
                    <div>
                        <h1 class="font-extrabold text-[20px] leading-tight">ScholarGate</h1>
                        <p class="text-slate-500 text-[13px]">Academic Excellence</p>
                    </div>
                </div>
            </div>

            @php
                $navItems = [
                    'home' => ['Home', 'fa-house'],
                    'profile' => ['Profile', 'fa-user'],
                    'information' => ['Information', 'fa-star'],
                    'applications' => ['Applications', 'fa-clipboard-list'],
                    'analytics' => ['Analytics', 'fa-chart-simple'],
                ];
            @endphp

            <nav class="px-4 py-4 space-y-1.5">
                @foreach ($navItems as $key => [$label, $icon])
                    <a href="{{ route('student.dashboard', ['tab' => $key, 'search' => request('search')]) }}"
                       class="flex items-center gap-4 px-4 py-4 rounded-xl text-[15px] font-{{ $tab === $key ? '700' : '500' }} {{ $tab === $key ? 'bg-[#dde2ea] text-slate-900' : 'text-slate-500 hover:bg-white/70 hover:text-slate-800' }}">
                        <i class="fa-solid {{ $icon }} w-5 text-center"></i>
                        <span>{{ $label }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        <div class="px-4 py-6 border-t border-slate-200 space-y-1.5">
            <a href="{{ route('student.dashboard', ['tab' => 'settings']) }}" class="flex items-center gap-4 px-4 py-4 rounded-xl text-slate-500 hover:bg-white/70 hover:text-slate-800 text-[15px] font-medium">
                <i class="fa-solid fa-gear w-5 text-center"></i>
                <span>Settings</span>
            </a>
            <a href="{{ route('student.dashboard', ['tab' => 'support']) }}" class="flex items-center gap-4 px-4 py-4 rounded-xl text-slate-500 hover:bg-white/70 hover:text-slate-800 text-[15px] font-medium">
                <i class="fa-regular fa-circle-question w-5 text-center"></i>
                <span>Support</span>
            </a>
        </div>
    </aside>

    <main class="flex-1 min-w-0">
        <header class="bg-[#f7f7f8] border-b border-slate-200 px-4 md:px-8 py-3">
            <div class="flex items-center gap-4">
                <div class="lg:hidden">
                    <a href="{{ route('student.dashboard') }}" class="w-10 h-10 rounded-xl bg-black text-white flex items-center justify-center">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </a>
                </div>
                <form method="GET" action="{{ route('student.dashboard') }}" class="flex-1 flex items-center gap-3">
                    <input type="hidden" name="tab" value="{{ $tab === 'settings' || $tab === 'support' ? 'home' : $tab }}">
                    <div class="relative flex-1 max-w-3xl">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Search scholarships, grants, or universities..."
                               class="w-full h-12 rounded-2xl border border-slate-300 bg-[#f5f3f2] pl-12 pr-4 text-[15px] outline-none focus:border-slate-400">
                    </div>
                </form>
                <button class="w-10 h-10 rounded-full text-slate-500 hover:bg-slate-200"><i class="fa-regular fa-bell"></i></button>
                <button class="w-10 h-10 rounded-full text-slate-500 hover:bg-slate-200"><i class="fa-regular fa-circle-question"></i></button>
                <a href="{{ route('student.dashboard', ['tab' => 'profile']) }}" class="flex items-center gap-3 group">
    <div class="text-right hidden sm:block">
        <div class="font-semibold leading-tight group-hover:text-blue-600 transition">
            {{ Auth::user()->name }}
        </div>
        <div class="text-xs text-slate-500">
            {{ Auth::user()->role === 'admin' ? 'Administrator' : 'Sistem Informasi' }}
        </div>
    </div>
    <div class="w-11 h-11 rounded-full bg-slate-300 overflow-hidden flex items-center justify-center text-slate-700 font-bold group-hover:ring-2 group-hover:ring-blue-500 transition">
        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
    </div>
</a>
            </div>
        </header>

        <div class="p-4 md:p-8">
            @if (session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-700 text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-rose-700 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            @if ($tab === 'home')
                <section class="space-y-6">
                    <div class="px-2">
                        <p class="text-[18px] md:text-[20px] text-slate-600">Temukan ratusan beasiswa dari instansi terpercaya di seluruh dunia.</p>
                    </div>

                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                        @forelse ($scholarships as $scholarship)
                            @php
                                $statusMap = [
                                    'closing' => ['Closing Soon', 'bg-[#f3e5b8] text-[#b66313]'],
                                    'open' => ['Open', 'bg-[#d8f0db] text-[#14994b]'],
                                    'upcoming' => ['Upcoming', 'bg-slate-200 text-slate-700'],
                                ];
                                [$statusLabel, $statusClass] = $statusMap[$scholarship->status] ?? ['Open', 'bg-slate-200 text-slate-700'];
                            @endphp
                            <article class="bg-[#f6f6f6] border border-slate-300 rounded-2xl p-6 relative min-h-[285px] hover:shadow-sm transition">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="w-12 h-12 rounded bg-[#0d2237] flex items-center justify-center shadow-inner">
                                        <i class="fa-solid fa-graduation-cap text-amber-400 text-sm"></i>
                                    </div>
                                    <div class="rounded-full px-4 py-2 text-sm font-bold {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </div>
                                </div>

                                <div class="mt-8 max-w-[85%]">
                                    <h3 class="text-[18px] font-medium">{{ $scholarship->title }}</h3>
                                    <p class="mt-2 text-[15px] text-slate-700">{{ $scholarship->provider }}</p>
                                </div>

                                <div class="mt-8 space-y-5 text-[15px]">
                                    <div class="flex items-start gap-4">
                                        <i class="fa-regular fa-copy mt-1 text-slate-500"></i>
                                        <div>
                                            <div class="text-slate-700">Coverage</div>
                                            <div class="font-bold">{{ $scholarship->coverage }}</div>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-4">
                                        <i class="fa-regular fa-calendar mt-1 text-slate-500"></i>
                                        <div>
                                            <div class="text-slate-700">Deadline</div>
                                            <div class="font-bold">{{ $scholarship->deadline->translatedFormat('d F Y') }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="absolute bottom-6 left-6 flex items-center gap-3">
                                    <a href="{{ route('student.apply', $scholarship) }}" class="inline-flex items-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-black">
                                        Apply
                                    </a>
                                </div>

                                <div class="absolute bottom-6 right-6 flex items-center gap-2">
                                    <form method="POST" action="{{ route('student.bookmark.toggle', $scholarship) }}">
                                        @csrf
                                        <button class="w-11 h-11 rounded-xl border border-slate-300 bg-white text-slate-700 hover:border-slate-400">
                                            <i class="{{ in_array($scholarship->id, $bookmarkIds) ? 'fa-solid' : 'fa-regular' }} fa-bookmark"></i>
                                        </button>
                                    </form>
                                </div>
                            </article>
                        @empty
                            <div class="xl:col-span-2 rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center text-slate-500">
                                Tidak ada beasiswa yang cocok dengan pencarian Anda.
                            </div>
                        @endforelse
                    </div>
                </section>
            @elseif ($tab === 'profile')
    <section class="bg-white rounded-3xl border border-slate-200 p-6 md:p-8 max-w-4xl">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-8">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-slate-200 flex items-center justify-center text-2xl font-bold text-slate-700">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold">{{ Auth::user()->name }}</h2>
                    <p class="text-slate-500">Mahasiswa</p>
                </div>
            </div>

            <a href="{{ route('student.dashboard', ['tab' => 'home']) }}"
               class="inline-flex items-center justify-center rounded-2xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Kembali ke Dashboard
            </a>
        </div>

        <form method="POST" action="{{ route('student.profile.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold mb-2">Nama Lengkap</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', Auth::user()->name) }}"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                        placeholder="Masukkan nama lengkap"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', Auth::user()->email) }}"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                        placeholder="Masukkan email"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">No. Telepon</label>
                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone', Auth::user()->phone) }}"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                        placeholder="Masukkan nomor telepon"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">NIM</label>
                    <input
                        type="text"
                        name="nim"
                        value="{{ old('nim', Auth::user()->nim) }}"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                        placeholder="Masukkan NIM"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Program Studi</label>
                    <input
                        type="text"
                        name="major"
                        value="{{ old('major', Auth::user()->major) }}"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                        placeholder="Masukkan program studi"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Universitas</label>
                    <input
                        type="text"
                        name="university"
                        value="{{ old('university', Auth::user()->university) }}"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                        placeholder="Masukkan universitas"
                    >
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Bio Singkat</label>
                <textarea
                    name="bio"
                    rows="5"
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                    placeholder="Tulis bio singkat tentang diri Anda"
                >{{ old('bio', Auth::user()->bio) }}</textarea>
            </div>

            <div class="flex items-center justify-end">
                <button
                    type="submit"
                    class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800"
                >
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </section
            @elseif ($tab === 'information')
                <section class="space-y-6">
                    <div class="bg-white rounded-3xl border border-slate-200 p-6">
                        <h2 class="text-2xl font-bold">Informasi Beasiswa</h2>
                        <p class="mt-2 text-slate-500">Seluruh peluang yang tersedia saat ini, lengkap dengan negara, kategori, dan tenggat waktu.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        @foreach ($scholarships as $scholarship)
                            <div class="bg-white rounded-3xl border border-slate-200 p-6">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <h3 class="font-bold text-lg">{{ $scholarship->title }}</h3>
                                        <p class="text-slate-500 text-sm">{{ $scholarship->provider }}</p>
                                    </div>
                                    <span class="text-xs font-semibold rounded-full px-3 py-1 bg-slate-100">{{ ucfirst($scholarship->status) }}</span>
                                </div>
                                <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <div class="text-slate-400">Negara</div>
                                        <div class="font-semibold">{{ $scholarship->country }}</div>
                                    </div>
                                    <div>
                                        <div class="text-slate-400">Kategori</div>
                                        <div class="font-semibold">{{ $scholarship->category }}</div>
                                    </div>
                                    <div class="col-span-2">
                                        <div class="text-slate-400">Deskripsi</div>
                                        <div class="font-semibold">{{ $scholarship->description }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @elseif ($tab === 'applications')
                <section class="space-y-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold">Applications</h2>
                            <p class="text-slate-500 mt-1">Pantau semua pengajuan beasiswa Anda dari satu tempat.</p>
                        </div>
                        <a href="{{ route('student.dashboard', ['tab' => 'home']) }}" class="inline-flex items-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white">
                            Cari Beasiswa Baru
                        </a>
                    </div>

                    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden">
                        <div class="grid grid-cols-12 gap-4 px-6 py-4 border-b border-slate-200 text-xs uppercase tracking-wide font-bold text-slate-500">
                            <div class="col-span-4">Scholarship</div>
                            <div class="col-span-2">IPK</div>
                            <div class="col-span-3">Penghasilan</div>
                            <div class="col-span-2">Status</div>
                            <div class="col-span-1">Aksi</div>
                        </div>
                        @forelse ($applications as $application)
                            <div class="grid grid-cols-12 gap-4 px-6 py-5 border-b border-slate-100 items-center text-sm">
                                <div class="col-span-12 md:col-span-4">
                                    <div class="font-semibold">{{ $application->scholarship->title }}</div>
                                    <div class="text-slate-500 text-xs">{{ $application->nama_lengkap }} • {{ $application->npm }}</div>
                                </div>
                                <div class="col-span-4 md:col-span-2 font-semibold">{{ number_format((float) $application->ipk, 2) }}</div>
                                <div class="col-span-4 md:col-span-3 font-semibold">Rp{{ number_format((float) $application->penghasilan_orang_tua, 0, ',', '.') }}</div>
                                <div class="col-span-4 md:col-span-2">
                                    <span class="rounded-full px-3 py-1 text-xs font-bold
                                        @if($application->status === 'approved') bg-emerald-100 text-emerald-700
                                        @elseif($application->status === 'rejected') bg-rose-100 text-rose-700
                                        @else bg-amber-100 text-amber-700 @endif">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </div>
                                <div class="col-span-12 md:col-span-1">
                                    <a href="{{ route('student.apply', $application->scholarship) }}" class="text-slate-600 hover:text-slate-900 font-semibold">Edit</a>
                                </div>
                            </div>
                        @empty
                            <div class="p-10 text-center text-slate-500">
                                Belum ada pengajuan. Silakan pilih beasiswa dari tab Home.
                            </div>
                        @endforelse
                    </div>
                </section>
            @elseif ($tab === 'analytics')
                <section class="space-y-6">
                    <div>
                        <h2 class="text-2xl font-bold">Analytics</h2>
                        <p class="text-slate-500 mt-1">Gambaran cepat performa aktivitas beasiswa Anda.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
                        <div class="bg-white rounded-3xl border border-slate-200 p-6">
                            <div class="text-slate-500 text-sm">Beasiswa Tersedia</div>
                            <div class="text-3xl font-extrabold mt-2">{{ $stats['total_scholarships'] }}</div>
                        </div>
                        <div class="bg-white rounded-3xl border border-slate-200 p-6">
                            <div class="text-slate-500 text-sm">Bookmark</div>
                            <div class="text-3xl font-extrabold mt-2">{{ $stats['bookmarks'] }}</div>
                        </div>
                        <div class="bg-white rounded-3xl border border-slate-200 p-6">
                            <div class="text-slate-500 text-sm">Applications</div>
                            <div class="text-3xl font-extrabold mt-2">{{ $stats['applications'] }}</div>
                        </div>
                        <div class="bg-white rounded-3xl border border-slate-200 p-6">
                            <div class="text-slate-500 text-sm">Approved</div>
                            <div class="text-3xl font-extrabold mt-2">{{ $stats['approved'] }}</div>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl border border-slate-200 p-6">
                        <h3 class="font-bold text-lg mb-5">Rekomendasi Tindakan</h3>
                        <div class="space-y-4 text-sm text-slate-600">
                            <p>• Lengkapi bookmark untuk menyimpan target beasiswa prioritas.</p>
                            <p>• Ajukan beasiswa dengan deadline paling dekat terlebih dahulu.</p>
                            <p>• Gunakan tab Applications untuk memantau seluruh progress pengajuan.</p>
                        </div>
                    </div>
                </section>
            @elseif ($tab === 'settings')
                <section class="bg-white rounded-3xl border border-slate-200 p-6 md:p-8 max-w-3xl">
                    <h2 class="text-2xl font-bold">Settings</h2>
                    <p class="text-slate-500 mt-2">Kelola preferensi dasar akun Anda.</p>
                    <div class="mt-8 space-y-4">
                        <div class="flex items-center justify-between rounded-2xl border border-slate-200 p-4">
                            <div>
                                <div class="font-semibold">Email akun</div>
                                <div class="text-sm text-slate-500">{{ Auth::user()->email }}</div>
                            </div>
                            <span class="text-xs font-bold rounded-full bg-emerald-100 text-emerald-700 px-3 py-1">Aktif</span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="rounded-2xl bg-rose-600 px-5 py-3 text-sm font-semibold text-white">Logout</button>
                        </form>
                    </div>
                </section>
            @elseif ($tab === 'support')
                <section class="bg-white rounded-3xl border border-slate-200 p-6 md:p-8 max-w-3xl">
                    <h2 class="text-2xl font-bold">Support</h2>
                    <p class="text-slate-500 mt-2">Butuh bantuan? Gunakan panduan singkat berikut.</p>
                    <div class="mt-8 space-y-4">
                        <div class="rounded-2xl border border-slate-200 p-4">
                            <div class="font-semibold">Cara apply</div>
                            <p class="text-sm text-slate-500 mt-1">Masuk ke tab Home, pilih beasiswa, lalu klik tombol Apply untuk mengisi formulir.</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 p-4">
                            <div class="font-semibold">Cara bookmark</div>
                            <p class="text-sm text-slate-500 mt-1">Klik ikon bookmark pada kartu beasiswa untuk menyimpan beasiswa favorit Anda.</p>
                        </div>
                    </div>
                </section>
            @endif
        </div>
    </main>
</div>
</body>
</html>
