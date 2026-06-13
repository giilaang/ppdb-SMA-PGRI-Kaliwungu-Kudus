<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\PpdbSetting;
use Illuminate\Http\Request;

class PpdbSettingController extends Controller
{
    public function index(Request $request)
    {
        $years = AcademicYear::orderBy('year', 'desc')->get();
        $selectedYearId = $request->get('academic_year_id');

        if (!$selectedYearId) {
            $activeYear = AcademicYear::where('is_active', true)->first();
            $selectedYearId = $activeYear ? $activeYear->id : ($years->first() ? $years->first()->id : null);
        }

        $setting = null;
        if ($selectedYearId) {
            $setting = PpdbSetting::firstOrCreate(
                ['academic_year_id' => $selectedYearId],
                [
                    'status' => 'closed',
                    'quota' => 100,
                    'requirements_text' => "1. Fotokopi Ijazah & SKHUN\n2. Fotokopi Akta Kelahiran & KK\n3. Pas Foto 3x4",
                    'flow_text' => "1. Isi Formulir Online\n2. Verifikasi Berkas\n3. Pengumuman\n4. Daftar Ulang",
                    'fees_text' => 'Pendaftaran Gratis.',
                    'schedule_text' => 'Gelombang I: Januari - Maret',
                ]
            );
        }

        return view('admin.ppdb-settings.index', compact('years', 'selectedYearId', 'setting'));
    }

    public function update(Request $request, $id)
    {
        $setting = PpdbSetting::findOrFail($id);

        $request->validate([
            'status' => 'required|in:open,closed',
            'quota' => 'required|integer|min:1',
            'requirements_text' => 'required|string',
            'flow_text' => 'required|string',
            'fees_text' => 'nullable|string',
            'schedule_text' => 'nullable|string',
        ]);

        $setting->update($request->all());

        return back()->with('success', 'Pengaturan PPDB berhasil diperbarui.');
    }
}
