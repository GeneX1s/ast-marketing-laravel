@extends('layouts.app')

@section('title', 'Kampanye')

@section('content')
<div class="mb-8 flex justify-between items-start" x-data="{ showModal: false }">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Kampanye</h1>
        <p class="text-gray-500 mt-1">Kelola dan pantau kampanye marketing Anda.</p>
    </div>
    
    @if(auth()->user()->hasPermission('kampanye') && in_array('create', auth()->user()->getPermissionPages()))
    <button @click="showModal = true" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
        Buat Kampanye
    </button>
    @endif

    <!-- Create Modal -->
    <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display: none;">
        <div @click.outside="showModal = false" class="bg-white rounded-2xl w-full max-w-lg p-6 shadow-xl">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Buat Kampanye Baru</h3>
            <form action="{{ route('kampanye.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kampanye</label>
                        <input type="text" name="name" required class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Channel (WA/Email/IG)</label>
                            <input type="text" name="channel" required class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis (Foto/Video)</label>
                            <input type="text" name="type" required class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">PIC (Penanggung Jawab)</label>
                        <select name="pic_id" required class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jadwal Tayang</label>
                        <input type="datetime-local" name="schedule" required class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Link Konten (Google Drive/Canva)</label>
                        <input type="url" name="content_url" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                        <textarea name="notes" rows="2" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm"></textarea>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="showModal = false" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 font-medium">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-gray-50 border-b border-gray-200 text-gray-600 font-medium">
                <tr>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Nama Kampanye</th>
                    <th class="px-6 py-4">Channel & Jenis</th>
                    <th class="px-6 py-4">PIC</th>
                    <th class="px-6 py-4">Jadwal</th>
                    <th class="px-6 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($kampanyes as $k)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        @php
                            $colors = [
                                'Terjadwal' => 'bg-yellow-100 text-yellow-800',
                                'Selesai' => 'bg-green-100 text-green-800',
                                'Batal' => 'bg-red-100 text-red-800',
                            ];
                            $colorClass = $colors[$k->status] ?? 'bg-blue-100 text-blue-800';
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $colorClass }}">
                            {{ ucfirst($k->status ?? 'Active') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $k->name }}</td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $k->channel }} <span class="text-gray-400 mx-1">•</span> {{ $k->type }}
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $k->pic?->name ?? 'Belum ada PIC' }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $k->schedule->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            @if($k->content_url)
                            <a href="{{ $k->content_url }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-xs font-medium bg-blue-50 px-2 py-1 rounded">Lihat Konten</a>
                            @endif
                            <form action="{{ route('kampanye.destroy', $k) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-medium bg-red-50 px-2 py-1 rounded">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">Belum ada data kampanye.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
