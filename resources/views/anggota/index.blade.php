@extends('layouts.app')

@section('title', 'Anggota')

@section('content')
    <style>
        [x-cloak] {
            display: none !important;
        }

        .form-input-custom {
            @apply w-full bg-slate-800 border border-slate-700 rounded-xl text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all py-2.5 px-4 outline-none;
        }

        .modal-backdrop {
            animation: fadeIn 0.2s ease;
        }

        .modal-box {
            animation: slideUp 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(24px) scale(0.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .table-row-hover {
            transition: background 0.15s ease, transform 0.1s ease;
        }

        .table-row-hover:hover {
            background: rgba(30, 41, 59, 0.6);
        }

        .badge-gender {
            @apply px-3 py-1 rounded-full text-xs font-semibold tracking-wide;
        }

        .glow-blue {
            box-shadow: 0 0 18px rgba(59, 130, 246, 0.35);
        }

        .glow-pink {
            box-shadow: 0 0 18px rgba(236, 72, 153, 0.35);
        }

        .glow-green {
            box-shadow: 0 0 18px rgba(16, 185, 129, 0.35);
        }
    </style>

    <div x-data="{
        showCreateModal: false,
        showEditModal: false,
        editData: { id: '', nama: '', gender: '', status: '', jabatan: '' },
        openEdit(item) {
            this.editData = { ...item };
            this.showEditModal = true;
        }
    }">

        {{-- ===== PAGE HEADER ===== --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <div class="flex items-center gap-2 text-xs text-gray-500 mb-2">
                    <span>Home</span>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span class="text-blue-400 font-medium">Anggota</span>
                </div>
                <h1 class="text-2xl font-black text-white tracking-tight">MEMBER DIRECTORY</h1>
                <p class="text-gray-400 text-sm mt-1">Kelola data anggota komunitas</p>
            </div>
            @auth
                @if (Auth::user()->role === 'admin')
                    <button @click="showCreateModal = true"
                        class="bg-blue-600 hover:bg-blue-500 active:scale-95 text-white px-6 py-2.5 rounded-xl font-bold transition-all shadow-lg shadow-blue-600/25 flex items-center gap-2">
                        <i class="fas fa-plus"></i> Tambah Anggota
                    </button>
                @endif
            @endauth
        </div>

        {{-- <div class="p-6 border-b border-slate-800 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-white flex items-center gap-2">
                        <i class="fas fa-users text-blue-500"></i> Data Anggota
                    </h3>
                    <p class="text-xs text-gray-500 mt-0.5">Total anggota terdaftar</p>
                </div>
                <div class="flex gap-2">
                    <button
                        class="flex items-center gap-2 text-xs px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white border border-slate-700 rounded-lg transition-all">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <button
                        class="flex items-center gap-2 text-xs px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white border border-slate-700 rounded-lg transition-all">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div> --}}
        {{-- </div> --}}


        {{-- ===== STATS SUMMARY BAR ===== --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center glow-blue">
                    <i class="fas fa-users text-blue-400"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-wider">Total</p>
                    <p class="text-xl font-black text-white">{{ $anggota->count() }}</p>
                </div>
            </div>
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center glow-blue">
                    <i class="fas fa-user text-blue-400"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-wider">Laki-laki</p>
                    <p class="text-xl font-black text-white">{{ $dataGender['laki-laki'] ?? 0 }}</p>
                </div>
            </div>
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-pink-500/10 flex items-center justify-center glow-pink">
                    <i class="fas fa-user text-pink-400"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-wider">Perempuan</p>
                    <p class="text-xl font-black text-white">{{ $dataGender['perempuan'] ?? 0 }}</p>
                </div>
            </div>
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center glow-green">
                    <i class="fas fa-graduation-cap text-emerald-400"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-wider">Pelajar</p>
                    <p class="text-xl font-black text-white">{{ $dataStatus['pelajar'] ?? 0 }}</p>
                </div>
            </div>
        </div>


        {{-- ===== TABLE CARD (DataTables) ===== --}}
        <div class="card overflow-hidden mb-8 p-4r">
            <div class="overflow-x-auto">
                <table id="anggota" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Gender(P/L)</th>
                            <th>Status</th>
                            <th>Jabatan</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($anggota as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->gender }}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->jabatan }}</td>
                                <td>
                                    @if (Auth::check() && Auth::user()->role === 'admin')
                                        <div class="flex justify-center gap-2">
                                            <button @click="openEdit({{ $item }})"
                                                class="p-2 text-amber-400 hover:bg-amber-400/10 rounded-lg transition-colors">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('anggota.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus anggota ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-red-500 hover:bg-red-500/10 rounded-lg transition-colors">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <div
                                            class="flex items-center gap-2 text-slate-500 italic text-xs bg-slate-800/50 px-3 py-1.5 rounded-lg border border-slate-700/50 w-fit">
                                            <i class="fas fa-lock text-[10px]"></i> Read Only
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ===== CHARTS ===== --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Status Chart --}}
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <h5 class="text-white font-bold flex items-center gap-2">
                        <i class="fas fa-chart-bar text-blue-500"></i> Distribusi Status
                    </h5>
                    <span
                        class="text-[10px] bg-blue-500/10 text-blue-400 px-2 py-1 rounded-md uppercase font-bold tracking-wider">Pekerjaan</span>
                </div>
                <div class="relative h-[260px]"><canvas id="chartStatus"></canvas></div>
                <div class="grid grid-cols-2 gap-3 mt-5">
                    <div class="bg-slate-800/40 p-3 rounded-xl border border-slate-700/50 text-center">
                        <p class="text-slate-400 text-xs uppercase tracking-wider mb-1">Pelajar</p>
                        <p class="text-white text-2xl font-black">{{ $dataStatus['pelajar'] ?? 0 }}</p>
                    </div>
                    <div class="bg-slate-800/40 p-3 rounded-xl border border-slate-700/50 text-center">
                        <p class="text-slate-400 text-xs uppercase tracking-wider mb-1">Bekerja</p>
                        <p class="text-white text-2xl font-black">{{ $dataStatus['bekerja'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            {{-- Gender Chart --}}
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <h5 class="text-white font-bold flex items-center gap-2">
                        <i class="fas fa-venus-mars text-purple-500"></i> Komposisi Gender
                    </h5>
                    <span
                        class="text-[10px] bg-purple-500/10 text-purple-400 px-2 py-1 rounded-md uppercase font-bold tracking-wider">Demografi</span>
                </div>
                <div class="relative h-[260px]"><canvas id="chartGender"></canvas></div>
                <div class="flex justify-around mt-5">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-blue-500 glow-blue"></div>
                        <span class="text-slate-300 text-sm font-medium">Laki-laki ({{ $dataGender['laki'] ?? 0 }})</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-pink-500 glow-pink"></div>
                        <span class="text-slate-300 text-sm font-medium">Perempuan
                            ({{ $dataGender['perempuan'] ?? 0 }})</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== CREATE MODAL ===== --}}
        <div x-show="showCreateModal" x-cloak
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm modal-backdrop">
            <div @click.away="showCreateModal = false"
                class="bg-slate-900 border border-slate-800 w-full max-w-lg rounded-2xl overflow-hidden shadow-2xl modal-box">
                <div class="p-6 border-b border-slate-800 flex justify-between items-center bg-slate-800/30">
                    <div>
                        <h2 class="text-xl font-bold text-white">Tambah Anggota Baru</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Isi semua data dengan benar</p>
                    </div>
                    <button @click="showCreateModal = false"
                        class="w-8 h-8 flex items-center justify-center text-slate-500 hover:text-white hover:bg-slate-700 rounded-lg transition-all">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form action="{{ route('anggota.store') }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama
                            Lengkap</label>
                        <input type="text" name="nama" required class="form-input-custom"
                            placeholder="Contoh: John Doe">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Gender</label>
                            <select name="gender" class="form-input-custom">
                                @foreach ($genderOptions as $opt)
                                    <option value="{{ $opt }}">{{ ucfirst($opt) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status</label>
                            <select name="status" class="form-input-custom">
                                @foreach ($statusOptions as $opt)
                                    <option value="{{ $opt }}">{{ ucfirst($opt) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Jabatan</label>
                        <select name="jabatan" class="form-input-custom">
                            @foreach ($jabatanOptions as $opt)
                                <option value="{{ $opt }}">{{ ucfirst($opt) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" @click="showCreateModal = false"
                            class="px-6 py-2.5 text-slate-400 font-bold hover:text-white transition-colors rounded-xl hover:bg-slate-800">Batal</button>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-500 active:scale-95 text-white px-8 py-2.5 rounded-xl font-bold shadow-lg shadow-blue-600/25 transition-all">
                            <i class="fas fa-save mr-2"></i>Simpan Anggota
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ===== EDIT MODAL ===== --}}
        <div x-show="showEditModal" x-cloak
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm modal-backdrop">
            <div @click.away="showEditModal = false"
                class="bg-slate-900 border border-slate-800 w-full max-w-lg rounded-2xl overflow-hidden shadow-2xl modal-box">

                <div class="p-6 border-b border-slate-800 flex justify-between items-center bg-amber-500/[0.03]">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center">
                            <i class="fas fa-user-edit text-amber-500"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">Edit Data Anggota</h2>
                            <p class="text-xs text-slate-400 mt-0.5">Perbarui informasi profil anggota</p>
                        </div>
                    </div>
                    <button @click="showEditModal = false"
                        class="w-8 h-8 flex items-center justify-center text-slate-500 hover:text-white hover:bg-slate-800 rounded-lg transition-all">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form :action="`{{ url('anggota') }}/${editData.id}`" method="POST" class="p-6 space-y-6">
                    @csrf @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-[0.1em] mb-2.5 ml-1">Nama
                            Lengkap</label>
                        <div class="relative">
                            <input type="text" name="nama" x-model="editData.nama" required
                                class="form-input-custom focus:border-amber-500 pl-11" placeholder="Masukkan nama...">
                            <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label
                                class="block text-xs font-bold text-slate-300 uppercase tracking-[0.1em] mb-2.5 ml-1">Gender</label>
                            <div class="relative">
                                <select name="gender" x-model="editData.gender"
                                    class="form-input-custom focus:border-amber-500 pl-11">
                                    @foreach ($genderOptions as $opt)
                                        <option value="{{ $opt }}">{{ ucfirst($opt) }}</option>
                                    @endforeach
                                </select>
                                <i
                                    class="fas fa-venus-mars absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                            </div>
                        </div>

                        <div>
                            <label
                                class="block text-xs font-bold text-slate-300 uppercase tracking-[0.1em] mb-2.5 ml-1">Status</label>
                            <div class="relative">
                                <select name="status" x-model="editData.status"
                                    class="form-input-custom focus:border-amber-500 pl-11">
                                    @foreach ($statusOptions as $opt)
                                        <option value="{{ $opt }}">{{ ucfirst($opt) }}</option>
                                    @endforeach
                                </select>
                                <i
                                    class="fas fa-briefcase absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label
                            class="block text-xs font-bold text-slate-300 uppercase tracking-[0.1em] mb-2.5 ml-1">Jabatan</label>
                        <div class="relative">
                            <select name="jabatan" x-model="editData.jabatan"
                                class="form-input-custom focus:border-amber-500 pl-11">
                                @foreach ($jabatanOptions as $opt)
                                    <option value="{{ $opt }}">{{ ucfirst($opt) }}</option>
                                @endforeach
                            </select>
                            <i
                                class="fas fa-shield-alt absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                        </div>
                    </div>

                    <div class="flex justify-end items-center gap-4 pt-4 border-t border-slate-800">
                        <button type="button" @click="showEditModal = false"
                            class="text-sm font-bold text-slate-400 hover:text-white transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-amber-500 hover:bg-amber-400 active:scale-95 text-slate-950 px-6 py-2.5 rounded-xl font-bold shadow-lg shadow-amber-500/20 transition-all flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>{{-- end x-data --}}

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Chart.defaults.color = '#94a3b8';
            Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";

            // ----- Status Bar Chart -----
            const ctxS = document.getElementById('chartStatus').getContext('2d');

            const blueGrad = ctxS.createLinearGradient(0, 0, 0, 300);
            blueGrad.addColorStop(0, '#3b82f6');
            blueGrad.addColorStop(1, '#1d4ed8');

            const greenGrad = ctxS.createLinearGradient(0, 0, 0, 300);
            greenGrad.addColorStop(0, '#10b981');
            greenGrad.addColorStop(1, '#047857');

            const statusLabels = @json($dataStatus->keys());
            const statusValues = @json($dataStatus->values());

            new Chart(ctxS, {
                type: 'bar',
                data: {
                    labels: statusLabels.map(l => l.toUpperCase()),
                    datasets: [{
                        data: statusValues,
                        backgroundColor: [blueGrad, greenGrad],
                        borderRadius: 10,
                        borderSkipped: false,
                        barPercentage: 0.55,
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    animation: {
                        duration: 900,
                        easing: 'easeOutQuart'
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    weight: 'bold',
                                    size: 11
                                }
                            }
                        },
                        y: {
                            grid: {
                                color: 'rgba(255,255,255,0.04)'
                            },
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            // ----- Gender Doughnut Chart -----
            const ctxG = document.getElementById('chartGender').getContext('2d');
            const genderLabels = @json($dataGender->keys());
            const genderValues = @json($dataGender->values());

            new Chart(ctxG, {
                type: 'doughnut',
                data: {
                    labels: genderLabels,
                    datasets: [{
                        data: genderValues,
                        backgroundColor: ['#3b82f6', '#ec4899', '#10b981'],
                        hoverOffset: 14,
                        borderWidth: 0,
                        borderRadius: 8,
                        spacing: 4,
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    cutout: '72%',
                    animation: {
                        animateRotate: true,
                        duration: 900,
                        easing: 'easeOutQuart'
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
@endsection
