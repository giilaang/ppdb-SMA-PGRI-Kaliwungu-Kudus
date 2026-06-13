<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolContact;
use Illuminate\Http\Request;

class SchoolContactController extends Controller
{
    public function index()
    {
        $contact = SchoolContact::first();
        if (!$contact) {
            $contact = SchoolContact::create([
                'whatsapp' => '628812942590',
                'email' => 'ppdb@smapgrikaliwungu.sch.id',
                'address' => 'Jl. Raya Kaliwungu - Kudus, Kaliwungu, Kabupaten Kudus, Jawa Tengah, 59332',
                'google_maps_iframe' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.0805096538676!2d110.80336217499616!3d-6.797284693192089!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e70c57c4c015b67%3A0x633d266e7a256958!2sSMA%20PGRI%20Kaliwungu!5e0!3m2!1sid!2sid!4v1715680000000!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            ]);
        }
        return view('admin.contacts.index', compact('contact'));
    }

    public function update(Request $request)
    {
        $contact = SchoolContact::firstOrFail();

        $request->validate([
            'whatsapp' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'google_maps_iframe' => 'nullable|string',
            'instagram' => 'nullable|url|max:255',
            'facebook' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'tiktok' => 'nullable|url|max:255',
        ]);

        $contact->update($request->all());

        return redirect()->route('admin.contacts.index')->with('success', 'Kontak sekolah berhasil diperbarui.');
    }
}
