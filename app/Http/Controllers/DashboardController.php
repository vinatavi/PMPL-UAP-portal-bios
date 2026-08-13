<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposal;
use App\Models\CashFlow; // WAJIB IMPORT MODEL CASHFLOW BARU

class DashboardController extends Controller
{
    // Menampilkan Dashboard Staff
    public function staff()
    {
        $proposals = Proposal::latest()->get();
        return view('staff', compact('proposals')); 
    }

    // Menampilkan Dashboard BPH
    public function bph()
    {
        $proposals = Proposal::where('status', 'menunggu_bph')->latest()->get();
        return view('bph', compact('proposals'));
    }

    // Menampilkan Dashboard Utama BPI (File: bpi.blade.php)
    public function review()
    {
        $proposals = Proposal::whereIn('status', ['menunggu_bpi', 'butuh revisi'])->latest()->get();
        
        $totalBudgetApproved = Proposal::where('status', 'approved')->sum('budget');
        $totalBudgetDiajukan = Proposal::whereIn('status', ['menunggu_bpi', 'butuh revisi'])->sum('budget');

        return view('bpi', compact('proposals', 'totalBudgetApproved', 'totalBudgetDiajukan')); 
    }
    
    // Menampilkan Dashboard Khusus Finance BPI (File: finance.blade.php)
    public function finance()
    {
        // 1. Data Utama Tabel: Semua proposal & yang masih antrean pencairan dana
        $allProposals = Proposal::latest()->get();
        $pendingProposals = Proposal::whereIn('status', ['menunggu_bpi', 'butuh revisi'])->latest()->get();

        // 2. KORELASI DATA STATISTIK KEUANGAN DINAMIS
        // Hitung total uang kas masuk tambahan dari database, lalu tambahkan modal awal Rp 50.000.000
        $danaSponsorMasuk = CashFlow::where('type', 'pemasukan')->sum('amount');
        $totalKasOrganisasi = 50000000 + $danaSponsorMasuk; 

        $totalDanaCair = Proposal::where('status', 'approved')->sum('budget');
        $totalDanaPending = Proposal::whereIn('status', ['menunggu_bpi', 'butuh revisi'])->sum('budget');
        $sisaKasSekarang = $totalKasOrganisasi - $totalDanaCair;

        // 3. HITUNG PENGELUARAN PER DIVISI (Untuk Keperluan Analisis Anggaran)
        $divisiStats = Proposal::where('status', 'approved')
            ->selectRaw('division, SUM(budget) as total_budget')
            ->groupBy('division')
            ->get();

        // 4. RIWAYAT KAS MASUK (Untuk ditampilkan di buku harian dana tambahan)
        $cashInflows = CashFlow::where('type', 'pemasukan')->latest()->take(5)->get();

        // Mengarah langsung ke file 'finance.blade.php' dengan membawa semua variabel pelengkap
        return view('finance', compact(
            'allProposals',
            'pendingProposals',
            'totalKasOrganisasi',
            'totalDanaCair',
            'totalDanaPending',
            'sisaKasSekarang',
            'divisiStats',
            'cashInflows'
        ));
    }

    // METHOD BARU: Menyimpan Uang Kas Masuk dari Form Manual Bendahara
    public function storeCashFlow(Request $request)
    {
        $request->validate([
            'source' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string'
        ]);

        CashFlow::create([
            'type' => 'pemasukan',
            'source' => $request->source,
            'amount' => $request->amount,
            'description' => $request->description
        ]);

        return redirect()->route('dashboard.finance')->with('success', 'Dana pemasukan kas berhasil dibukukan!');
    }

    // Menampilkan Kalender
    public function calendar()
    {
        // Ambil semua proposal untuk dijadikan event/aktivitas di kalender
        $proposals = Proposal::all();
        
        $events = [];
        foreach ($proposals as $proposal) {
            $events[] = [
                'title' => '[' . strtoupper($proposal->division) . '] ' . $proposal->title,
                'start' => $proposal->event_date, // Format wajib: YYYY-MM-DD
                'color' => $proposal->status === 'approved' ? '#22c55e' : '#0f4fcf', // Hijau jika sah, Biru jika proses
                'url'   => route('proposal.show', $proposal->id) // Klik event langsung buka detail berkas
            ];
        }

        // Kirim data $events dalam bentuk JSON ke view calendar
        return view('calendar', ['events' => json_encode($events)]);
    }
}