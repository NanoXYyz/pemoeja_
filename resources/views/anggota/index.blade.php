@extends('layouts.app')

@section('title', 'Anggota')

@section('content')
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* ===== MODAL ANIMATIONS ===== */
        .modal-backdrop {
            animation: fadeIn 0.2s ease;
        }

        .modal-box {
            animation: slideUp 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
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
                transform: translateY(32px) scale(0.96);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* ===== MODAL FORM FIELDS ===== */
        .field-label {
            display: block;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #94a3b8;
            margin-bottom: 0.5rem;
        }

        .field-wrapper {
            position: relative;
        }

        .field-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 13px;
            pointer-events: none;
            z-index: 1;
            transition: color 0.2s;
        }

        /* CREATE modal field — blue accent */
        .field-create .field-icon {
            color: #3b82f6;
        }

        .field-create input,
        .field-create select {
            width: 100%;
            padding: 12px 16px 12px 42px;
            background: #0f172a;
            border: 1.5px solid #1e293b;
            border-radius: 12px;
            color: #f1f5f9;
            font-size: 0.875rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            appearance: none;
            -webkit-appearance: none;
        }

        .field-create input:focus,
        .field-create select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
            background: #0d1520;
        }

        .field-create input::placeholder {
            color: #475569;
        }

        .field-create select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%233b82f6' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 18px 18px;
            padding-right: 40px;
            cursor: pointer;
        }

        .field-create select option {
            background: #0f172a;
            color: #f1f5f9;
        }

        /* EDIT modal field — amber accent */
        .field-edit .field-icon {
            color: #f59e0b;
        }

        .field-edit input,
        .field-edit select {
            width: 100%;
            padding: 12px 16px 12px 42px;
            background: #0f172a;
            border: 1.5px solid #1e293b;
            border-radius: 12px;
            color: #f1f5f9;
            font-size: 0.875rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            appearance: none;
            -webkit-appearance: none;
        }

        .field-edit input:focus,
        .field-edit select:focus {
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.15);
            background: #0d1520;
        }

        .field-edit input::placeholder {
            color: #475569;
        }

        .field-edit select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23f59e0b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 18px 18px;
            padding-right: 40px;
            cursor: pointer;
        }

        .field-edit select option {
            background: #0f172a;
            color: #f1f5f9;
        }

        /* ===== MODAL HEADER GRADIENT STRIPES ===== */
        .modal-header-create {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.08) 0%, rgba(15, 23, 42, 0) 60%);
        }

        .modal-header-edit {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.08) 0%, rgba(15, 23, 42, 0) 60%);
        }

        /* ===== ICON BADGE ===== */
        .icon-badge-create {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            background: rgba(59, 130, 246, 0.12);
            border: 1px solid rgba(59, 130, 246, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-badge-edit {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            background: rgba(245, 158, 11, 0.12);
            border: 1px solid rgba(245, 158, 11, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ===== SECTION DIVIDER ===== */
        .form-section-label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: #475569;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }

        .form-section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #1e293b;
        }

        /* ===== STAT CARDS ===== */
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

        /* ===== TABLE ===== */
        .table-row-hover {
            transition: background 0.15s ease;
        }

        .table-row-hover:hover {
            background: rgba(30, 41, 59, 0.6);
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
                    <i class="bi bi-gender-male text-blue-400"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-wider">Laki-laki</p>
                    <p class="text-xl font-black text-white">{{ $dataGender['laki-laki'] ?? 0 }}</p>
                </div>
            </div>
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-pink-500/10 flex items-center justify-center glow-pink">
                    <i class="bi bi-gender-female text-pink-400"></i>
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

        {{-- ===== TABLE CARD ===== --}}
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

        {{-- ================================================== --}}
        {{-- ===== CREATE MODAL ============================= --}}
        {{-- ================================================== --}}
        <div x-show="showCreateModal" x-cloak
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/75 backdrop-blur-md modal-backdrop">
            <div @click.away="showCreateModal = false"
                class="bg-[#0d1117] border border-slate-800/70 w-full max-w-md rounded-2xl overflow-hidden shadow-2xl modal-box"
                style="box-shadow: 0 25px 60px rgba(0,0,0,0.6), 0 0 0 1px rgba(59,130,246,0.08);">

                {{-- Header --}}
                <div class="px-6 py-5 modal-header-create border-b border-slate-800/60 flex justify-between items-center">
                    <div class="flex items-center gap-3.5">
                        <div class="icon-badge-create">
                            <i class="fas fa-user-plus text-blue-400 text-sm"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-white leading-tight">Tambah Anggota Baru</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Isi semua data dengan benar</p>
                        </div>
                    </div>
                    <button @click="showCreateModal = false"
                        class="w-8 h-8 flex items-center justify-center text-slate-500 hover:text-white hover:bg-slate-800 rounded-lg transition-all">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>

                {{-- Form --}}
                <form action="{{ route('anggota.store') }}" method="POST" class="p-6 space-y-5">
                    @csrf

                    {{-- Nama Lengkap --}}
                    <div>
                        <p class="form-section-label">Identitas</p>
                        <label class="field-label">Nama Lengkap</label>
                        <div class="field-wrapper field-create">
                            <i class="fas fa-user field-icon"></i>
                            <input type="text" name="nama" oninput="this.value = this.value.toUpperCase()" required
                                placeholder="Contoh: John Doe">
                        </div>
                    </div>

                    {{-- Gender & Status --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="field-label">Gender</label>
                            <div class="field-wrapper field-create">
                                <i class="fas fa-venus-mars field-icon"></i>
                                <select name="gender">
                                    @foreach ($genderOptions as $opt)
                                        <option value="{{ $opt }}">{{ ucfirst($opt) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="field-label">Status</label>
                            <div class="field-wrapper field-create">
                                <i class="fas fa-briefcase field-icon"></i>
                                <select name="status">
                                    @foreach ($statusOptions as $opt)
                                        <option value="{{ $opt }}">{{ ucfirst($opt) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Jabatan --}}
                    <div>
                        <label class="field-label">Jabatan</label>
                        <div class="field-wrapper field-create">
                            <i class="fas fa-shield-alt field-icon"></i>
                            <select name="jabatan">
                                @foreach ($jabatanOptions as $opt)
                                    <option value="{{ $opt }}">{{ ucfirst($opt) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end items-center gap-3 pt-5 border-t border-slate-800/60">
                        <button type="button" @click="showCreateModal = false"
                            class="px-5 py-2.5 text-sm text-slate-400 font-semibold hover:text-white transition-colors rounded-xl hover:bg-slate-800/70">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-500 active:scale-95 rounded-xl shadow-lg shadow-blue-600/25 transition-all"
                            style="box-shadow: 0 4px 15px rgba(59,130,246,0.35);">
                            <i class="fas fa-save text-xs"></i>
                            Simpan Anggota
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ================================================== --}}
        {{-- ===== EDIT MODAL =============================== --}}
        {{-- ================================================== --}}
        <div x-show="showEditModal" x-cloak
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/75 backdrop-blur-md modal-backdrop">
            <div @click.away="showEditModal = false"
                class="bg-[#0d1117] border border-slate-800/70 w-full max-w-md rounded-2xl overflow-hidden shadow-2xl modal-box"
                style="box-shadow: 0 25px 60px rgba(0,0,0,0.6), 0 0 0 1px rgba(245,158,11,0.08);">

                {{-- Header --}}
                <div class="px-6 py-5 modal-header-edit border-b border-slate-800/60 flex justify-between items-center">
                    <div class="flex items-center gap-3.5">
                        <div class="icon-badge-edit">
                            <i class="fas fa-user-edit text-amber-400 text-sm"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-white leading-tight">Edit Data Anggota</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Perbarui informasi profil anggota</p>
                        </div>
                    </div>
                    <button @click="showEditModal = false"
                        class="w-8 h-8 flex items-center justify-center text-slate-500 hover:text-white hover:bg-slate-800 rounded-lg transition-all">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>

                {{-- Form --}}
                <form :action="`{{ url('anggota') }}/${editData.id}`" method="POST" class="p-6 space-y-5">
                    @csrf @method('PUT')

                    {{-- Nama Lengkap --}}
                    <div>
                        <p class="form-section-label">Identitas</p>
                        <label class="field-label">Nama Lengkap</label>
                        <div class="field-wrapper field-edit">
                            <i class="fas fa-user field-icon"></i>
                            <input type="text" name="nama" oninput="this.value = this.value.toUpperCase()"
                                x-model="editData.nama" required placeholder="Masukkan nama...">
                        </div>
                    </div>

                    {{-- Gender & Status --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="field-label">Gender</label>
                            <div class="field-wrapper field-edit">
                                <i class="fas fa-venus-mars field-icon"></i>
                                <select name="gender" x-model="editData.gender">
                                    @foreach ($genderOptions as $opt)
                                        <option value="{{ $opt }}">{{ ucfirst($opt) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="field-label">Status</label>
                            <div class="field-wrapper field-edit">
                                <i class="fas fa-briefcase field-icon"></i>
                                <select name="status" x-model="editData.status">
                                    @foreach ($statusOptions as $opt)
                                        <option value="{{ $opt }}">{{ ucfirst($opt) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Jabatan --}}
                    <div>
                        <label class="field-label">Jabatan</label>
                        <div class="field-wrapper field-edit">
                            <i class="fas fa-shield-alt field-icon"></i>
                            <select name="jabatan" x-model="editData.jabatan">
                                @foreach ($jabatanOptions as $opt)
                                    <option value="{{ $opt }}">{{ ucfirst($opt) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end items-center gap-3 pt-5 border-t border-slate-800/60">
                        <button type="button" @click="showEditModal = false"
                            class="px-5 py-2.5 text-sm text-slate-400 font-semibold hover:text-white transition-colors rounded-xl hover:bg-slate-800/70">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 active:scale-95 rounded-xl shadow-lg transition-all"
                            style="box-shadow: 0 4px 15px rgba(245,158,11,0.35);">
                            <i class="fas fa-save text-xs"></i>
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
                        barPercentage: 0.55
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
                        spacing: 4
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
