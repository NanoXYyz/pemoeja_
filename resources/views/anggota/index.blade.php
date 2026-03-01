{{-- resources/views/anggota/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Anggota')

@section('content')
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <div class="flex items-center gap-2 text-xs text-gray-500 mb-2">
                <span>Home</span> <i class="fas fa-chevron-right text-xs"></i> <span class="text-blue-400">Anggota</span>
            </div>
            <h1 class="text-2xl font-900 text-white">Member Directory</h1>
            <p class="text-gray-400 text-sm mt-1">Kelola data anggota komunitas</p>
        </div>
        @auth
            @if (Auth::user()->role === 'admin')
                <a href="{{ route('anggota.create') }}"
                    class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-lg shadow-blue-600/20 flex items-center gap-2">
                    <i class="fas fa-plus"></i> Tambah Anggota
                </a>
            @endif
        @endauth
    </div>

    <!-- Table -->
    <div class="card overflow-hidden">
        <div class="p-6 border-b border-navy-700 flex items-center justify-between">
            <div>
                <h3 class="font-700 text-white">Data Anggota</h3>
                <p class="text-xs text-gray-500 mt-0.5">Total anggota terdaftar</p>
            </div>
            <div class="flex gap-2">
                <button class="btn-secondary text-xs py-1.5 px-3"><i class="fas fa-filter"></i> Filter</button>
                <button class="btn-secondary text-xs py-1.5 px-3"><i class="fas fa-download"></i> Export</button>
            </div>
        </div>
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
                            <td> {{ $index + 1 }} </td>
                            <td> {{ $item->nama }} </td>
                            <td> {{ $item->gender }} </td>
                            <td> {{ $item->status }} </td>
                            <td> {{ $item->jabatan }} </td>
                            <td>
                                @if (Auth::check() && Auth::user()->role === 'admin')
                                    <div x-data="{ open: false }" class="relative inline-block text-left">
                                        <button @click="open = !open" @click.away="open = false"
                                            class="flex items-center gap-2 px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white text-sm font-bold rounded-xl border border-slate-700 transition-all active:scale-95">
                                            AKSI
                                            <i class="fas fa-chevron-down text-[10px] transition-transform"
                                                :class="open ? 'rotate-180' : ''"></i>
                                        </button>

                                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="transform opacity-0 scale-95"
                                            x-transition:enter-end="transform opacity-100 scale-100"
                                            class="absolute right-0 mt-2 w-40 bg-slate-900 border border-slate-800 rounded-xl shadow-2xl z-50 overflow-hidden">

                                            <div class="py-1">
                                                <a href="{{ route('anggota.edit', $item->id) }}"
                                                    class="flex items-center gap-3 px-4 py-3 text-sm text-amber-400 hover:bg-slate-800 transition-colors font-medium">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>

                                                <form action="{{ route('anggota.destroy', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-500 hover:bg-slate-800 transition-colors font-medium border-t border-slate-800"><i
                                                            class="fas fa-trash-alt"></i> Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div
                                        class="flex items-center gap-2 text-slate-500 italic text-xs bg-slate-800/50 px-3 py-1.5 rounded-lg border border-slate-700/50 w-fit">
                                        <i class="fas fa-lock text-[10px]"></i>
                                        Read Only
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- CHART --}}

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8 mt-8">
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <h5 class="text-white font-bold flex items-center gap-2">
                    <i class="fas fa-user-tag text-blue-500"></i> Distribusi Status
                </h5>
                <span
                    class="text-[10px] bg-blue-500/10 text-blue-400 px-2 py-1 rounded-md uppercase font-bold tracking-wider">Pekerjaan</span>
            </div>
            <div class="relative h-[300px]">
                <canvas id="chartStatus"></canvas>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-6">
                <div class="bg-slate-800/40 p-3 rounded-xl border border-slate-700/50">
                    <p class="text-slate-400 text-xs mb-1 text-center uppercase tracking-tighter">Pelajar</p>
                    <p class="text-white text-xl font-black text-center">{{ $dataStatus['pelajar'] }}</p>
                </div>
                <div class="bg-slate-800/40 p-3 rounded-xl border border-slate-700/50">
                    <p class="text-slate-400 text-xs mb-1 text-center uppercase tracking-tighter">Bekerja</p>
                    <p class="text-white text-xl font-black text-center">{{ $dataStatus['bekerja'] }}</p>
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
            <div class="relative h-[300px]">
                <canvas id="chartGender"></canvas>
            </div>
            <div class="flex justify-around mt-6">
                <div class="flex items-center gap-3">
                    <div class="w-3 h-3 rounded-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.5)]"></div>
                    <span class="text-slate-300 text-sm font-medium">Pria ({{ $dataGender['laki'] }})</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-3 h-3 rounded-full bg-pink-500 shadow-[0_0_10px_rgba(236,72,153,0.5)]"></div>
                    <span class="text-slate-300 text-sm font-medium">Wanita ({{ $dataGender['perempuan'] }})</span>
                </div>
            </div>
        </div>
    </div>


    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Konfigurasi Global
        Chart.defaults.color = '#94a3b8'; // Slate 400
        Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";

        // --- 1. Chart Status (Bar Chart dengan Gradien) ---
        const ctxStatus = document.getElementById('chartStatus').getContext('2d');

        // Buat Gradien Biru
        const blueGrad = ctxStatus.createLinearGradient(0, 0, 0, 400);
        blueGrad.addColorStop(0, '#3b82f6'); // blue-500
        blueGrad.addColorStop(1, '#1d4ed8'); // blue-700

        // Buat Gradien Hijau/Emerald
        const greenGrad = ctxStatus.createLinearGradient(0, 0, 0, 400);
        greenGrad.addColorStop(0, '#10b981'); // emerald-500
        greenGrad.addColorStop(1, '#047857'); // emerald-700

        new Chart(ctxStatus, {
            type: 'bar',
            data: {
                labels: ['PELAJAR', 'BEKERJA'],
                datasets: [{
                    data: [{{ $dataStatus['pelajar'] }}, {{ $dataStatus['bekerja'] }}],
                    backgroundColor: [blueGrad, greenGrad],
                    borderRadius: 12,
                    borderSkipped: false,
                    barPercentage: 0.6,
                }]
            },
            options: {
                maintainAspectRatio: false,
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
                            color: 'rgba(255,255,255,0.05)'
                        },
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // --- 2. Chart Gender (Doughnut Chart Glow) ---
        const ctxGender = document.getElementById('chartGender').getContext('2d');
        new Chart(ctxGender, {
            type: 'doughnut',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [{{ $dataGender['laki'] }}, {{ $dataGender['perempuan'] }}],
                    backgroundColor: ['#3b82f6', '#ec4899'], // Blue 500 & Pink 500
                    hoverOffset: 15,
                    borderWidth: 0,
                    borderRadius: 10,
                    spacing: 5
                }]
            },
            options: {
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
@endsection
