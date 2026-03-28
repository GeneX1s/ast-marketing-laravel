@extends('layouts.app')

@section('title', 'Form Pengajuan')

@section('content')
<div class="mb-8 flex justify-between items-start" x-data="{ showModal: false }">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Pengajuan Merchant</h1>
        <p class="text-gray-500 mt-1">Daftar pengajuan merchant baru yang perlu diverifikasi.</p>
    </div>

    <button @click="showModal = true" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
        Tambah Pengajuan Manual
    </button>
    
    <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display: none;">
        <div @click.outside="showModal = false" class="bg-white rounded-2xl w-full max-w-lg p-6 shadow-xl">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Pengajuan Baru</h3>
            <form action="{{ route('pengajuan.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Usaha / PT</label>
                        <input type="text" name="name" required class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp</label>
                            <input type="text" name="phone_number" required class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Registrasi</label>
                            <input type="email" name="email" required class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                        <textarea name="address" required rows="2" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm"></textarea>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="showModal = false" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 font-medium">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">Simpan Pengajuan</button>
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
                    <th class="px-6 py-4">Tanggal Pengajuan</th>
                    <th class="px-6 py-4">Nama Usaha</th>
                    <th class="px-6 py-4">Kontak</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($pengajuans as $p)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-gray-600">{{ $p->created_at->format('d M Y - H:i') }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900">
                        {{ $p->name }}
                        <p class="text-xs text-gray-500 font-normal mt-0.5 truncate max-w-[200px]">{{ $p->address }}</p>
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        <p>{{ $p->phone_number }}</p>
                        <p class="text-xs text-gray-500">{{ $p->email }}</p>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $s = strtolower($p->status);
                            $colors = [
                                'diterima' => 'bg-green-100 text-green-800',
                                'disetujui' => 'bg-green-100 text-green-800',
                                'ditolak' => 'bg-red-100 text-red-800',
                            ];
                            $colorClass = $colors[$s] ?? 'bg-yellow-100 text-yellow-800';
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $colorClass }}">
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2" x-data="{ showStatusModal: false }">
                            <button @click="showStatusModal = true" class="text-blue-600 hover:bg-blue-50 px-3 py-1.5 rounded text-xs font-medium transition-colors border border-blue-200">
                                Update Status
                            </button>
                            
                            <div x-show="showStatusModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display: none;">
                                <div @click.outside="showStatusModal = false" class="bg-white rounded-xl w-full max-w-sm p-5 shadow-xl whitespace-normal text-left">
                                    <h3 class="font-bold text-gray-900 mb-4">Update Status Pengajuan</h3>
                                    <form action="{{ route('pengajuan.updateStatus', $p) }}" method="POST">
                                        @csrf @method('PUT')
                                        <select name="status" class="w-full border-gray-300 rounded-lg text-sm mb-4">
                                            <option value="Perlu Verifikasi" {{ $p->status == 'Perlu Verifikasi' ? 'selected' : '' }}>Perlu Verifikasi</option>
                                            <option value="Diterima" {{ strtolower($p->status) == 'diterima' ? 'selected' : '' }}>Diterima / Disetujui</option>
                                            <option value="Ditolak" {{ strtolower($p->status) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                        <div class="flex justify-end gap-2">
                                            <button type="button" @click="showStatusModal = false" class="px-3 py-1.5 bg-gray-100 text-gray-600 rounded">Batal</button>
                                            <button type="submit" class="px-3 py-1.5 bg-blue-600 text-white rounded font-medium">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">Belum ada data pengajuan merchant.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
