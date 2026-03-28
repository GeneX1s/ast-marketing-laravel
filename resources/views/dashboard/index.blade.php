@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Dashboard Marketing</h1>
    <p class="text-gray-500 mt-1">Ringkasan performa marketing dan pencapaian target hari ini.</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden group hover:shadow-md transition-shadow">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-50 rounded-full group-hover:scale-110 transition-transform duration-500"></div>
        <div class="relative">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-blue-100 text-blue-600 rounded-xl">
                    @include('icons.megaphone')
                </div>
                <span class="flex items-center text-sm font-medium text-green-600 bg-green-50 px-2 py-1 rounded-lg">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    12.5%
                </span>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Kampanye</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-1">124</h3>
            </div>
        </div>
    </div>

    <!-- Leads Card -->
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden group hover:shadow-md transition-shadow">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-purple-50 rounded-full group-hover:scale-110 transition-transform duration-500"></div>
        <div class="relative">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-purple-100 text-purple-600 rounded-xl">
                    @include('icons.user')
                </div>
                <span class="flex items-center text-sm font-medium text-green-600 bg-green-50 px-2 py-1 rounded-lg">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    8.2%
                </span>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Prospek</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-1">8,432</h3>
            </div>
        </div>
    </div>

    <!-- Conversion Card -->
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden group hover:shadow-md transition-shadow">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-green-50 rounded-full group-hover:scale-110 transition-transform duration-500"></div>
        <div class="relative">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-green-100 text-green-600 rounded-xl">
                    @include('icons.file-text')
                </div>
                <span class="flex items-center text-sm font-medium text-red-600 bg-red-50 px-2 py-1 rounded-lg">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                    2.4%
                </span>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Konversi Merchant</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-1">1,204</h3>
            </div>
        </div>
    </div>

    <!-- Revenue Card -->
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden group hover:shadow-md transition-shadow">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-orange-50 rounded-full group-hover:scale-110 transition-transform duration-500"></div>
        <div class="relative">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-orange-100 text-orange-600 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="flex items-center text-sm font-medium text-green-600 bg-green-50 px-2 py-1 rounded-lg">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    14.6%
                </span>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Transaksi Sales</p>
                <h3 class="text-3xl font-bold text-gray-900 mt-1">Rp 48.2M</h3>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Activity Chart (Placeholder) -->
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="font-bold text-gray-900">Aktivitas Kampanye</h3>
                <p class="text-sm text-gray-500">Performa harian 30 hari terakhir</p>
            </div>
            <select class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2">
                <option>Bulan Ini</option>
                <option>Bulan Lalu</option>
                <option>Tahun Ini</option>
            </select>
        </div>
        <div class="h-64 flex items-end justify-between gap-2">
            <!-- Mock Bar Chart -->
            @for($i = 0; $i < 30; $i++)
                @php $height = rand(20, 100); @endphp
                <div class="w-full bg-blue-100 rounded-t-sm hover:bg-blue-300 transition-colors relative group" style="height: {{ $height }}%">
                    <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                        {{ $height * 10 }}
                    </div>
                </div>
            @endfor
        </div>
    </div>

    <!-- Recent Prospects -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-900">Prospek Terbaru</h3>
            <a href="/form-pengajuan" class="text-sm text-blue-600 hover:text-blue-700 font-medium">Lihat Semua</a>
        </div>
        <div class="divide-y divide-gray-50">
            @for($i = 1; $i <= 5; $i++)
            <div class="p-4 flex items-center gap-4 hover:bg-gray-50 transition-colors cursor-pointer">
                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm">
                    P{{ $i }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate">PT. Bisnis Jaya {{ $i }}</p>
                    <p class="text-xs text-gray-500 truncate">Pengajuan Pendaftaran Merchant</p>
                </div>
                <div class="text-xs font-medium px-2 py-1 rounded bg-yellow-50 text-yellow-700">
                    Pending
                </div>
            </div>
            @endfor
        </div>
    </div>
</div>
@endsection
