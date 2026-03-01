@extends('layouts.app')

@section('title', 'Jadwal')

@section('content')
    <div x-data="{
        selectedJadwal: {
            nama: '{{ $activeJadwal->acara ?? 'Tidak ada jadwal' }}',
            tempat: '{{ $activeJadwal->tempat ?? '-' }}',
            mc: '{{ $activeJadwal->mc ?? '-' }}',
            pf: '{{ $activeJadwal->pf ?? '-' }}'
        }
    }">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-900 text-white">Manajemen Jadwal Ibadah</h1>
                <p class="text-gray-400 text-sm mt-1">Kelola jadwal kegiatan dan ibadah</p>
            </div>
            <div class="flex gap-2">
                <button class="btn-secondary" onclick="exportJadwal()">
                    <i class="fas fa-file-export mr-1"></i> Export
                </button>
                <button class="font-500 px-2 bg-green-500/20 border border-green-500/40 rounded-xl" onclick="kirimWhatsApp()">
                    <i class="fab fa-whatsapp mr-1"></i> Kirim WhatsApp
                </button>
                <button class="btn-primary" onclick="tambahJadwal()">
                    <i class="fas fa-plus mr-1"></i> Tambah Jadwal
                </button>

            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-500/20 border border-green-500/40 rounded-xl text-green-400 text-sm">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="card p-5">
                    <div id="calendar"></div>
                </div>
            </div>

            <div class="flex flex-col gap-4">
                <div class="card p-5" id="formTambahJadwal" style="display: none;">
                    <div class="section-header mb-4 flex justify-between items-center">
                        <h3 class="font-700 text-white text-sm"><i class="fas fa-plus mr-2 text-blue-500"></i>Tambah Jadwal
                        </h3>
                        <button type="button" onclick="toggleFormJadwal(false)" class="text-gray-500 hover:text-white"><i
                                class="fas fa-times"></i></button>
                    </div>

                    <form action="{{ route('jadwal.store') }}" method="POST">
                        @csrf
                        <div class="space-y-3">
                            <div>
                                <label class="text-xs text-gray-400 mb-1 block">Nama Acara</label>
                                <input type="text" name="title" placeholder="Contoh: Ibadah Raya"
                                    class="form-input text-sm" oninput="this.value = this.value.toUpperCase()" required>
                            </div>
                            <div class="grid
                                    grid-cols-2 gap-2">
                                <div>
                                    <label class="text-xs text-gray-400 mb-1 block">Tanggal</label>
                                    <input type="date" name="tanggal" class="form-input text-sm" required>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-400 mb-1 block">Tempat</label>
                                    <input type="text" name="tempat" class="form-input text-sm"
                                        oninput="this.value = this.value.toUpperhase()" required>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="text-xs text-gray-400 mb-1 block">Pelayan Firman</label>
                                    <input type="text" name="pf" class="form-input text-sm"
                                        oninput="this.value = this.value.toUpperCase()" required>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-400 mb-1 block">Worship Leader</label>
                                    <input type="text" name="mc" class="form-input text-sm"
                                        oninput="this.value = this.value.toUpperCase()" required>
                                </div>
                            </div>
                            <button type="submit" class="btn-primary w-full justify-center py-2.5 mt-2">
                                <i class="fas fa-save mr-2"></i> Simpan Jadwal
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card p-5 border-l-4 border-amber-500 bg-slate-800/40 shadow-xl">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-amber-500/20 rounded-lg flex items-center justify-center text-amber-500">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-amber-500 font-bold uppercase tracking-wider">Detail Terpilih</p>
                            <h3 class="text-white font-bold text-base leading-tight" x-text="selectedJadwal.nama"></h3>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex flex-col p-2 bg-white/5 rounded-lg">
                            <span class="text-[10px] text-gray-500 font-semibold uppercase">Lokasi</span>
                            <span class="text-white text-sm" x-text="selectedJadwal.tempat"></span>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="p-2 bg-white/5 rounded-lg">
                                <span class="text-[10px] text-gray-500 font-semibold uppercase">MC / WL</span>
                                <span class="text-white text-sm block truncate" x-text="selectedJadwal.mc"></span>
                            </div>
                            <div class="p-2 bg-white/5 rounded-lg">
                                <span class="text-[10px] text-gray-500 font-semibold uppercase">PF</span>
                                <span class="text-white text-sm block truncate" x-text="selectedJadwal.pf"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card p-5 overflow-hidden">
                    <h4 class="font-700 text-white text-sm mb-4 flex items-center">
                        <span class="w-1.5 h-4 bg-blue-500 rounded-full mr-2"></span> Jadwal Mendatang
                    </h4>
                    <div class="space-y-2 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                        @foreach ($allJadwal as $item)
                            @php $dateObj = \Carbon\Carbon::parse($item->tanggal); @endphp
                            <div @click="selectedJadwal = { 
                                nama: '{{ $item->title }}', 
                                tempat: '{{ $item->tempat }}', 
                                mc: '{{ $item->mc }}', 
                                pf: '{{ $item->pf }}' 
                             }"
                                class="flex gap-3 p-3 rounded-xl hover:bg-blue-500/10 cursor-pointer transition-all border border-transparent hover:border-blue-500/20 group">

                                <div
                                    class="flex-shrink-0 w-12 h-12 rounded-xl bg-slate-700/50 border border-white/5 flex flex-col items-center justify-center group-hover:border-blue-500/30">
                                    <span
                                        class="text-[9px] text-gray-400 font-bold uppercase">{{ $dateObj->translatedFormat('M') }}</span>
                                    <span
                                        class="text-sm font-black text-white group-hover:text-blue-400">{{ $dateObj->format('d') }}</span>
                                </div>

                                <div class="flex-1 min-w-0 flex flex-col justify-center">
                                    <p
                                        class="text-sm font-bold text-white group-hover:text-blue-400 transition-colors truncate">
                                        {{ $item->acara }}</p>
                                    <p class="text-[11px] text-gray-500 truncate"><i
                                            class="fas fa-map-marker-alt mr-1"></i>{{ $item->tempat }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        let calendar = null;

        document.addEventListener('DOMContentLoaded', function() {
            initCalendar();
        });

        function initCalendar() {
            const calEl = document.getElementById('calendar');
            if (!calEl) return;

            calendar = new FullCalendar.Calendar(calEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                // MENGAMBIL DATA DARI CONTROLLER
                events: @json($events),

                eventClick: function(info) {
                    // Saat event kalender diklik, update Card Detail (Alpine.js)
                    const props = info.event.extendedProps;
                    const alpineData = document.querySelector('[x-data]').__x.$data;
                    alpineData.selectedJadwal = {
                        nama: info.event.title,
                        tempat: props.tempat,
                        mc: props.mc,
                        pf: props.pf
                    };
                },
                height: 'auto',
                dateClick: function(info) {
                    const dateInput = document.querySelector('input[name="tanggal"]');
                    if (dateInput) {
                        dateInput.value = info.dateStr;
                        toggleFormJadwal(true);
                    }
                }
            });
            calendar.render();
        }

        function toggleFormJadwal(show) {
            const form = document.getElementById('formTambahJadwal');
            if (form) {
                form.style.display = show ? 'block' : 'none';
                if (show) form.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        }

        function tambahJadwal() {
            toggleFormJadwal(true);
        }

        function kirimWhatsApp() {
            // 1. Ambil data dari state Alpine.js
            const alpineData = document.querySelector('[x-data]').__x.$data;
            const jadwal = alpineData.selectedJadwal;

            // 2. Validasi jika data kosong
            if (!jadwal.nama || jadwal.nama === 'Tidak ada jadwal') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Pilih jadwal terlebih dahulu dari kalender atau daftar!',
                });
                return;
            }

            // 3. Format Pesan
            // Gunakan \n untuk baris baru (diencode jadi %0A nantinya)
            const teksPesan =
                `*JADWAL IBADAH / KEGIATAN*%0A` +
                `---------------------------%0A` +
                `*Acara:* ${jadwal.nama}%0A` +
                `*Tempat:* ${jadwal.tempat}%0A` +
                `*MC / WL:* ${jadwal.mc}%0A` +
                `*Pelayan Firman:* ${jadwal.pf}%0A%0A` +
                `Mohon kehadiran dan pelayanannya. Tuhan Yesus memberkati.`;

            // 4. Redirect ke WhatsApp
            // Kosongkan nomor (wa.me/) agar user bisa memilih kontak/grup sendiri di WA
            const url = `https://wa.me/?text=${teksPesan}`;

            window.open(url, '_blank');
        }
    </script>
@endpush
