<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Brochure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrochureController extends Controller
{
    public function index(Request $request)
    {
        $years = AcademicYear::orderBy('year', 'desc')->get();
        $selectedYearId = $request->get('academic_year_id');

        if (!$selectedYearId) {
            $activeYear = AcademicYear::where('is_active', true)->first();
            $selectedYearId = $activeYear ? $activeYear->id : ($years->first() ? $years->first()->id : null);
        }

        $brochures = [];
        if ($selectedYearId) {
            $brochures = Brochure::where('academic_year_id', $selectedYearId)->get();
        }

        return view('admin.brochures.index', compact('years', 'selectedYearId', 'brochures'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'title' => 'required|string|max:255',
            'brochure_file' => 'required|file|mimes:pdf|max:5120', // max 5MB PDF
        ], [
            'brochure_file.mimes' => 'Berkas brosur harus berformat PDF.',
            'brochure_file.max' => 'Ukuran berkas brosur tidak boleh melebihi 5MB.',
        ]);

        $filePath = null;
        if ($request->hasFile('brochure_file')) {
            $filePath = $request->file('brochure_file')->store('brochures', 'local'); // store in private disk
        }

        // If this is set as active, deactivate other brochures for this academic year
        Brochure::where('academic_year_id', $request->academic_year_id)->update(['is_active' => false]);

        Brochure::create([
            'academic_year_id' => $request->academic_year_id,
            'title' => $request->title,
            'file_path' => $filePath,
            'is_active' => true,
        ]);

        return redirect()->route('admin.brochures.index', ['academic_year_id' => $request->academic_year_id])
            ->with('success', 'Brosur berhasil diunggah.');
    }

    public function activate($id)
    {
        $brochure = Brochure::findOrFail($id);
        
        // Deactivate all others for this academic year
        Brochure::where('academic_year_id', $brochure->academic_year_id)->update(['is_active' => false]);
        
        // Activate current
        $brochure->update(['is_active' => true]);

        return redirect()->route('admin.brochures.index', ['academic_year_id' => $brochure->academic_year_id])
            ->with('success', 'Brosur aktif berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $brochure = Brochure::findOrFail($id);
        $academic_year_id = $brochure->academic_year_id;

        // Delete file
        if ($brochure->file_path && Storage::disk('local')->exists($brochure->file_path)) {
            Storage::disk('local')->delete($brochure->file_path);
        }

        $brochure->delete();

        return redirect()->route('admin.brochures.index', ['academic_year_id' => $academic_year_id])
            ->with('success', 'Brosur berhasil dihapus.');
    }
}
