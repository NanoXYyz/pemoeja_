<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Setting;
use Illuminate\Http\Request;

class ArsipController extends Controller
{
    public function index()
    {
        $arsip             = Arsip::orderBy('tahun', 'desc')->get();
        // Opsi kategori dari settings untuk filter tab dan form
        $keteranganOptions = Arsip::getKeteranganOptions();

        return view('arsip.index', compact('arsip', 'keteranganOptions'));
    }

    public function create()
    {
        $keteranganOptions = Arsip::getKeteranganOptions();
        return view('arsip.create', compact('keteranganOptions'));
    }

    public function store(Request $request)
    {
        $rules = Arsip::validationRules();
        $request->validate($rules, [
            'tahun.required'      => 'TAHUN HARUS DI ISI !',
            'keterangan.required' => 'KETERANGAN HARUS DI ISI !',
            'link.required'       => 'LINK HARUS DI ISI !',
        ]);

        $data           = $request->only(['keterangan', 'link']);
        $data['tahun']  = $request->tahun . '-01-01';

        Arsip::create($data);
        return redirect()->route('arsip.index')->with('success', 'Arsip berhasil disimpan!');
    }

    public function edit(string $id)
    {
        $arsip             = Arsip::findOrFail($id);
        $keteranganOptions = Arsip::getKeteranganOptions();

        return view('arsip.edit', compact('arsip', 'keteranganOptions'));
    }

    public function update(Request $request, string $id)
    {
        $rules = Arsip::validationRules();
        $request->validate($rules, [
            'tahun.required'      => 'TAHUN HARUS DI ISI !',
            'keterangan.required' => 'KETERANGAN HARUS DI ISI !',
            'link.required'       => 'LINK HARUS DI ISI !',
        ]);

        $arsip         = Arsip::findOrFail($id);
        $data          = $request->only(['keterangan', 'link']);
        $data['tahun'] = $request->tahun . '-01-01';

        $arsip->update($data);
        return redirect()->route('arsip.index')->with('success', 'Arsip berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        Arsip::destroy($id);
        return redirect()->route('arsip.index')->with('success', 'Arsip berhasil dihapus!');
    }
}