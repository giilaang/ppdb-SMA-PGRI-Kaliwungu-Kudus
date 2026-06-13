<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::all();
        return view('admin.facilities.index', compact('facilities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('facilities', 'public');
            $imagePath = 'storage/' . $path;
        }

        Facility::create([
            'name' => $request->name,
            'description' => $request->description,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $facility = Facility::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'description']);

        if ($request->hasFile('image')) {
            // Delete old
            if ($facility->image_path && !str_contains($facility->image_path, 'unsplash.com') && Storage::disk('public')->exists(str_replace('storage/', '', $facility->image_path))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $facility->image_path));
            }
            $path = $request->file('image')->store('facilities', 'public');
            $data['image_path'] = 'storage/' . $path;
        }

        $facility->update($data);

        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $facility = Facility::findOrFail($id);

        // Delete photo
        if ($facility->image_path && !str_contains($facility->image_path, 'unsplash.com') && Storage::disk('public')->exists(str_replace('storage/', '', $facility->image_path))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $facility->image_path));
        }

        $facility->delete();

        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil dihapus.');
    }
}
