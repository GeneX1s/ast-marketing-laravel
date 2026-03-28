@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Profil Saya</h1>
    <p class="text-gray-500 mt-1">Informasi detail mengenai akun Anda.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl">
    <!-- Header banner -->
    <div class="h-32 bg-gradient-to-r from-blue-600 to-indigo-700"></div>

    <div class="px-8 pb-8 relative">
        <!-- Avatar -->
        <div class="w-24 h-24 rounded-full border-4 border-white bg-blue-100 text-blue-600 flex items-center justify-center text-3xl font-bold absolute -top-12 shadow-md">
            {{ Str::upper(substr(auth()->user()->name, 0, 2)) }}
        </div>

        <div class="pt-16 max-w-2xl">
            <h2 class="text-2xl font-bold text-gray-900">{{ auth()->user()->name }}</h2>
            <div class="flex items-center gap-2 mt-1 mb-6">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ auth()->user()->role->name ?? 'Staff' }}
                </span>
                <span class="text-sm text-gray-500">{{ auth()->user()->email }}</span>
            </div>

            <dl class="space-y-4 text-sm">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 border-b border-gray-100 pb-4">
                    <dt class="font-medium text-gray-500 sm:col-span-1">No. Handphone</dt>
                    <dd class="text-gray-900 sm:col-span-2">{{ auth()->user()->phone_number ?? '-' }}</dd>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 border-b border-gray-100 pb-4">
                    <dt class="font-medium text-gray-500 sm:col-span-1">Alamat</dt>
                    <dd class="text-gray-900 sm:col-span-2">{{ auth()->user()->address ?? '-' }}</dd>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 border-b border-gray-100 pb-4">
                    <dt class="font-medium text-gray-500 sm:col-span-1">Status Akun</dt>
                    <dd class="text-gray-900 sm:col-span-2">
                        @if(auth()->user()->status)
                            <span class="text-green-600 font-medium">Aktif</span>
                        @else
                            <span class="text-red-600 font-medium">Non-Aktif</span>
                        @endif
                    </dd>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                    <dt class="font-medium text-gray-500 sm:col-span-1">Terdaftar Sejak</dt>
                    <dd class="text-gray-900 sm:col-span-2">{{ auth()->user()->created_at->format('d M Y') }}</dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection
