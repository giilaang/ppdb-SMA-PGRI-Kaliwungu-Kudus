<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AchievementController extends Controller
{
    public function index()
    {
        $achievements = Achievement::orderBy('year', 'desc')->get();
        return view('admin.achievements.index', compact('achievements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|string|max:4',
            'level' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('achievements', 'public');
            $imagePath = 'storage/' . $path;
        }

        Achievement::create([
            'title' => $request->title,
            'year' => $request->year,
            'level' => $request->level,
            'description' => $request->description,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.achievements.index')->with('success', 'Prestasi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $achievement = Achievement::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|string|max:4',
            'level' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title', 'year', 'level', 'description']);

        if ($request->hasFile('image')) {
            // Delete old
            if ($achievement->image_path && !str_contains($achievement->image_path, 'unsplash.com') && Storage::disk('public')->exists(str_replace('storage/', '', $achievement->image_path))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $achievement->image_path));
            }
            $path = $request->file('image')->store('achievements', 'public');
            $data['image_path'] = 'storage/' . $path;
        }

        $achievement->update($data);

        return redirect()->route('admin.achievements.index')->with('success', 'Prestasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $achievement = Achievement::findOrFail($id);

        // Delete photo
        if ($achievement->image_path && !str_contains($achievement->image_path, 'unsplash.com') && Storage::disk('public')->exists(str_replace('storage/', '', $achievement->image_path))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $achievement->image_path));
        }

        $achievement->delete();

        return redirect()->route('admin.achievements.index')->with('success', 'Prestasi berhasil dihapus.');
    }
}
