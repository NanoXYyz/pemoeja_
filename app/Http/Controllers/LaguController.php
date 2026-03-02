<?php

namespace App\Http\Controllers;

use App\Models\Lagu;
use App\Models\Setting;
use Illuminate\Http\Request;

class LaguController extends Controller
{
    public function index()
    {
        $lagus   = Lagu::all();
        // Kirim opsi key ke view agar select transpose juga dinamis
        $keyOptions = Lagu::getKeyOptions();

        return view('lagu.index', compact('lagus', 'keyOptions'));
    }

    public function create()
    {
        $lagus      = Lagu::all();
        $keyOptions = Lagu::getKeyOptions();

        return view('lagu.create', compact('lagus', 'keyOptions'));
    }

    public function store(Request $request)
    {
        $keyOptions = implode(',', Lagu::getKeyOptions());

        $request->validate([
            'title' => 'required|string|max:255',
            'key'   => "required|in:{$keyOptions}",
            'lirik' => 'required|string',
            'reff'  => 'nullable|string',
        ], [
            'title.required' => 'JUDUL HARUS DI ISI !!!',
            'key.required'   => 'CHORD HARUS DI ISI !!!',
            'key.in'         => 'CHORD TIDAK VALID !!!',
            'lirik.required' => 'LIRIK HARUS DI ISI !!!',
        ]);

        Lagu::create($request->only(['title', 'key', 'lirik', 'reff']));
        return redirect()->route('lagu.index')->with('success', 'Lagu berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $lagus      = Lagu::findOrFail($id);
        $keyOptions = Lagu::getKeyOptions();

        return view('lagu.edit', compact('lagus', 'keyOptions'));
    }

    public function update(Request $request, string $id)
    {
        $keyOptions = implode(',', Lagu::getKeyOptions());

        $request->validate([
            'title' => 'required|string|max:255',
            'key'   => "required|in:{$keyOptions}",
            'lirik' => 'required|string',
            'reff'  => 'nullable|string',
        ], [
            'title.required' => 'JUDUL HARUS DI ISI !!!',
            'key.required'   => 'CHORD HARUS DI ISI !!!',
            'key.in'         => 'CHORD TIDAK VALID !!!',
            'lirik.required' => 'LIRIK HARUS DI ISI !!!',
        ]);

        Lagu::findOrFail($id)->update($request->only(['title', 'key', 'lirik', 'reff']));
        return redirect()->route('lagu.index')->with('success', 'Lagu berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        Lagu::destroy($id);
        return redirect()->route('lagu.index')->with('success', 'Lagu berhasil dihapus!');
    }
}