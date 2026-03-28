@extends('layouts.app')

@section('title', 'Laporan Sales')

@section('content')
<div class="mb-8 flex justify-between items-start" x-data="{ showModal: false }">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Laporan Sales</h1>
        <p class="text-gray-500 mt-1">Lacak pencapaian dan omzet harian tim.</p>
    </div>

    <!-- Tambah Sale Modal placeholder -> would normally contain form -> matching the code structure -->
    <button @click="showModal = true" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
        Catat Penjualan
    </button>
    
    <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display: none;">
        <div @click.outside="showModal = false" class="bg-white rounded-2xl w-full max-w-lg p-6 shadow-xl">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Catat Penjualan Baru</h3>
            <form action="{{ route('laporan-sales.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Merchant / Bisnis</label>
                        <select name="business_id" required class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="">-- Pilih Bisnis --</option>
                            @foreach($businesses as $b)
                                <option value="{{ $b->id }}">{{ $b->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nilai Penjualan (Rp)</label>
                        <input type="number" name="amount" required min="0" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Layanan</label>
                        <textarea name="description" rows="2" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm"></textarea>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="showModal = false" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 font-medium">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">Simpan Penjualan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-6 text-white shadow-lg">
        <h3 class="text-blue-100 font-medium mb-1">Total Omzet Bulan Ini</h3>
        <p class="text-4xl font-bold">Rp {{ number_format($sales->sum('amount'), 0, ',', '.') }}</p>
        <div class="mt-4 pt-4 border-t border-blue-500/30 flex justify-between items-center text-sm text-blue-100">
            <span>{{ $sales->count() }} Transaksi</span>
            <span>+12.5% dari bulan lalu</span>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-8">
    <div class="p-6 border-b border-gray-100">
        <h3 class="font-bold text-gray-900">Riwayat Penjualan Terbaru</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-gray-50 border-b border-gray-200 text-gray-600 font-medium">
                <tr>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Merchant</th>
                    <th class="px-6 py-4">Nilai</th>
                    <th class="px-6 py-4">Deskripsi</th>
                    <th class="px-6 py-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($sales as $s)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-gray-600">{{ $s->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $s->business?->name }}</td>
                    <td class="px-6 py-4 font-bold text-blue-600">Rp {{ number_format($s->amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ Str::limit($s->description, 30) }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            {{ $s->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">Belum ada data penjualan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
