<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\PpdbWave;
use Illuminate\Http\Request;

class PpdbWaveController extends Controller
{
    public function index(Request $request)
    {
        $years = AcademicYear::orderBy('year', 'desc')->get();
        $selectedYearId = $request->get('academic_year_id');

        if (!$selectedYearId) {
            $activeYear = AcademicYear::where('is_active', true)->first();
            $selectedYearId = $activeYear ? $activeYear->id : ($years->first() ? $years->first()->id : null);
        }

        $waves = [];
        if ($selectedYearId) {
            $waves = PpdbWave::where('academic_year_id', $selectedYearId)->get();
        }

        return view('admin.ppdb-waves.index', compact('years', 'selectedYearId', 'waves'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'nullable|boolean',
        ]);

        PpdbWave::create([
            'academic_year_id' => $request->academic_year_id,
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->has('is_active') ? (bool)$request->is_active : true,
        ]);

        return redirect()->route('admin.ppdb-waves.index', ['academic_year_id' => $request->academic_year_id])
            ->with('success', 'Gelombang pendaftaran berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $wave = PpdbWave::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'nullable|boolean',
        ]);

        $wave->update([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->has('is_active') ? (bool)$request->is_active : false,
        ]);

        return redirect()->route('admin.ppdb-waves.index', ['academic_year_id' => $wave->academic_year_id])
            ->with('success', 'Gelombang pendaftaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $wave = PpdbWave::findOrFail($id);
        $academic_year_id = $wave->academic_year_id;
        $wave->delete();

        return redirect()->route('admin.ppdb-waves.index', ['academic_year_id' => $academic_year_id])
            ->with('success', 'Gelombang pendaftaran berhasil dihapus.');
    }
}
