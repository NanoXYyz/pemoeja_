<div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-xl mb-8">
    <div class="p-6 border-b border-slate-800 flex justify-between items-center">
        <h3 class="font-bold text-white flex items-center gap-2">
            <i class="fas fa-users text-blue-500"></i> Daftar Anggota Aktif
        </h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-800/50 text-slate-400 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4 font-bold">No</th>
                    <th class="px-6 py-4 font-bold">Nama</th>
                    <th class="px-6 py-4 font-bold">Gender</th>
                    <th class="px-6 py-4 font-bold">Status</th>
                    <th class="px-6 py-4 font-bold">Jabatan</th>
                    <th class="px-6 py-4 font-bold text-center">Opsi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800 text-slate-300">
                @foreach ($anggota as $index => $item)
                    <tr class="hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-4 text-sm">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-semibold text-white">{{ $item->nama }}</td>
                        <td class="px-6 py-4"><span
                                class="px-3 py-1 bg-slate-800 rounded-full text-xs">{{ $item->gender }}</span></td>
                        <td class="px-6 py-4 text-sm">{{ $item->status }}</td>
                        <td class="px-6 py-4 text-sm text-blue-400 font-medium">{{ $item->jabatan }}</td>
                        <td class="px-6 py-4">
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
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
