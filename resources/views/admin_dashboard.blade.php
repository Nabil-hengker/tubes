<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScholarGate - Admin Dashboard</title>
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
                        <i class="fa-solid fa-user-shield text-xl"></i>
                    </div>
                    <div>
                        <h1 class="font-extrabold text-[20px] leading-tight">ScholarGate</h1>
                        <p class="text-slate-500 text-[13px]">Admin Panel</p>
                    </div>
                </div>
            </div>

            @php
                $adminNavItems = [
                    'overview' => ['Overview', 'fa-house'],
                    'scholarships' => ['Scholarships', 'fa-graduation-cap'],
                    'applications' => ['Applications', 'fa-clipboard-list'],
                    'students' => ['Students', 'fa-users'],
                    'profile' => ['Profile', 'fa-user'],
                ];
            @endphp

            <nav class="px-4 py-4 space-y-1.5">
                @foreach ($adminNavItems as $key => [$label, $icon])
                    <a href="{{ route('admin.dashboard', ['tab' => $key]) }}"
                       class="flex items-center gap-4 px-4 py-4 rounded-xl text-[15px] font-{{ $tab === $key ? '700' : '500' }} {{ $tab === $key ? 'bg-[#dde2ea] text-slate-900' : 'text-slate-500 hover:bg-white/70 hover:text-slate-800' }}">
                        <i class="fa-solid {{ $icon }} w-5 text-center"></i>
                        <span>{{ $label }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        <div class="px-4 py-6 border-t border-slate-200">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full flex items-center gap-4 px-4 py-4 rounded-xl text-rose-600 hover:bg-rose-50 text-[15px] font-semibold">
                    <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 min-w-0">
        <header class="bg-[#f7f7f8] border-b border-slate-200 px-4 md:px-8 py-3">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold">Dashboard Admin</h2>
                    <p class="text-sm text-slate-500">Kelola beasiswa, pengajuan, dan data mahasiswa</p>
                </div>

                <div class="flex items-center gap-3">
                    <button class="w-10 h-10 rounded-full text-slate-500 hover:bg-slate-200">
                        <i class="fa-regular fa-bell"></i>
                    </button>

                    <a href="{{ route('admin.dashboard', ['tab' => 'profile']) }}" class="flex items-center gap-3 group">
                        <div class="text-right hidden sm:block">
                            <div class="font-semibold leading-tight group-hover:text-blue-600 transition">
                                {{ Auth::user()->name }}
                            </div>
                            <div class="text-xs text-slate-500">Administrator</div>
                        </div>
                        <div class="w-11 h-11 rounded-full bg-slate-300 overflow-hidden flex items-center justify-center text-slate-700 font-bold group-hover:ring-2 group-hover:ring-blue-500 transition">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </a>
                </div>
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

            @if ($tab === 'overview')
                <section class="space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-5">
                        <div class="bg-white rounded-3xl border border-slate-200 p-6">
                            <div class="text-sm text-slate-500">Total Mahasiswa</div>
                            <div class="mt-2 text-3xl font-extrabold">{{ $stats['students'] }}</div>
                        </div>
                        <div class="bg-white rounded-3xl border border-slate-200 p-6">
                            <div class="text-sm text-slate-500">Total Beasiswa</div>
                            <div class="mt-2 text-3xl font-extrabold">{{ $stats['scholarships'] }}</div>
                        </div>
                        <div class="bg-white rounded-3xl border border-slate-200 p-6">
                            <div class="text-sm text-slate-500">Total Pengajuan</div>
                            <div class="mt-2 text-3xl font-extrabold">{{ $stats['applications'] }}</div>
                        </div>
                        <div class="bg-white rounded-3xl border border-slate-200 p-6">
                            <div class="text-sm text-slate-500">Pending</div>
                            <div class="mt-2 text-3xl font-extrabold text-amber-600">{{ $stats['pending'] }}</div>
                        </div>
                        <div class="bg-white rounded-3xl border border-slate-200 p-6">
                            <div class="text-sm text-slate-500">Approved</div>
                            <div class="mt-2 text-3xl font-extrabold text-emerald-600">{{ $stats['approved'] }}</div>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl border border-slate-200 p-6">
                        <h3 class="text-xl font-bold mb-4">Pengajuan Terbaru</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="text-left text-slate-500 border-b">
                                        <th class="py-3 pr-4">Mahasiswa</th>
                                        <th class="py-3 pr-4">Beasiswa</th>
                                        <th class="py-3 pr-4">IPK</th>
                                        <th class="py-3 pr-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($applications->take(8) as $application)
                                        <tr class="border-b border-slate-100">
                                            <td class="py-4 pr-4">{{ $application->nama_lengkap ?? $application->user->name }}</td>
                                            <td class="py-4 pr-4">{{ $application->scholarship->title ?? '-' }}</td>
                                            <td class="py-4 pr-4">{{ $application->ipk ?? '-' }}</td>
                                            <td class="py-4 pr-4">
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                    {{ $application->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                                    {{ ucfirst($application->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="py-6 text-center text-slate-500">Belum ada data pengajuan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

            @elseif ($tab === 'scholarships')
                <section class="bg-white rounded-3xl border border-slate-200 p-6">
                    <h3 class="text-xl font-bold mb-5">Daftar Beasiswa</h3>
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">
                        @forelse ($scholarships as $scholarship)
                            <div class="rounded-3xl border border-slate-200 p-5">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <h4 class="font-bold text-lg">{{ $scholarship->title }}</h4>
                                        <p class="text-slate-500 text-sm mt-1">{{ $scholarship->provider }}</p>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        {{ $scholarship->status === 'open' ? 'bg-emerald-100 text-emerald-700' : ($scholarship->status === 'closing' ? 'bg-amber-100 text-amber-700' : 'bg-slate-200 text-slate-700') }}">
                                        {{ ucfirst($scholarship->status) }}
                                    </span>
                                </div>

                                <div class="mt-4 space-y-2 text-sm">
                                    <div><span class="font-semibold">Coverage:</span> {{ $scholarship->coverage }}</div>
                                    <div><span class="font-semibold">Country:</span> {{ $scholarship->country }}</div>
                                    <div><span class="font-semibold">Deadline:</span> {{ \Carbon\Carbon::parse($scholarship->deadline)->translatedFormat('d F Y') }}</div>
                                </div>
                            </div>
                        @empty
                            <p class="text-slate-500">Belum ada beasiswa.</p>
                        @endforelse
                    </div>
                </section>

            @elseif ($tab === 'applications')
                <section class="bg-white rounded-3xl border border-slate-200 p-6">
                    <h3 class="text-xl font-bold mb-5">Semua Pengajuan</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-slate-500 border-b">
                                    <th class="py-3 pr-4">Mahasiswa</th>
                                    <th class="py-3 pr-4">Email</th>
                                    <th class="py-3 pr-4">Beasiswa</th>
                                    <th class="py-3 pr-4">IPK</th>
                                    <th class="py-3 pr-4">Penghasilan Orang Tua</th>
                                    <th class="py-3 pr-4">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($applications as $application)
                                    <tr class="border-b border-slate-100">
                                        <td class="py-4 pr-4">{{ $application->nama_lengkap ?? $application->user->name }}</td>
                                        <td class="py-4 pr-4">{{ $application->user->email ?? '-' }}</td>
                                        <td class="py-4 pr-4">{{ $application->scholarship->title ?? '-' }}</td>
                                        <td class="py-4 pr-4">{{ $application->ipk ?? '-' }}</td>
                                        <td class="py-4 pr-4">
                                            {{ $application->penghasilan_orang_tua ? 'Rp ' . number_format($application->penghasilan_orang_tua, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="py-4 pr-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                {{ $application->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                                {{ ucfirst($application->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-6 text-center text-slate-500">Belum ada pengajuan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

            @elseif ($tab === 'students')
                <section class="bg-white rounded-3xl border border-slate-200 p-6">
                    <h3 class="text-xl font-bold mb-5">Data Mahasiswa</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left text-slate-500 border-b">
                                    <th class="py-3 pr-4">Nama</th>
                                    <th class="py-3 pr-4">Email</th>
                                    <th class="py-3 pr-4">Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($students as $student)
                                    <tr class="border-b border-slate-100">
                                        <td class="py-4 pr-4">{{ $student->name }}</td>
                                        <td class="py-4 pr-4">{{ $student->email }}</td>
                                        <td class="py-4 pr-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                                {{ ucfirst($student->role) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-6 text-center text-slate-500">Belum ada data mahasiswa.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

            @elseif ($tab === 'profile')
                <section class="bg-white rounded-3xl border border-slate-200 p-6 md:p-8 max-w-3xl">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-16 h-16 rounded-full bg-slate-200 flex items-center justify-center text-2xl font-bold text-slate-700">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">{{ Auth::user()->name }}</h2>
                            <p class="text-slate-500">Administrator</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-semibold mb-2">Nama</label>
                            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                                   class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-slate-400">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                                   class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-slate-400">
                        </div>

                        <button type="submit" class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white">
                            Simpan Perubahan
                        </button>
                    </form>
                </section>
            @endif
        </div>
    </main>
</div>
</body>
</html>
