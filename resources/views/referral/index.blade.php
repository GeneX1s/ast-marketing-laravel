@extends('layouts.app')

@section('title', 'Kode Referral')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Program Referral</h1>
    <p class="text-gray-500 mt-1">Pantau penggunaan kode referral dan komisi partner.</p>
</div>

<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-gray-50 border-b border-gray-200 text-gray-600 font-medium">
                <tr>
                    <th class="px-6 py-4">Partner</th>
                    <th class="px-6 py-4">Kode Referral</th>
                    <th class="px-6 py-4">Komisi</th>
                    <th class="px-6 py-4">Pengguna</th>
                    <th class="px-6 py-4">Pengguna Aktif</th>
                    <th class="px-6 py-4">Total Komisi</th>
                    <th class="px-6 py-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($referrals as $r)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $r->recruiter_name }}</td>
                    <td class="px-6 py-4 font-mono font-bold text-blue-600 bg-blue-50/50 mix-blend-multiply">{{ $r->referral_code }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $r->commission_value }} ({{ $r->commission_type }})</td>
                    <td class="px-6 py-4 text-gray-600">{{ $r->participant }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $r->active_participant }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900">Rp {{ number_format((float)$r->total_commission, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            {{ ucfirst($r->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">Belum ada data referral.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
