<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advantage;
use Illuminate\Http\Request;

class AdvantageController extends Controller
{
    public function index()
    {
        $advantages = Advantage::orderBy('order', 'asc')->get();
        return view('admin.advantages.index', compact('advantages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string', // SVG tag or class name
            'order' => 'required|integer',
        ]);

        Advantage::create($request->all());

        return redirect()->route('admin.advantages.index')->with('success', 'Keunggulan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $advantage = Advantage::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string',
            'order' => 'required|integer',
        ]);

        $advantage->update($request->all());

        return redirect()->route('admin.advantages.index')->with('success', 'Keunggulan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $advantage = Advantage::findOrFail($id);
        $advantage->delete();

        return redirect()->route('admin.advantages.index')->with('success', 'Keunggulan berhasil dihapus.');
    }
}
