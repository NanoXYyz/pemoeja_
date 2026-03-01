<?php

namespace App\Http\Controllers;

use App\Models\Lagu;
use Illuminate\Http\Request;

class LaguController extends Controller
{
    public function index()
    {
        // Mengambil semua data lagu dari database
        $lagus = Lagu::all(); 
        return view('lagu.index', compact('lagus'));
    }

    public function create()
    {
        $lagus = Lagu::all();
        return view('lagu.create', compact('lagus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'key' => 'required',
            'lirik' => 'required',
        ], [
            'title.required' => 'JUDUL HARUS DI ISI !!!',
            'key.required' => 'CHORD HARUS DI ISI !!!',
            'lirik.required' => 'LIRIK HARUS DI ISI !!!',
        ]);

        Lagu::create($request->all());
        return redirect()->route('lagu.index')->with('success', 'Lagu berhasil ditambahkan!');
    }

    public function edit(String $id) {
        $lagus = Lagu::find($id);
        return view('lagu.edit', compact('lagus'));
    }

    public function update(Request $request, String $id) {
        $request->validate([
            'title' => 'required',
            'key' => 'required',
            'lirik' => 'required',
        ], [
            'title.required' => 'JUDUL HARUS DI ISI !!!',
            'key.required' => 'CHORD HARUS DI ISI !!!',
            'lirik.required' => 'LIRIK HARUS DI ISI !!!',
        ]);
    }

    public function destroy(String $id) {
        Lagu::destroy($id);
        return redirect()->route('lagu.index')->with('sucsses');
    }
}
