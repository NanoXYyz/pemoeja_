<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\SettingOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function index()
    {
        // Mengambil semua data settings beserta opsinya
        $settings = Setting::with('options')->get();
        return view('settings.index', compact('settings'));
    }

    // app/Http/Controllers/SettingController.php
public function store(Request $request) {
    $request->validate([
        'category'    => 'required|in:anggota,keuangan,lagu,jadwal,arsip,role',
        'sub_content' => 'required|string',
        'type_data'   => 'required',
        'options'     => 'nullable|array',
    ]);

    try {
        DB::beginTransaction();
        $setting = Setting::create([
            'category'      => $request->category,
            'sub_content'   => str_replace(' ', '_', strtolower($request->sub_content)),
            'type_data'     => $request->type_data,
            'keterangan'    => $request->keterangan,
            'default_value' => $request->default_val,
        ]);

        if ($request->type_data === 'enum' && $request->has('options')) {
            foreach ($request->options as $opt) {
                if (!empty($opt)) {
                    SettingOption::create([
                        'setting_id'  => $setting->id,
                        'option_name' => $opt,
                    ]);
                }
            }
        }
        DB::commit();
        return redirect()->back()->with('success', 'Konfigurasi berhasil ditambahkan ✨');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
    }
}

public function destroy($id) {
    Setting::findOrFail($id)->delete();
    return redirect()->back()->with('success', 'Konfigurasi dihapus! 🗑️');
}
}