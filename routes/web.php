<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\DashboardController;

// =========================================================================
// RUTE PUBLIK (Bisa diakses langsung tanpa login)
// =========================================================================

// Landing Page Utama (Menampilkan profil, logo, pengertian, dan divisi BIOS)
Route::get('/', function () {
    return view('welcome');
});

// Jalur Masuk Sistem (Halaman Login)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);


// =========================================================================
// RUTE PRIVATE (Wajib login terlebih dahulu)
// =========================================================================
Route::middleware(['auth'])->group(function () {
    
    // Rute Keluar Sistem
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // 1. AKSES VALIDASI KHUSUS BPI, FINANCE, & PRESDIR 
    Route::middleware(['role:bpi,presdir,admin'])->group(function () {
        // Rute statis review proposal
        Route::get('/proposal/review', [DashboardController::class, 'review'])->name('proposal.review');
        
        // Sinkronisasi Halaman Dashboard BPI & Review
        Route::get('/dashboard/review', [DashboardController::class, 'review'])->name('dashboard.review');
        Route::get('/dashboard/bpi', [DashboardController::class, 'review'])->name('dashboard.bpi');
        
        // Otoritas Khusus Fitur Finansial Terpusat
        Route::get('/dashboard/finance', [DashboardController::class, 'finance'])->name('dashboard.finance');
        Route::post('/dashboard/finance/cashflow', [DashboardController::class, 'storeCashFlow'])->name('finance.cashflow.store');
        
        Route::post('/proposal/{id}/approve-bpi', [ProposalController::class, 'approveBpi'])->name('proposal.approve.bpi');
        Route::post('/proposal/{id}/revisi-bpi', [ProposalController::class, 'revisiBpi'])->name('proposal.revisi.bpi');
    });

    // 2. AKSES PEMBUATAN & REVISI PROPOSAL (STAFF, BPH, & ADMIN)
    Route::middleware(['role:staff,bph,admin'])->group(function () {
        Route::get('/proposal-form', [ProposalController::class, 'create'])->name('proposal.form');
        Route::post('/proposal-form', [ProposalController::class, 'store'])->name('proposal.submit');
        
        // Manajemen revisi dan pengiriman ulang dokumen
        Route::get('/proposal-form/{id}/edit', [ProposalController::class, 'edit'])->name('proposal.edit');
        Route::put('/proposal-form/{id}', [ProposalController::class, 'update'])->name('proposal.update');
    });

    // 3. AKSES EXCLUSIVE DASHBOARD STAFF
    Route::middleware(['role:staff,admin'])->group(function () {
        Route::get('/dashboard/staff', [DashboardController::class, 'staff'])->name('dashboard.staff');
    });

    // 4. AKSES VALIDASI KHUSUS BPH & DASHBOARD BPH
    Route::middleware(['role:bph'])->group(function () {
        Route::get('/dashboard/bph', [DashboardController::class, 'bph'])->name('dashboard.bph');
        Route::post('/proposal/{id}/approve-bph', [ProposalController::class, 'approveBph'])->name('proposal.approve.bph');
        Route::post('/proposal/{id}/revisi-bph', [ProposalController::class, 'revisiBph'])->name('proposal.revisi.bph');
    });

    // 5. AKSES BERSAMA MULTI-ROLE (Staff, BPH, BPI, Presdir, Admin)
    Route::middleware(['role:staff,bph,bpi,presdir,admin'])->group(function () {
        Route::get('/proposal', [ProposalController::class, 'proposalList'])->name('proposal.list');
        Route::get('/proposals', [ProposalController::class, 'proposalList']);
        
        // Rute wildcard ditaruh di paling bawah agar tidak mengacaukan rute statis di atasnya
        Route::get('/proposal/{proposal}', [ProposalController::class, 'show'])->name('proposal.show');
    });

    // Kalender Kegiatan Bersama
    Route::get('/dashboard/calendar', [DashboardController::class, 'calendar'])->name('dashboard.calendar');
});
