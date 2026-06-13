<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AnnouncementController extends Controller
{
    public function index()
    {
        // Only load columns needed for the list — NOT loading full 'content' on every row
        $announcements = Announcement::select(['id', 'title', 'file_path', 'is_active', 'published_at'])
            ->orderBy('published_at', 'desc')
            ->paginate(15);
        return view('admin.announcements.index', compact('announcements'));
    }

    /**
     * Return JSON for the AJAX edit panel (full content only loaded on demand).
     */
    public function editData($id)
    {
        $ann = Announcement::findOrFail($id);
        return response()->json([
            'id'               => $ann->id,
            'title'            => $ann->title,
            'content'          => $ann->content,
            'is_active'        => (bool) $ann->is_active,
            'published_at_local' => $ann->published_at
                ? $ann->published_at->format('Y-m-d\TH:i')
                : now()->format('Y-m-d\TH:i'),
            'file_url'         => $ann->file_path
                ? (Str::startsWith($ann->file_path, 'http') ? $ann->file_path : asset($ann->file_path))
                : null,
            'file_name'        => $ann->file_path ? basename($ann->file_path) : null,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'file' => 'nullable|file|max:5120', // Max 5MB file attachment
            'published_at' => 'required|date',
            'is_active' => 'nullable|boolean',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('announcements', 'public');
            $filePath = 'storage/' . $path;
        }

        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'file_path' => $filePath,
            'is_active' => $request->has('is_active') ? (bool)$request->is_active : true,
            'published_at' => $request->published_at,
        ]);

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'file' => 'nullable|file|max:5120',
            'published_at' => 'required|date',
            'is_active' => 'nullable|boolean',
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'published_at' => $request->published_at,
            'is_active' => $request->has('is_active') ? (bool)$request->is_active : false,
        ];

        if ($request->hasFile('file')) {
            // Delete old file
            if ($announcement->file_path && Storage::disk('public')->exists(str_replace('storage/', '', $announcement->file_path))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $announcement->file_path));
            }
            $path = $request->file('file')->store('announcements', 'public');
            $data['file_path'] = 'storage/' . $path;
        }

        $announcement->update($data);

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);

        // Delete file
        if ($announcement->file_path && Storage::disk('public')->exists(str_replace('storage/', '', $announcement->file_path))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $announcement->file_path));
        }

        $announcement->delete();

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
