<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Bookmark;
use App\Models\Scholarship;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ScholarshipController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $this->seedScholarships();

        $tab = $request->string('tab', 'home')->toString();
        $search = trim($request->string('search')->toString());

        $scholarshipsQuery = Scholarship::query();

        if ($search !== '') {
            $scholarshipsQuery->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('provider', 'like', "%{$search}%")
                    ->orWhere('country', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $scholarships = $scholarshipsQuery
            ->orderByRaw("CASE status WHEN 'closing' THEN 1 WHEN 'open' THEN 2 ELSE 3 END")
            ->orderBy('deadline')
            ->get();

        $user = Auth::user();
        $bookmarkIds = Bookmark::where('user_id', $user->id)->pluck('scholarship_id')->all();

        $applications = Application::with('scholarship')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $bookmarkedScholarships = $scholarships->whereIn('id', $bookmarkIds)->values();
        $availableScholarships = $scholarships
            ->reject(fn ($item) => in_array($item->id, $applications->pluck('scholarship_id')->all()))
            ->values();

        $stats = [
            'total_scholarships' => $scholarships->count(),
            'bookmarks' => count($bookmarkIds),
            'applications' => $applications->count(),
            'approved' => $applications->where('status', 'approved')->count(),
        ];

        return view('dashboard', compact(
            'tab',
            'search',
            'scholarships',
            'bookmarkIds',
            'applications',
            'bookmarkedScholarships',
            'availableScholarships',
            'stats'
        ));
    }

    public function showApplyForm(Scholarship $scholarship): View
    {
        abort_if(Auth::user()->role === 'admin', 403);

        $existingApplication = Application::where('user_id', Auth::id())
            ->where('scholarship_id', $scholarship->id)
            ->first();

        return view('apply_form', compact('scholarship', 'existingApplication'));
    }

    public function storeApplication(Request $request, Scholarship $scholarship): RedirectResponse
    {
        abort_if(Auth::user()->role === 'admin', 403);

        $validated = $request->validate([
            'npm' => 'required|string|max:30',
            'nama_lengkap' => 'required|string|max:255',
            'ipk' => 'required|numeric|min:0|max:4',
            'penghasilan_orang_tua' => 'required|numeric|min:0',
            'file_khs' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        $documentPath = Application::where('user_id', Auth::id())
            ->where('scholarship_id', $scholarship->id)
            ->value('document_path');

        if ($request->hasFile('file_khs')) {
            $documentPath = $request->file('file_khs')->store('documents', 'public');
        }

        Application::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'scholarship_id' => $scholarship->id,
            ],
            [
                'npm' => $validated['npm'],
                'nama_lengkap' => $validated['nama_lengkap'],
                'ipk' => $validated['ipk'],
                'penghasilan_orang_tua' => $validated['penghasilan_orang_tua'],
                'document_path' => $documentPath,
                'status' => 'pending',
            ]
        );

        return redirect()->route('student.dashboard', ['tab' => 'applications'])
            ->with('success', 'Pengajuan berhasil disimpan.');
    }

    public function toggleBookmark(Scholarship $scholarship): RedirectResponse
    {
        $bookmark = Bookmark::where('user_id', Auth::id())
            ->where('scholarship_id', $scholarship->id)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            $message = 'Bookmark dihapus.';
        } else {
            Bookmark::create([
                'user_id' => Auth::id(),
                'scholarship_id' => $scholarship->id,
            ]);
            $message = 'Beasiswa ditambahkan ke bookmark.';
        }

        return back()->with('success', $message);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
    abort_if(Auth::user()->role === 'admin', 403);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
        'phone' => 'nullable|string|max:30',
        'nim' => 'nullable|string|max:50',
        'major' => 'nullable|string|max:100',
        'university' => 'nullable|string|max:150',
        'bio' => 'nullable|string|max:1000',
    ]);

    $request->user()->update($validated);

    return redirect()->route('student.dashboard', ['tab' => 'profile'])
        ->with('success', 'Profil berhasil diperbarui.');
    }

    public function adminIndex(Request $request): View
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        $this->seedScholarships();

        $tab = $request->string('tab', 'overview')->toString();

        $applications = Application::with(['user', 'scholarship'])->latest()->get();
        $scholarships = Scholarship::latest()->get();
        $students = User::where('role', 'student')->latest()->get();

        $stats = [
            'students' => User::where('role', 'student')->count(),
            'scholarships' => Scholarship::count(),
            'applications' => $applications->count(),
            'pending' => $applications->where('status', 'pending')->count(),
            'approved' => $applications->where('status', 'approved')->count(),
        ];

        return view('admin_dashboard', compact(
            'tab',
            'applications',
            'scholarships',
            'students',
            'stats'
        ));
    }

    public function updateAdminProfile(Request $request): RedirectResponse
    {
    abort_if(Auth::user()->role !== 'admin', 403);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
    ]);

    User::where('id', Auth::id())->update($validated);

    return redirect()
        ->route('admin.dashboard', ['tab' => 'profile'])
        ->with('success', 'Profil admin berhasil diperbarui.');
    }

    private function seedScholarships(): void
    {
        if (Scholarship::count() > 0) {
            return;
        }

        $items = [
            [
                'title' => 'Beasiswa LPDP Tahap 2',
                'provider' => 'Lembaga Pengelola Dana Pendidikan',
                'coverage' => 'Tuition Fees + Living Allowance',
                'deadline' => now()->addDays(12)->toDateString(),
                'category' => 'Pascasarjana',
                'description' => 'Dukungan penuh biaya pendidikan dan biaya hidup untuk studi lanjutan.',
                'country' => 'Indonesia',
                'status' => 'closing',
            ],
            [
                'title' => 'Chevening Scholarships',
                'provider' => 'Foreign, Commonwealth & Development Office UK',
                'coverage' => 'Tuition + Flights + Stipend',
                'deadline' => now()->addDays(45)->toDateString(),
                'category' => 'Global',
                'description' => 'Program beasiswa penuh untuk studi S2 di Inggris.',
                'country' => 'United Kingdom',
                'status' => 'upcoming',
            ],
            [
                'title' => 'Monash International Merit',
                'provider' => 'Monash University, Australia',
                'coverage' => 'Partial Tuition Waiver',
                'deadline' => now()->addDays(28)->toDateString(),
                'category' => 'Undergraduate',
                'description' => 'Beasiswa merit untuk mahasiswa internasional dengan capaian akademik tinggi.',
                'country' => 'Australia',
                'status' => 'open',
            ],
            [
                'title' => 'MEXT Undergraduate',
                'provider' => 'Government of Japan',
                'coverage' => 'Full Scholarship + Monthly Allowance',
                'deadline' => now()->addDays(18)->toDateString(),
                'category' => 'Government',
                'description' => 'Kesempatan studi di Jepang dengan pendanaan penuh dan tunjangan bulanan.',
                'country' => 'Japan',
                'status' => 'closing',
            ],
        ];

        foreach ($items as $item) {
            Scholarship::create($item);
        }
    }

}
