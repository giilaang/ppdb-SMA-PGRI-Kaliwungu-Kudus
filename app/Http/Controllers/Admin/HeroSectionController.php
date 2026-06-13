<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class HeroSectionController extends Controller
{
    public function index(Request $request)
    {
        $years = AcademicYear::orderBy('year', 'desc')->get();
        $selectedYearId = $request->get('academic_year_id');

        if (!$selectedYearId) {
            $activeYear = AcademicYear::where('is_active', true)->first();
            $selectedYearId = $activeYear ? $activeYear->id : ($years->first() ? $years->first()->id : null);
        }

        $hero = null;
        if ($selectedYearId) {
            $hero = HeroSection::firstOrCreate(
                ['academic_year_id' => $selectedYearId],
                [
                    'title' => 'SMA PGRI KALIWUNGU KUDUS',
                    'subtitle' => 'Segera bergabung bersama sekolah unggulan yang membentuk generasi cerdas, berkarakter, dan berprestasi.',
                    'register_button_text' => 'Daftar Sekarang',
                    'brochure_button_text' => 'Download Brosur',
                ]
            );
        }

        return view('admin.hero.index', compact('years', 'selectedYearId', 'hero'));
    }

    public function update(Request $request, $id)
    {
        $hero = HeroSection::findOrFail($id);

        $request->validate([
            'title'                => 'required|string|max:500',
            'subtitle'             => 'required|string',
            'register_button_text' => 'required|string|max:100',
            'brochure_button_text' => 'required|string|max:100',
            'banner_image_1'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'banner_image_2'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'banner_image_3'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        // Use only() so _token, _method, academic_year_id are never included
        $data = $request->only([
            'title',
            'subtitle',
            'register_button_text',
            'brochure_button_text',
        ]);

        for ($i = 1; $i <= 3; $i++) {
            $inputName = "banner_image_{$i}";

            if ($request->hasFile($inputName) && $request->file($inputName)->isValid()) {
                try {
                    // Delete old image from storage (skip default seed images)
                    $oldPath = $hero->$inputName;
                    if ($oldPath && !str_starts_with($oldPath, 'images/')) {
                        $storagePath = ltrim(str_replace('storage/', '', $oldPath), '/');
                        if (Storage::disk('public')->exists($storagePath)) {
                            Storage::disk('public')->delete($storagePath);
                        }
                    }

                    // Store the new image
                    $path = $request->file($inputName)->store('hero', 'public');
                    $data[$inputName] = 'storage/' . $path;

                } catch (\Exception $e) {
                    Log::error("Hero banner upload failed for {$inputName}: " . $e->getMessage());
                    return back()
                        ->withErrors(["Gagal mengunggah banner {$i}: " . $e->getMessage()])
                        ->withInput();
                }

            } elseif ($request->boolean("delete_banner_{$i}")) {
                // Hapus banner tanpa menggantinya dengan file baru
                $oldPath = $hero->$inputName;
                if ($oldPath && !str_starts_with($oldPath, 'images/')) {
                    $storagePath = ltrim(str_replace('storage/', '', $oldPath), '/');
                    if (Storage::disk('public')->exists($storagePath)) {
                        Storage::disk('public')->delete($storagePath);
                    }
                }
                $data[$inputName] = null;
            }
        }

        $hero->update($data);

        return redirect()
            ->route('admin.hero.index', ['academic_year_id' => $hero->academic_year_id])
            ->with('success', 'Hero section berhasil diperbarui! 🎉');
    }
}
