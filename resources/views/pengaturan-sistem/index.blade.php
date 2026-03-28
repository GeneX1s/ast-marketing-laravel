@extends('layouts.app')

@section('title', 'Pengaturan Sistem / RBAC')

@section('content')
<div class="mb-8 flex justify-between items-start" x-data="{ showUserModal: false }">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Pengaturan Sistem (RBAC)</h1>
        <p class="text-gray-500 mt-1">Kelola Pengguna, Peran, dan Hak Akses sistem.</p>
    </div>

    @if($tab === 'users')
    <button @click="showUserModal = true" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
        Tambah Pengguna Baru
    </button>
    @endif
    
    <!-- Tambah User Modal -->
    <div x-show="showUserModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display: none;">
        <div @click.outside="showUserModal = false" class="bg-white rounded-2xl w-full max-w-md p-6 shadow-xl">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Tambah Pengguna</h3>
            <form action="{{ route('pengaturan-sistem.storeUser') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" required class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" required class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role / Peran</label>
                        <select name="role" required class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Password default: <code class="bg-gray-100 px-1 py-0.5 rounded text-red-600 font-mono">password123</code></p>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="showUserModal = false" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 font-medium">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden min-h-[500px]">
    <!-- Tabs Header -->
    <div class="flex border-b border-gray-200 bg-gray-50/50">
        <a href="?tab=users" class="px-6 py-4 text-sm font-medium border-b-2 {{ $tab === 'users' ? 'border-blue-600 text-blue-600 bg-white' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            Manajemen Pengguna
        </a>
        <a href="?tab=permissions" class="px-6 py-4 text-sm font-medium border-b-2 {{ $tab === 'permissions' ? 'border-blue-600 text-blue-600 bg-white' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            Hak Akses (Peran)
        </a>
        <a href="?tab=logs" class="px-6 py-4 text-sm font-medium border-b-2 {{ $tab === 'logs' ? 'border-blue-600 text-blue-600 bg-white' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            Activity Log
        </a>
    </div>

    <!-- Tab Content -->
    <div class="p-0">
        @if($tab === 'users')
            <!-- Users Tab -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-gray-50 border-b border-gray-200 text-gray-600 font-medium">
                        <tr>
                            <th class="px-6 py-4">Pengguna</th>
                            <th class="px-6 py-4">Role / Peran</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($users as $u)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-900">{{ $u->name }}</p>
                                <p class="text-gray-500 text-xs mt-0.5">{{ $u->email }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                    {{ $u->role?->name ?? 'Tanpa Peran' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full {{ $u->status ? 'bg-green-500' : 'bg-red-500' }}"></div>
                                    <span class="text-gray-600">{{ $u->status ? 'Aktif' : 'Non-Aktif' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2" x-data="{ showEditModal: false }">
                                    <!-- Toggle Status -->
                                    <form action="{{ route('pengaturan-sistem.toggleStatus', $u) }}" method="POST">
                                        @csrf @method('PUT')
                                        <button type="submit" class="text-xs font-medium px-2 py-1 rounded {{ $u->status ? 'text-orange-600 hover:bg-orange-50 bg-orange-50/50' : 'text-green-600 hover:bg-green-50 bg-green-50/50' }}">
                                            {{ $u->status ? 'Non-Aktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>

                                    <!-- Delete -->
                                    @if(auth()->id() !== $u->id)
                                    <form action="{{ route('pengaturan-sistem.destroyUser', $u) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengguna ini secara permanen?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs font-medium px-2 py-1 rounded text-red-600 hover:bg-red-50 bg-red-50/50">Hapus</button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @elseif($tab === 'permissions')
            <!-- Permissions Tab -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($permissionGroups as $group)
                    <div class="border border-gray-200 rounded-xl overflow-hidden" x-data="{ editing: false }">
                        <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex justify-between items-center">
                            <h4 class="font-bold text-gray-900">{{ $group->name }}</h4>
                            <button @click="editing = !editing" class="text-xs font-medium text-blue-600 hover:text-blue-800" x-text="editing ? 'Batal' : 'Edit Hak Akses'"></button>
                        </div>
                        <div class="p-4 bg-white min-h-[200px]">
                            <!-- View Mode -->
                            <div x-show="!editing">
                                @php
                                    $groupPerms = $group->permissions->pluck('name')->toArray();
                                @endphp
                                @if(empty($groupPerms))
                                    <p class="text-sm text-gray-500 italic">Belum ada hak akses.</p>
                                @else
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($groupPerms as $permName)
                                            <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded border border-gray-200">{{ $permName }}</span>
                                        @endforeach
                                    </div>
                                @endif
                                
                                @if($group->name === 'Admin Group')
                                <div class="mt-4 p-3 bg-blue-50 border border-blue-100 rounded-lg text-xs text-blue-800 flex items-start gap-2">
                                    <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p>Admin memiliki Bypass penuh ke semua fitur terlepas dari perizinan yang dicentang.</p>
                                </div>
                                @endif
                            </div>

                            <!-- Edit Mode -->
                            <div x-show="editing" style="display: none;">
                                <form action="{{ route('pengaturan-sistem.updatePermissions', $group) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="space-y-3 max-h-60 overflow-y-auto mb-4 pr-2">
                                        @php
                                            $currentPermIds = $group->permissions->pluck('id')->toArray();
                                        @endphp
                                        @foreach($permissions as $p)
                                        <label class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded cursor-pointer border border-transparent hover:border-gray-100">
                                            <input type="checkbox" name="permissions[]" value="{{ $p->id }}" 
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                                                {{ in_array($p->id, $currentPermIds) ? 'checked' : '' }}>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 leading-none">{{ $p->name }}</p>
                                                <p class="text-xs text-gray-500 mt-1">Modul: {{ $p->page }} / Aksi: {{ $p->action }}</p>
                                            </div>
                                        </label>
                                        @endforeach
                                    </div>
                                    <button type="submit" class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">Simpan Perubahan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>

        @elseif($tab === 'logs')
            <!-- Activity Log Tab -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-gray-50 border-b border-gray-200 text-gray-600 font-medium">
                        <tr>
                            <th class="px-6 py-4">Waktu</th>
                            <th class="px-6 py-4">Pengguna</th>
                            <th class="px-6 py-4">Modul / Aksi</th>
                            <th class="px-6 py-4">Deskripsi</th>
                            <th class="px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($activities as $log)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3 text-gray-500">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                            <td class="px-6 py-3 font-medium text-gray-800">{{ $log->user }}</td>
                            <td class="px-6 py-3">
                                <span class="font-medium text-gray-700">{{ $log->module }}</span>
                                <span class="mx-1 text-gray-300">/</span>
                                <span class="text-xs font-bold text-blue-600 tracking-wider">{{ $log->action }}</span>
                            </td>
                            <td class="px-6 py-3 text-gray-600 max-w-[300px] truncate" title="{{ $log->description }}">
                                {{ $log->description }}
                            </td>
                            <td class="px-6 py-3">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold tracking-wider {{ $log->result === 'SUCCESS' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $log->result }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">Belum ada aktivitas yang terekam.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
