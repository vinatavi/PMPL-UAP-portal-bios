@extends('layouts.app')

@section('title', 'Dashboard Staff')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    #dashStaff {
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 14px;
        color: #1e293b;
        background: #f8fafc;
        min-height: 100vh;
        padding: 28px 24px;
    }

    .page-eyebrow {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em;
        color: #0369a1; background: #f0f9ff; border: 1px solid #bae6fd;
        border-radius: 6px; padding: 3px 10px; margin-bottom: 10px;
    }
    .page-eyebrow i { font-size: 13px; }
    .page-title { font-size: 22px; font-weight: 600; color: #0f172a; letter-spacing: -0.3px; margin-bottom: 4px; }
    .page-subtitle { font-size: 13px; color: #64748b; line-height: 1.5; margin-bottom: 28px; }

    .alert {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 16px; border-radius: 10px; font-size: 13px; font-weight: 500;
        margin-bottom: 20px;
    }
    .alert i { font-size: 16px; flex-shrink: 0; }
    .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }

    .action-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 28px;
    }
    .action-card {
        background: #fff; border: 1px solid #e2e8f0; border-radius: 14px;
        padding: 20px; display: flex; flex-direction: column;
        justify-content: space-between; gap: 14px;
    }
    .action-card-icon {
        width: 36px; height: 36px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 2px;
    }
    .action-card-icon i { font-size: 18px; }
    .icon-blue  { background: #eff6ff; color: #1d4ed8; }
    .icon-slate { background: #f1f5f9; color: #475569; }
    .icon-teal  { background: #f0fdfa; color: #0f766e; }
    .action-card h3 { font-size: 14px; font-weight: 600; color: #0f172a; margin-bottom: 4px; }
    .action-card p  { font-size: 12px; color: #64748b; line-height: 1.5; }

    .btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 6px;
        padding: 9px 14px; font-size: 13px; font-weight: 500;
        border-radius: 8px; cursor: pointer; text-decoration: none; font-family: inherit;
        border: 1px solid transparent; transition: opacity 0.15s;
    }
    .btn i { font-size: 14px; }
    .btn:hover { opacity: 0.88; }
    .btn-primary { background: #1d4ed8; color: #fff; border-color: #1e40af; }
    .btn-default { background: #fff; color: #334155; border-color: #e2e8f0; }
    .btn-sm { padding: 5px 10px; font-size: 12px; }

    .section-card {
        background: #fff; border: 1px solid #e2e8f0;
        border-radius: 14px; overflow: hidden;
    }
    .section-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 16px 20px; border-bottom: 1px solid #f1f5f9;
    }
    .section-header-left { display: flex; align-items: center; gap: 8px; }
    .section-header i { font-size: 17px; color: #64748b; }
    .section-title-text { font-size: 14px; font-weight: 600; color: #1e293b; }
    .count-badge {
        background: #f1f5f9; color: #475569; font-size: 11px; font-weight: 600;
        padding: 2px 8px; border-radius: 20px;
    }

    .data-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .data-table thead tr { background: #f8fafc; }
    .data-table th {
        padding: 10px 16px; font-size: 11px; font-weight: 600;
        text-transform: uppercase; letter-spacing: 0.04em;
        color: #94a3b8; border-bottom: 1px solid #e2e8f0;
        text-align: left; white-space: nowrap;
    }
    .data-table td {
        padding: 14px 16px; border-bottom: 1px solid #f1f5f9;
        vertical-align: top; color: #334155;
    }
    .data-table tbody tr:last-child td { border-bottom: none; }
    .data-table tbody tr:hover { background: #fafafa; }
    .td-title { font-weight: 500; color: #0f172a; }
    .td-sub   { font-size: 11px; color: #94a3b8; margin-top: 2px; }

    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 9px; border-radius: 6px; font-size: 11px; font-weight: 600;
    }
    .badge i { font-size: 11px; }
    .badge-yellow { background: #fefce8; color: #a16207; border: 1px solid #fde68a; }
    .badge-blue   { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .badge-green  { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .badge-red    { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
    .badge-gray   { background: #f8fafc; color: #475569; border: 1px solid #e2e8f0; }

    .revisi-box {
        margin-top: 8px; background: #fef2f2;
        border-left: 3px solid #ef4444; border-radius: 0 6px 6px 0;
        padding: 8px 10px;
    }
    .revisi-box-label {
        color: #991b1b; font-size: 11px; font-weight: 600;
        text-transform: uppercase; letter-spacing: 0.04em;
        display: block; margin-bottom: 3px;
    }
    .revisi-box-text { color: #b91c1c; font-size: 12px; margin: 0; line-height: 1.4; font-style: italic; }

    .empty-state td { text-align: center; padding: 48px 16px; color: #94a3b8; font-size: 13px; }
    .empty-state i { font-size: 32px; color: #cbd5e1; display: block; margin-bottom: 8px; }
</style>
@endsection

@section('content')
<div id="dashStaff">

    <div class="page-eyebrow">
        <i class="ti ti-user-check"></i> Staff — Pengajuan Kegiatan
    </div>
    <h1 class="page-title">Halaman Kerja Staff</h1>
    <p class="page-subtitle">Kelola pengajuan berkas, pantau sirkulasi validasi, dan lihat agenda kegiatan organisasi.</p>

    @if(session('success'))
    <div class="alert alert-success">
        <i class="ti ti-circle-check"></i> {{ session('success') }}
    </div>
    @endif

    {{-- ── Action Cards ─────────────────────────────── --}}
    <div class="action-grid">
        <div class="action-card">
            <div>
                <div class="action-card-icon icon-blue"><i class="ti ti-file-plus"></i></div>
                <h3>Buat Pengajuan Baru</h3>
                <p>Isi formulir digital untuk mendaftarkan proposal kegiatan divisi Anda ke sistem.</p>
            </div>
            <a href="{{ route('proposal.form') }}" class="btn btn-primary">
                <i class="ti ti-edit"></i> Mulai Isi Formulir
            </a>
        </div>

        <div class="action-card">
            <div>
                <div class="action-card-icon icon-teal"><i class="ti ti-calendar-event"></i></div>
                <h3>Kalender Kegiatan</h3>
                <p>Lihat jadwal pelaksanaan acara internal seluruh divisi agar tidak terjadi bentrok.</p>
            </div>
            <a href="{{ route('dashboard.calendar') }}" class="btn btn-default">
                <i class="ti ti-calendar"></i> Buka Kalender
            </a>
        </div>

        <div class="action-card">
            <div>
                <div class="action-card-icon icon-slate"><i class="ti ti-archive"></i></div>
                <h3>Arsip Dokumen</h3>
                <p>Lihat seluruh file proposal digital yang telah menyelesaikan validasi akhir.</p>
            </div>
            <a href="{{ route('proposal.list') }}" class="btn btn-default">
                <i class="ti ti-folders"></i> Lihat Arsip
            </a>
        </div>
    </div>

    {{-- ── Proposal History Table ───────────────────── --}}
    <div class="section-card">
        <div class="section-header">
            <div class="section-header-left">
                <i class="ti ti-history"></i>
                <span class="section-title-text">Riwayat proposal saya</span>
                <span class="count-badge">{{ $proposals->count() }}</span>
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Judul kegiatan</th>
                        <th>Divisi</th>
                        <th>Tanggal acara</th>
                        <th>Status</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($proposals as $proposal)
                    @php $status = strtolower($proposal->status); @endphp
                    <tr>
                        <td>
                            <div class="td-title">{{ $proposal->title }}</div>
                            <div class="td-sub">{{ strtoupper($proposal->division) }}</div>
                        </td>
                        <td style="color: #64748b;">{{ ucfirst($proposal->division) }}</td>
                        <td style="color: #64748b; white-space: nowrap;">
                            {{ \Carbon\Carbon::parse($proposal->event_date)->format('d M Y') }}
                        </td>
                        <td>
                            @if($status === 'menunggu_bph')
                                <span class="badge badge-yellow">
                                    <i class="ti ti-clock"></i> Menunggu BPH
                                </span>
                            @elseif($status === 'menunggu_bpi')
                                <span class="badge badge-blue">
                                    <i class="ti ti-send"></i> Menunggu BPI
                                </span>
                            @elseif($status === 'approved')
                                <span class="badge badge-green">
                                    <i class="ti ti-circle-check"></i> Selesai / Approved
                                </span>
                            @elseif($status === 'butuh revisi' || $status === 'revisi')
                                <div>
                                    <span class="badge badge-red">
                                        <i class="ti ti-alert-circle"></i> Butuh Revisi
                                    </span>
                                    @if($proposal->notes)
                                    <div class="revisi-box">
                                        <strong class="revisi-box-label">Catatan revisi</strong>
                                        <p class="revisi-box-text">"{{ $proposal->notes }}"</p>
                                    </div>
                                    @endif
                                </div>
                            @else
                                <span class="badge badge-gray">
                                    <i class="ti ti-point"></i> {{ strtoupper($proposal->status) }}
                                </span>
                            @endif
                        </td>
                        <td style="text-align: center; vertical-align: top; padding-top: 18px;">
                            <a href="{{ route('proposal.show', $proposal->id) }}" class="btn btn-default btn-sm">
                                <i class="ti ti-eye"></i> Lihat Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-state">
                        <td colspan="5">
                            <i class="ti ti-inbox"></i>
                            Belum ada riwayat pengajuan proposal.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection