{{-- resources/views/arsip/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Arsip')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <div class="flex items-center gap-2 text-xs text-gray-500 mb-2">
                <span>Home</span> <i class="fas fa-chevron-right"></i> <span class="text-blue-400">Arsip</span>
            </div>
            <h1 class="text-2xl font-900 text-white">Arsip Dokumen</h1>
            <p class="text-gray-400 text-sm mt-1">Kelola semua dokumen, foto, dan tautan arsip</p>
        </div>
        <button onclick="showModal('modalTambahArsip')" class="btn-primary">
            <i class="fas fa-plus mr-1"></i> Tambah Arsip
        </button>
    </div>

    {{-- Filter Tab — dibangun dari $keteranganOptions (settings) --}}
    <div class="flex gap-2 mb-6 overflow-x-auto pb-2">
        <button class="btn-primary text-xs py-2 px-4 filter-btn" data-type="all"
            onclick="filterArsip('all', this)">Semua</button>
        @foreach ($keteranganOptions as $opt)
            <button class="btn-secondary text-xs py-2 px-4 filter-btn" data-type="{{ $opt }}"
                onclick="filterArsip('{{ $opt }}', this)">
                {{ ucwords(str_replace('-', ' ', $opt)) }}
            </button>
        @endforeach
    </div>

    {{-- Archive Grid — data dari DB --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4" id="archiveGrid">
        @php
            $iconMap = [
                'notulensi' => ['icon' => 'fa-file-alt', 'color' => 'green'],
                'laporan-tahunan' => ['icon' => 'fa-folder', 'color' => 'blue'],
                'foto-kegiatan' => ['icon' => 'fa-photo-video', 'color' => 'purple'],
                'dokumen-lain' => ['icon' => 'fa-file-pdf', 'color' => 'red'],
                'default' => ['icon' => 'fa-archive', 'color' => 'gray'],
            ];
        @endphp

        @foreach ($arsip as $item)
            @php
                $meta = $iconMap[$item->keterangan] ?? $iconMap['default'];
                $tahun = \Carbon\Carbon::parse($item->tahun)->format('Y');
            @endphp
            <div class="archive-card group arsip-item" data-type="{{ $item->keterangan }}" data-id="{{ $item->id }}">
                <div
                    class="h-32 bg-gradient-to-br from-{{ $meta['color'] }}-900/50 to-navy-800 flex items-center justify-center relative overflow-hidden">
                    <i class="fas {{ $meta['icon'] }} text-{{ $meta['color'] }}-400 text-3xl"></i>
                    <div
                        class="absolute inset-0 bg-{{ $meta['color'] }}-500/0 group-hover:bg-{{ $meta['color'] }}-500/10 transition-all flex items-center justify-center opacity-0 group-hover:opacity-100">
                        <div class="flex gap-2">
                            <a href="{{ $item->link }}" target="_blank"
                                class="w-7 h-7 rounded bg-white/20 flex items-center justify-center text-white text-xs hover:bg-white/30">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                            <a href="{{ route('arsip.edit', $item->id) }}"
                                class="w-7 h-7 rounded bg-white/20 flex items-center justify-center text-white text-xs hover:bg-blue-500/50">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('arsip.destroy', $item->id) }}" method="POST" class="inline"
                                onsubmit="return confirm('Hapus arsip ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="w-7 h-7 rounded bg-white/20 flex items-center justify-center text-white text-xs hover:bg-red-500/50">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <p class="text-xs font-700 text-white truncate" title="{{ $item->keterangan }}">
                        {{ ucwords(str_replace('-', ' ', $item->keterangan)) }}
                    </p>
                    <p class="text-xs text-gray-600 mt-0.5">{{ $tahun }}</p>
                    <a href="{{ $item->link }}" target="_blank"
                        class="text-blue-400 text-xs hover:underline mt-1 block truncate">{{ $item->link }}</a>
                </div>
            </div>
        @endforeach

        {{-- Tombol tambah --}}
        <div class="border-2 border-dashed border-navy-600 rounded-xl flex flex-col items-center justify-center min-h-48 hover:border-blue-500 transition-colors cursor-pointer group"
            onclick="showModal('modalTambahArsip')">
            <div
                class="w-12 h-12 rounded-full bg-navy-800 group-hover:bg-blue-500/15 flex items-center justify-center mb-2 border border-navy-600 group-hover:border-blue-500">
                <i class="fas fa-plus text-gray-500 group-hover:text-blue-400"></i>
            </div>
            <p class="text-xs text-gray-600 group-hover:text-gray-400 font-600">Tambah Arsip</p>
        </div>
    </div>

    {{-- Modal Tambah Arsip --}}
    <div id="modalTambahArsip" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4"
        style="background: rgba(0,0,0,0.7); backdrop-filter: blur(4px)">
        <div class="card w-full max-w-md p-6 relative">
            <button onclick="closeModal('modalTambahArsip')"
                class="absolute top-4 right-4 text-gray-500 hover:text-white w-8 h-8 flex items-center justify-center rounded-lg hover:bg-navy-700">
                <i class="fas fa-times"></i>
            </button>
            <div class="section-header mb-6">
                <div class="section-icon"><i class="fas fa-folder-plus"></i></div>
                <h3 class="font-700 text-white">Tambah Arsip Baru</h3>
            </div>
            <form action="{{ route('arsip.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="text-xs text-gray-400 mb-1 block">Tahun</label>
                        <input type="number" name="tahun" min="2000" max="2099" value="{{ date('Y') }}"
                            class="form-input" required>
                    </div>
                    <div>
                        {{-- Kategori dari settings, bukan hardcode --}}
                        <label class="text-xs text-gray-400 mb-1 block">Kategori</label>
                        <select name="keterangan" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($keteranganOptions as $opt)
                                <option value="{{ $opt }}">{{ ucwords(str_replace('-', ' ', $opt)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-gray-400 mb-1 block">Link / URL</label>
                        <input type="url" name="link" placeholder="https://drive.google.com/..." class="form-input"
                            required>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="button" onclick="closeModal('modalTambahArsip')"
                            class="btn-secondary flex-1 justify-center">Batal</button>
                        <button type="submit" class="btn-primary flex-1 justify-center"><i class="fas fa-save"></i>
                            Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function showModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.getElementById(id).classList.add('flex');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.getElementById(id).classList.remove('flex');
        }

        function filterArsip(type, btn) {
            document.querySelectorAll('.arsip-item').forEach(item => {
                item.style.display = (type === 'all' || item.dataset.type === type) ? '' : 'none';
            });
            document.querySelectorAll('.filter-btn').forEach(b => {
                b.classList.remove('btn-primary');
                b.classList.add('btn-secondary');
            });
            btn.classList.remove('btn-secondary');
            btn.classList.add('btn-primary');
        }
        document.getElementById('modalTambahArsip').addEventListener('click', function(e) {
            if (e.target === this) closeModal(this.id);
        });
    </script>
@endpush
