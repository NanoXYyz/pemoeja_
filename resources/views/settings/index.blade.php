@extends('layouts.app')

@section('title', 'Settings')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <div x-data="{
        activeTab: 'ANGGOTA',
        showForm: false,
        typeData: 'string',
        // Perbaikan utama: Menggunakan array of objects untuk stabilitas input
        options: [{ id: Date.now(), value: '' }],
    
        addOption() {
            this.options.push({ id: Date.now(), value: '' });
        },
        removeOption(index) {
            if (this.options.length > 1) this.options.splice(index, 1);
        }
    }" class="min-h-screen bg-[#050b1a] p-6 md:p-12 text-slate-200">

        <div class="fixed inset-0 overflow-hidden -z-10 pointer-events-none">
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-600/10 blur-[120px] rounded-full"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-cyan-600/10 blur-[120px] rounded-full"></div>
        </div>

        <header
            class="mb-12 flex flex-col md:flex-row justify-between items-center gap-6 animate__animated animate__fadeInDown">
            <div>
                <h1 class="text-6xl font-black tracking-tighter text-white">
                    Core <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">Settings</span>
                </h1>
                <p class="text-slate-400 mt-2 font-medium italic">Konfigurasi arsitektur data dinamis.</p>
            </div>

            <button @click="showForm = !showForm"
                :class="showForm ? 'bg-red-500/10 text-red-400 border-red-500/50' :
                    'bg-blue-600 text-white shadow-[0_0_20px_rgba(37,99,235,0.3)]'"
                class="flex items-center gap-3 px-8 py-4 rounded-2xl border border-transparent font-bold transition-all hover:scale-105 active:scale-95 shadow-xl">
                <i class="fas transition-transform duration-500" :class="showForm ? 'fa-times rotate-90' : 'fa-plus'"></i>
                <span x-text="showForm ? 'Batalkan' : 'Buat Variabel Baru'"></span>
            </button>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <aside class="lg:col-span-3 space-y-2 animate__animated animate__fadeInLeft">
                @foreach (['ANGGOTA', 'KEUANGAN', 'LAGU', 'JADWAL', 'ARSIP', 'ROLE'] as $menu)
                    <button @click="activeTab = '{{ $menu }}'; showForm = false"
                        :class="activeTab === '{{ $menu }}' ?
                            'bg-gradient-to-r from-blue-600/20 to-transparent border-l-4 border-blue-500 text-blue-400 pl-8' :
                            'text-slate-500 hover:text-slate-300 border-l-4 border-transparent hover:pl-6'"
                        class="w-full py-4 px-4 text-sm font-black transition-all text-left tracking-[0.2em] uppercase">
                        {{ $menu }}
                    </button>
                @endforeach
            </aside>

            <main class="lg:col-span-9">

                <div x-show="showForm" x-transition:enter="animate__animated animate__zoomIn animate__faster"
                    x-transition:leave="animate__animated animate__zoomOut animate__faster"
                    class="bg-[#0f172a]/80 backdrop-blur-xl rounded-[40px] p-8 md:p-12 border border-white/10 mb-12 shadow-2xl relative overflow-hidden"
                    x-cloak>

                    <form action="{{ route('settings.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <div class="space-y-3">
                                <label class="text-xs font-black text-blue-400 uppercase tracking-widest">Kategori
                                    Tujuan</label>
                                <select name="category" x-model="activeTab.toLowerCase()"
                                    class="w-full bg-white/5 p-5 rounded-2xl border border-white/10 text-white focus:ring-2 ring-blue-500 outline-none transition-all appearance-none cursor-pointer">
                                    <option value="anggota">ANGGOTA</option>
                                    <option value="keuangan">KEUANGAN</option>
                                    <option value="lagu">LAGU</option>
                                    <option value="jadwal">JADWAL</option>
                                    <option value="arsip">ARSIP</option>
                                    <option value="role">ROLE</option>
                                </select>
                            </div>
                            <div class="space-y-3">
                                <label class="text-xs font-black text-blue-400 uppercase tracking-widest">Field ID
                                    (Slug)</label>
                                <input type="text" name="sub_content" placeholder="contoh: jenis_tabungan" required
                                    class="w-full bg-white/5 p-5 rounded-2xl border border-white/10 text-white focus:ring-2 ring-blue-500 outline-none placeholder:opacity-20">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                            <div class="space-y-3">
                                <label class="text-xs font-black text-cyan-400 uppercase tracking-widest">Tipe Input
                                    Data</label>
                                <select name="type_data" x-model="typeData"
                                    class="w-full bg-white/5 p-4 rounded-2xl border border-white/10 text-white outline-none focus:border-cyan-500 transition-colors">
                                    <option value="string">Teks Pendek (String)</option>
                                    <option value="text">Teks Panjang (Textarea)</option>
                                    <option value="enum">Pilihan Terbatas (Dropdown)</option>
                                    <option value="integer">Hanya Angka (Number)</option>
                                </select>
                            </div>
                            <div class="space-y-3">
                                <label class="text-xs font-black text-cyan-400 uppercase tracking-widest">Validasi
                                    Backend</label>
                                <select name="keterangan"
                                    class="w-full bg-white/5 p-4 rounded-2xl border border-white/10 text-white outline-none">
                                    <option value="nullable">Boleh Kosong</option>
                                    <option value="required">Wajib Diisi</option>
                                    <option value="unique">Nilai Harus Unik</option>
                                </select>
                            </div>
                        </div>

                        <div x-show="typeData === 'enum'"
                            x-transition:enter="animate__animated animate__fadeInUp animate__faster"
                            class="p-8 bg-black/30 rounded-[30px] border border-white/5 space-y-6" x-cloak>

                            <div class="flex justify-between items-center border-b border-white/5 pb-4">
                                <h3 class="text-sm font-bold text-slate-400 tracking-tight">Manajemen Daftar Opsi</h3>
                                <button type="button" @click="addOption()"
                                    class="bg-cyan-500/20 text-cyan-400 text-xs px-5 py-2 rounded-full hover:bg-cyan-500 hover:text-white transition-all font-black uppercase">
                                    + Tambah List
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <template x-for="(opt, index) in options" :key="opt.id">
                                    <div class="flex gap-3 group animate__animated animate__fadeInUp animate__faster">
                                        <div class="flex-grow relative">
                                            <input type="text" name="options[]" x-model="opt.value"
                                                :placeholder="'Opsi ke-' + (index + 1)"
                                                class="w-full bg-[#050b1a] p-4 rounded-xl border border-white/10 text-white focus:border-cyan-500 outline-none transition-all pr-10">
                                            <span
                                                class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-600"
                                                x-text="index + 1"></span>
                                        </div>
                                        <button type="button" @click="removeOption(index)"
                                            class="w-12 h-12 flex items-center justify-center rounded-xl bg-red-500/10 text-red-500/40 hover:text-red-500 hover:bg-red-500/20 transition-all">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <button type="submit"
                            class="mt-10 w-full py-5 bg-gradient-to-r from-blue-600 to-cyan-500 rounded-2xl font-black text-xl shadow-[0_10px_40px_rgba(37,99,235,0.3)] hover:shadow-blue-500/50 transition-all active:scale-[0.97]">
                            DEPLOY KONFIGURASI
                        </button>
                    </form>
                </div>

                <div class="space-y-6">
                    @foreach (['ANGGOTA', 'KEUANGAN', 'LAGU', 'JADWAL', 'ARSIP', 'ROLE'] as $m)
                        <div x-show="activeTab === '{{ $m }}'" class="animate__animated animate__fadeIn">
                            @php $filtered = $settings->where('category', strtolower($m)); @endphp

                            @forelse($filtered as $s)
                                <div
                                    class="group bg-[#0f172a]/40 border border-white/5 rounded-[35px] p-8 hover:bg-[#0f172a]/70 hover:border-blue-500/40 transition-all duration-500 relative overflow-hidden">
                                    <div
                                        class="absolute -right-10 -top-10 w-32 h-32 bg-blue-500/5 blur-3xl group-hover:bg-blue-500/10 transition-all">
                                    </div>

                                    <div
                                        class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative z-10">
                                        <div class="flex items-center gap-6">
                                            <div
                                                class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500/20 to-cyan-500/20 flex items-center justify-center text-blue-400 border border-white/10 shadow-inner">
                                                <i class="fas fa-database text-xl"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-black text-white text-2xl tracking-tight uppercase">
                                                    {{ str_replace('_', ' ', $s->sub_content) }}</h4>
                                                <div class="flex gap-3 mt-2">
                                                    <span
                                                        class="text-[10px] bg-blue-500/10 text-blue-400 border border-blue-500/20 px-3 py-1 rounded-lg font-black tracking-widest uppercase">{{ $s->type_data }}</span>
                                                    <span
                                                        class="text-[10px] bg-slate-800 text-slate-400 px-3 py-1 rounded-lg font-black tracking-widest uppercase">{{ $s->keterangan }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <form action="{{ route('settings.destroy', $s->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Hapus konfigurasi variabel ini secara permanen?')"
                                                class="w-12 h-12 rounded-2xl flex items-center justify-center text-slate-600 bg-white/5 hover:bg-red-500 hover:text-white transition-all group/del shadow-lg">
                                                <i class="fas fa-trash-alt group-hover/del:animate-bounce"></i>
                                            </button>
                                        </form>
                                    </div>

                                    @if ($s->options->count() > 0)
                                        <div
                                            class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-3 mt-8 relative z-10">
                                            @foreach ($s->options as $o)
                                                <div
                                                    class="text-xs bg-white/5 border border-white/5 px-4 py-3 rounded-xl text-slate-400 font-bold hover:text-cyan-400 hover:border-cyan-500/30 transition-all flex items-center gap-2">
                                                    <div class="w-1 h-1 bg-current rounded-full"></div>
                                                    {{ $o->option_name }}
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div
                                    class="py-32 text-center border-2 border-dashed border-white/5 rounded-[50px] animate__animated animate__pulse animate__infinite">
                                    <i class="fas fa-folder-open text-slate-700 text-5xl mb-4"></i>
                                    <p class="text-slate-600 font-black uppercase tracking-[0.4em]">Database Kosong</p>
                                </div>
                            @endforelse
                        </div>
                    @endforeach
                </div>
            </main>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            background-color: #050b1a;
        }

        /* Desain Dropdown Select Custom */
        select option {
            background-color: #0f172a;
            color: white;
            padding: 20px;
        }

        /* Scrollbar Modern */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #334155;
        }
    </style>
@endsection
