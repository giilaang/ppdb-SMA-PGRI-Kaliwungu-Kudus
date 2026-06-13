<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Admin\PpdbSettingController;
use App\Http\Controllers\Admin\PpdbWaveController;
use App\Http\Controllers\Admin\RegistrantController;
use App\Http\Controllers\Admin\SchoolProfileController;
use App\Http\Controllers\Admin\HeroSectionController;
use App\Http\Controllers\Admin\AdvantageController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\MajorController;
use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\SchoolContactController;
use App\Http\Controllers\Admin\BrochureController;

// ============================================
// FRONTEND ROUTES
// ============================================
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::post('/daftar', [FrontendController::class, 'register'])->name('register.submit');
Route::get('/bukti-pendaftaran/{reg_number}', [FrontendController::class, 'receipt'])->name('receipt');
Route::get('/download-brosur', [FrontendController::class, 'downloadBrochure'])->name('brochure.download');

// New Frontend Pages
Route::get('/tentang-sma', [FrontendController::class, 'about'])->name('about');
Route::get('/fasilitas', [FrontendController::class, 'facilities'])->name('facilities');
Route::get('/program-pilihan', [FrontendController::class, 'majors'])->name('majors');
Route::get('/prestasi-siswa', [FrontendController::class, 'achievements'])->name('achievements');
Route::get('/layanan/ppdb', [FrontendController::class, 'ppdbService'])->name('services.ppdb');
Route::get('/layanan/brosur', [FrontendController::class, 'brochureService'])->name('services.brochure');
Route::get('/layanan/kontak', [FrontendController::class, 'contactService'])->name('services.contact');


// ============================================
// NEWS FRONTEND
// ============================================

Route::get('/berita', [FrontendController::class, 'allNews'])
    ->name('news.index');

Route::get('/berita/{id}', [FrontendController::class, 'newsDetail'])
    ->name('news.show');


// ============================================
// ANNOUNCEMENT FRONTEND
// ============================================

Route::get('/pengumuman', [FrontendController::class, 'allAnnouncements'])
    ->name('announcements.index');

Route::get('/pengumuman/{id}', [FrontendController::class, 'announcementDetail'])
    ->name('announcements.show');
    
// ============================================
// AUTH ROUTES
// ============================================
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('logout');

// ============================================
// ADMIN ROUTES (Protected by auth + role)
// ============================================
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {

    // Dashboard (all roles)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Academic Years (super_admin only)
    Route::get('/tahun-ajaran', [AcademicYearController::class, 'index'])->name('academic-years.index')->middleware('role:super_admin');
    Route::post('/tahun-ajaran', [AcademicYearController::class, 'store'])->name('academic-years.store')->middleware('role:super_admin');
    Route::patch('/tahun-ajaran/{id}/activate', [AcademicYearController::class, 'activate'])->name('academic-years.activate')->middleware('role:super_admin');
    Route::patch('/tahun-ajaran/{id}/toggle-archive', [AcademicYearController::class, 'toggleArchive'])->name('academic-years.toggleArchive')->middleware('role:super_admin');
    Route::delete('/tahun-ajaran/{id}', [AcademicYearController::class, 'destroy'])->name('academic-years.destroy')->middleware('role:super_admin');

    // PPDB Settings (super_admin, admin_ppdb)
    Route::get('/ppdb-settings', [PpdbSettingController::class, 'index'])->name('ppdb-settings.index')->middleware('role:super_admin,admin_ppdb');
    Route::patch('/ppdb-settings/{id}', [PpdbSettingController::class, 'update'])->name('ppdb-settings.update')->middleware('role:super_admin,admin_ppdb');

    // PPDB Waves (super_admin, admin_ppdb)
    Route::get('/gelombang', [PpdbWaveController::class, 'index'])->name('ppdb-waves.index')->middleware('role:super_admin,admin_ppdb');
    Route::post('/gelombang', [PpdbWaveController::class, 'store'])->name('ppdb-waves.store')->middleware('role:super_admin,admin_ppdb');
    Route::patch('/gelombang/{id}', [PpdbWaveController::class, 'update'])->name('ppdb-waves.update')->middleware('role:super_admin,admin_ppdb');
    Route::delete('/gelombang/{id}', [PpdbWaveController::class, 'destroy'])->name('ppdb-waves.destroy')->middleware('role:super_admin,admin_ppdb');

    // Registrants (super_admin, admin_ppdb)
    Route::get('/pendaftar', [RegistrantController::class, 'index'])->name('registrants.index')->middleware('role:super_admin,admin_ppdb');
    Route::get('/pendaftar/{id}', [RegistrantController::class, 'show'])->name('registrants.show')->middleware('role:super_admin,admin_ppdb');
    Route::patch('/pendaftar/{id}/verifikasi', [RegistrantController::class, 'verify'])->name('registrants.verify')->middleware('role:super_admin,admin_ppdb');
    Route::get('/pendaftar/{id}/dokumen/{type}', [RegistrantController::class, 'viewDocument'])->name('registrants.document.view')->middleware('role:super_admin,admin_ppdb');
    Route::get('/pendaftar/{id}/dokumen/{type}/download', [RegistrantController::class, 'downloadDocument'])->name('registrants.document.download')->middleware('role:super_admin,admin_ppdb');
    Route::get('/pendaftar/export/csv', [RegistrantController::class, 'exportCsv'])->name('registrants.export.csv')->middleware('role:super_admin,admin_ppdb');
    Route::delete('/pendaftar/{id}', [RegistrantController::class, 'destroy'])->name('registrants.destroy')->middleware('role:super_admin');

    // Content Management (super_admin, editor_content)
    Route::get('/hero', [HeroSectionController::class, 'index'])->name('hero.index')->middleware('role:super_admin,editor_content');
    Route::patch('/hero/{id}', [HeroSectionController::class, 'update'])->name('hero.update')->middleware('role:super_admin,editor_content');

    Route::get('/profil', [SchoolProfileController::class, 'index'])->name('profile.index')->middleware('role:super_admin,editor_content');
    Route::patch('/profil/update', [SchoolProfileController::class, 'update'])->name('profile.update')->middleware('role:super_admin,editor_content');

    Route::get('/keunggulan', [AdvantageController::class, 'index'])->name('advantages.index')->middleware('role:super_admin,editor_content');
    Route::post('/keunggulan', [AdvantageController::class, 'store'])->name('advantages.store')->middleware('role:super_admin,editor_content');
    Route::patch('/keunggulan/{id}', [AdvantageController::class, 'update'])->name('advantages.update')->middleware('role:super_admin,editor_content');
    Route::delete('/keunggulan/{id}', [AdvantageController::class, 'destroy'])->name('advantages.destroy')->middleware('role:super_admin,editor_content');

    Route::get('/fasilitas', [FacilityController::class, 'index'])->name('facilities.index')->middleware('role:super_admin,editor_content');
    Route::post('/fasilitas', [FacilityController::class, 'store'])->name('facilities.store')->middleware('role:super_admin,editor_content');
    Route::patch('/fasilitas/{id}', [FacilityController::class, 'update'])->name('facilities.update')->middleware('role:super_admin,editor_content');
    Route::delete('/fasilitas/{id}', [FacilityController::class, 'destroy'])->name('facilities.destroy')->middleware('role:super_admin,editor_content');

    Route::get('/jurusan', [MajorController::class, 'index'])->name('majors.index')->middleware('role:super_admin,editor_content');
    Route::post('/jurusan', [MajorController::class, 'store'])->name('majors.store')->middleware('role:super_admin,editor_content');
    Route::patch('/jurusan/{id}', [MajorController::class, 'update'])->name('majors.update')->middleware('role:super_admin,editor_content');
    Route::delete('/jurusan/{id}', [MajorController::class, 'destroy'])->name('majors.destroy')->middleware('role:super_admin,editor_content');

    Route::get('/prestasi', [AchievementController::class, 'index'])->name('achievements.index')->middleware('role:super_admin,editor_content');
    Route::post('/prestasi', [AchievementController::class, 'store'])->name('achievements.store')->middleware('role:super_admin,editor_content');
    Route::patch('/prestasi/{id}', [AchievementController::class, 'update'])->name('achievements.update')->middleware('role:super_admin,editor_content');
    Route::delete('/prestasi/{id}', [AchievementController::class, 'destroy'])->name('achievements.destroy')->middleware('role:super_admin,editor_content');

    Route::get('/galeri', [GalleryController::class, 'index'])->name('galleries.index')->middleware('role:super_admin,editor_content');
    Route::post('/galeri', [GalleryController::class, 'store'])->name('galleries.store')->middleware('role:super_admin,editor_content');
    Route::patch('/galeri/{id}', [GalleryController::class, 'update'])->name('galleries.update')->middleware('role:super_admin,editor_content');
    Route::delete('/galeri/{id}', [GalleryController::class, 'destroy'])->name('galleries.destroy')->middleware('role:super_admin,editor_content');

    Route::get('/kontak', [SchoolContactController::class, 'index'])->name('contacts.index')->middleware('role:super_admin,editor_content');
    Route::patch('/kontak/update', [SchoolContactController::class, 'update'])->name('contacts.update')->middleware('role:super_admin,editor_content');

    // Brochure (super_admin, admin_ppdb)
    Route::get('/brosur', [BrochureController::class, 'index'])->name('brochures.index')->middleware('role:super_admin,admin_ppdb');
    Route::post('/brosur', [BrochureController::class, 'store'])->name('brochures.store')->middleware('role:super_admin,admin_ppdb');
    Route::patch('/brosur/{id}/activate', [BrochureController::class, 'activate'])->name('brochures.activate')->middleware('role:super_admin,admin_ppdb');
    Route::delete('/brosur/{id}', [BrochureController::class, 'destroy'])->name('brochures.destroy')->middleware('role:super_admin,admin_ppdb');

    // News Management
    Route::get('/berita', [\App\Http\Controllers\Admin\NewsController::class, 'index'])->name('news.index')->middleware('role:super_admin,editor_content');
    Route::post('/berita', [\App\Http\Controllers\Admin\NewsController::class, 'store'])->name('news.store')->middleware('role:super_admin,editor_content');
    Route::get('/berita/{id}/edit-data', [\App\Http\Controllers\Admin\NewsController::class, 'editData'])->name('news.editData')->middleware('role:super_admin,editor_content');
    Route::patch('/berita/{id}', [\App\Http\Controllers\Admin\NewsController::class, 'update'])->name('news.update')->middleware('role:super_admin,editor_content');
    Route::delete('/berita/{id}', [\App\Http\Controllers\Admin\NewsController::class, 'destroy'])->name('news.destroy')->middleware('role:super_admin,editor_content');

    // Announcements Management
    Route::get('/pengumuman', [\App\Http\Controllers\Admin\AnnouncementController::class, 'index'])->name('announcements.index')->middleware('role:super_admin,editor_content');
    Route::post('/pengumuman', [\App\Http\Controllers\Admin\AnnouncementController::class, 'store'])->name('announcements.store')->middleware('role:super_admin,editor_content');
    Route::patch('/pengumuman/{id}', [\App\Http\Controllers\Admin\AnnouncementController::class, 'update'])->name('announcements.update')->middleware('role:super_admin,editor_content');
    Route::delete('/pengumuman/{id}', [\App\Http\Controllers\Admin\AnnouncementController::class, 'destroy'])->name('announcements.destroy')->middleware('role:super_admin,editor_content');
});
