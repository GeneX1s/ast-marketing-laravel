@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="space-y-6" x-data="profileForm()">
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="fixed bottom-4 right-4 bg-gray-900 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3 z-50 transition-all duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        <span>{{ session('success') }}</span>
        <button @click="show = false" class="text-gray-400 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
    </div>
    @endif

    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-900 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
        Kembali ke Dashboard
    </a>

    <div>
        <h1 class="text-2xl font-bold text-gray-900">Profil Saya</h1>
        <p class="text-gray-500 mt-1">Informasi akun dan data pribadi Anda</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
        <div class="flex items-center gap-6">
            <div class="w-24 h-24 rounded-full bg-blue-600 flex items-center justify-center text-white text-3xl font-medium shadow-inner">
                {{ Str::upper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ auth()->user()->name ?? '' }}</h2>
                <p class="text-gray-500">{{ auth()->user()->role->name ?? 'Staff' }}</p>
                <div class="mt-2 inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-medium">
                    <div class="w-1.5 h-1.5 rounded-full bg-blue-600"></div>
                    {{ auth()->user()->role->name ?? 'Staff' }}
                </div>
            </div>
        </div>
        <button @click="isEditModalOpen = true" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            Edit Profil
        </button>
    </div>

    <!-- Contact Info -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-8">
        <h3 class="font-semibold text-gray-900 mb-6">Informasi Kontak</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="flex items-start gap-4">
                <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Email</p>
                    <p class="font-medium text-gray-900">{{ auth()->user()->email ?? '' }}</p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <div class="p-2 bg-green-50 rounded-lg text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-400">No. Telepon</p>
                    <p class="font-medium text-gray-900">{{ auth()->user()->phone_number ?? '-' }}</p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <div class="p-2 bg-purple-50 rounded-lg text-purple-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Lokasi</p>
                    <p class="font-medium text-gray-900">{{ auth()->user()->address ?? '-' }}</p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <div class="p-2 bg-orange-50 rounded-lg text-orange-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Bergabung Sejak</p>
                    <p class="font-medium text-gray-900">{{ auth()->user()->created_at->translatedFormat('d F Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="isEditModalOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-gray-900/50 backdrop-blur-sm" @keydown.escape.window="isEditModalOpen = false">
        <div x-show="isEditModalOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" @click.away="isEditModalOpen = false" class="relative w-full max-w-md p-4 mx-auto">
            <div class="relative bg-white rounded-xl shadow-2xl border border-gray-100 flex flex-col max-h-[90vh]">
                <div class="flex items-center justify-between p-6 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900">Edit Profil</h3>
                    <button @click="isEditModalOpen = false" class="text-gray-400 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                    </button>
                </div>
                <form action="#" method="POST" class="p-6 space-y-4 overflow-y-auto" @submit.prevent="submitForm">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" x-model="form.name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                        <input type="text" name="phone_number" x-model="form.phone_number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                        <input type="text" name="address" x-model="form.address" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="button" @click="isEditModalOpen = false" class="flex-1 px-4 py-2 border border-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50">Batal</button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 flex justify-center items-center gap-2" :disabled="isLoading">
                            <span x-show="!isLoading">Simpan Perubahan</span>
                            <span x-show="isLoading" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Menyimpan...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('profileForm', () => ({
            isEditModalOpen: false,
            isLoading: false,
            form: {
                name: '{{ auth()->user()->name ?? "" }}',
                phone_number: '{{ auth()->user()->phone_number ?? "" }}',
                address: '{{ auth()->user()->address ?? "" }}',
            },
            submitForm(e) {
                this.isLoading = true;
                setTimeout(() => {
                    this.isLoading = false;
                    this.isEditModalOpen = false;
                    window.location.reload();
                }, 800);
            }
        }));
    });
</script>
@endpush
@endsection
