@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
    <p class="text-gray-500 mt-1 text-sm">Selamat datang kembali, berikut ringkasan hari ini</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Kampanye Card -->
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500">Kampanye Aktif</p>
            <h3 class="text-3xl font-bold text-gray-900 mt-1">12</h3>
            <p class="text-xs text-gray-400 mt-1">3 terjadwal hari ini</p>
        </div>
        <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
            @include('icons.target')
        </div>
    </div>
    <!-- Prospek Card -->
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500">Prospek Baru</p>
            <h3 class="text-3xl font-bold text-gray-900 mt-1">47</h3>
            <p class="text-xs text-gray-400 mt-1">Minggu ini</p>
        </div>
        <div class="p-3 bg-green-50 text-green-600 rounded-xl">
            @include('icons.users')
        </div>
    </div>
    <!-- Pengajuan Card -->
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500">Pengajuan Pending</p>
            <h3 class="text-3xl font-bold text-gray-900 mt-1">23</h3>
            <p class="text-xs text-gray-400 mt-1">8 perlu verifikasi</p>
        </div>
        <div class="p-3 bg-orange-50 text-orange-600 rounded-xl">
            @include('icons.file-text')
        </div>
    </div>
    <!-- Sign-up Card -->
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500">Total Sign-up Referral</p>
            <h3 class="text-3xl font-bold text-gray-900 mt-1">156</h3>
            <p class="text-xs text-gray-400 mt-1">Bulan ini</p>
        </div>
        <div class="p-3 bg-purple-50 text-purple-600 rounded-xl">
            @include('icons.gift')
        </div>
    </div>
</div>

<!-- Aksi Cepat -->
<div class="mb-8">
    <h3 class="font-bold text-gray-900 mb-4">Aksi Cepat</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="{{ route('kampanye.index') }}" class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl border border-blue-200 text-blue-600 hover:bg-blue-50 transition-colors font-medium text-sm">
            <span class="text-lg leading-none font-light">+</span> Tambah Kampanye
        </a>
        <a href="{{ route('laporan-sales.index') }}" class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl border border-green-200 text-green-600 hover:bg-green-50 transition-colors font-medium text-sm">
            <span class="text-lg leading-none font-light">+</span> Tambah Prospek
        </a>
        <a href="{{ route('referral.index') }}" class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl border border-purple-200 text-purple-600 hover:bg-purple-50 transition-colors font-medium text-sm">
            <span class="text-lg leading-none font-light">+</span> Buat Kode Referral
        </a>
        <a href="{{ route('pengajuan.index') }}" class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl border border-orange-200 text-orange-600 hover:bg-orange-50 transition-colors font-medium text-sm">
            <span class="text-lg leading-none font-light">+</span> Buat Pengajuan
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Posting Terjadwal Hari Ini -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="text-gray-400">@include('icons.clock', ['class' => 'w-5 h-5'])</div>
                <h3 class="font-bold text-gray-900">Posting Terjadwal Hari Ini</h3>
            </div>
            <a href="{{ route('kampanye.index') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
        </div>
        <div class="divide-y divide-gray-50 flex-1">
            <!-- Item 1 -->
            <div class="p-5 hover:bg-gray-50 transition-colors flex justify-between items-start">
                <div>
                    <h4 class="font-semibold text-gray-900 text-sm">Posting Instagram - Promo Lebaran</h4>
                    <div class="flex items-center gap-3 mt-2">
                        <span class="text-xs text-gray-500 flex items-center gap-1">@include('icons.clock', ['class' => 'w-3 h-3']) 10:00</span>
                        <span class="text-[10px] font-medium px-2 py-0.5 rounded-full bg-blue-50 text-blue-600">Instagram</span>
                    </div>
                </div>
                <span class="text-[10px] font-medium px-3 py-1 rounded-full bg-yellow-50 text-yellow-700">Pending</span>
            </div>
            <!-- Item 2 -->
            <div class="p-5 hover:bg-gray-50 transition-colors flex justify-between items-start">
                <div>
                    <h4 class="font-semibold text-gray-900 text-sm">Email Blast - Fitur Baru AST PAY</h4>
                    <div class="flex items-center gap-3 mt-2">
                        <span class="text-xs text-gray-500 flex items-center gap-1">@include('icons.clock', ['class' => 'w-3 h-3']) 14:00</span>
                        <span class="text-[10px] font-medium px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-600">Email</span>
                    </div>
                </div>
                <span class="text-[10px] font-medium px-3 py-1 rounded-full bg-yellow-50 text-yellow-700">Pending</span>
            </div>
            <!-- Item 3 -->
            <div class="p-5 hover:bg-gray-50 transition-colors flex justify-between items-start">
                <div>
                    <h4 class="font-semibold text-gray-900 text-sm">WhatsApp Campaign - Follow Up Merchant</h4>
                    <div class="flex items-center gap-3 mt-2">
                        <span class="text-xs text-gray-500 flex items-center gap-1">@include('icons.clock', ['class' => 'w-3 h-3']) 16:00</span>
                        <span class="text-[10px] font-medium px-2 py-0.5 rounded-full bg-green-50 text-green-700">WhatsApp</span>
                    </div>
                </div>
                <span class="text-[10px] font-medium px-3 py-1 rounded-full bg-yellow-50 text-yellow-700">Pending</span>
            </div>
            <!-- Item 4 -->
            <div class="p-5 hover:bg-gray-50 transition-colors flex justify-between items-start">
                <div>
                    <h4 class="font-semibold text-gray-900 text-sm">TikTok Video - Tutorial Pembayaran</h4>
                    <div class="flex items-center gap-3 mt-2">
                        <span class="text-xs text-gray-500 flex items-center gap-1">@include('icons.clock', ['class' => 'w-3 h-3']) 19:00</span>
                        <span class="text-[10px] font-medium px-2 py-0.5 rounded-full border border-gray-200 text-gray-700 bg-white">TikTok</span>
                    </div>
                </div>
                <span class="text-[10px] font-medium px-3 py-1 rounded-full bg-yellow-50 text-yellow-700">Pending</span>
            </div>
            <!-- Item 5 -->
            <div class="p-5 hover:bg-gray-50 transition-colors flex justify-between items-start">
                <div>
                    <h4 class="font-semibold text-gray-900 text-sm">SEO Article - Keuntungan Merchant</h4>
                    <div class="flex items-center gap-3 mt-2">
                        <span class="text-xs text-gray-500 flex items-center gap-1">@include('icons.clock', ['class' => 'w-3 h-3']) Pending</span>
                        <span class="text-[10px] font-medium px-2 py-0.5 rounded-full bg-orange-50 text-orange-600">Blog</span>
                    </div>
                </div>
                <span class="text-[10px] font-medium px-3 py-1 rounded-full bg-yellow-50 text-yellow-700">Pending</span>
            </div>
        </div>
    </div>

    <!-- Follow-up Prioritas -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="text-orange-500">@include('icons.alert-circle', ['class' => 'w-5 h-5'])</div>
                <h3 class="font-bold text-gray-900">Follow-up Prioritas</h3>
            </div>
            <a href="{{ route('laporan-sales.index') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
        </div>
        <div class="divide-y divide-gray-50 flex-1">
            <!-- Item 1 -->
            <div class="p-5 hover:bg-gray-50 transition-colors flex justify-between items-start">
                <div>
                    <h4 class="font-semibold text-gray-900 text-sm">PT Maju Jaya</h4>
                    <p class="text-xs text-gray-500 mt-1">PIC: Siti Rahayu</p>
                    <div class="flex items-center gap-3 mt-2">
                        <span class="text-[10px] font-medium px-2 py-0.5 rounded-full bg-blue-50 text-blue-600">Negosiasi</span>
                        <span class="text-xs text-gray-400 font-medium">Jatuh tempo: Hari ini</span>
                    </div>
                </div>
                <span class="text-[10px] font-medium px-3 py-1 rounded-full bg-red-50 text-red-600">Tinggi</span>
            </div>
            <!-- Item 2 -->
            <div class="p-5 hover:bg-gray-50 transition-colors flex justify-between items-start">
                <div>
                    <h4 class="font-semibold text-gray-900 text-sm">Toko Berkah Abadi</h4>
                    <p class="text-xs text-gray-500 mt-1">PIC: Ahmad Yani</p>
                    <div class="flex items-center gap-3 mt-2">
                        <span class="text-[10px] font-medium px-2 py-0.5 rounded-full bg-purple-50 text-purple-600">Demo</span>
                        <span class="text-xs text-gray-400 font-medium">Jatuh tempo: Hari ini</span>
                    </div>
                </div>
                <span class="text-[10px] font-medium px-3 py-1 rounded-full bg-red-50 text-red-600">Tinggi</span>
            </div>
            <!-- Item 3 -->
            <div class="p-5 hover:bg-gray-50 transition-colors flex justify-between items-start">
                <div>
                    <h4 class="font-semibold text-gray-900 text-sm">UD Sejahtera</h4>
                    <p class="text-xs text-gray-500 mt-1">PIC: Budi Santoso</p>
                    <div class="flex items-center gap-3 mt-2">
                        <span class="text-[10px] font-medium px-2 py-0.5 rounded-full bg-cyan-50 text-cyan-700">Dihubungi</span>
                        <span class="text-xs text-gray-400 font-medium">Jatuh tempo: Besok</span>
                    </div>
                </div>
                <span class="text-[10px] font-medium px-3 py-1 rounded-full bg-yellow-50 text-yellow-700">Sedang</span>
            </div>
            <!-- Item 4 -->
            <div class="p-5 hover:bg-gray-50 transition-colors flex justify-between items-start">
                <div>
                    <h4 class="font-semibold text-gray-900 text-sm">CV Karya Mandiri</h4>
                    <p class="text-xs text-gray-500 mt-1">PIC: Rina Wati</p>
                    <div class="flex items-center gap-3 mt-2">
                        <span class="text-[10px] font-medium px-2 py-0.5 rounded-full bg-gray-100 text-gray-700 border border-gray-200">Baru</span>
                        <span class="text-xs text-gray-400 font-medium">Jatuh tempo: Besok</span>
                    </div>
                </div>
                <span class="text-[10px] font-medium px-3 py-1 rounded-full bg-yellow-50 text-yellow-700">Sedang</span>
            </div>
        </div>
    </div>
</div>
@endsection
