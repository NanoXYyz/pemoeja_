<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalController extends Controller
{
    public function index()
    {
        // Mengambil semua jadwal untuk daftar samping
        $allJadwal = Jadwal::orderBy('tanggal', 'asc')->get();

        // Jadwal terdekat untuk detail awal
        $activeJadwal = Jadwal::where('tanggal', '>=', Carbon::today())
                               ->orderBy('tanggal', 'asc')
                               ->first();

        // Format data untuk FullCalendar
        $events = $allJadwal->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'start' => $item->tanggal,
                'extendedProps' => [
                    'tempat' => $item->tempat,
                    'mc' => $item->mc,
                    'pf' => $item->pf,
                ]
            ];
        });

        return view('jadwal.index', compact('allJadwal', 'activeJadwal', 'events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'tempat' => 'required|string|max:255',
            'pf' => 'required|string|max:255',
            'mc' => 'required|string|max:255',
        ]);

        Jadwal::create($validated);

        return redirect()->back()->with('success', 'Jadwal berhasil ditambahkan!');
    }
}