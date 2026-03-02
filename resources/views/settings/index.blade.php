{{-- resources/views/settings/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Settings')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <div class="flex items-center gap-2 text-xs text-gray-500 mb-2">
                <span>Home</span> <i class="fas fa-chevron-right text-xs"></i> <span class="text-blue-400">Settings</span>
            </div>
            <h1 class="text-2xl font-900 text-white">Konfigurasi Sistem</h1>
            <p class="text-gray-400 text-sm mt-1">Kelola opsi dropdown dan field di semua modul</p>
        </div>
        <button onclick="openModal()" class="btn-primary">
            <i class="fas fa-plus"></i> Tambah Konfigurasi
        </button>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-500/20 border border-green-500/40 rounded-xl text-green-400 text-sm">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 p-4 bg-red-500/20 border border-red-500/40 rounded-xl text-red-400 text-sm">
            <i class="fas fa-times-circle mr-2"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Settings per category --}}
    @forelse ($settings as $category => $group)
        <div class="mb-8">
            <div class="flex items-center gap-2 mb-4">
                <span class="w-2 h-6 bg-blue-500 rounded-full"></span>
                <h2 class="text-lg font-900 text-white uppercase tracking-wide">{{ $category }}</h2>
                <span class="text-xs text-gray-500 bg-navy-800 px-2 py-0.5 rounded-full">{{ $group->count() }} field</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($group as $setting)
                    <div class="card p-5 relative">
                        {{-- Delete setting --}}
                        <form action="{{ route('settings.destroy', $setting->id) }}" method="POST"
                            class="absolute top-3 right-3" onsubmit="return confirm('Hapus konfigurasi ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-gray-600 hover:text-red-400 transition-colors text-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>

                        <div class="mb-3">
                            <span
                                class="text-[10px] font-900 text-blue-400 uppercase tracking-widest">{{ $setting->category }}</span>
                            <h3 class="text-white font-700 text-base mt-0.5">{{ $setting->sub_content }}</h3>
                            <div class="flex gap-2 mt-1.5">
                                <span
                                    class="text-[10px] bg-navy-800 text-gray-400 px-2 py-0.5 rounded">{{ $setting->type_data }}</span>
                                <span
                                    class="text-[10px] bg-navy-800 text-gray-400 px-2 py-0.5 rounded">{{ $setting->keterangan }}</span>
                                @if ($setting->default_value)
                                    <span class="text-[10px] bg-blue-500/10 text-blue-400 px-2 py-0.5 rounded">default:
                                        {{ $setting->default_value }}</span>
                                @endif
                            </div>
                        </div>

                        @if ($setting->type_data === 'enum' && $setting->options->count() > 0)
                            <div class="mb-3">
                                <p class="text-[10px] text-gray-500 uppercase mb-2 font-700">Opsi tersedia:</p>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach ($setting->options->sortBy('urutan') as $opt)
                                        <div
                                            class="flex items-center gap-1 bg-navy-800 border border-navy-600 rounded-lg px-2 py-1">
                                            <span class="text-xs text-gray-300">{{ $opt->option_name }}</span>
                                            <form action="{{ route('settings.option.destroy', $opt->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus opsi ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="text-gray-600 hover:text-red-400 transition-colors ml-1 text-[10px]">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Tambah opsi baru --}}
                            <form action="{{ route('settings.option.add', $setting->id) }}" method="POST"
                                class="flex gap-2 mt-2">
                                @csrf
                                <input type="text" name="option_name" placeholder="Opsi baru..."
                                    class="form-input text-xs flex-1 py-1.5" required>
                                <button type="submit" class="btn-primary py-1.5 px-3 text-xs">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="card p-12 text-center">
            <i class="fas fa-cog text-gray-600 text-4xl mb-4"></i>
            <p class="text-gray-500">Belum ada konfigurasi. Tambah konfigurasi pertama Anda!</p>
        </div>
    @endforelse

    {{-- Modal Tambah Setting --}}
    <div id="modalTambah" class="fixed inset-0 z-50 hidden">
        <div class="fixed inset-0 bg-black/80 backdrop-blur-sm" onclick="closeModal()"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4 pointer-events-none">
            <div class="bg-navy-900 border border-navy-700 rounded-2xl w-full max-w-lg shadow-2xl p-6 pointer-events-auto">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-900 text-white">Tambah Konfigurasi</h2>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-white text-2xl">&times;</button>
                </div>
                <form action="{{ route('settings.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-xs font-700 text-gray-400 uppercase mb-1 block">Modul / Category</label>
                                <select name="category" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach (['anggota', 'keuangan', 'lagu', 'jadwal', 'arsip'] as $cat)
                                        <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-xs font-700 text-gray-400 uppercase mb-1 block">Nama Field</label>
                                <input type="text" name="sub_content" class="form-input" placeholder="gender, jabatan..."
                                    required>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-xs font-700 text-gray-400 uppercase mb-1 block">Tipe Data</label>
                                <select name="type_data" class="form-select" id="typeDataSelect" required>
                                    <option value="string">string</option>
                                    <option value="text">text</option>
                                    <option value="enum">enum (dropdown)</option>
                                    <option value="integer">integer</option>
                                    <option value="date">date</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-xs font-700 text-gray-400 uppercase mb-1 block">Keterangan</label>
                                <select name="keterangan" class="form-select" required>
                                    <option value="required">required</option>
                                    <option value="nullable">nullable</option>
                                    <option value="unique">unique</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="text-xs font-700 text-gray-400 uppercase mb-1 block">Default Value
                                (opsional)</label>
                            <input type="text" name="default_value" class="form-input" placeholder="Nilai default...">
                        </div>

                        {{-- Opsi enum (tampil hanya jika type = enum) --}}
                        <div id="optionsContainer" class="hidden">
                            <label class="text-xs font-700 text-gray-400 uppercase mb-2 block">Opsi Pilihan</label>
                            <div id="optionsList" class="space-y-2">
                                <div class="flex gap-2">
                                    <input type="text" name="options[]" class="form-input text-sm flex-1"
                                        placeholder="Opsi 1...">
                                    <button type="button" onclick="removeOption(this)"
                                        class="text-gray-600 hover:text-red-400 px-2"><i
                                            class="fas fa-times"></i></button>
                                </div>
                            </div>
                            <button type="button" onclick="addOption()"
                                class="mt-2 text-xs text-blue-400 hover:text-blue-300 flex items-center gap-1">
                                <i class="fas fa-plus"></i> Tambah Opsi
                            </button>
                        </div>

                        <div class="flex gap-3 pt-2">
                            <button type="submit" class="btn-primary flex-1 justify-center py-3">Simpan</button>
                            <button type="button" onclick="closeModal()" class="btn-secondary px-6">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openModal() {
            document.getElementById('modalTambah').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modalTambah').classList.add('hidden');
        }

        document.getElementById('typeDataSelect').addEventListener('change', function() {
            document.getElementById('optionsContainer').classList.toggle('hidden', this.value !== 'enum');
        });

        function addOption() {
            const list = document.getElementById('optionsList');
            const div = document.createElement('div');
            div.className = 'flex gap-2';
            div.innerHTML =
                `<input type="text" name="options[]" class="form-input text-sm flex-1" placeholder="Opsi...">
                         <button type="button" onclick="removeOption(this)" class="text-gray-600 hover:text-red-400 px-2"><i class="fas fa-times"></i></button>`;
            list.appendChild(div);
        }

        function removeOption(btn) {
            const parent = btn.closest('.flex');
            if (document.querySelectorAll('#optionsList .flex').length > 1) parent.remove();
        }
    </script>
@endpush
