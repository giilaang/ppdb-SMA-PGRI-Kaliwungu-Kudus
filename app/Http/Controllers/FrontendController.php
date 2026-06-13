<?php

namespace App\Http\Controllers;


use App\Models\AcademicYear;
use App\Models\SchoolProfile;
use App\Models\HeroSection;
use App\Models\Advantage;
use App\Models\Facility;
use App\Models\Major;
use App\Models\Achievement;
use App\Models\Gallery;
use App\Models\SchoolContact;
use App\Models\PpdbSetting;
use App\Models\PpdbWave;
use App\Models\Brochure;
use App\Models\Registrant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    public function index()
    {
        // Get active academic year
        $activeYear = AcademicYear::where('is_active', true)->first();

        // Fallback if no active academic year
        if (!$activeYear) {
            $activeYear = AcademicYear::latest()->first();
        }

        $hero = null;
        $ppdbSetting = null;
        $activeWave = null;
        $brochure = null;

        if ($activeYear) {
            $hero = HeroSection::where('academic_year_id', $activeYear->id)->first();
            $ppdbSetting = PpdbSetting::where('academic_year_id', $activeYear->id)->first();
            $activeWave = PpdbWave::where('academic_year_id', $activeYear->id)
                ->where('is_active', true)
                ->whereDate('start_date', '<=', now())
                ->whereDate('end_date', '>=', now())
                ->first();
            $brochure = Brochure::where('academic_year_id', $activeYear->id)
                ->where('is_active', true)
                ->first();

            // Only treat brochure as available if the physical file actually exists on disk
            if ($brochure && !Storage::disk('local')->exists($brochure->file_path)) {
                $brochure = null;
            }
        }

        $profile = SchoolProfile::first();
        $advantages = Advantage::orderBy('order', 'asc')->get();
        $facilities = Facility::all();
        $majors = Major::all();
        $achievements = Achievement::orderBy('year', 'desc')->get();
        $galleries = Gallery::all();
        $contact = SchoolContact::first();

        // Fetch news and announcements for the home page
        $news = \App\Models\News::orderBy('published_at', 'desc')->take(3)->get();
        $announcements = \App\Models\Announcement::where('is_active', true)
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();

        // Increment visitor counter (basic session based)
        if (!session()->has('visited')) {
            session()->put('visited', true);
            // We can log visitor count in a file or db, let's keep track using cache or database counter
            // For simplicity, let's store page views in cache
            try {
                $views = cache()->get('visitor_count', 0);
                cache()->put('visitor_count', $views + 1);
            } catch (\Exception $e) {
                // ignore
            }
        }

        return view('frontend.index', compact(
            'activeYear',
            'hero',
            'ppdbSetting',
            'activeWave',
            'brochure',
            'profile',
            'advantages',
            'facilities',
            'majors',
            'achievements',
            'galleries',
            'contact',
            'news',
            'announcements'
        ));
    }

    public function about()
    {
        $profile = SchoolProfile::first();
        $advantages = Advantage::orderBy('order', 'asc')->get();
        return view('frontend.about', compact('profile', 'advantages'));
    }

    public function facilities()
    {
        $facilities = Facility::all();
        return view('frontend.facilities', compact('facilities'));
    }

    public function majors()
    {
        $majors = Major::all();
        return view('frontend.majors', compact('majors'));
    }

    public function achievements()
    {
        $achievements = Achievement::orderBy('year', 'desc')->get();
        return view('frontend.achievements', compact('achievements'));
    }

    public function ppdbService()
    {
        $majors = Major::all();
        return view('frontend.ppdb_service', compact('majors'));
    }

    public function brochureService()
    {
        return view('frontend.brochure_service');
    }

    public function contactService()
    {
        return view('frontend.contact_service');
    }

    public function register(Request $request)
    {
        $activeYear = AcademicYear::where('is_active', true)->first();
        if (!$activeYear) {
            return back()->with('error', 'Pendaftaran ditutup karena tahun ajaran aktif belum dikonfigurasi.');
        }

        $setting = PpdbSetting::where('academic_year_id', $activeYear->id)->first();
        if (!$setting || $setting->status !== 'open') {
            return back()->with('error', 'Pendaftaran PPDB saat ini sedang ditutup.');
        }

        // Validate wave dates
        $activeWave = PpdbWave::where('academic_year_id', $activeYear->id)
            ->where('is_active', true)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->first();
        if (!$activeWave) {
            return back()->with('error', 'Tidak ada gelombang pendaftaran aktif saat ini.');
        }

        // Check quota limit
        $currentRegistrants = Registrant::where('academic_year_id', $activeYear->id)->count();
        if ($currentRegistrants >= $setting->quota) {
            return back()->with('error', 'Kuota pendaftaran untuk tahun ajaran ini sudah terpenuhi.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => 'required|string|size:10',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:L,P',
            'address' => 'required|string',
            'previous_school' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'parent_name' => 'required|string|max:255',
            'selected_major_id' => 'required|exists:majors,id',
            'document_ijazah' => 'nullable|file|max:2048|mimes:pdf,jpg,jpeg,png',
            'document_akta' => 'nullable|file|max:2048|mimes:pdf,jpg,jpeg,png',
            'document_kk' => 'nullable|file|max:2048|mimes:pdf,jpg,jpeg,png',
            'document_foto' => 'nullable|file|max:2048|mimes:jpg,jpeg,png',
        ], [
            'nisn.size' => 'NISN harus tepat 10 digit.',
            'document_ijazah.max' => 'Ukuran berkas Ijazah tidak boleh melebihi 2MB.',
            'document_akta.max' => 'Ukuran berkas Akta tidak boleh melebihi 2MB.',
            'document_kk.max' => 'Ukuran berkas KK tidak boleh melebihi 2MB.',
            'document_foto.max' => 'Ukuran Pas Foto tidak boleh melebihi 2MB.',
        ]);

        // Process file uploads (Private local storage)
        $ijazahPath = $request->hasFile('document_ijazah') 
            ? $request->file('document_ijazah')->store('registrants/ijazah', 'local') 
            : null;
        $aktaPath = $request->hasFile('document_akta') 
            ? $request->file('document_akta')->store('registrants/akta', 'local') 
            : null;
        $kkPath = $request->hasFile('document_kk') 
            ? $request->file('document_kk')->store('registrants/kk', 'local') 
            : null;
        $fotoPath = $request->hasFile('document_foto') 
            ? $request->file('document_foto')->store('registrants/foto', 'local') 
            : null;

        // Generate registration number in a transaction to prevent duplicates
        $registrant = DB::transaction(function () use ($activeYear, $request, $ijazahPath, $aktaPath, $kkPath, $fotoPath) {
            $year_prefix = date('Y');
            
            // Loop until a unique registration number is found
            $attempts = 0;
            do {
                $count = Registrant::where('academic_year_id', $activeYear->id)->count() + 1 + $attempts;
                $registration_number = 'REG-' . $year_prefix . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
                $exists = Registrant::where('registration_number', $registration_number)->exists();
                $attempts++;
            } while ($exists);

            return Registrant::create([
                'academic_year_id' => $activeYear->id,
                'registration_number' => $registration_number,
                'name' => $request->name,
                'nisn' => $request->nisn,
                'place_of_birth' => $request->place_of_birth,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'address' => $request->address,
                'previous_school' => $request->previous_school,
                'phone_number' => $request->phone_number,
                'parent_name' => $request->parent_name,
                'selected_major_id' => $request->selected_major_id,
                'document_ijazah' => $ijazahPath,
                'document_akta' => $aktaPath,
                'document_kk' => $kkPath,
                'document_foto' => $fotoPath,
                'status' => 'pending',
            ]);
        });

        return redirect()->route('receipt', $registrant->registration_number)
            ->with('success', 'Pendaftaran Anda berhasil dikirim! Silakan cetak bukti pendaftaran ini.');
    }

    public function receipt($reg_number)
    {
        $registrant = Registrant::where('registration_number', $reg_number)
            ->with(['academicYear', 'major'])
            ->firstOrFail();

        $contact = SchoolContact::first();

        return view('frontend.receipt', compact('registrant', 'contact'));
    }

    public function downloadBrochure()
    {
        $activeYear = AcademicYear::where('is_active', true)->first();

        if (!$activeYear) {
            return $this->brochureNotFound('Tahun ajaran aktif belum dikonfigurasi.');
        }

        $brochure = Brochure::where('academic_year_id', $activeYear->id)
            ->where('is_active', true)
            ->first();

        if (!$brochure) {
            return $this->brochureNotFound('Brosur belum diunggah untuk tahun ajaran ini.');
        }

        if (!Storage::disk('local')->exists($brochure->file_path)) {
            return $this->brochureNotFound('File brosur tidak ditemukan di server. Silakan hubungi admin sekolah.');
        }

        // Serve the file as a download
        $fileName = preg_replace('/[^a-zA-Z0-9_\-.]/', '_', $brochure->title) . '.pdf';
        return Storage::disk('local')->download($brochure->file_path, $fileName);
    }

    /**
     * Return a user-friendly error view when brochure is unavailable.
     */
    private function brochureNotFound(string $message)
    {
        $contact = SchoolContact::first();
        return response()->view('frontend.brochure_not_found', [
            'message' => $message,
            'contact' => $contact,
        ], 404);
    }

    public function allNews()
    {
        $news = \App\Models\News::orderBy('published_at', 'desc')->paginate(6);
        return view('frontend.news_index', compact('news'));
    }

    public function newsDetail($slug)
    {
        $newsItem = \App\Models\News::where('slug', $slug)->first();
        if (!$newsItem) {
            $newsItem = \App\Models\News::findOrFail($slug);
        }
        
        $latestNews = \App\Models\News::where('id', '!=', $newsItem->id)
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();

        return view('frontend.news_detail', compact('newsItem', 'latestNews'));
    }

    public function allAnnouncements()
    {
        $announcements = \App\Models\Announcement::where('is_active', true)
            ->orderBy('published_at', 'desc')
            ->paginate(6);
        return view('frontend.announcements_index', compact('announcements'));
    }

    public function announcementDetail($id)
    {
        $announcement = \App\Models\Announcement::where('is_active', true)
            ->findOrFail($id);

        $latestAnnouncements = \App\Models\Announcement::where('is_active', true)
            ->where('id', '!=', $announcement->id)
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();

        return view('frontend.announcement_detail', compact('announcement', 'latestAnnouncements'));
    }
}
