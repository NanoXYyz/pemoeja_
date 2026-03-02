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

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- Card Pemasukan --}}
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
                    <div class="absolute -right-4 -bottom-4 text-green-500/5 text-8xl transform -rotate-12 group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                </div>

                {{-- Card Pengeluaran --}}
                <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-xl relative overflow-hidden group">
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <span class="text-gray-500 text-[10px] font-black uppercase tracking-[0.2em]">Total Pengeluaran</span>
                        <div class="w-10 h-10 rounded-xl bg-red-500/10 flex items-center justify-center">
                            <i class="fas fa-arrow-up text-red-500"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-black text-white mb-1 relative z-10">
                        Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}
                    </p>
                    <div class="absolute -right-4 -bottom-4 text-red-500/5 text-8xl transform -rotate-12 group-hover:scale-110 transition-transform duration-500">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                </div>

                {{-- Card Saldo --}}
                <div class="rounded-3xl p-6 shadow-xl relative overflow-hidden group border border-blue-500/30 bg-gradient-to-br from-slate-900 to-slate-800">
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <span class="text-blue-400 text-[10px] font-black uppercase tracking-[0.2em]">Saldo Saat Ini</span>
                        <div class="w-10 h-10 rounded-xl bg-blue-500/20 flex items-center justify-center border border-blue-500/20">
                            <i class="fas fa-wallet text-blue-400"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300 mb-1 relative z-10">
                        Rp {{ number_format($saldoAkhir ?? 0, 0, ',', '.') }}
                    </p>
                    <p class="text-slate-500 text-[9px] font-bold uppercase tracking-widest">Update: {{ now()->format('d M Y') }}</p>
                </div>
            </div>

            {{-- Tabel Riwayat --}}
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
                                        <p class="text-sm font-black text-white uppercase group-hover:text-blue-400 transition-colors">
                                            {{ $item->keterangan }}
                                        </p>
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        {{-- Badge warna: pemasukan=hijau, lainnya=merah, dinamis dari settings --}}
                                        @php
                                            $isIn = $item->input === 'pemasukan';
                                        @endphp
                                        <span class="px-3 py-1 text-[9px] font-black rounded-lg border uppercase
                                            {{ $isIn ? 'bg-green-500/10 text-green-500 border-green-500/20' : 'bg-red-500/10 text-red-500 border-red-500/20' }}">
                                            {{ ucfirst($item->input) }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 text-sm font-black {{ $isIn ? 'text-green-400' : 'text-red-400' }}">
                                        {{ $isIn ? '+' : '-' }} Rp {{ number_format($item->saldo, 0, ',', '.') }}
                                    </td>
                                    <td class="px-8 py-5">
                                        @if ($item->bukti)
                                            <button onclick="showImageModal('{{ asset('storage/' . $item->bukti) }}', '{{ $item->keterangan }}')"
                                                class="w-10 h-10 rounded-xl overflow-hidden border border-slate-700 hover:border-blue-500 transition-all relative group/img">
                                                <img src="{{ asset('storage/' . $item->bukti) }}" class="w-full h-full object-cover">
                                                <div class="absolute inset-0 bg-blue-600/40 flex items-center justify-center opacity-0 group-hover/img:opacity-100 transition-opacity">
                                                    <i class="fas fa-eye text-white text-[10px]"></i>
                                                </div>
                                            </button>
                                        @else
                                            <div class="w-10 h-10 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center">
                                                <i class="fas fa-image text-slate-600 text-[10px]"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="flex justify-center gap-3">
                                            <button onclick="openEditModal({{ $item }})"
                                                class="p-2 text-yellow-500/50 hover:text-yellow-500 transition-colors">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('keuangan.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus data ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 text-red-500/50 hover:text-red-500 transition-colors">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-8 py-20 text-center">
                                        <p class="text-gray-600 font-bold uppercase tracking-widest text-xs">Belum ada data transaksi</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
        <div class="bg-slate-900 border border-slate-800 rounded-[2.5rem] p-8 shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <h5 class="text-white font-black uppercase tracking-widest text-sm flex items-center gap-2">
                    <i class="fas fa-chart-line text-blue-500"></i> Trend Saldo
                </h5>
                <select id="periodFilter" onchange="updateLineChart()"
                    class="bg-slate-800 border-none text-blue-400 text-[10px] font-black uppercase tracking-widest rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 cursor-pointer">
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
            {{-- Legend dinamis dari inputOptions settings --}}
            <div class="flex justify-around mt-4">
                @php $doughnutColors = ['#10b981', '#ef4444', '#3b82f6', '#f59e0b']; @endphp
                @foreach ($inputOptions as $i => $opt)
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full" style="background: {{ $doughnutColors[$i % count($doughnutColors)] }}"></div>
                        <span class="text-slate-400 text-xs font-bold uppercase">{{ ucfirst($opt) }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ====== MODAL TAMBAH TRANSAKSI ====== --}}
    <div id="createModal" class="fixed inset-0 z-[9999] hidden opacity-0 transition-opacity duration-300">
        <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-xl" onclick="closeCreateModal()"></div>
        <div class="relative h-full w-full flex items-center justify-center p-6">
            <div id="createModalContent"
                class="relative max-w-2xl w-full bg-slate-900 rounded-[2.5rem] overflow-hidden shadow-[0_0_80px_-20px_rgba(59,130,246,0.3)] border border-slate-700 transform scale-95 transition-transform duration-300">

                <div class="px-10 py-8 border-b border-slate-800 flex items-center justify-between bg-gradient-to-r from-slate-800/50 to-transparent">
                    <h4 class="text-xl font-black text-white uppercase tracking-widest flex items-center gap-3">
                        <span class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center shadow-lg shadow-blue-600/40">
                            <i class="fas fa-plus text-xs text-white"></i>
                        </span>
                        Input Data Kas
                    </h4>
                    <button onclick="closeCreateModal()" class="w-10 h-10 rounded-full text-gray-500 hover:text-white hover:bg-white/10 transition-all flex items-center justify-center">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form action="{{ route('keuangan.store') }}" method="POST" enctype="multipart/form-data" class="p-10">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-[10px] font-black text-blue-500 uppercase tracking-[0.2em] mb-3 px-1">Tanggal Transaksi</label>
                                <input type="date" name="date" value="{{ date('Y-m-d') }}" required
                                    class="w-full bg-slate-800/50 border-slate-700 rounded-2xl text-white text-sm focus:ring-2 focus:ring-blue-500 h-14 px-6">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-blue-500 uppercase tracking-[0.2em] mb-3 px-1">Nominal (IDR)</label>
                                <div class="relative">
                                    <span class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-500 font-bold text-sm">Rp</span>
                                    <input type="text" id="display_saldo" placeholder="0" required
                                        oninput="formatCurrency(this)"
                                        class="w-full bg-slate-800/50 border-slate-700 pl-14 rounded-2xl text-white text-xl font-black focus:ring-2 focus:ring-blue-500 h-14">
                                    <input type="hidden" name="saldo" id="formSaldo">
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-[10px] font-black text-blue-500 uppercase tracking-[0.2em] mb-3 px-1">Jenis Transaksi</label>
                                {{-- Dibangun dari $inputOptions (settings), bukan hardcode --}}
                                <div class="grid grid-cols-{{ count($inputOptions) <= 2 ? '2' : '3' }} gap-3">
                                    @php
                                        $optColors = [
                                            0 => ['border-green-500', 'bg-green-500/10', 'text-green-500'],
                                            1 => ['border-red-500',   'bg-red-500/10',   'text-red-500'],
                                            2 => ['border-blue-500',  'bg-blue-500/10',  'text-blue-500'],
                                            3 => ['border-amber-500', 'bg-amber-500/10', 'text-amber-500'],
                                        ];
                                    @endphp
                                    @foreach ($inputOptions as $i => $opt)
                                        @php $c = $optColors[$i % count($optColors)]; @endphp
                                        <label class="cursor-pointer">
                                            <input type="radio" name="input" value="{{ $opt }}" class="peer hidden" {{ $i === 0 ? 'checked' : '' }}>
                                            <div class="flex items-center justify-center h-14 rounded-2xl border border-slate-700 bg-slate-800/50 text-gray-500
                                                peer-checked:{{ $c[0] }} peer-checked:{{ $c[1] }} peer-checked:{{ $c[2] }}
                                                transition-all font-black text-xs uppercase">
                                                {{ ucfirst($opt) }}
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-blue-500 uppercase tracking-[0.2em] mb-3 px-1">Bukti Gambar</label>
                                <div class="relative">
                                    <input type="file" name="bukti" id="buktiInput" accept="image/*" class="hidden" onchange="previewFile(this)">
                                    <label for="buktiInput" class="flex items-center gap-4 px-6 h-14 rounded-2xl border-2 border-dashed border-slate-700 bg-slate-800/30 hover:border-blue-500 transition-all cursor-pointer">
                                        <i class="fas fa-upload text-gray-500"></i>
                                        <span id="fileName" class="text-[10px] font-black text-gray-500 uppercase truncate">Pilih Lampiran</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <label class="block text-[10px] font-black text-blue-500 uppercase tracking-[0.2em] mb-3 px-1">Keterangan</label>
                        <input name="keterangan" placeholder="Masukkan detail transaksi di sini..."
                            oninput="this.value = this.value.toUpperCase()" required
                            class="w-full bg-slate-800/50 border-slate-700 rounded-2xl text-white text-sm focus:ring-2 focus:ring-blue-500 px-6 py-4">
                    </div>

                    <div class="mt-10 flex gap-4">
                        <button type="button" onclick="closeCreateModal()"
                            class="flex-1 h-14 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] text-gray-500 hover:bg-slate-800 border border-slate-700">Batal</button>
                        <button type="submit"
                            class="flex-[2] h-14 bg-blue-600 hover:bg-blue-500 text-white rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] shadow-xl shadow-blue-600/20">
                            Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ====== MODAL EDIT TRANSAKSI ====== --}}
    <div id="editModal" class="fixed inset-0 z-[9999] hidden opacity-0 transition-opacity duration-300">
        <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-xl" onclick="closeEditModal()"></div>
        <div class="relative h-full w-full flex items-center justify-center p-6">
            <div id="editModalContent"
                class="relative max-w-2xl w-full bg-slate-900 rounded-[2.5rem] overflow-hidden shadow-[0_0_80px_-20px_rgba(251,191,36,0.2)] border border-slate-700 transform scale-95 transition-transform duration-300">

                <div class="px-10 py-8 border-b border-slate-800 flex items-center justify-between bg-gradient-to-r from-slate-800/50 to-transparent">
                    <h4 class="text-xl font-black text-white uppercase tracking-widest flex items-center gap-3">
                        <span class="w-10 h-10 rounded-xl bg-amber-500 flex items-center justify-center shadow-lg shadow-amber-500/40">
                            <i class="fas fa-edit text-xs text-white"></i>
                        </span>
                        Edit Transaksi
                    </h4>
                    <button onclick="closeEditModal()" class="w-10 h-10 rounded-full text-gray-500 hover:text-white hover:bg-white/10 transition-all flex items-center justify-center">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form id="editForm" action="" method="POST" enctype="multipart/form-data" class="p-10">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-[10px] font-black text-amber-500 uppercase tracking-[0.2em] mb-3 px-1">Tanggal Transaksi</label>
                                <input type="date" name="date" id="editDate" required
                                    class="w-full bg-slate-800/50 border-slate-700 rounded-2xl text-white text-sm focus:ring-2 focus:ring-amber-500 h-14 px-6">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-amber-500 uppercase tracking-[0.2em] mb-3 px-1">Nominal (IDR)</label>
                                <div class="relative">
                                    <span class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-500 font-bold text-sm">Rp</span>
                                    <input type="text" id="edit_display_saldo" placeholder="0" required
                                        oninput="formatCurrencyEdit(this)"
                                        class="w-full bg-slate-800/50 border-slate-700 pl-14 rounded-2xl text-white text-xl font-black focus:ring-2 focus:ring-amber-500 h-14">
                                    <input type="hidden" name="saldo" id="editFormSaldo">
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-[10px] font-black text-amber-500 uppercase tracking-[0.2em] mb-3 px-1">Jenis Transaksi</label>
                                {{-- Juga dinamis dari $inputOptions --}}
                                <div class="grid grid-cols-{{ count($inputOptions) <= 2 ? '2' : '3' }} gap-3" id="editInputOptions">
                                    @foreach ($inputOptions as $i => $opt)
                                        @php $c = $optColors[$i % count($optColors)]; @endphp
                                        <label class="cursor-pointer">
                                            <input type="radio" name="input" value="{{ $opt }}" class="peer hidden edit-input-radio">
                                            <div class="flex items-center justify-center h-14 rounded-2xl border border-slate-700 bg-slate-800/50 text-gray-500
                                                peer-checked:{{ $c[0] }} peer-checked:{{ $c[1] }} peer-checked:{{ $c[2] }}
                                                transition-all font-black text-xs uppercase">
                                                {{ ucfirst($opt) }}
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-amber-500 uppercase tracking-[0.2em] mb-3 px-1">Bukti Baru (opsional)</label>
                                <div class="relative">
                                    <input type="file" name="bukti" id="editBuktiInput" accept="image/*" class="hidden" onchange="previewFileEdit(this)">
                                    <label for="editBuktiInput" class="flex items-center gap-4 px-6 h-14 rounded-2xl border-2 border-dashed border-slate-700 bg-slate-800/30 hover:border-amber-500 transition-all cursor-pointer">
                                        <i class="fas fa-upload text-gray-500"></i>
                                        <span id="editFileName" class="text-[10px] font-black text-gray-500 uppercase truncate">Ganti Lampiran</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <label class="block text-[10px] font-black text-amber-500 uppercase tracking-[0.2em] mb-3 px-1">Keterangan</label>
                        <input name="keterangan" id="editKeterangan" placeholder="Detail transaksi..."
                            oninput="this.value = this.value.toUpperCase()" required
                            class="w-full bg-slate-800/50 border-slate-700 rounded-2xl text-white text-sm focus:ring-2 focus:ring-amber-500 px-6 py-4">
                    </div>

                    <div class="mt-10 flex gap-4">
                        <button type="button" onclick="closeEditModal()"
                            class="flex-1 h-14 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] text-gray-500 hover:bg-slate-800 border border-slate-700">Batal</button>
                        <button type="submit"
                            class="flex-[2] h-14 bg-amber-500 hover:bg-amber-400 text-white rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] shadow-xl shadow-amber-500/20">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Preview Gambar --}}
    <div id="imageModal" class="fixed inset-0 z-[9999] hidden opacity-0 transition-opacity duration-300">
        <div class="absolute inset-0 bg-slate-950/90 backdrop-blur-xl" onclick="closeImageModal()"></div>
        <div class="relative h-full w-full flex items-center justify-center p-6">
            <div id="imageModalContent"
                class="relative max-w-4xl w-full bg-slate-900 rounded-[2.5rem] overflow-hidden border border-slate-700 transform scale-95 transition-all">
                <div class="p-4 border-b border-slate-800 flex justify-between px-8 py-4">
                    <h5 id="modalTitle" class="text-white font-black uppercase text-xs tracking-widest">Bukti Transaksi</h5>
                    <button onclick="closeImageModal()" class="text-gray-500 hover:text-white"><i class="fas fa-times"></i></button>
                </div>
                <div class="p-8 flex justify-center bg-slate-950/50">
                    <img id="modalImage" src="" class="max-h-[70vh] rounded-2xl shadow-2xl">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // ====== MODAL CREATE ======
        function showCreateModal() {
            const m = document.getElementById('createModal');
            const c = document.getElementById('createModalContent');
            m.classList.remove('hidden');
            setTimeout(() => { m.classList.add('opacity-100'); c.classList.replace('scale-95','scale-100'); }, 10);
            document.body.style.overflow = 'hidden';
        }
        function closeCreateModal() {
            const m = document.getElementById('createModal');
            const c = document.getElementById('createModalContent');
            m.classList.remove('opacity-100');
            c.classList.replace('scale-100','scale-95');
            setTimeout(() => m.classList.add('hidden'), 300);
            document.body.style.overflow = 'auto';
        }

        // ====== MODAL EDIT ======
        function openEditModal(item) {
            const m = document.getElementById('editModal');
            const c = document.getElementById('editModalContent');

            // Set action form ke route update
            document.getElementById('editForm').action = `/keuangan/${item.id}`;
            document.getElementById('editDate').value        = item.date;
            document.getElementById('editKeterangan').value  = item.keterangan.toUpperCase();

            // Set nominal
            document.getElementById('editFormSaldo').value        = item.saldo;
            document.getElementById('edit_display_saldo').value   = new Intl.NumberFormat('id-ID').format(item.saldo);

            // Set radio sesuai nilai input dari DB
            document.querySelectorAll('.edit-input-radio').forEach(r => {
                r.checked = (r.value === item.input);
            });

            m.classList.remove('hidden');
            setTimeout(() => { m.classList.add('opacity-100'); c.classList.replace('scale-95','scale-100'); }, 10);
            document.body.style.overflow = 'hidden';
        }
        function closeEditModal() {
            const m = document.getElementById('editModal');
            const c = document.getElementById('editModalContent');
            m.classList.remove('opacity-100');
            c.classList.replace('scale-100','scale-95');
            setTimeout(() => m.classList.add('hidden'), 300);
            document.body.style.overflow = 'auto';
        }

        // ====== MODAL IMAGE ======
        function showImageModal(src, title) {
            const m = document.getElementById('imageModal');
            const c = document.getElementById('imageModalContent');
            document.getElementById('modalImage').src = src;
            document.getElementById('modalTitle').innerText = title;
            m.classList.remove('hidden');
            setTimeout(() => { m.classList.add('opacity-100'); c.classList.replace('scale-95','scale-100'); }, 10);
        }
        function closeImageModal() {
            const m = document.getElementById('imageModal');
            const c = document.getElementById('imageModalContent');
            m.classList.remove('opacity-100');
            c.classList.replace('scale-100','scale-95');
            setTimeout(() => m.classList.add('hidden'), 300);
        }

        function previewFile(input) {
            const label = document.getElementById('fileName');
            if (input.files?.[0]) { label.innerText = input.files[0].name; label.classList.replace('text-gray-500','text-blue-400'); }
        }
        function previewFileEdit(input) {
            const label = document.getElementById('editFileName');
            if (input.files?.[0]) { label.innerText = input.files[0].name; label.classList.replace('text-gray-500','text-amber-400'); }
        }

        document.addEventListener('keydown', e => { if (e.key === 'Escape') { closeCreateModal(); closeEditModal(); closeImageModal(); } });

        // ====== FORMAT CURRENCY ======
        function formatCurrency(input) {
            const val = input.value.replace(/[^0-9]/g, '');
            document.getElementById('formSaldo').value = val;
            input.value = val ? new Intl.NumberFormat('id-ID').format(val) : '';
        }
        function formatCurrencyEdit(input) {
            const val = input.value.replace(/[^0-9]/g, '');
            document.getElementById('editFormSaldo').value = val;
            input.value = val ? new Intl.NumberFormat('id-ID').format(val) : '';
        }

        // ====== CHARTS ======
        const allChartData = @json($chartData);

        // Line Chart
        const ctxLine = document.getElementById('lineChart').getContext('2d');
        let lineChart = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: allChartData.monthly.labels,
                datasets: [{
                    label: 'Saldo',
                    data: allChartData.monthly.values,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59,130,246,0.1)',
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
                plugins: { legend: { display: false } },
                scales: {
                    y: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#64748b', font: { size: 10, weight: 'bold' } } },
                    x: { grid: { display: false }, ticks: { color: '#64748b', font: { size: 10, weight: 'bold' } } }
                }
            }
        });
        function updateLineChart() {
            const period = document.getElementById('periodFilter').value;
            lineChart.data.labels = allChartData[period].labels;
            lineChart.data.datasets[0].data = allChartData[period].values;
            lineChart.update();
        }

        // Doughnut Chart — label & data dari settings (dinamis)
        const inputOptions  = @json($inputOptions);
        const doughnutData  = @json($inputOptions->mapWithKeys(fn($opt) => [$opt => $totals[$opt] ?? 0])->values());
        const doughnutColors = ['#10b981','#ef4444','#3b82f6','#f59e0b'];

        new Chart(document.getElementById('doughnutChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: inputOptions.map(o => o.charAt(0).toUpperCase() + o.slice(1)),
                datasets: [{
                    data: doughnutData,
                    backgroundColor: doughnutColors.slice(0, inputOptions.length),
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
                        labels: { color: '#94a3b8', font: { size: 10, weight: 'bold' }, padding: 20, usePointStyle: true }
                    }
                }
            }
        });
    </script>
@endsection