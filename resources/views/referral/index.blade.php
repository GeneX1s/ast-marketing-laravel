@extends('layouts.app')

@section('title', 'Referral')

@section('content')
<div class="mb-8 flex justify-between items-start" x-data="{
        showModal: false,
        showEditModal: false, 
        showDeleteModal: false,
        formItem: { id: null, recruiter_name: '', referral_code: '', commission_type: 'fixed', commission_value: '' },
        deleteData: { id: null, name: '' },
        copyToClipboard(text) {
            navigator.clipboard.writeText(text);
            alert('Kode Referral disalin: ' + text);
        }
    }">
    
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Referral</h1>
        <p class="text-gray-500 mt-1">Kelola kode referral dan komisi</p>
    </div>

    <button @click="showModal = true; formItem = { recruiter_name: '', referral_code: '', commission_type: 'fixed', commission_value: '' }" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2 shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Buat Kode Referral
    </button>
    
    <!-- Modals Overlay -->
    <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" style="display: none;" x-transition>
        <div @click.outside="showModal = false" class="bg-white rounded-xl w-full max-w-lg p-6 shadow-xl relative">
            <button @click="showModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <h3 class="text-xl font-bold text-gray-900 mb-6">Buat Kode Referral Baru</h3>
            
            <form action="{{ route('referral.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-[12px] font-semibold text-gray-700 mb-1 uppercase tracking-wider">Nama Recruiter/Tim</label>
                        <input type="text" name="recruiter_name" x-model="formItem.recruiter_name" placeholder="Nama recruiter atau tim" required class="w-full border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5">
                    </div>
                    
                    <div>
                        <label class="block text-[12px] font-semibold text-gray-700 mb-1 uppercase tracking-wider">Kode Referral</label>
                        <input type="text" name="referral_code" x-model="formItem.referral_code" placeholder="REF-XXXX-2024" required class="w-full border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5">
                    </div>

                    <div>
                        <label class="block text-[12px] font-semibold text-gray-700 mb-1 uppercase tracking-wider">Tipe Komisi</label>
                        <select name="commission_type" x-model="formItem.commission_type" required class="w-full border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5 text-gray-700">
                            <option value="fixed">Nominal Tetap per Signup</option>
                            <option value="percentage">Persentase dari Transaksi</option>
                        </select>
                    </div>

                    <div x-show="formItem.commission_type === 'fixed'">
                        <label class="block text-[12px] font-semibold text-gray-700 mb-1 uppercase tracking-wider">Nominal Komisi (Rp)</label>
                        <input type="number" name="commission_value_fixed" x-model="formItem.commission_value" placeholder="50000" class="w-full border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5">
                    </div>
                    
                    <div x-show="formItem.commission_type === 'percentage'" style="display: none;">
                        <label class="block text-[12px] font-semibold text-gray-700 mb-1 uppercase tracking-wider">Persentase Komisi (%)</label>
                        <input type="number" name="commission_value_percentage" x-model="formItem.commission_value" placeholder="10" min="1" max="100" class="w-full border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm py-2.5">
                    </div>
                </div>
                
                <div class="mt-8 grid grid-cols-2 gap-4">
                    <button type="button" @click="showModal = false" class="w-full py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 text-sm transition-colors">Batal</button>
                    <button type="submit" class="w-full py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 text-sm shadow-sm transition-colors">Buat</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Toolbar & Table Container -->
    <div class="fixed mt-24 right-8 left-64 lg:left-72">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden p-6 relative">
            
            <!-- Toolbar -->
            <div class="flex flex-row gap-4 mb-6 items-center w-full">
                <div class="relative flex-1">
                    <svg class="absolute top-1/2 -translate-y-1/2 left-5 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" placeholder="Cari recruiter atau kode..." class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none">
                </div>
                <div class="relative w-56 shrink-0">
                    <select class="w-full appearance-none bg-white border border-gray-300 rounded-lg pl-4 pr-10 py-2.5 text-sm text-gray-700 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none cursor-pointer">
                        <option>Semua Status</option>
                        <option>Aktif</option>
                        <option>Non-Aktif</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-gray-50/50 border-b border-gray-100 text-gray-500 font-medium">
                        <tr>
                            <th class="px-4 py-3 font-medium">Recruiter/Tim</th>
                            <th class="px-4 py-3 font-medium">Kode Referral</th>
                            <th class="px-4 py-3 font-medium">Skema Komisi</th>
                            <th class="px-4 py-3 font-medium text-center">Total Pendaftar</th>
                            <th class="px-4 py-3 font-medium text-center">Aktif</th>
                            <th class="px-4 py-3 font-medium">Komisi Terhitung</th>
                            <th class="px-4 py-3 font-medium text-center">Status</th>
                            <th class="px-4 py-3 font-medium text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($referrals as $r)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-4 py-4 font-medium text-gray-900">{{ $r->recruiter_name }}</td>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="bg-gray-100 text-gray-700 px-2.5 py-1 rounded text-xs font-mono font-medium">{{ $r->referral_code }}</span>
                                    <button @click="copyToClipboard('{{ $r->referral_code }}')" class="text-gray-400 hover:text-gray-600 transition-colors" title="Copy">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    </button>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-gray-600">{{ $r->commission_value }} {{ $r->commission_type == 'percentage' ? '% dari transaksi' : 'Rp per signup' }}</td>
                            <td class="px-4 py-4 text-gray-900 text-center">{{ $r->participant }}</td>
                            <td class="px-4 py-4 text-green-600 font-medium text-center">{{ $r->active_participant }}</td>
                            <td class="px-4 py-4 font-medium text-gray-900">Rp {{ number_format((float)$r->total_commission, 0, ',', '.') }}</td>
                            <td class="px-4 py-4">
                                <form action="{{ route('referral.updateStatus', $r->id) }}" method="POST" class="flex justify-center items-center m-0 p-0">
                                    @csrf @method('PUT')
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" onchange="this.form.submit()" class="sr-only peer" {{ $r->status === 'active' ? 'checked' : '' }}>
                                        <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-green-500"></div>
                                    </label>
                                </form>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center justify-center gap-3">
                                    <!-- Edit btn placeholder -->
                                    <button type="button" class="text-blue-600 hover:text-blue-800 transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    
                                    <button type="button" @click="deleteData = { id: {{ $r->id ?? 0 }}, name: '{{ $r->referral_code }}' }; showDeleteModal = true" class="text-red-600 hover:text-red-800 transition-colors" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">Belum ada data referral.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
    
    <!-- Delete Modal Overlay -->
    <div x-show="showDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" style="display: none;" x-transition>
       <div @click.outside="showDeleteModal = false" class="bg-white rounded-xl w-full max-w-sm p-6 shadow-xl relative">
          <button @click="showDeleteModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
          </button>
          
          <h3 class="text-lg font-bold text-gray-900 mb-6">Hapus Referral</h3>
          
          <div class="bg-red-50 border border-red-100 rounded-lg p-3 mb-6 flex gap-3 text-red-600">
             <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
             <p class="text-[13px] leading-tight font-medium">Apakah Anda yakin ingin menghapus kode referral ini? Tindakan ini tidak dapat dibatalkan.</p>
          </div>
          <p class="text-sm text-gray-700 mb-6 font-medium">Menghapus kode: <strong class="text-gray-900 font-bold" x-text="deleteData.name"></strong></p>
          
          <form :action="'{{ url('/referral') }}/' + deleteData.id" method="POST">
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
