<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\HeroSection;
use App\Models\PpdbSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AcademicYearController extends Controller
{
    public function index()
    {
        $years = AcademicYear::orderBy('year', 'desc')->get();
        return view('admin.academic-years.index', compact('years'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|string|max:20|unique:academic_years,year',
        ], [
            'year.unique' => 'Tahun ajaran ini sudah terdaftar.',
        ]);

        DB::transaction(function () use ($request) {
            $year = AcademicYear::create([
                'year' => $request->year,
                'is_active' => false,
                'is_archived' => false,
            ]);

            // Initialize defaults for this year to prevent crashes
            HeroSection::create([
                'academic_year_id' => $year->id,
                'title' => 'SMA PGRI KALIWUNGU KUDUS',
                'subtitle' => 'Segera bergabung bersama sekolah unggulan yang membentuk generasi cerdas, berkarakter, dan berprestasi.',
                'register_button_text' => 'Daftar Sekarang',
                'brochure_button_text' => 'Download Brosur',
            ]);

            PpdbSetting::create([
                'academic_year_id' => $year->id,
                'status' => 'closed',
                'quota' => 100,
                'requirements_text' => "1. Fotokopi Ijazah & SKHUN\n2. Fotokopi Akta Kelahiran & KK\n3. Pas Foto 3x4",
                'flow_text' => "1. Isi Formulir Online\n2. Verifikasi Berkas\n3. Pengumuman\n4. Daftar Ulang",
                'fees_text' => 'Pendaftaran Gratis.',
                'schedule_text' => 'Gelombang I: Januari - Maret',
            ]);
        });

        return redirect()->route('admin.academic-years.index')->with('success', 'Tahun ajaran baru berhasil dibuat.');
    }

    public function activate($id)
    {
        DB::transaction(function () use ($id) {
            // Deactivate all
            AcademicYear::query()->update(['is_active' => false]);
            
            // Activate selected
            $year = AcademicYear::findOrFail($id);
            $year->update(['is_active' => true]);
        });

        return redirect()->route('admin.academic-years.index')->with('success', 'Tahun ajaran aktif berhasil diubah.');
    }

    public function toggleArchive($id)
    {
        $year = AcademicYear::findOrFail($id);
        if ($year->is_active) {
            return back()->with('error', 'Tahun ajaran aktif tidak dapat diarsipkan.');
        }

        $year->update(['is_archived' => !$year->is_archived]);
        
        $status = $year->is_archived ? 'diarsipkan' : 'diaktifkan kembali dari arsip';
        return redirect()->route('admin.academic-years.index')->with('success', "Tahun ajaran berhasil {$status}.");
    }

    public function destroy($id)
    {
        $year = AcademicYear::findOrFail($id);
        if ($year->is_active) {
            return back()->with('error', 'Tahun ajaran aktif tidak dapat dihapus.');
        }

        $year->delete(); // Cascading deletes will handle hero, settings, registrants, etc.
        return redirect()->route('admin.academic-years.index')->with('success', 'Tahun ajaran berhasil dihapus beserta data di dalamnya.');
    }
}
