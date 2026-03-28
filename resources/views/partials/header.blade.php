@php
    $user = auth()->user();
    $userName = $user?->name ?? 'Pengguna';
    $userEmail = $user?->email ?? '';
    $userRole = $user?->role?->name ?? 'Staff';
    $initials = collect(explode(' ', $userName))->map(fn($n) => strtoupper(substr($n, 0, 1)))->take(2)->join('');
@endphp

<header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 fixed top-0 left-64 right-0 z-50" x-data="{ notifOpen: false, profileOpen: false }">
    {{-- Search --}}
    <div class="flex-1 max-w-xl relative">
        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
            @include('icons.search')
        </div>
        <input type="text" placeholder="Cari kampanye, prospek, atau apa saja..."
               class="w-full pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
    </div>

    <div class="flex items-center gap-6">
        {{-- Notification Bell --}}
        <div class="relative">
            <button @click="notifOpen = !notifOpen; profileOpen = false"
                    class="relative p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-full transition-colors outline-none">
                @include('icons.bell')
                <span class="absolute top-1 right-1 w-4 h-4 bg-red-500 text-white text-[10px] flex items-center justify-center rounded-full border border-white">3</span>
            </button>
            <div x-show="notifOpen" @click.outside="notifOpen = false" x-transition
                 class="absolute right-0 top-full mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-100 z-50 overflow-hidden" style="display: none;">
                <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-900">Notifikasi</h3>
                    <button class="text-xs text-blue-600 hover:underline">Tandai semua dibaca</button>
                </div>
                <div class="max-h-[320px] overflow-y-auto">
                    @foreach([
                        ['msg' => 'Kampanye "Promo Lebaran" terjadwal hari ini pukul 10:00', 'time' => '5 menit lalu', 'read' => false],
                        ['msg' => 'Pengajuan baru dari PT Maju Jaya perlu verifikasi', 'time' => '15 menit lalu', 'read' => false],
                        ['msg' => 'Follow-up sales untuk Toko Berkah jatuh tempo hari ini', 'time' => '1 jam lalu', 'read' => false],
                        ['msg' => 'Kode referral REF-2024 mencapai 50 pendaftar', 'time' => '2 jam lalu', 'read' => true],
                    ] as $notif)
                        <div class="p-4 border-b border-gray-50 hover:bg-gray-50 transition-colors flex gap-3 {{ !$notif['read'] ? 'bg-blue-50/30' : '' }}">
                            <div class="mt-1.5 w-2 h-2 rounded-full shrink-0 {{ !$notif['read'] ? 'bg-blue-600' : 'bg-transparent' }}"></div>
                            <div>
                                <p class="text-sm {{ !$notif['read'] ? 'text-gray-900 font-medium' : 'text-gray-600' }}">{{ $notif['msg'] }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $notif['time'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="p-3 border-t border-gray-100 bg-gray-50 text-center">
                    <button class="text-xs text-blue-600 font-medium hover:underline">Lihat semua notifikasi</button>
                </div>
            </div>
        </div>

        {{-- Profile Dropdown --}}
        <div class="relative">
            <button @click="profileOpen = !profileOpen; notifOpen = false"
                    class="flex items-center gap-3 hover:bg-gray-50 p-2 rounded-lg transition-colors text-left">
                <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-medium">{{ $initials }}</div>
                <div class="text-sm">
                    <p class="font-medium text-gray-900 leading-none">{{ $userName }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $userRole }}</p>
                </div>
            </button>
            <div x-show="profileOpen" @click.outside="profileOpen = false" x-transition
                 class="absolute right-0 top-full mt-2 w-64 bg-white rounded-xl shadow-lg border border-gray-100 z-50 overflow-hidden py-1" style="display: none;">
                <div class="px-4 py-3 border-b border-gray-100">
                    <p class="font-medium text-gray-900">{{ $userName }}</p>
                    <p class="text-xs text-gray-500">{{ $userEmail }}</p>
                    <p class="text-xs text-blue-600 mt-1 font-medium">{{ $userRole }}</p>
                </div>
                <a href="/profil" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 w-full">
                    @include('icons.user') Profil
                </a>
                <a href="/pengaturan" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 w-full">
                    @include('icons.settings') Pengaturan Akun
                </a>
                <div class="border-t border-gray-100 mt-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 w-full text-left">
                            @include('icons.log-out') Keluar (Logout)
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
