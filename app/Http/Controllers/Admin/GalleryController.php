<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::all();
        return view('admin.galleries.index', compact('galleries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'image' => 'required|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('galleries', 'public');
            $imagePath = 'storage/' . $path;
        }

        Gallery::create([
            'title' => $request->title,
            'category' => $request->category,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.galleries.index')->with('success', 'Galeri berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'title' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'category' => $request->category,
        ];

        if ($request->hasFile('image')) {
            // Delete old
            if ($gallery->image_path && !str_contains($gallery->image_path, 'unsplash.com') && Storage::disk('public')->exists(str_replace('storage/', '', $gallery->image_path))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $gallery->image_path));
            }
            $path = $request->file('image')->store('galleries', 'public');
            $data['image_path'] = 'storage/' . $path;
        }

        $gallery->update($data);

        return redirect()->route('admin.galleries.index')->with('success', 'Galeri berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);

        // Delete photo
        if ($gallery->image_path && !str_contains($gallery->image_path, 'unsplash.com') && Storage::disk('public')->exists(str_replace('storage/', '', $gallery->image_path))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $gallery->image_path));
        }

        $gallery->delete();

        return redirect()->route('admin.galleries.index')->with('success', 'Galeri berhasil dihapus.');
    }
}
