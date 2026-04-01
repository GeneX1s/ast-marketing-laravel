@extends('layouts.app')

@section('title', 'Kampanye Marketing')

@section('content')
<div x-data="{ showModal: false, showEditModal: false, showDeleteModal: false, editData: {}, editTanggal: '', editWaktu: '', deleteData: {} }">

    <!-- Header & Button -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kampanye Marketing</h1>
            <p class="text-gray-500 mt-1 text-sm">Kelola konten marketing di berbagai channel</p>
        </div>
        
        <button @click="showModal = true" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-colors flex items-center gap-2">
            + Buat Kampanye
        </button>
    </div>

    <!-- Toolbar -->
    <div class="flex flex-row gap-4 mb-6 items-center w-full">
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                 <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" placeholder="Cari kampanye..." class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none">
        </div>
        <div class="relative w-56 shrink-0">
            <select class="w-full appearance-none bg-white border border-gray-300 rounded-lg pl-4 pr-10 py-2.5 text-sm text-gray-700 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none cursor-pointer">
                <option>Semua Channel</option>
                <option>Instagram</option>
                <option>Email</option>
                <option>WhatsApp</option>
            </select>
            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50 border-b border-gray-200 text-gray-900 font-bold text-xs">
                    <tr>
                        <th class="px-6 py-4">Nama Kampanye</th>
                        <th class="px-6 py-4">Channel</th>
                        <th class="px-6 py-4">Tipe Konten</th>
                        <th class="px-6 py-4">Jadwal</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">PIC</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white text-sm">
                    @forelse($kampanyes as $k)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-bold text-gray-900">{{ $k->name }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border border-gray-200 bg-white text-gray-700">
                                {{ $k->channel }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $k->type }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $k->schedule->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusStr = strtolower($k->status ?? 'active');
                                $statusClass = 'bg-gray-100 text-gray-600';
                                if($statusStr == 'terjadwal') $statusClass = 'bg-blue-50 text-blue-600';
                                elseif($statusStr == 'active') $statusClass = 'bg-gray-100 text-gray-600';
                                elseif($statusStr == 'draft') $statusClass = 'bg-gray-100 text-gray-600';
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                                {{ $k->status ?? 'active' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $k->pic?->name ?? 'Staff Sales' }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" @click="editData = {{ json_encode($k) }}; editTanggal = '{{ $k->schedule->format('Y-m-d') }}'; editWaktu = '{{ $k->schedule->format('H:i') }}'; showEditModal = true" class="p-1 text-green-600 hover:bg-green-50 rounded transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button type="button" @click="deleteData = {{ json_encode($k) }}; showDeleteModal = true" class="p-1 text-red-500 hover:bg-red-50 rounded transition-colors" title="Hapus">
                                    <svg class="w-4 h-4 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-sm text-gray-500 border-t border-gray-100">
                            Masih belum ada data Kampanye.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Pagination -->
    @if($kampanyes->hasPages())
    <div>
        {{ $kampanyes->links() }}
    </div>
    @endif

    <!-- Create Modal -->
    <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm" style="display: none;" x-transition>
        <div @click.outside="showModal = false" class="bg-white rounded-xl w-full max-w-lg p-6 shadow-2xl relative">
            <button @click="showModal = false" class="absolute top-6 right-6 text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <h3 class="text-lg font-bold text-gray-900 mb-6">Buat Kampanye Baru</h3>
            
            <form action="{{ route('kampanye.store') }}" method="POST" x-data="{ tanggal: '', waktu: '' }">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kampanye</label>
                        <input type="text" name="name" required placeholder="Masukkan nama kampanye" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Channel</label>
                            <select name="channel" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none bg-white">
                                <option>Instagram</option>
                                <option>Email</option>
                                <option>WhatsApp</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Konten</label>
                            <select name="type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none bg-white">
                                <option>Foto</option>
                                <option>Video</option>
                                <option>Web</option>
                                <option>Artikel</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Link Konten</label>
                        <input type="url" name="content_url" placeholder="https://drive.google.com/..." class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                            <div class="relative">
                                <input type="hidden" name="schedule" :value="tanggal && waktu ? tanggal + ' ' + waktu : ''">
                                <input type="date" x-model="tanggal" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Waktu</label>
                            <div class="relative">
                                <input type="time" x-model="waktu" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">PIC</label>
                        <select name="pic_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none bg-white">
                            <option value="">Pilih PIC</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                        <textarea name="notes" rows="2" placeholder="Tambahkan catatan jika ada..." class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none resize-none"></textarea>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-4">
                    <button type="button" @click="showModal = false" class="w-full py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 text-sm">Batal</button>
                    <button type="submit" class="w-full py-2 bg-blue-600 rounded-lg text-white font-medium hover:bg-blue-700 text-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm" style="display: none;" x-transition>
        <div @click.outside="showEditModal = false" class="bg-white rounded-xl w-full max-w-lg p-6 shadow-2xl relative">
            <button @click="showEditModal = false" class="absolute top-6 right-6 text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <h3 class="text-lg font-bold text-gray-900 mb-6">Edit Kampanye</h3>
            
            <form :action="'/kampanye/' + editData.id" method="POST">
                @csrf @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kampanye</label>
                        <input type="text" name="name" :value="editData.name" required placeholder="Masukkan nama kampanye" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Channel</label>
                            <select name="channel" :value="editData.channel" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none bg-white">
                                <option>Instagram</option>
                                <option>Email</option>
                                <option>WhatsApp</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Konten</label>
                            <select name="type" :value="editData.type" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none bg-white">
                                <option>Foto</option>
                                <option>Video</option>
                                <option>Web</option>
                                <option>Artikel</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Link Konten</label>
                        <input type="url" name="content_url" :value="editData.content_url" placeholder="https://drive.google.com/..." class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                            <div class="relative">
                                <input type="hidden" name="schedule" :value="editTanggal && editWaktu ? editTanggal + ' ' + editWaktu : ''">
                                <input type="date" x-model="editTanggal" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Waktu</label>
                            <div class="relative">
                                <input type="time" x-model="editWaktu" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">PIC</label>
                            <select name="pic_id" :value="editData.pic_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none bg-white">
                                <option value="">Pilih PIC</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" :value="editData.status" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none bg-white">
                                <option value="Terjadwal">Terjadwal</option>
                                <option value="active">Active</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                        <textarea name="notes" :value="editData.notes" rows="2" placeholder="Tambahkan catatan jika ada..." class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm outline-none resize-none"></textarea>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-4">
                    <button type="button" @click="showEditModal = false" class="w-full py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 text-sm">Batal</button>
                    <button type="submit" class="w-full py-2 bg-blue-600 rounded-lg text-white font-medium hover:bg-blue-700 text-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div x-show="showDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm" style="display: none;" x-transition>
       <div @click.outside="showDeleteModal = false" class="bg-white rounded-xl w-full max-w-lg p-6 relative shadow-2xl">
          <div class="flex justify-between items-center mb-6">
              <h3 class="text-lg font-bold text-gray-900">Hapus Kampanye</h3>
              <button @click="showDeleteModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
              </button>
          </div>
          <div class="bg-red-50 text-red-600 px-4 py-3 rounded-lg flex items-start gap-3 mb-6">
              <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
              <p class="text-sm">Apakah Anda yakin ingin menghapus kampanye ini? Tindakan ini tidak dapat dibatalkan.</p>
          </div>
          <p class="text-sm text-gray-700 mb-6 font-medium">Menghapus kampanye: <strong class="text-gray-900 font-bold" x-text="deleteData.name"></strong></p>
          
          <form :action="'{{ url('/kampanye') }}/' + deleteData.id" method="POST">
              @csrf @method('DELETE')
              <div class="grid grid-cols-2 gap-4">
                  <button type="button" @click="showDeleteModal = false" class="w-full py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 text-sm">Batal</button>
                  <button type="submit" class="w-full py-2.5 text-white rounded-lg font-medium hover:opacity-90 text-sm transition-opacity" style="background-color: #dc2626;">Hapus</button>
              </div>
          </form>
       </div>
    </div>
</div>
@endsection
