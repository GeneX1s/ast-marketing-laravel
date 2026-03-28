<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KampanyeController;
use App\Http\Controllers\LaporanSalesController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\PengaturanSistemController;

// =====================
// AUTH ROUTES (Guest only)
// =====================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// =====================
// PROTECTED ROUTES
// =====================
Route::middleware(['auth', \App\Http\Middleware\CheckPermission::class])->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Kampanye
    Route::get('/kampanye', [KampanyeController::class, 'index'])->name('kampanye.index');
    Route::post('/kampanye', [KampanyeController::class, 'store'])->name('kampanye.store');
    Route::put('/kampanye/{kampanye}', [KampanyeController::class, 'update'])->name('kampanye.update');
    Route::delete('/kampanye/{kampanye}', [KampanyeController::class, 'destroy'])->name('kampanye.destroy');

    // Laporan Sales
    Route::get('/laporan-sales', [LaporanSalesController::class, 'index'])->name('laporan-sales.index');
    Route::post('/laporan-sales', [LaporanSalesController::class, 'storeSale'])->name('laporan-sales.store');

    // Referral
    Route::get('/referral', [ReferralController::class, 'index'])->name('referral.index');

    // Form Pengajuan
    Route::get('/form-pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');
    Route::post('/form-pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');
    Route::put('/form-pengajuan/{pengajuan}/status', [PengajuanController::class, 'updateStatus'])->name('pengajuan.updateStatus');
    Route::delete('/form-pengajuan/{pengajuan}', [PengajuanController::class, 'destroy'])->name('pengajuan.destroy');

    // Pengaturan Sistem (Admin only — enforced by CheckPermission middleware)
    Route::get('/pengaturan-sistem', [PengaturanSistemController::class, 'index'])->name('pengaturan-sistem.index');
    Route::post('/pengaturan-sistem/users', [PengaturanSistemController::class, 'storeUser'])->name('pengaturan-sistem.storeUser');
    Route::put('/pengaturan-sistem/users/{user}', [PengaturanSistemController::class, 'updateUser'])->name('pengaturan-sistem.updateUser');
    Route::put('/pengaturan-sistem/users/{user}/toggle', [PengaturanSistemController::class, 'toggleUserStatus'])->name('pengaturan-sistem.toggleStatus');
    Route::delete('/pengaturan-sistem/users/{user}', [PengaturanSistemController::class, 'destroyUser'])->name('pengaturan-sistem.destroyUser');
    Route::put('/pengaturan-sistem/permission-groups/{group}', [PengaturanSistemController::class, 'updatePermissionGroup'])->name('pengaturan-sistem.updatePermissions');

    // Profil & Pengaturan Akun (always accessible)
    Route::get('/profil', function () {
        return view('profil.index');
    })->name('profil.index');

    Route::get('/pengaturan', function () {
        return view('pengaturan.index');
    })->name('pengaturan.index');
});
