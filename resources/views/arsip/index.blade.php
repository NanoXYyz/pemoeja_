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

    <!-- Category Tabs -->
    <div class="flex gap-2 mb-6 overflow-x-auto pb-2">
        <button class="btn-primary text-xs py-2 px-4" onclick="filterArsip('all')">Semua</button>
        <button class="btn-secondary text-xs py-2 px-4" onclick="filterArsip('keuangan')">Keuangan</button>
        <button class="btn-secondary text-xs py-2 px-4" onclick="filterArsip('dokumen')">Dokumen</button>
        <button class="btn-secondary text-xs py-2 px-4" onclick="filterArsip('foto')">Foto</button>
        <button class="btn-secondary text-xs py-2 px-4" onclick="filterArsip('video')">Video</button>
        <button class="btn-secondary text-xs py-2 px-4" onclick="filterArsip('lainnya')">Lainnya</button>
    </div>

    <!-- Archive Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4" id="archiveGrid">
        @php
            $arsipList = [
                [
                    'title' => 'Laporan Keuangan Q1 2023',
                    'date' => 'Maret 2023',
                    'link' => 'drive.google.com/...',
                    'icon' => 'fa-folder',
                    'color' => 'blue',
                    'type' => 'keuangan',
                ],
                [
                    'title' => 'Notulen Rapat Pengurus',
                    'date' => 'Februari 2023',
                    'link' => 'docs.google.com/...',
                    'icon' => 'fa-file-alt',
                    'color' => 'green',
                    'type' => 'dokumen',
                ],
                [
                    'title' => 'Foto Ibadah Natal 2022',
                    'date' => 'Desember 2022',
                    'link' => 'photos.google.com/...',
                    'icon' => 'fa-photo-video',
                    'color' => 'purple',
                    'type' => 'foto',
                ],
                [
                    'title' => 'Video Rekaman Ibadah',
                    'date' => 'Januari 2023',
                    'link' => 'youtube.com/...',
                    'icon' => 'fa-file-video',
                    'color' => 'yellow',
                    'type' => 'video',
                ],
                [
                    'title' => 'AD/ART Organisasi',
                    'date' => 'Oktober 2020',
                    'link' => 'drive.google.com/...',
                    'icon' => 'fa-file-pdf',
                    'color' => 'red',
                    'type' => 'dokumen',
                ],
                [
                    'title' => 'Laporan Keuangan Q2 2023',
                    'date' => 'Juni 2023',
                    'link' => 'drive.google.com/...',
                    'icon' => 'fa-folder',
                    'color' => 'blue',
                    'type' => 'keuangan',
                ],
                [
                    'title' => 'Dokumentasi Retreat',
                    'date' => 'Mei 2023',
                    'link' => 'photos.google.com/...',
                    'icon' => 'fa-image',
                    'color' => 'purple',
                    'type' => 'foto',
                ],
                [
                    'title' => 'Materi PA',
                    'date' => 'April 2023',
                    'link' => 'docs.google.com/...',
                    'icon' => 'fa-file-alt',
                    'color' => 'green',
                    'type' => 'dokumen',
                ],
                [
                    'title' => 'Rekaman KKR',
                    'date' => 'Maret 2023',
                    'link' => 'youtube.com/...',
                    'icon' => 'fa-file-video',
                    'color' => 'yellow',
                    'type' => 'video',
                ],
                [
                    'title' => 'Dokumen Legal',
                    'date' => 'Januari 2022',
                    'link' => 'drive.google.com/...',
                    'icon' => 'fa-file-pdf',
                    'color' => 'red',
                    'type' => 'dokumen',
                ],
            ];
        @endphp

        @foreach ($arsipList as $index => $arsip)
            <div class="archive-card group arsip-item" data-type="{{ $arsip['type'] }}" data-index="{{ $index }}">
                <div
                    class="h-32 bg-gradient-to-br from-{{ $arsip['color'] }}-900/50 to-navy-800 flex items-center justify-center relative overflow-hidden">
                    <i class="fas {{ $arsip['icon'] }} text-{{ $arsip['color'] }}-400 text-3xl"></i>
                    <div
                        class="absolute inset-0 bg-{{ $arsip['color'] }}-500/0 group-hover:bg-{{ $arsip['color'] }}-500/10 transition-all flex items-center justify-center opacity-0 group-hover:opacity-100">
                        <div class="flex gap-2">
                            <button onclick="openLink('{{ $arsip['link'] }}')"
                                class="w-7 h-7 rounded bg-white/20 flex items-center justify-center text-white text-xs hover:bg-white/30">
                                <i class="fas fa-external-link-alt"></i>
                            </button>
                            <button onclick="editArsip({{ $index }})"
                                class="w-7 h-7 rounded bg-white/20 flex items-center justify-center text-white text-xs hover:bg-blue-500/50">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteArsip({{ $index }})"
                                class="w-7 h-7 rounded bg-white/20 flex items-center justify-center text-white text-xs hover:bg-red-500/50">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <p class="text-xs font-700 text-white truncate" title="{{ $arsip['title'] }}">{{ $arsip['title'] }}
                    </p>
                    <p class="text-xs text-gray-600 mt-0.5">{{ $arsip['date'] }}</p>
                    <a href="#" onclick="event.preventDefault(); openLink('{{ $arsip['link'] }}')"
                        class="text-blue-400 text-xs hover:underline mt-1 block truncate">{{ $arsip['link'] }}</a>
                </div>
            </div>
        @endforeach

        <!-- Add new card -->
        <div class="border-2 border-dashed border-navy-600 rounded-xl flex flex-col items-center justify-center min-h-48 hover:border-blue-500 transition-colors cursor-pointer group"
            onclick="showModal('modalTambahArsip')">
            <div
                class="w-12 h-12 rounded-full bg-navy-800 group-hover:bg-blue-500/15 flex items-center justify-center mb-2 transition-colors border border-navy-600 group-hover:border-blue-500">
                <i class="fas fa-plus text-gray-500 group-hover:text-blue-400 transition-colors"></i>
            </div>
            <p class="text-xs text-gray-600 group-hover:text-gray-400 transition-colors font-600">Tambah Arsip</p>
        </div>
    </div>

    <!-- Modal Tambah Arsip -->
    <div id="modalTambahArsip" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4"
        style="background: rgba(0,0,0,0.7); backdrop-filter: blur(4px)">
        <div class="card w-full max-w-md p-6 relative">
            <button onclick="closeModal('modalTambahArsip')"
                class="absolute top-4 right-4 text-gray-500 hover:text-white w-8 h-8 flex items-center justify-center rounded-lg hover:bg-navy-700 transition-all">
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
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-input" required>
                    </div>
                    <div>
                        <label>Kategori</label>
                        <select name="kategori" class="form-select">
                            <option value="keuangan">Keuangan</option>
                            <option value="dokumen">Dokumen</option>
                            <option value="foto">Foto</option>
                            <option value="video">Video</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label>Keterangan / Judul</label>
                        <textarea name="keterangan" class="form-textarea" rows="3" placeholder="Deskripsi arsip..." required></textarea>
                    </div>
                    <div>
                        <label>Link / URL</label>
                        <input type="url" name="link" placeholder="https://drive.google.com/..." class="form-input"
                            required>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="button" onclick="closeModal('modalTambahArsip')"
                            class="btn-secondary flex-1 justify-center">Batal</button>
                        <button type="submit" class="btn-primary flex-1 justify-center">
                            <i class="fas fa-save"></i> Simpan
                        </button>
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

        function filterArsip(type) {
            const items = document.querySelectorAll('.arsip-item');

            items.forEach(item => {
                if (type === 'all') {
                    item.style.display = '';
                } else {
                    const itemType = item.dataset.type;
                    item.style.display = itemType === type ? '' : 'none';
                }
            });

            // Update button states
            document.querySelectorAll('.gap-2.mb-6 button').forEach(btn => {
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-secondary');
            });
            event.target.classList.remove('btn-secondary');
            event.target.classList.add('btn-primary');
        }

        function openLink(link) {
            window.open('https://' + link.replace('...', ''), '_blank');
        }

        function editArsip(index) {
            Swal.fire({
                title: 'Edit Arsip',
                text: 'Fitur edit akan segera hadir',
                icon: 'info',
                background: '#0f2040',
                color: '#fff',
                confirmButtonColor: '#3b7fff'
            });
        }

        function deleteArsip(index) {
            Swal.fire({
                title: 'Hapus Arsip?',
                text: 'Data yang dihapus tidak dapat dikembalikan',
                icon: 'warning',
                background: '#0f2040',
                color: '#fff',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const item = document.querySelector(`.arsip-item[data-index="${index}"]`);
                    if (item) {
                        item.remove();
                        Swal.fire('Terhapus!', 'Arsip berhasil dihapus', 'success');
                    }
                }
            });
        }

        // Close modal on backdrop click
        document.getElementById('modalTambahArsip').addEventListener('click', function(e) {
            if (e.target === this) closeModal(this.id);
        });
    </script>
@endpush
