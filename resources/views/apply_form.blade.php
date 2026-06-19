<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply Beasiswa - ScholarGate</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="min-h-screen bg-[#f3f4f6] text-slate-800">
    <div class="max-w-5xl mx-auto p-4 md:p-8">
        <div class="mb-6">
            <a href="{{ route('student.dashboard', ['tab' => 'home']) }}" class="inline-flex items-center gap-2 rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-[0.95fr_1.05fr] gap-6">
            <div class="bg-white border border-slate-200 rounded-3xl p-6 md:p-8">
                <div class="w-14 h-14 rounded-2xl bg-slate-900 text-white flex items-center justify-center">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <h1 class="text-2xl font-bold mt-6">{{ $scholarship->title }}</h1>
                <p class="text-slate-500 mt-2">{{ $scholarship->provider }}</p>

                <div class="mt-8 space-y-5 text-sm">
                    <div class="flex items-start gap-4">
                        <i class="fa-regular fa-copy mt-1 text-slate-500"></i>
                        <div>
                            <div class="text-slate-500">Coverage</div>
                            <div class="font-semibold">{{ $scholarship->coverage }}</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <i class="fa-regular fa-calendar mt-1 text-slate-500"></i>
                        <div>
                            <div class="text-slate-500">Deadline</div>
                            <div class="font-semibold">{{ $scholarship->deadline->translatedFormat('d F Y') }}</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <i class="fa-solid fa-location-dot mt-1 text-slate-500"></i>
                        <div>
                            <div class="text-slate-500">Country</div>
                            <div class="font-semibold">{{ $scholarship->country }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-3xl p-6 md:p-8">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold">Formulir Pengajuan</h2>
                    <p class="text-slate-500 mt-2">Lengkapi data di bawah untuk mengirim atau memperbarui pengajuan Anda.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('student.store', $scholarship) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold mb-2">NPM</label>
                        <input type="text" name="npm" value="{{ old('npm', $existingApplication->npm ?? '') }}" class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-slate-400" placeholder="Contoh: 2210112345" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $existingApplication->nama_lengkap ?? Auth::user()->name) }}" class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-slate-400" required>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold mb-2">IPK</label>
                            <input type="number" step="0.01" min="0" max="4" name="ipk" value="{{ old('ipk', $existingApplication->ipk ?? '') }}" class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-slate-400" placeholder="3.75" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2">Penghasilan Orang Tua</label>
                            <input type="number" min="0" name="penghasilan_orang_tua" value="{{ old('penghasilan_orang_tua', $existingApplication->penghasilan_orang_tua ?? '') }}" class="w-full rounded-2xl border border-slate-300 px-4 py-3 outline-none focus:border-slate-400" placeholder="5000000" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Upload KHS / Dokumen Pendukung</label>
                        <input type="file" name="file_khs" class="w-full rounded-2xl border border-slate-300 px-4 py-3 bg-white outline-none focus:border-slate-400">
                        <p class="mt-2 text-xs text-slate-500">Format: PDF/JPG/PNG. Maksimal 4 MB.</p>
                    </div>
                    <button class="w-full rounded-2xl bg-slate-900 px-5 py-3.5 text-sm font-semibold text-white">
                        {{ $existingApplication ? 'Perbarui Pengajuan' : 'Kirim Pengajuan' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
