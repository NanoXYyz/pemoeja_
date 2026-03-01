<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeuanganController extends Controller
{
    public function index()
    {
        // 1. Data Line Chart (Harian - 7 Hari Terakhir)
        $daily = Keuangan::selectRaw('DATE_FORMAT(date, "%d %b") as label, SUM(CASE WHEN input = "pemasukan" THEN saldo ELSE -saldo END) as value')
            ->where('date', '>=', now()->subDays(7))
            ->groupBy('label', 'date')
            ->orderBy('date')
            ->get();

        // 2. Data Line Chart (Bulanan - Tahun Ini)
        $monthly = Keuangan::selectRaw('DATE_FORMAT(date, "%M") as label, SUM(CASE WHEN input = "pemasukan" THEN saldo ELSE -saldo END) as value')
            ->whereYear('date', date('Y'))
            ->groupBy('label', DB::raw('MONTH(date)'))
            ->orderBy(DB::raw('MONTH(date)'))
            ->get();

        // 3. Data Line Chart (Tahunan)
        $yearly = Keuangan::selectRaw('YEAR(date) as label, SUM(CASE WHEN input = "pemasukan" THEN saldo ELSE -saldo END) as value')
            ->groupBy('label')
            ->orderBy('label')
            ->get();

        $chartData = [
            'daily'   => ['labels' => $daily->pluck('label'), 'values' => $daily->pluck('value')],
            'monthly' => ['labels' => $monthly->pluck('label'), 'values' => $monthly->pluck('value')],
            'yearly'  => ['labels' => $yearly->pluck('label'), 'values' => $yearly->pluck('value')],
        ];

        $keuangan = Keuangan::orderBy('date', 'desc')->get();
        $totalPemasukan = Keuangan::where('input', 'pemasukan')->sum('saldo');
        $totalPengeluaran = Keuangan::where('input', 'pengeluaran')->sum('saldo');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        return view('keuangan.index', compact('keuangan', 'totalPemasukan', 'totalPengeluaran', 'saldoAkhir', 'chartData'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date'       => 'required|date',
            'keterangan' => 'required|string|max:255',
            'input'      => 'required|in:pemasukan,pengeluaran',
            'saldo'      => 'required|numeric|min:0',
            'bukti'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('bukti')) {
            $validated['bukti'] = $request->file('bukti')->store('bukti_transaksi', 'public');
        }

        Keuangan::create($validated);
        return redirect()->route('keuangan.index')->with('success', 'Transaksi berhasil dicatat!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date'       => 'required|date',
            'keterangan' => 'required|string|max:255',
            'saldo'      => 'required|numeric|min:0',
            'input'      => 'required|in:pemasukan,pengeluaran',
            'bukti'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $keuangan = Keuangan::findOrFail($id);
        $data = $request->only(['date', 'keterangan', 'saldo', 'input']);

        if ($request->hasFile('bukti')) {
            if ($keuangan->bukti) {
                Storage::disk('public')->delete($keuangan->bukti);
            }
            $data['bukti'] = $request->file('bukti')->store('bukti_transaksi', 'public');
        }

        $keuangan->update($data);
        return redirect()->route('keuangan.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        if ($keuangan->bukti) {
            Storage::disk('public')->delete($keuangan->bukti);
        }
        $keuangan->delete();
        return redirect()->route('keuangan.index')->with('success', 'Data berhasil dihapus!');
    }
}