@extends('layouts.app')

@section('title', 'Manajemen Keuangan')

@section('content')
    <div class="p-6">
        <div class="max-w-7xl mx-auto space-y-6">

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-black text-white uppercase tracking-wider">Manajemen Keuangan</h1>
                    <p class="text-gray-400 text-sm mt-1">Monitor dan kelola arus keuangan organisasi secara real-time</p>
                </div>
                <button onclick="showCreateModal()"
                    class="bg-blue-600 hover:bg-blue-500 text-white px-8 py-4 rounded-2xl font-black uppercase tracking-widest transition-all shadow-xl shadow-blue-600/20 flex items-center justify-center gap-3 group active:scale-95">
                    <i class="fas fa-plus group-hover:rotate-90 transition-transform"></i> Transaksi Baru
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-xl relative overflow-hidden group">
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <span class="text-gray-500 text-[10px] font-black uppercase tracking-[0.2em]">Total Pemasukan</span>
                        <div class="w-10 h-10 rounded-xl bg-green-500/10 flex items-center justify-center">
                            <i class="fas fa-arrow-down text-green-500"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-black text-white mb-1 relative z-10">
                        Rp {{ number_format($totalPemasukan ?? 0, 0, ',', '.') }}
                    </p>
                    <div
                        class="absolute -right-4 -bottom-4 text-green-500/5 text-8xl transform -rotate-12 group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                </div>

                <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-xl relative overflow-hidden group">
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <span class="text-gray-500 text-[10px] font-black uppercase tracking-[0.2em]">Total
                            Pengeluaran</span>
                        <div class="w-10 h-10 rounded-xl bg-red-500/10 flex items-center justify-center">
                            <i class="fas fa-arrow-up text-red-500"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-black text-white mb-1 relative z-10">
                        Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}
                    </p>
                    <div
                        class="absolute -right-4 -bottom-4 text-red-500/5 text-8xl transform -rotate-12 group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                </div>

                <div
                    class="rounded-3xl p-6 shadow-xl relative overflow-hidden group border border-blue-500/30 bg-gradient-to-br from-slate-900 to-slate-800">
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <span class="text-blue-400 text-[10px] font-black uppercase tracking-[0.2em]">Saldo Saat Ini</span>
                        <div
                            class="w-10 h-10 rounded-xl bg-blue-500/20 flex items-center justify-center border border-blue-500/20">
                            <i class="fas fa-wallet text-blue-400"></i>
                        </div>
                    </div>
                    <p
                        class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300 mb-1 relative z-10">
                        Rp {{ number_format($saldoAkhir ?? 0, 0, ',', '.') }}
                    </p>
                    <p class="text-slate-500 text-[9px] font-bold uppercase tracking-widest">Update:
                        {{ now()->format('d M Y') }}</p>
                </div>
            </div>

            <div class="bg-slate-900 border border-slate-800 rounded-[2rem] overflow-hidden shadow-2xl">
                <div class="px-8 py-6 border-b border-slate-800 flex items-center justify-between bg-slate-800/30">
                    <h3 class="font-black text-white uppercase tracking-widest flex items-center gap-3 text-sm">
                        <span class="w-2 h-6 bg-blue-500 rounded-full"></span>
                        Riwayat Transaksi
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-800/50 text-gray-500 text-[10px] font-black uppercase tracking-[0.3em]">
                            <tr>
                                <th class="px-8 py-5">Tanggal</th>
                                <th class="px-8 py-5">Keterangan</th>
                                <th class="px-8 py-5 text-center">Tipe</th>
                                <th class="px-8 py-5">Nominal</th>
                                <th class="px-8 py-5">Bukti</th>
                                <th class="px-8 py-5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/50">
                            @forelse ($keuangan as $item)
                                <tr class="hover:bg-slate-800/30 transition-all group">
                                    <td class="px-8 py-5 text-xs font-bold text-gray-400">
                                        {{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-8 py-5">
                                        <p
                                            class="text-sm font-black text-white uppercase group-hover:text-blue-400 transition-colors">
                                            {{ $item->keterangan }}
                                        </p>
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        @if ($item->input == 'pemasukan')
                                            <span
                                                class="px-3 py-1 text-[9px] font-black bg-green-500/10 text-green-500 rounded-lg border border-green-500/20 uppercase">Masuk</span>
                                        @else
                                            <span
                                                class="px-3 py-1 text-[9px] font-black bg-red-500/10 text-red-500 rounded-lg border border-red-500/20 uppercase">Keluar</span>
                                        @endif
                                    </td>
                                    <td
                                        class="px-8 py-5 text-sm font-black {{ $item->input == 'pemasukan' ? 'text-green-400' : 'text-red-400' }}">
                                        {{ $item->input == 'pengeluaran' ? '-' : '+' }} Rp
                                        {{ number_format($item->saldo, 0, ',', '.') }}
                                    </td>
                                    <td class="px-8 py-5">
                                        @if ($item->bukti)
                                            <button
                                                onclick="showImageModal('{{ asset('storage/' . $item->bukti) }}', '{{ $item->keterangan }}')"
                                                class="w-10 h-10 rounded-xl overflow-hidden border border-slate-700 hover:border-blue-500 transition-all relative group/img">
                                                <img src="{{ asset('storage/' . $item->bukti) }}"
                                                    class="w-full h-full object-cover">
                                                <div
                                                    class="absolute inset-0 bg-blue-600/40 flex items-center justify-center opacity-0 group-hover/img:opacity-100 transition-opacity">
                                                    <i class="fas fa-eye text-white text-[10px]"></i>
                                                </div>
                                            </button>
                                        @else
                                            <div
                                                class="w-10 h-10 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center">
                                                <i class="fas fa-image-slash text-slate-600 text-[10px]"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="flex justify-center gap-3">
                                            <a href="{{ route('keuangan.edit', $item->id) }}"
                                                class="p-2 text-yellow-500/50 hover:text-yellow-500 transition-colors">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('keuangan.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus data?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-red-500/50 hover:text-red-500 transition-colors">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-8 py-20 text-center">
                                        <p class="text-gray-600 font-bold uppercase tracking-widest text-xs">Belum ada data
                                            transaksi</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
        <div class="bg-slate-900 border border-slate-800 rounded-[2.5rem] p-8 shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h5 class="text-white font-black uppercase tracking-widest text-sm flex items-center gap-2">
                        <i class="fas fa-chart-line text-blue-500"></i> Trend Saldo
                    </h5>
                </div>
                <select id="periodFilter" onchange="updateLineChart()"
                    class="bg-slate-800 border-none text-blue-400 text-[10px] font-black uppercase tracking-widest rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 transition-all cursor-pointer">
                    <option value="daily">Harian (7 Hari)</option>
                    <option value="monthly" selected>Bulanan</option>
                    <option value="yearly">Tahunan</option>
                </select>
            </div>
            <div class="h-[300px] w-full">
                <canvas id="lineChart"></canvas>
            </div>
        </div>

        <div class="bg-slate-900 border border-slate-800 rounded-[2.5rem] p-8 shadow-xl">
            <h5 class="text-white font-black uppercase tracking-widest text-sm flex items-center gap-2 mb-6">
                <i class="fas fa-chart-pie text-emerald-500"></i> Struktur Arus Kas
            </h5>
            <div class="h-[300px] w-full flex items-center justify-center">
                <canvas id="doughnutChart"></canvas>
            </div>
        </div>
    </div>



    <div id="createModal" class="fixed inset-0 z-[9999] hidden opacity-0 transition-opacity duration-300">
        <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-xl" onclick="closeCreateModal()"></div>
        <div class="relative h-full w-full flex items-center justify-center p-6">
            <div id="createModalContent"
                class="relative max-w-2xl w-full bg-slate-900 rounded-[2.5rem] overflow-hidden shadow-[0_0_80px_-20px_rgba(59,130,246,0.3)] border border-slate-700 transform scale-95 transition-transform duration-300">

                <div
                    class="px-10 py-8 border-b border-slate-800 flex items-center justify-between bg-gradient-to-r from-slate-800/50 to-transparent">
                    <div>
                        <h4 class="text-xl font-black text-white uppercase tracking-widest flex items-center gap-3">
                            <span
                                class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center shadow-lg shadow-blue-600/40">
                                <i class="fas fa-plus text-xs text-white"></i>
                            </span>
                            Input Data Kas
                        </h4>
                    </div>
                    <button onclick="closeCreateModal()"
                        class="w-10 h-10 rounded-full text-gray-500 hover:text-white hover:bg-white/10 transition-all flex items-center justify-center">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form action="{{ route('keuangan.store') }}" method="POST" enctype="multipart/form-data"
                    class="p-10">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div class="group">
                                <label
                                    class="block text-[10px] font-black text-blue-500 uppercase tracking-[0.2em] mb-3 px-1">Tanggal
                                    Transaksi</label>
                                <input type="date" name="date" value="{{ date('Y-m-d') }}" required
                                    class="w-full bg-slate-800/50 border-slate-700 rounded-2xl text-white text-sm focus:ring-2 focus:ring-blue-500 transition-all h-14 px-6">
                            </div>

                            <div class="group">
                                <label
                                    class="block text-[10px] font-black text-blue-500 uppercase tracking-[0.2em] mb-3 px-1">
                                    Nominal (IDR)
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-500 font-bold text-sm">Rp</span>

                                    <input type="text" id="display_saldo" placeholder="0" required
                                        oninput="formatCurrency(this)"
                                        class="w-full bg-slate-800/50 border-slate-700 pl-14 rounded-2xl text-white text-xl font-black focus:ring-2 focus:ring-blue-500 transition-all h-14">

                                    <input type="hidden" name="saldo" id="formSaldo">
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="group">
                                <label
                                    class="block text-[10px] font-black text-blue-500 uppercase tracking-[0.2em] mb-3 px-1">Jenis
                                    Transaksi</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="input" value="pemasukan" class="peer hidden"
                                            checked>
                                        <div
                                            class="flex items-center justify-center h-14 rounded-2xl border border-slate-700 bg-slate-800/50 text-gray-500 peer-checked:border-green-500 peer-checked:bg-green-500/10 peer-checked:text-green-500 transition-all font-black text-xs uppercase">
                                            Masuk
                                        </div>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="input" value="pengeluaran" class="peer hidden">
                                        <div
                                            class="flex items-center justify-center h-14 rounded-2xl border border-slate-700 bg-slate-800/50 text-gray-500 peer-checked:border-red-500 peer-checked:bg-red-500/10 peer-checked:text-red-500 transition-all font-black text-xs uppercase">
                                            Keluar
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="group">
                                <label
                                    class="block text-[10px] font-black text-blue-500 uppercase tracking-[0.2em] mb-3 px-1">Bukti
                                    Gambar</label>
                                <div class="relative group/file">
                                    <input type="file" name="bukti" id="buktiInput" accept="image/*"
                                        class="hidden" onchange="previewFile(this)">
                                    <label for="buktiInput"
                                        class="flex items-center gap-4 px-6 h-14 rounded-2xl border-2 border-dashed border-slate-700 bg-slate-800/30 hover:border-blue-500 transition-all cursor-pointer">
                                        <i class="fas fa-upload text-gray-500"></i>
                                        <span id="fileName"
                                            class="text-[10px] font-black text-gray-500 uppercase truncate">Pilih
                                            Lampiran</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <label
                            class="block text-[10px] font-black text-blue-500 uppercase tracking-[0.2em] mb-3 px-1">Keterangan</label>
                        <input name="keterangan" rows="2" placeholder="Masukkan detail transaksi di sini..."
                            oninput="this.value = this.value.toUpperCase()" required
                            class="w-full bg-slate-800/50 border-slate-700 rounded-2xl text-white text-sm focus:ring-2 focus:ring-blue-500 transition-all px-6 py-4"></input>
                    </div>

                    <div class="mt-10 flex gap-4">
                        <button type="button" onclick="closeCreateModal()"
                            class="flex-1 h-14 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] text-gray-500 hover:bg-slate-800 transition-all border border-slate-700">Batal</button>
                        <button type="submit"
                            class="flex-[2] h-14 bg-blue-600 hover:bg-blue-500 text-white rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] shadow-xl shadow-blue-600/20 transition-all">Simpan
                            Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="imageModal" class="fixed inset-0 z-[9999] hidden opacity-0 transition-opacity duration-300">
        <div class="absolute inset-0 bg-slate-950/90 backdrop-blur-xl" onclick="closeImageModal()"></div>
        <div class="relative h-full w-full flex items-center justify-center p-6">
            <div id="imageModalContent"
                class="relative max-w-4xl w-full bg-slate-900 rounded-[2.5rem] overflow-hidden border border-slate-700 transform scale-95 transition-all">
                <div class="p-4 border-b border-slate-800 flex justify-between px-8 py-4">
                    <h5 id="modalTitle" class="text-white font-black uppercase text-xs tracking-widest">Bukti
                        Transaksi
                    </h5>
                    <button onclick="closeImageModal()" class="text-gray-500 hover:text-white"><i
                            class="fas fa-times"></i></button>
                </div>
                <div class="p-8 flex justify-center bg-slate-950/50">
                    <img id="modalImage" src="" class="max-h-[70vh] rounded-2xl shadow-2xl">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Modal Create Logic
        function showCreateModal() {
            const m = document.getElementById('createModal');
            const c = document.getElementById('createModalContent');
            m.classList.remove('hidden');
            setTimeout(() => {
                m.classList.add('opacity-100');
                c.classList.remove('scale-95');
                c.classList.add('scale-100');
            }, 10);
            document.body.style.overflow = 'hidden';
        }

        function closeCreateModal() {
            const m = document.getElementById('createModal');
            const c = document.getElementById('createModalContent');
            m.classList.remove('opacity-100');
            c.classList.remove('scale-100');
            c.classList.add('scale-95');
            setTimeout(() => m.classList.add('hidden'), 300);
            document.body.style.overflow = 'auto';
        }

        // Modal Image Logic
        function showImageModal(src, title) {
            const m = document.getElementById('imageModal');
            const c = document.getElementById('imageModalContent');
            document.getElementById('modalImage').src = src;
            document.getElementById('modalTitle').innerText = title;
            m.classList.remove('hidden');
            setTimeout(() => {
                m.classList.add('opacity-100');
                c.classList.remove('scale-95');
                c.classList.add('scale-100');
            }, 10);
        }

        function closeImageModal() {
            const m = document.getElementById('imageModal');
            const c = document.getElementById('imageModalContent');
            m.classList.remove('opacity-100');
            c.classList.remove('scale-100');
            c.classList.add('scale-95');
            setTimeout(() => m.classList.add('hidden'), 300);
        }

        function previewFile(input) {
            const label = document.getElementById('fileName');
            if (input.files && input.files[0]) {
                label.innerText = input.files[0].name;
                label.classList.replace('text-gray-500', 'text-blue-400');
            }
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeCreateModal();
                closeImageModal();
            }
        });

        const allChartData = @json($chartData);
        let lineChart;

        // --- Inisialisasi Line Chart ---
        const ctxLine = document.getElementById('lineChart').getContext('2d');
        lineChart = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: allChartData.monthly.labels,
                datasets: [{
                    label: 'Saldo',
                    data: allChartData.monthly.values,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 4,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#0f172a',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    tension: 0.4,
                    fill: true
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
                    y: {
                        grid: {
                            color: 'rgba(255,255,255,0.05)'
                        },
                        ticks: {
                            color: '#64748b',
                            font: {
                                size: 10,
                                weight: 'bold'
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#64748b',
                            font: {
                                size: 10,
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        });

        // Fungsi Update Line Chart
        function updateLineChart() {
            const period = document.getElementById('periodFilter').value;
            lineChart.data.labels = allChartData[period].labels;
            lineChart.data.datasets[0].data = allChartData[period].values;
            lineChart.update();
        }

        // --- Inisialisasi Doughnut Chart ---
        const ctxDoughnut = document.getElementById('doughnutChart').getContext('2d');
        new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: ['Pemasukan', 'Pengeluaran'],
                datasets: [{
                    data: [{{ $totalPemasukan }}, {{ $totalPengeluaran }}],
                    backgroundColor: ['#10b981', '#ef4444'],
                    hoverOffset: 20,
                    borderWidth: 0,
                    borderRadius: 10
                }]
            },
            options: {
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#94a3b8',
                            font: {
                                size: 10,
                                weight: 'bold'
                            },
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });

        function formatCurrency(input) {
            // 1. Ambil angka saja dari input
            let value = input.value.replace(/[^0-9]/g, '');

            // 2. Masukkan angka murni ke input hidden (untuk database)
            document.getElementById('formSaldo').value = value;

            // 3. Format tampilan visual dengan titik (Ribuan)
            if (value) {
                input.value = new Intl.NumberFormat('id-ID').format(value);
            } else {
                input.value = '';
            }
        }

        // Tambahkan ini di fungsi openEditModal(data) Anda agar saat edit, formatnya muncul otomatis
        function openFormModal(data = null) {
            const modal = document.getElementById('formModal');
            // ... kode modal lainnya ...

            if (data) {
                // ... kode setting action form lainnya ...

                // Isi input hidden (angka murni)
                document.getElementById('formSaldo').value = data.saldo;

                // Isi input display dengan format titik
                document.getElementById('display_saldo').value = new Intl.NumberFormat('id-ID').format(data.saldo);

                document.getElementById('formDate').value = data.date;
                document.getElementById('formKeterangan').value = data.keterangan;
                // ...
            } else {
                document.getElementById('mainForm').reset();
                document.getElementById('formSaldo').value = '';
                document.getElementById('display_saldo').value = '';
            }
            // ...
        }
    </script>
@endsection
