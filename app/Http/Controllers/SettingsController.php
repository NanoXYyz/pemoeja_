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
        // Group by category agar tampil lebih terstruktur
        $settings = Setting::with('options')->get()->groupBy('category');
        return view('settings.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category'      => 'required|string|in:anggota,keuangan,lagu,jadwal,arsip',
            'sub_content'   => 'required|string',
            'type_data'     => 'required|in:string,text,enum,integer,date',
            'keterangan'    => 'required|in:required,nullable,unique',
            'default_value' => 'nullable|string',
            'options'       => 'nullable|array',
            'options.*'     => 'nullable|string|max:100',
        ]);

        DB::beginTransaction();
        try {
            $setting = Setting::create([
                'category'      => $request->category,
                'sub_content'   => str_replace(' ', '_', strtolower($request->sub_content)),
                'type_data'     => $request->type_data,
                'keterangan'    => $request->keterangan,
                'default_value' => $request->default_value,
            ]);

            if ($request->type_data === 'enum' && $request->has('options')) {
                foreach (array_filter($request->options) as $i => $opt) {
                    SettingOption::create([
                        'setting_id'  => $setting->id,
                        'option_name' => $opt,
                        'label'       => $opt,
                        'urutan'      => $i + 1,
                    ]);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Konfigurasi berhasil ditambahkan ✨');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    /**
     * Tambah satu opsi baru ke setting yang sudah ada
     */
    public function addOption(Request $request, $settingId)
    {
        $request->validate([
            'option_name' => 'required|string|max:100',
        ]);

        $setting = Setting::findOrFail($settingId);
        $urutan  = $setting->options()->max('urutan') + 1;

        SettingOption::create([
            'setting_id'  => $settingId,
            'option_name' => $request->option_name,
            'label'       => $request->option_name,
            'urutan'      => $urutan,
        ]);

        return redirect()->back()->with('success', 'Opsi berhasil ditambahkan!');
    }

    /**
     * Hapus satu opsi
     */
    public function destroyOption($optionId)
    {
        SettingOption::findOrFail($optionId)->delete();
        return redirect()->back()->with('success', 'Opsi dihapus!');
    }

    public function destroy($id)
    {
        Setting::findOrFail($id)->delete(); // cascade akan hapus options juga
        return redirect()->back()->with('success', 'Konfigurasi dihapus! 🗑️');
    }
}