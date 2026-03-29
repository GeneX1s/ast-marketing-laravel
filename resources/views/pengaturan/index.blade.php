@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="space-y-6" x-data="settingsForm()">
    <!-- Toast -->
    <div x-show="toast.visible" x-transition style="display: none;" class="fixed bottom-4 right-4 bg-gray-900 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3 z-50">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        <span x-text="toast.message"></span>
        <button @click="toast.visible = false" class="text-gray-400 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
    </div>

    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-900 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
        Kembali ke Dashboard
    </a>

    <div>
        <h1 class="text-2xl font-bold text-gray-900">Pengaturan Akun</h1>
        <p class="text-gray-500 mt-1">Kelola keamanan dan preferensi akun Anda</p>
    </div>

    <!-- Security Card -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-start gap-4">
            <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/></svg>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Keamanan Akun</h2>
                <p class="text-gray-500 text-sm">Kelola password dan keamanan login</p>
            </div>
        </div>

        <div class="divide-y divide-gray-100">
            <div class="p-6 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <div>
                        <h3 class="text-sm font-medium text-gray-900">Ubah Password</h3>
                        <p class="text-xs text-gray-500">Terakhir diperbarui 30 hari lalu</p>
                    </div>
                </div>
                <button @click="openPasswordModal()" class="px-4 py-2 border border-blue-200 text-blue-600 rounded-lg text-sm font-medium hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Ubah
                </button>
            </div>
            <div class="p-6 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="20" x="5" y="2" rx="2" ry="2"/><path d="M12 18h.01"/></svg>
                    <div>
                        <h3 class="text-sm font-medium text-gray-900">Autentikasi 2 Faktor (2FA)</h3>
                        <p class="text-xs text-gray-500">Gunakan OTP untuk verifikasi login tambahan</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <button @click="is2FAEnabled = !is2FAEnabled" :class="is2FAEnabled ? 'bg-green-500' : 'bg-gray-200'" class="w-11 h-6 rounded-full transition-colors relative focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        <div :class="is2FAEnabled ? 'translate-x-5' : 'translate-x-0'" class="w-4 h-4 bg-white rounded-full absolute top-1 left-1 transition-transform"></div>
                    </button>
                    <span class="text-sm font-medium" :class="is2FAEnabled ? 'text-gray-900' : 'text-gray-500'" x-text="is2FAEnabled ? 'Aktif' : 'Nonaktif'"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Password Modal -->
    <div x-show="isPasswordModalOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-gray-900/50 backdrop-blur-sm" @keydown.escape.window="isPasswordModalOpen = false">
        <div x-show="isPasswordModalOpen" @click.away="isPasswordModalOpen = false" class="relative w-full max-w-md p-4 mx-auto">
            <div class="relative bg-white rounded-xl shadow-2xl border border-gray-100 flex flex-col">
                <div class="flex items-center justify-between p-6 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900" x-text="passwordStep === 'input' ? 'Ubah Password' : 'Verifikasi 2FA'"></h3>
                    <button @click="isPasswordModalOpen = false" class="text-gray-400 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
                    </button>
                </div>

                <!-- Input Step -->
                <div x-show="passwordStep === 'input'" class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
                        <input type="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                        <input type="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button @click="isPasswordModalOpen = false" class="flex-1 px-4 py-2 border border-gray-200 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Batal</button>
                        <button @click="handlePasswordSubmit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 shadow-sm">Simpan</button>
                    </div>
                </div>

                <!-- OTP Step -->
                <div x-show="passwordStep === 'otp'" class="p-6 text-center space-y-6">
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 mb-4 shadow-inner">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/></svg>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Kode OTP telah dikirim ke email Anda</p>
                    </div>

                    <div class="flex justify-center gap-2">
                        <template x-for="(digit, index) in otp" :key="index">
                            <input type="text" maxlength="1" x-model="otp[index]" x-ref="'otp' + index" @input="handleOtpInput(index, $event)" @keydown="handleOtpKeydown(index, $event)" :disabled="otpLoading || otpSuccess" class="w-10 h-12 border border-gray-300 rounded-lg text-center text-xl font-bold focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50">
                        </template>
                    </div>

                    <button @click="handleVerify" :disabled="!isOtpComplete || otpLoading || otpSuccess" :class="[ 'w-full py-3 rounded-lg font-bold flex items-center justify-center gap-2 text-white transition-all', (isOtpComplete && !otpLoading && !otpSuccess) ? 'bg-blue-600 hover:bg-blue-700' : 'bg-blue-300 cursor-not-allowed', otpSuccess ? 'bg-green-600' : '' ]">
                        <span x-show="!otpLoading && !otpSuccess">Verify</span>
                        <span x-show="otpLoading" class="flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Verifying...
                        </span>
                        <span x-show="otpSuccess" class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            Success
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('settingsForm', () => ({
            is2FAEnabled: false,
            isPasswordModalOpen: false,
            passwordStep: 'input',
            toast: { visible: false, message: '' },
            otp: ['', '', '', '', '', ''],
            otpLoading: false,
            otpSuccess: false,

            get isOtpComplete() { return this.otp.every(d => d !== ''); },

            openPasswordModal() {
                this.passwordStep = 'input';
                this.otp = ['', '', '', '', '', ''];
                this.otpLoading = false;
                this.otpSuccess = false;
                this.isPasswordModalOpen = true;
            },

            showToast(msg) {
                this.toast.message = msg;
                this.toast.visible = true;
                setTimeout(() => { this.toast.visible = false; }, 3000);
            },

            handlePasswordSubmit() {
                if (this.is2FAEnabled) {
                    this.passwordStep = 'otp';
                    setTimeout(() => { this.$refs.otp0.focus(); }, 100);
                } else {
                    this.isPasswordModalOpen = false;
                    this.showToast('Password berhasil diubah');
                }
            },

            handleOtpInput(index, event) {
                const val = event.target.value;
                if (isNaN(Number(val))) { this.otp[index] = ''; return; }
                if (val !== '' && index < 5) { this.$refs['otp' + (index + 1)].focus(); }
            },

            handleOtpKeydown(index, event) {
                if (event.key === 'Backspace' && this.otp[index] === '' && index > 0) {
                    this.$refs['otp' + (index - 1)].focus();
                }
            },

            handleVerify() {
                this.otpLoading = true;
                setTimeout(() => {
                    this.otpLoading = false;
                    this.otpSuccess = true;
                    setTimeout(() => {
                        this.isPasswordModalOpen = false;
                        this.showToast('Password berhasil diubah');
                    }, 1000);
                }, 1200);
            }
        }));
    });
</script>
@endpush
@endsection
