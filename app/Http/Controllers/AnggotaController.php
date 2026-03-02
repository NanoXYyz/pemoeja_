<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Setting;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = Anggota::all();

        // Mengambil opsi dari settings untuk dropdown di modal dan chart
        $genderOptions  = Setting::getOptions('anggota', 'gender');
        $statusOptions  = Setting::getOptions('anggota', 'status');
        $jabatanOptions = Setting::getOptions('anggota', 'jabatan');

        // Menyiapkan data untuk Chart
        $dataGender = collect($genderOptions)->mapWithKeys(fn($g) => [$g => Anggota::where('gender', $g)->count()]);
        $dataStatus = collect($statusOptions)->mapWithKeys(fn($s) => [$s => Anggota::where('status', $s)->count()]);

        return view('anggota.index', compact(
            'anggota', 
            'dataStatus', 
            'dataGender', 
            'genderOptions', 
            'statusOptions', 
            'jabatanOptions'
        ));
    }

    public function store(Request $request)
    {
        $rules = Anggota::validationRules();
        $request->validate($rules);

        // Validasi kuota jabatan
        $limits = $this->getJabatanLimits();
        if (isset($limits[$request->jabatan])) {
            $count = Anggota::where('jabatan', $request->jabatan)->count();
            if ($count >= $limits[$request->jabatan]) {
                return back()->withErrors(['jabatan' => "Kuota untuk jabatan {$request->jabatan} sudah penuh."]);
            }
        }

        Anggota::create($request->only(['nama', 'gender', 'status', 'jabatan']));
        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function update(Request $request, string $id)
    {
        $rules = Anggota::validationRules();
        $request->validate($rules);

        Anggota::findOrFail($id)->update($request->only(['nama', 'gender', 'status', 'jabatan']));
        return redirect()->route('anggota.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        Anggota::destroy($id);
        return redirect()->route('anggota.index')->with('success', 'Anggota dihapus!');
    }

    private function getJabatanLimits(): array
    {
        return [
            'ketua' => 1, 'wakil' => 1, 'sekretaris' => 2, 'bendahara' => 2, 'persekutuan' => 4,
        ];
    }
}