@php
    $user = auth()->user();
    $userRole = $user?->role?->name ?? 'Staff';
    $isAdmin = $userRole === 'Admin';
    $permissions = $user?->role?->permissionGroup?->permissions ?? collect();

    $menuItems = [
        ['name' => 'Dashboard', 'href' => '/', 'icon' => 'layout-dashboard'],
        ['name' => 'Kampanye', 'href' => '/kampanye', 'icon' => 'megaphone'],
        ['name' => 'Laporan Sales', 'href' => '/laporan-sales', 'icon' => 'file-text'],
        ['name' => 'Referral', 'href' => '/referral', 'icon' => 'gift'],
        ['name' => 'Form Pengajuan', 'href' => '/form-pengajuan', 'icon' => 'clipboard-check'],
    ];

    if ($isAdmin) {
        $menuItems[] = ['name' => 'Pengaturan', 'href' => '/pengaturan-sistem', 'icon' => 'settings'];
    }

    // Filter by permissions for non-admin
    if (!$isAdmin) {
        $menuItems = array_filter($menuItems, function ($item) use ($permissions) {
            $segment = $item['href'] === '/' ? 'dashboard' : ltrim(explode('/', $item['href'])[1] ?? '', '/');
            return $permissions->contains('page', $segment);
        });
    }
@endphp

<div class="w-64 bg-white h-screen border-r border-gray-200 flex flex-col fixed left-0 top-0 z-40">
    <div class="p-6">
        <a href="/" class="flex items-center gap-2">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold">AP</div>
            <div>
                <h1 class="font-bold text-gray-900 leading-none">AST PAY</h1>
                <p class="text-xs text-gray-500">Marketing Internal</p>
            </div>
        </a>
    </div>

    <nav class="flex-1 px-4 py-4 space-y-1">
        @foreach($menuItems as $item)
            @php
                $isActive = request()->is(ltrim($item['href'], '/') ?: '/');
                if ($item['href'] === '/') $isActive = request()->path() === '/';
            @endphp
            <a href="{{ $item['href'] }}"
               class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg transition-colors
                      {{ $isActive ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                @include('icons.' . $item['icon'])
                {{ $item['name'] }}
            </a>
        @endforeach
    </nav>

    <div class="p-4 m-4 bg-blue-50 rounded-lg">
        <div class="flex items-center gap-2 mb-1">
            <div class="w-2 h-2 rounded-full bg-blue-600"></div>
            <p class="text-xs font-semibold text-blue-800">Role: {{ $userRole }}</p>
        </div>
        <p class="text-xs text-blue-600">
            {{ $isAdmin ? 'Akses penuh sistem' : 'Akses terbatas' }}
        </p>
    </div>
</div>
