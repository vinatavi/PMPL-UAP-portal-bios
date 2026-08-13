@extends('layouts.app')

@section('title', 'Daftar Proposal')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
    /* ─── Grid ─────────────────────────────────────── */
    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 24px;
    }

    /* ─── Proposal Card ────────────────────────────── */
    .proposal-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.15s, box-shadow 0.15s;
    }
    .proposal-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    }

    .card-banner {
        height: 130px;
        background-image:
            linear-gradient(to bottom, rgba(15, 79, 207, 0.85), rgba(15, 79, 207, 0.6)),
            url('https://cdn-web.ruangguru.com/landing-pages/assets/hs/mengenal-proposal.jpg');
        background-size: cover;
        background-position: center;
        padding: 16px;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        box-sizing: border-box;
    }
    .banner-budget {
        color: white;
        font-size: 13px;
        font-weight: 600;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3);
    }

    .card-body {
        padding: 18px 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .card-body h3 {
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 12px;
        color: #0f172a;
        line-height: 1.4;
    }

    .meta-info {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 13px;
        color: #64748b;
        margin-bottom: 7px;
    }
    .meta-info i { font-size: 14px; }

    /* ─── Add-new card ─────────────────────────────── */
    .add-new-card {
        border: 1.5px dashed #cbd5e1;
        background: transparent;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 40px 20px;
        border-radius: 14px;
        text-decoration: none;
        color: #64748b;
        min-height: 280px;
        box-sizing: border-box;
        transition: border-color 0.15s, color 0.15s, background 0.15s;
    }
    .add-new-card:hover {
        border-color: #1d4ed8;
        color: #1d4ed8;
        background: #eff6ff;
    }
    .add-new-card i { font-size: 28px; margin-bottom: 8px; display: block; }

    /* ─── Badges ───────────────────────────────────── */
    .badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        border: 1px solid rgba(255,255,255,0.2);
    }
    .badge-pending   { background: rgba(254,252,232,0.9); color: #92400e; }
    .badge-wait-bpi { background: rgba(240,249,255,0.9); color: #075985; }
    .badge-revisi   { background: rgba(254,242,242,0.9); color: #991b1b; }
    .badge-active   { background: rgba(240,253,244,0.9); color: #166534; }
    .badge-secondary{ background: rgba(248,250,252,0.9); color: #475569; }

    /* ─── Action buttons ────────────────────────────── */
    .action-buttons {
        display: flex;
        gap: 8px;
        margin-top: 14px;
    }
    .btn-detail {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 9px 14px;
        font-size: 13px;
        font-weight: 500;
        border-radius: 8px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #334155;
        text-decoration: none;
        transition: background 0.15s;
    }
    .btn-detail:hover { background: #f1f5f9; }
    .btn-detail i { font-size: 14px; }

    .btn-revisi-action {
        background: #fff7ed;
        border: 1px solid #ffedd5;
        color: #ea580c;
    }
    .btn-revisi-action:hover { background: #ffedd5; }

    /* ─── Desain Komponen Notifikasi Database ─── */
    .alert-db {
        display: flex;
        gap: 14px;
        border-radius: 12px;
        padding: 16px 20px;
        margin-top: 20px;
        margin-bottom: 10px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }
    .alert-db i { font-size: 22px; flex-shrink: 0; margin-top: 1px; }
    .alert-db h4 { font-size: 14px; font-weight: 700; margin: 0 0 4px 0; }
    .alert-db p { font-size: 13px; margin: 0; line-height: 1.4; }
</style>
@endsection

@section('content')

{{-- ─── HEADER DINAMIS (BPH / STAFF) ─── --}}
<div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px;">
    <div>
        @if(Auth::user() && strtolower(Auth::user()->role) === 'bph')
            <h1 style="font-size: 20px; font-weight: 600; color: #0f172a;">Panel Pengawasan BPH</h1>
            <p style="color: #64748b; font-size: 13px; margin-top: 4px;">Validasi draf staff sebelum diteruskan ke tingkat pimpinan eksekutif BPI.</p>
        @else
            <h1 style="font-size: 20px; font-weight: 600; color: #0f172a;">Arsip Dokumen Proposal</h1>
            <p style="color: #64748b; font-size: 13px; margin-top: 4px;">Pantau sirkulasi berkas digital internal BIOS secara transparan.</p>
        @endif
    </div>

    {{-- Tombol Ajun Tambahan Di Kanan Atas Khusus Akses Cepat --}}
    @if(in_array(strtolower(Auth::user()->role ?? ''), ['staff', 'bph']))
        <a href="{{ route('proposal.form') }}" class="btn-detail" style="background: #2563eb; color: #ffffff; border-color: #2563eb; padding: 10px 18px; font-weight: 600; width: auto; flex: none;">
            <i class="ti ti-plus"></i> Ajukan proker divisi
        </a>
    @endif
</div>

{{-- ─── NOTIFIKASI AKTIF BERDASARKAN STATUS DATABASE UNTUK STAFF SAJA ─── --}}
@if(Auth::user() && strtolower(Auth::user()->role) === 'staff' && isset($latestProposal))
    
    {{-- ALERT APABILA STATUS PROPOSAL BERUBAH MENJADI BUTUH REVISI --}}
    @if(in_array(strtolower($latestProposal->status), ['butuh revisi', 'revisi']))
    <div class="alert-db" style="background: #fef2f2; border-left: 4px solid #ef4444;">
        <i class="ti ti-alert-triangle" style="color: #ef4444;"></i>
        <div>
            <h4 style="color: #991b1b;">⚠️ Perhatian: Dokumen Perlu Perbaikan!</h4>
            <p style="color: #7f1d1d; margin-bottom: 8px;">
                Proposal proker Anda yang berjudul <strong>"{{ $latestProposal->title }}"</strong> dikembalikan oleh pimpinan karena membutuhkan revisi.
            </p>
            @if($latestProposal->notes)
                <div style="background: #ffffff; padding: 10px 14px; border-radius: 8px; border: 1px solid #fee2e2; font-size: 12px; color: #dc2626; font-style: italic; margin-bottom: 10px;">
                    <strong>Catatan Revisi:</strong> {{ $latestProposal->notes }}
                </div>
            @endif
            <a href="{{ route('proposal.edit', $latestProposal->id) }}" class="btn-detail btn-revisi-action" style="display: inline-flex; width: auto; padding: 6px 14px; font-size: 12px; font-weight: 600; border-radius: 6px;">
                <i class="ti ti-edit"></i> Edit & Upload Ulang Berkas
            </a>
        </div>
    </div>
    @endif

    {{-- ALERT APABILA STATUS PROPOSAL BERUBAH MENJADI APPROVED --}}
    @if(strtolower($latestProposal->status) === 'approved')
    <div class="alert-db" style="background: #f0fdf4; border-left: 4px solid #10b981;">
        <i class="ti ti-circle-check" style="color: #10b981;"></i>
        <div>
            <h4 style="color: #065f46;">🎉 Selamat! Proposal Disetujui</h4>
            <p style="color: #047857;">
                Proposal program kerja terbaru Anda <strong>"{{ $latestProposal->title }}"</strong> telah lolos validasi penuh dan statusnya kini <strong>Approved</strong>.
            </p>
        </div>
    </div>
    @endif

@endif

{{-- ─── GRID CONTAINER ─── --}}
<div class="grid-container">
    @foreach($proposals as $proposal)
    <div class="proposal-card">
        <div class="card-banner">
            @php $status = strtolower($proposal->status); @endphp

            @if($status === 'menunggu_bph')
                <span class="badge badge-pending">Menunggu BPH</span>
            @elseif($status === 'menunggu_bpi')
                <span class="badge badge-wait-bpi">Menunggu BPI</span>
            @elseif(in_array($status, ['butuh revisi', 'revisi']))
                <span class="badge badge-revisi">Butuh Revisi</span>
            @elseif($status === 'approved')
                <span class="badge badge-active">Approved</span>
            @else
                <span class="badge badge-secondary">{{ $proposal->status }}</span>
            @endif

            <span class="banner-budget">Rp {{ number_format($proposal->budget, 0, ',', '.') }}</span>
        </div>

        <div class="card-body">
            <h3>{{ $proposal->title }}</h3>

            <div class="meta-info">
                <i class="ti ti-calendar-event" aria-hidden="true"></i>
                <span>{{ \Carbon\Carbon::parse($proposal->event_date)->format('d M Y') }}</span>
            </div>
            <div class="meta-info">
                <i class="ti ti-users" aria-hidden="true"></i>
                <span>Divisi {{ strtoupper($proposal->division) }}</span>
            </div>

            <div class="action-buttons">
                <a href="{{ route('proposal.show', $proposal->id) }}" class="btn-detail">
                    Detail <i class="ti ti-arrow-right"></i>
                </a>
                
                {{-- Tombol Khusus Perbaiki Berkas jika statusnya sedang butuh revisi --}}
                @if(in_array($status, ['butuh revisi', 'revisi']) && strtolower(Auth::user()->role ?? '') === 'staff')
                    <a href="{{ route('proposal.edit', $proposal->id) }}" class="btn-detail btn-revisi-action">
                        <i class="ti ti-edit"></i> Perbaiki Berkas
                    </a>
                @endif
            </div>
        </div>
    </div>
    @endforeach

    @if(in_array(strtolower(Auth::user()->role ?? ''), ['staff', 'bph']))
    <a href="{{ route('proposal.form') }}" class="add-new-card">
        <div>
            <i class="ti ti-plus"></i>
            <div style="font-size: 14px; font-weight: 500; margin-bottom: 4px;">Tambah Proposal</div>
            <div style="font-size: 12px;">Buat usulan proker baru</div>
        </div>
    </a>
    @endif
</div>

@endsection