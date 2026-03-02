{{-- resources/views/lagu/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Lirik Lagu')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <div class="flex items-center gap-2 text-xs text-gray-500 mb-2">
                <span>Home</span> <i class="fas fa-chevron-right text-xs"></i> <span class="text-blue-400">Lagu / Lirik</span>
            </div>
            <h1 class="text-2xl font-900 text-white">Lirik & Chord Lagu</h1>
            <p class="text-gray-400 text-sm mt-1">Koleksi lagu pujian dan penyembahan</p>
        </div>
        <button onclick="openModal()" class="btn-primary">
            <i class="fas fa-plus"></i> Tambah Lagu
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Sidebar daftar lagu --}}
        <div class="card overflow-hidden">
            <div class="p-4 border-b border-navy-700">
                <div class="relative">
                    <input type="text" class="form-input pl-9 text-sm" id="searchLagu" placeholder="Cari judul lagu...">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-500 text-sm"></i>
                </div>
            </div>
            <div class="divide-y divide-navy-700 max-h-[600px] overflow-y-auto" id="songList">
                @foreach ($lagus as $index => $lagu)
                    <div class="song-item p-4 cursor-pointer transition-colors hover:bg-navy-800"
                        onclick="selectSong({{ $index }})" data-id="{{ $lagu->id }}">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-9 h-9 rounded-lg bg-navy-700 flex items-center justify-center text-xs font-900 text-gray-300">
                                {{ $loop->iteration }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-700 text-white truncate">{{ $lagu->title }}</p>
                                <span class="text-xs text-gray-500">Key: {{ $lagu->key }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="p-3 border-t border-navy-700">
                <p class="text-xs text-gray-500 text-center">Ditemukan {{ count($lagus) }} lagu</p>
            </div>
        </div>

        {{-- Area lirik --}}
        <div class="lg:col-span-2 card overflow-hidden">
            <div class="p-6 border-b border-navy-700">
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <h2 class="text-xl font-900 text-white" id="songTitle">Pilih Lagu</h2>
                        <div class="flex items-center gap-3 mt-1.5">
                            <span class="badge badge-blue" id="songKey">-</span>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button class="btn-secondary py-2 px-3 text-xs" onclick="window.print()">
                            <i class="fas fa-print"></i>
                        </button>
                    </div>
                </div>

                {{-- Transpose controls — key options dari settings --}}
                <div class="flex items-center gap-3 mt-3">
                    <span class="text-xs text-gray-500 uppercase tracking-wider font-600">Original</span>
                    <span class="badge badge-blue font-mono font-700" id="originalKey">-</span>
                    <div class="flex items-center gap-1 ml-2">
                        <button onclick="transpose(-1)"
                            class="w-8 h-8 rounded bg-navy-700 border border-navy-600 text-white hover:border-blue-500 transition-all font-700">−</button>
                        <select id="currentKey" class="form-select py-1 px-2 text-xs w-20" onchange="setKey(this.value)">
                            {{-- Diisi dari settings, bukan hardcode --}}
                            @foreach ($keyOptions as $k)
                                <option value="{{ $k }}">{{ $k }}</option>
                            @endforeach
                        </select>
                        <button onclick="transpose(1)"
                            class="w-8 h-8 rounded bg-navy-700 border border-navy-600 text-white hover:border-blue-500 transition-all font-700">+</button>
                        <button onclick="resetKey()" class="btn-secondary py-1 px-3 text-xs ml-1">Reset</button>
                    </div>
                </div>
            </div>

            <div class="p-6 overflow-y-auto" style="max-height: 600px" id="lyricsDisplay">
                <div class="text-gray-500 italic text-center py-20">Silahkan pilih lagu dari daftar di samping</div>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Lagu --}}
    <div id="modalTambah" class="fixed inset-0 z-50 hidden">
        <div class="fixed inset-0 bg-black/80 backdrop-blur-sm" onclick="closeModal()"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4 pointer-events-none">
            <div class="bg-navy-900 border border-navy-700 rounded-2xl w-full max-w-3xl shadow-2xl p-6 pointer-events-auto">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-900 text-white">Tambah Lagu Baru</h2>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-white text-2xl">&times;</button>
                </div>
                <form action="{{ route('lagu.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="text-xs font-700 text-gray-400 uppercase mb-1 block">Judul Lagu</label>
                            <input type="text" name="title" oninput="this.value=this.value.toUpperCase()"
                                class="form-input" required placeholder="Judul...">
                        </div>
                        <div>
                            <label class="text-xs font-700 text-gray-400 uppercase mb-1 block">Kunci Dasar</label>
                            {{-- Key dari settings, bukan hardcode --}}
                            <select name="key" class="form-select">
                                @foreach ($keyOptions as $k)
                                    <option value="{{ $k }}">{{ $k }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="text-xs font-700 text-gray-400 uppercase mb-1 block">Lirik & Chord (Verse)</label>
                        <textarea name="lirik" rows="6" class="form-textarea font-mono text-sm" placeholder="Chord di atas lirik..."
                            required></textarea>
                    </div>
                    <div class="mb-6">
                        <label class="text-xs font-700 text-blue-400 uppercase mb-1 block">Chorus / Reff</label>
                        <textarea name="reff" rows="4" class="form-textarea font-mono text-sm bg-blue-500/5"
                            placeholder="Chord di atas lirik reff..."></textarea>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="btn-primary flex-1 justify-center py-3">Simpan Lagu</button>
                        <button type="button" onclick="closeModal()" class="btn-secondary px-6">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const songData = @json($lagus);
        // Key notes diambil dari settings via PHP, bukan hardcode di JS
        const NOTES = @json($keyOptions);
        const NOTES_FLAT = ['C', 'Db', 'D', 'Eb', 'E', 'F', 'Gb', 'G', 'Ab', 'A', 'Bb', 'B'];

        let currentSemitone = 0;
        let originalSemitone = 0;

        function transposeChordText(text, semitones) {
            return text.replace(/\b([A-G](?:#|b)?(?:m|maj|min|dim|aug|sus|add)?(?:\d+)?(?:\/[A-G](?:#|b)?)?)\b/g, function(
                match) {
                const rootMatch = match.match(/^([A-G](?:#|b)?)/);
                if (!rootMatch) return match;
                const root = rootMatch[1];
                const rest = match.slice(root.length);
                let idx = NOTES.indexOf(root);
                if (idx === -1) idx = NOTES_FLAT.indexOf(root);
                if (idx === -1) return match;
                const newIdx = ((idx + semitones) % 12 + 12) % 12;
                return NOTES[newIdx] + rest;
            });
        }

        function selectSong(idx) {
            const song = songData[idx];
            if (!song) return;
            document.getElementById('songTitle').innerText = song.title;
            document.getElementById('originalKey').innerText = song.key;
            document.getElementById('songKey').innerText = song.key;
            originalSemitone = NOTES.indexOf(song.key);
            if (originalSemitone === -1) originalSemitone = NOTES_FLAT.indexOf(song.key);
            currentSemitone = originalSemitone;
            document.getElementById('currentKey').value = song.key;
            const lyricsArea = document.getElementById('lyricsDisplay');
            lyricsArea.innerHTML = `
            <div class="mb-8">
                <pre class="chord-render font-mono text-gray-300 leading-relaxed whitespace-pre-wrap outline-none" data-original="${song.lirik}">${song.lirik}</pre>
            </div>
            ${song.reff ? `
                <div class="mb-6 bg-blue-500/5 rounded-2xl p-6 border border-blue-500/10 shadow-inner">
                    <span class="text-[10px] font-900 text-blue-400 tracking-[0.2em] uppercase block mb-4">Chorus</span>
                    <pre class="chord-render font-mono text-white font-600 leading-relaxed whitespace-pre-wrap outline-none" data-original="${song.reff}">${song.reff}</pre>
                </div>` : ''}
        `;
            updateActiveState(idx);
        }

        function updateChords() {
            const diff = currentSemitone - originalSemitone;
            document.querySelectorAll('.chord-render').forEach(el => {
                el.textContent = transposeChordText(el.getAttribute('data-original'), diff);
            });
        }

        function transpose(n) {
            currentSemitone = ((currentSemitone + n) % 12 + 12) % 12;
            document.getElementById('currentKey').value = NOTES[currentSemitone];
            updateChords();
        }

        function setKey(val) {
            currentSemitone = NOTES.indexOf(val);
            if (currentSemitone === -1) currentSemitone = NOTES_FLAT.indexOf(val);
            updateChords();
        }

        function resetKey() {
            currentSemitone = originalSemitone;
            document.getElementById('currentKey').value = NOTES[originalSemitone] ?? NOTES[0];
            updateChords();
        }

        function updateActiveState(idx) {
            document.querySelectorAll('.song-item').forEach((item, i) => {
                item.classList.toggle('bg-blue-500/10', i === idx);
                item.classList.toggle('border-l-4', i === idx);
                item.classList.toggle('border-blue-500', i === idx);
            });
        }

        function openModal() {
            document.getElementById('modalTambah').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modalTambah').classList.add('hidden');
        }

        document.getElementById('searchLagu').addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            document.querySelectorAll('.song-item').forEach((item, i) => {
                item.style.display = songData[i].title.toLowerCase().includes(term) ? 'block' : 'none';
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            if (songData.length > 0) selectSong(0);
        });
    </script>
@endpush
