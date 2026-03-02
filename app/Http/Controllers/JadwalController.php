<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Setting;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalController extends Controller
{
    public function index()
    {
        $allJadwal    = Jadwal::orderBy('tanggal', 'asc')->get();
        $activeJadwal = Jadwal::where('tanggal', '>=', Carbon::today())
                              ->orderBy('tanggal', 'asc')
                              ->first();

        // Opsi dari settings untuk form tambah jadwal
        $titleOptions  = Jadwal::getTitleOptions();
        $tempatOptions = Jadwal::getTempatOptions();

        $events = $allJadwal->map(fn($item) => [
            'id'            => $item->id,
            'title'         => $item->title,
            'start'         => $item->tanggal,
            'extendedProps' => [
                'tempat' => $item->tempat,
                'mc'     => $item->mc,
                'pf'     => $item->pf,
            ],
        ]);

        return view('jadwal.index', compact('allJadwal', 'activeJadwal', 'events', 'titleOptions', 'tempatOptions'));
    }

    public function store(Request $request)
    {
        $rules = Jadwal::validationRules();
        $request->validate($rules, [
            'title.required'   => 'NAMA ACARA HARUS DI ISI!',
            'tanggal.required' => 'TANGGAL HARUS DI ISI!',
            'tempat.required'  => 'TEMPAT HARUS DI ISI!',
            'mc.required'      => 'WORSHIP LEADER HARUS DI ISI!',
            'pf.required'      => 'PELAYAN FIRMAN HARUS DI ISI!',
        ]);

        Jadwal::create($request->only(['title', 'tanggal', 'tempat', 'mc', 'pf']));
        return redirect()->back()->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function destroy(string $id)
    {
        Jadwal::destroy($id);
        return redirect()->back()->with('success', 'Jadwal berhasil dihapus!');
    }
}