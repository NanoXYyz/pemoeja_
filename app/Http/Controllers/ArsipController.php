<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use Illuminate\Http\Request;

class ArsipController extends Controller
{
    public function index() {
        $arsip = Arsip::all();
        return view('arsip.index', compact('arsip'));
    }

    public function create() {
        return view('arsip.create');
    }

    public function store(Request $request) {
        $request->validate([
            'tahun'     => 'required',
            'keterangan'=> 'required',
            'link'      => 'required',
        ], [
            'tahun.required'        => 'TAHUN HARUS DI ISI !',
            'keterangan.required'   => 'KETERANGAN HARUS DI ISI !',
            'link.required'         => 'LINK HARUS DI ISI !',
        ]);

        $data = $request->all();
        $data['tahun'] = $request->tahun . '-01-01';

        Arsip::create($data);
        return redirect()->route('arsip.index');
    }

    public function edit(String $id) {
        $arsip = Arsip::find($id);
        return view('arsip.edit', compact('arsip'));
    }

    public function update(Request $request, String $id) {
        $request->validate([
            'tahun'     => 'required',
            'keterangan'=> 'required',
            'link'      => 'required',
        ], [
            'tahun.required'        => 'TAHUN HARUS DI ISI !',
            'keterangan.required'   => 'KETERANGAN HARUS DI ISI !',
            'link.required'         => 'LINK HARUS DI ISI !',
        ]);

        $arsip = Arsip::findOrFail($id);

        $arsip->update($request->all());
        return redirect()->route('arsip.index')->with('sucsses');
    }

    public function destroy(String $id) {
        Arsip::destroy($id);
        return redirect()->route('arsip.index')->with('sucsses');
    }
}
