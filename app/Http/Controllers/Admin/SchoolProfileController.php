<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SchoolProfileController extends Controller
{
    public function index()
    {
        $profile = SchoolProfile::first();
        if (!$profile) {
            $profile = SchoolProfile::create([
                'description' => 'Isi deskripsi sekolah disini...',
                'vision' => 'Isi visi disini...',
                'mission' => 'Isi misi disini...',
                'principal_welcome_name' => 'Nama Kepala Sekolah',
                'principal_welcome_title' => 'Kepala Sekolah',
                'principal_welcome_text' => 'Sambutan kepala sekolah...',
                'history' => 'Sejarah sekolah...',
            ]);
        }
        return view('admin.profile.index', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = SchoolProfile::firstOrFail();

        $request->validate([
            'description' => 'required|string',
            'vision' => 'required|string',
            'mission' => 'required|string',
            'principal_welcome_name' => 'required|string|max:255',
            'principal_welcome_title' => 'required|string|max:255',
            'principal_welcome_text' => 'required|string',
            'principal_welcome_photo' => 'nullable|image|max:2048',
            'history' => 'required|string',
            'video' => 'nullable|file|mimes:mp4,mov,avi,webm|max:51200', // max 50MB
        ]);

        $data = $request->except(['principal_welcome_photo', 'video']);

        if ($request->hasFile('principal_welcome_photo')) {
            // Delete old photo if exists and is not the default seeder reference
            $oldPhotoPath = str_replace('storage/', '', $profile->principal_welcome_photo);
            if ($profile->principal_welcome_photo && !str_contains($profile->principal_welcome_photo, 'images/ppdb/') && Storage::disk('public')->exists($oldPhotoPath)) {
                Storage::disk('public')->delete($oldPhotoPath);
            }
            // Store new photo
            $path = $request->file('principal_welcome_photo')->store('profile', 'public');
            $data['principal_welcome_photo'] = 'storage/' . $path;
        }

        if ($request->hasFile('video')) {
            // Delete old video if exists and is not the default seeder reference
            $oldVideoPath = str_replace('storage/', '', $profile->video_path);
            if ($profile->video_path && !str_contains($profile->video_path, 'images/ppdb/') && Storage::disk('public')->exists($oldVideoPath)) {
                Storage::disk('public')->delete($oldVideoPath);
            }
            // Store new video
            $path = $request->file('video')->store('profile', 'public');
            $data['video_path'] = 'storage/' . $path;
        }

        $profile->update($data);

        return redirect()->route('admin.profile.index')->with('success', 'Profil sekolah berhasil diperbarui.');
    }
}
