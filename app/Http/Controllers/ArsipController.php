<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use Illuminate\Http\Request;

class ArsipController extends Controller
{
    public function index()
    {
        $arsip             = Arsip::orderBy('tahun', 'desc')->get();
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
        $validated = $request->validate(Arsip::validationRules(), [
            'tahun.required' => 'TAHUN HARUS DI ISI !',
            'tahun.integer'  => 'TAHUN HARUS BERUPA ANGKA !',
            'tahun.min'      => 'TAHUN MINIMAL 2000 !',
            'tahun.max'      => 'TAHUN TIDAK BOLEH MELEBIHI TAHUN INI !',
            'keterangan.required' => 'KETERANGAN HARUS DI ISI !',
            'keterangan.in'       => 'KETERANGAN TIDAK VALID !',
            'link.required'  => 'LINK HARUS DI ISI !',
            'link.url'       => 'FORMAT LINK TIDAK VALID ! Gunakan format: https://...',
        ]);

        Arsip::create([
            'tahun'      => $validated['tahun'] . '-01-01',
            'keterangan' => $validated['keterangan'],
            'link'       => $validated['link'],
        ]);

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
        $validated = $request->validate(Arsip::validationRules(), [
            'tahun.required' => 'TAHUN HARUS DI ISI !',
            'tahun.integer'  => 'TAHUN HARUS BERUPA ANGKA !',
            'tahun.min'      => 'TAHUN MINIMAL 2000 !',
            'tahun.max'      => 'TAHUN TIDAK BOLEH MELEBIHI TAHUN INI !',
            'keterangan.required' => 'KETERANGAN HARUS DI ISI !',
            'keterangan.in'       => 'KETERANGAN TIDAK VALID !',
            'link.required'  => 'LINK HARUS DI ISI !',
            'link.url'       => 'FORMAT LINK TIDAK VALID ! Gunakan format: https://...',
        ]);

        $arsip = Arsip::findOrFail($id);
        $arsip->update([
            'tahun'      => $validated['tahun'] . '-01-01',
            'keterangan' => $validated['keterangan'],
            'link'       => $validated['link'],
        ]);

        return redirect()->route('arsip.index')->with('success', 'Arsip berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        Arsip::findOrFail($id)->delete();
        return redirect()->route('arsip.index')->with('success', 'Arsip berhasil dihapus!');
    }
}