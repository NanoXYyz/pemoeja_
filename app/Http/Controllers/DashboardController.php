<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Models\Anggota;
use App\Models\Arsip;
use App\Models\Keuangan;
use App\Models\Lagu;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard() 
    {
        $dataStatus = [
            'pelajar' => Anggota::where('status', 'pelajar')->count(),
            'bekerja' => Anggota::where('status', 'bekerja')->count(),
        ];

        $dataGender = [
            'laki'      => Anggota::where('gender', 'laki-laki')->count(),
            'perempuan' => Anggota::where('gender', 'perempuan')->count(),
        ];
        
        // Menghitung total semua record di tabel anggota
        $totalAnggota = Anggota::count();
        $totalLagu = Lagu::count();
        $totalArsip = Arsip::count();

        $totalPemasukan = Keuangan::where('input', 'pemasukan')->sum('saldo');
        $totalPengeluaran = Keuangan::where('input', 'pengeluaran')->sum('saldo');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        // Mengirim data ke view
        return view('content.dashboard', compact('totalLagu', 'totalAnggota', 'totalArsip', 'saldoAkhir', 'dataStatus', 'dataGender'));
    }
}