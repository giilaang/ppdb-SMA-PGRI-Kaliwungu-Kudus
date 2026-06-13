<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        // Only select columns needed for the list — NOT loading full 'content' body for every row
        $news = News::select(['id', 'title', 'slug', 'image_path', 'published_at'])
            ->orderBy('published_at', 'desc')
            ->paginate(15);
        return view('admin.news.index', compact('news'));
    }

    /**
     * Return JSON data for the AJAX-driven edit panel.
     * Content is NOT pre-loaded on the index page — only fetched when the editor clicks Edit.
     */
    public function editData($id)
    {
        $news = News::findOrFail($id);
        return response()->json([
            'id'               => $news->id,
            'title'            => $news->title,
            'content'          => $news->content,
            'published_at_local' => $news->published_at
                ? $news->published_at->format('Y-m-d\TH:i')
                : now()->format('Y-m-d\TH:i'),
            'image_url'        => $news->image_path
                ? (Str::startsWith($news->image_path, 'http')
                    ? $news->image_path
                    : asset($news->image_path))
                : null,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'published_at' => 'required|date',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('news', 'public');
            $imagePath = 'storage/' . $path;
        }

        // Generate unique slug
        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $count = 1;
        while (News::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        News::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'image_path' => $imagePath,
            'published_at' => $request->published_at,
        ]);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'published_at' => 'required|date',
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'published_at' => $request->published_at,
        ];

        // Update slug only if title changed
        if ($news->title !== $request->title) {
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $count = 1;
            while (News::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $data['slug'] = $slug;
        }

        if ($request->hasFile('image')) {
            // Delete old photo
            if ($news->image_path && !str_contains($news->image_path, 'unsplash.com') && Storage::disk('public')->exists(str_replace('storage/', '', $news->image_path))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $news->image_path));
            }
            $path = $request->file('image')->store('news', 'public');
            $data['image_path'] = 'storage/' . $path;
        }

        $news->update($data);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);

        // Delete photo
        if ($news->image_path && !str_contains($news->image_path, 'unsplash.com') && Storage::disk('public')->exists(str_replace('storage/', '', $news->image_path))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $news->image_path));
        }

        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus.');
    }
}
