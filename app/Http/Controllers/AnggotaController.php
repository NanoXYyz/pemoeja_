<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Settings;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index()
    {

        $anggota = Anggota::all();
        // dd($anggota);    

        $dataStatus = [
            'pelajar' => Anggota::where('status', 'pelajar')->count(),
            'bekerja' => Anggota::where('status', 'bekerja')->count(),
        ];

        $dataGender = [
            'laki'      => Anggota::where('gender', 'laki-laki')->count(),
            'perempuan' => Anggota::where('gender', 'perempuan')->count(),
        ];

        return view('anggota.index', compact('anggota', 'dataStatus', 'dataGender'));
    }

    // public function create() {

    //     $title = 'tambah/anggota';

    //     return view('anggota.create', compact('title'));
    // }
    public function create() {
    $title = 'tambah/anggota';
    
    // Ambil daftar jabatan dari database settings
    $settingJabatan = Settings::where('key', 'jabatan_anggota')->first();
    $listJabatan = $settingJabatan ? $settingJabatan->values : [];

    return view('anggota.create', compact('title', 'listJabatan'));
    }

    public function store(Request $request) 
    {
    // 1. Validasi Format Input
    $request->validate([
        'nama'    => 'required',
        'gender'  => 'required|in:laki-laki,perempuan',
        'status'  => 'required|in:pelajar,bekerja',
        'jabatan' => 'required|in:ketua,sekretaris,bendahara,persekutuan,anggota',
    ], [
        'nama.required'    => 'NAMA HARUS DI ISI',
        'gender.required'  => 'GENDER HARUS DI ISI',
        'gender.in'        => 'GENDER HARUS LAKI-LAKI ATAU PEREMPUAN',
        'status.required'  => 'STATUS HARUS DI ISI',
        'status.in'        => 'STATUS HARUS PELAJAR ATAU BEKERJA',
        'jabatan.required' => 'JABATAN HARUS DI ISI',
        'jabatan.in'       => 'JABATAN HARUS SESUAI PILIHAN',
    ]);

    $limits = [
        'ketua'       => 1,
        'wakil'       => 1,
        'sekretaris'  => 2,
        'bendahara'   => 2,
        'persekutuan' => 4,
    ];

    $jabatanDipilih = $request->jabatan;

    if (array_key_exists($jabatanDipilih, $limits)) {
        $jumlahSekarang = Anggota::where('jabatan', $jabatanDipilih)->count();

        if ($jumlahSekarang >= $limits[$jabatanDipilih]) {
            return back()->withInput()->withErrors([
                'jabatan' => "Maaf, kuota untuk jabatan {$jabatanDipilih} sudah penuh (Maksimal {$limits[$jabatanDipilih]} orang)."
            ]);
        }
    }
    Anggota::create($request->all());

    return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil ditambahkan!');
    }

    public function edit(String $id) {
        $anggota = Anggota::find($id);
        return view('anggota.edit', compact('anggota'));
    }

    public function update(Request $request, String $id) {
        $request->validate([
            'nama'      => 'required',
            'gender'    => 'required|in:laki-laki,perempuan',
            'status'    => 'required|in:pelajar,bekerja',
            'jabatan'   => 'required|in:ketua,sekertaris,bendahara,persekutuan,anggota',
        ], [
            'nama.required'     => 'NAMA HARUS DI ISI',
            'gender.required'   => 'GENDER HARUS DI ISI',
            'gender.in'         => 'GENDER HARUS LAKI-LAKI ATAU PEREMPUAN',
            'status.required'   => 'STATUS HARUS DI ISI',
            'status.in'         => 'STATUS HARUS PELAJAR ATAU BEKERJA',
            'jabatan.required'  => 'JABATAN HARUS DI ISI',
            'jabatan.in'        => 'JABATAN HARUS DI ISI (KETUA, SEKRETARIS, BENDAHARA, PERSEKUTUAN, ANGGOTA)',
        ]);

        $anggota = Anggota::findOrFail($id);

        $anggota->update($request->all());
        return redirect()->route('anggota.index')->with('sucsses');
    }

    public function destroy(String $id) {
        Anggota::destroy($id);
        return redirect()->route('anggota.index')->with('sucsses');
    }
}
