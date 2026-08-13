@extends('layouts.app')

@section('title', 'Dashboard BPI')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
    /* ─── Base ─────────────────────────────────────── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    #dashBpi {
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 14px;
        color: #1e293b;
        background: #f8fafc;
        min-height: 100vh;
        padding: 28px 24px;
    }

    /* ─── Page header ──────────────────────────────── */
    .page-header { margin-bottom: 28px; }
    .page-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #1d4ed8;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 6px;
        padding: 3px 10px;
        margin-bottom: 10px;
    }
    .page-eyebrow i { font-size: 13px; }
    .page-title {
        font-size: 22px;
        font-weight: 600;
        color: #0f172a;
        letter-spacing: -0.3px;
        margin-bottom: 4px;
    }
    .page-subtitle { font-size: 13px; color: #64748b; line-height: 1.5; }

    /* ─── Metrics ──────────────────────────────────── */
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 28px;
    }
    @media (max-width: 700px) { .metrics-grid { grid-template-columns: 1fr; } }

    .metric-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .metric-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .metric-icon i { font-size: 19px; }
    .icon-green  { background: #f0fdf4; color: #16a34a; }
    .icon-red    { background: #fef2f2; color: #dc2626; }
    .icon-blue   { background: #eff6ff; color: #1d4ed8; }
    .metric-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #94a3b8;
    }
    .metric-value {
        font-size: 22px;
        font-weight: 600;
        color: #0f172a;
        line-height: 1;
    }
    .metric-value.green { color: #16a34a; }
    .metric-value.red   { color: #dc2626; }
    .metric-value.blue  { color: #1d4ed8; }
    .metric-note { font-size: 12px; color: #94a3b8; }

    /* ─── Section card ─────────────────────────────── */
    .section-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
    }
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
    }
    .section-header-left {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .section-header i { font-size: 17px; color: #64748b; }
    .section-title-text {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
    }
    .count-badge {
        background: #f1f5f9;
        color: #475569;
        font-size: 11px;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 20px;
    }

    /* ─── Table ────────────────────────────────────── */
    .data-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .data-table thead tr { background: #f8fafc; }
    .data-table th {
        padding: 10px 16px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #94a3b8;
        border-bottom: 1px solid #e2e8f0;
        text-align: left;
        white-space: nowrap;
    }
    .data-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        color: #334155;
    }
    .data-table tbody tr:last-child td { border-bottom: none; }
    .data-table tbody tr:hover { background: #fafafa; }
    .text-center { text-align: center !important; }
    .text-right  { text-align: right !important; }

    .td-title { font-weight: 500; color: #0f172a; }
    .td-sub   { font-size: 11px; color: #94a3b8; margin-top: 2px; letter-spacing: 0.03em; }
    .amount   { font-weight: 600; color: #1d4ed8; }

    /* ─── Badges ───────────────────────────────────── */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 9px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }
    .badge i { font-size: 11px; }
    .badge-yellow { background: #fefce8; color: #a16207; border: 1px solid #fde68a; }
    .badge-blue   { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .badge-green  { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .badge-red    { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
    .badge-gray   { background: #f8fafc; color: #475569; border: 1px solid #e2e8f0; }

    /* ─── Action button ────────────────────────────── */
    .btn-audit {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 500;
        border-radius: 7px;
        background: #1d4ed8;
        color: #ffffff;
        text-decoration: none;
        transition: background 0.15s;
        white-space: nowrap;
    }
    .btn-audit:hover { background: #1e40af; }
    .btn-audit i { font-size: 12px; }

    /* ─── Empty state ──────────────────────────────── */
    .empty-state td {
        text-align: center;
        padding: 48px 16px;
        color: #94a3b8;
        font-size: 13px;
    }
    .empty-state i { font-size: 32px; color: #cbd5e1; display: block; margin-bottom: 8px; }
</style>
@endsection

@section('content')
<div id="dashBpi">

    {{-- ── Page Header ─────────────────────────────── --}}
    <div class="page-header">
        <div class="page-eyebrow">
            <i class="ti ti-shield-check"></i> BPI — Finance &amp; Eksekutif
        </div>
        <h1 class="page-title">Dashboard Utama BPI</h1>
        <p class="page-subtitle">Ringkasan kondisi sirkulasi keuangan dan legalitas otorisasi dokumen organisasi BIOS.</p>
    </div>

    {{-- ── Metric Cards ─────────────────────────────── --}}
    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-icon icon-green"><i class="ti ti-circle-check"></i></div>
            <div>
                <div class="metric-label">Dana Keluar (Approved)</div>
                <div class="metric-value green">Rp {{ number_format($totalBudgetApproved, 0, ',', '.') }}</div>
                <div class="metric-note">Total akumulasi dana proker cair</div>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon icon-red"><i class="ti ti-clock-pause"></i></div>
            <div>
                <div class="metric-label">Estimasi Beban Kas (Pending)</div>
                <div class="metric-value red">Rp {{ number_format($totalBudgetDiajukan, 0, ',', '.') }}</div>
                <div class="metric-note">Dari antrean berkas masuk BPI</div>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon icon-blue"><i class="ti ti-files"></i></div>
            <div>
                <div class="metric-label">Antrean Berkas Masuk</div>
                <div class="metric-value blue">{{ $proposals->count() }} berkas</div>
                <div class="metric-note">Butuh tindakan review finansial</div>
            </div>
        </div>
    </div>

    {{-- ── Proposal Queue Table ─────────────────────── --}}
    <div class="section-card">
        <div class="section-header">
            <div class="section-header-left">
                <i class="ti ti-list-check"></i>
                <span class="section-title-text">Antrean berkas otorisasi finansial</span>
                <span class="count-badge">{{ $proposals->count() }}</span>
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Judul kegiatan</th>
                        <th>Divisi</th>
                        <th class="text-right">Estimasi kas</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($proposals as $proposal)
                    @php $status = strtolower($proposal->status); @endphp
                    <tr>
                        <td>
                            <div class="td-title">{{ $proposal->title }}</div>
                            <div class="td-sub">{{ \Carbon\Carbon::parse($proposal->event_date)->format('d M Y') }}</div>
                        </td>
                        <td style="color: #64748b;">{{ strtoupper($proposal->division) }}</td>
                        <td class="text-right amount">Rp {{ number_format($proposal->budget, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @if($status === 'menunggu_bph')
                                <span class="badge badge-yellow"><i class="ti ti-clock"></i> Filter BPH</span>
                            @elseif($status === 'menunggu_bpi')
                                <span class="badge badge-blue"><i class="ti ti-clock"></i> Review BPI</span>
                            @elseif($status === 'approved')
                                <span class="badge badge-green"><i class="ti ti-circle-check"></i> Selesai</span>
                            @else
                                <span class="badge badge-red"><i class="ti ti-alert-circle"></i> Butuh Revisi</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('proposal.show', $proposal->id) }}" class="btn-audit">
                                Audit <i class="ti ti-arrow-right"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-state">
                        <td colspan="5">
                            <i class="ti ti-inbox"></i>
                            Tidak ada antrean pengajuan anggaran baru saat ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection