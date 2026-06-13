<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MajorController extends Controller
{
    public function index()
    {
        $majors = Major::all();
        return view('admin.majors.index', compact('majors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:majors,name',
            'description' => 'required|string',
            'image' => 'required|image|max:2048',
        ], [
            'name.unique' => 'Nama jurusan sudah terdaftar.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('majors', 'public');
            $imagePath = 'storage/' . $path;
        }

        Major::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.majors.index')->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $major = Major::findOrFail($id);

        $request->validate([
            'name' => "required|string|max:255|unique:majors,name,{$id}",
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            // Delete old
            if ($major->image_path && !str_contains($major->image_path, 'unsplash.com') && Storage::disk('public')->exists(str_replace('storage/', '', $major->image_path))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $major->image_path));
            }
            $path = $request->file('image')->store('majors', 'public');
            $data['image_path'] = 'storage/' . $path;
        }

        $major->update($data);

        return redirect()->route('admin.majors.index')->with('success', 'Jurusan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $major = Major::findOrFail($id);

        // Delete photo
        if ($major->image_path && !str_contains($major->image_path, 'unsplash.com') && Storage::disk('public')->exists(str_replace('storage/', '', $major->image_path))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $major->image_path));
        }

        $major->delete();

        return redirect()->route('admin.majors.index')->with('success', 'Jurusan berhasil dihapus.');
    }
}
