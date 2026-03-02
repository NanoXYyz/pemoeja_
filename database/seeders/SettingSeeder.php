<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Models\SettingOption;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // ── ANGGOTA ────────────────────────────────────────
            [
                'category'      => 'anggota',
                'sub_content'   => 'gender',
                'type_data'     => 'enum',
                'keterangan'    => 'required',
                'default_value' => null,
                'options'       => [
                    ['option_name' => 'laki-laki', 'label' => 'Laki-laki', 'urutan' => 1],
                    ['option_name' => 'perempuan',  'label' => 'Perempuan',  'urutan' => 2],
                ],
            ],
            [
                'category'      => 'anggota',
                'sub_content'   => 'status',
                'type_data'     => 'enum',
                'keterangan'    => 'required',
                'default_value' => null,
                'options'       => [
                    ['option_name' => 'pelajar', 'label' => 'Pelajar', 'urutan' => 1],
                    ['option_name' => 'bekerja',  'label' => 'Bekerja',  'urutan' => 2],
                ],
            ],
            [
                'category'      => 'anggota',
                'sub_content'   => 'jabatan',
                'type_data'     => 'enum',
                'keterangan'    => 'required',
                'default_value' => 'anggota',
                'options'       => [
                    ['option_name' => 'ketua',       'label' => 'Ketua',       'urutan' => 1],
                    ['option_name' => 'wakil',       'label' => 'Wakil',       'urutan' => 2],
                    ['option_name' => 'sekretaris',  'label' => 'Sekretaris',  'urutan' => 3],
                    ['option_name' => 'bendahara',   'label' => 'Bendahara',   'urutan' => 4],
                    ['option_name' => 'persekutuan', 'label' => 'Persekutuan', 'urutan' => 5],
                    ['option_name' => 'anggota',     'label' => 'Anggota',     'urutan' => 6],
                ],
            ],

            // ── KEUANGAN ───────────────────────────────────────
            [
                'category'      => 'keuangan',
                'sub_content'   => 'input',
                'type_data'     => 'enum',
                'keterangan'    => 'required',
                'default_value' => 'pemasukan',
                'options'       => [
                    ['option_name' => 'pemasukan',   'label' => 'Pemasukan',   'urutan' => 1],
                    ['option_name' => 'pengeluaran', 'label' => 'Pengeluaran', 'urutan' => 2],
                ],
            ],

            // ── LAGU ───────────────────────────────────────────
            [
                'category'      => 'lagu',
                'sub_content'   => 'key',
                'type_data'     => 'enum',
                'keterangan'    => 'required',
                'default_value' => 'C',
                'options'       => collect(['C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#', 'A', 'A#', 'B'])
                    ->map(fn ($k, $i) => ['option_name' => $k, 'label' => $k, 'urutan' => $i + 1])
                    ->toArray(),
            ],

            // ── JADWAL ─────────────────────────────────────────
            [
                'category'      => 'jadwal',
                'sub_content'   => 'title',
                'type_data'     => 'enum',
                'keterangan'    => 'required',
                'default_value' => null,
                'options'       => [
                    ['option_name' => 'ibadah-minggu',    'label' => 'Ibadah Minggu',    'urutan' => 1],
                    ['option_name' => 'ibadah-pemuda',    'label' => 'Ibadah Pemuda',    'urutan' => 2],
                    ['option_name' => 'ibadah-hari-raya', 'label' => 'Ibadah Hari Raya', 'urutan' => 3],
                ],
            ],
            [
                'category'      => 'jadwal',
                'sub_content'   => 'tempat',
                'type_data'     => 'enum',
                'keterangan'    => 'required',
                'default_value' => null,
                'options'       => [
                    ['option_name' => 'gereja-utama', 'label' => 'Gereja Utama', 'urutan' => 1],
                    ['option_name' => 'aula',         'label' => 'Aula',         'urutan' => 2],
                ],
            ],

            // ── ARSIP ──────────────────────────────────────────
            [
                'category'      => 'arsip',
                'sub_content'   => 'keterangan',
                'type_data'     => 'enum',
                'keterangan'    => 'required',
                'default_value' => null,
                'options'       => [
                    ['option_name' => 'notulensi',      'label' => 'Notulensi',      'urutan' => 1],
                    ['option_name' => 'laporan-tahunan','label' => 'Laporan Tahunan','urutan' => 2],
                    ['option_name' => 'foto-kegiatan',  'label' => 'Foto Kegiatan',  'urutan' => 3],
                    ['option_name' => 'dokumen-lain',   'label' => 'Dokumen Lain',   'urutan' => 4],
                ],
            ],
        ];

        foreach ($data as $item) {
            $options = $item['options'];
            unset($item['options']);

            $setting = Setting::updateOrCreate(
                ['category' => $item['category'], 'sub_content' => $item['sub_content']],
                $item
            );

            foreach ($options as $opt) {
                SettingOption::updateOrCreate(
                    ['setting_id' => $setting->id, 'option_name' => strtolower(str_replace(' ', '-', $opt['option_name']))],
                    ['label' => $opt['label'], 'urutan' => $opt['urutan']]
                );
            }
        }
    }
}