@extends('layouts.app')

@section('title', 'BPI Approval')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
    /* ─── Page header ──────────────────────────────── */
    .page-header {
        margin-bottom: 24px;
    }
    .page-title {
        font-size: 20px;
        font-weight: 600;
        color: #0f172a;
    }
    .page-subtitle {
        font-size: 13px;
        color: #64748b;
        margin-top: 4px;
        line-height: 1.5;
    }

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
        gap: 8px;
        padding: 14px 18px;
        border-bottom: 1px solid #f1f5f9;
    }
    .section-header i { font-size: 17px; color: #64748b; }
    .section-header span {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
    }

    /* ─── Table ────────────────────────────────────── */
    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .data-table thead tr { background: #f8fafc; }
    .data-table th {
        padding: 10px 16px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #64748b;
        border-bottom: 1px solid #e2e8f0;
        text-align: left;
        white-space: nowrap;
    }
    .data-table td {
        padding: 12px 16px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .data-table tbody tr:last-child td { border-bottom: none; }
    .data-table tbody tr:hover { background: #f8fafc; }
    .text-center { text-align: center !important; }
    .text-right  { text-align: right !important; }

    /* ─── Amount & division ────────────────────────── */
    .amount-blue { color: #1d4ed8; font-weight: 600; }
    .division-tag {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.04em;
        color: #94a3b8;
        margin-top: 2px;
    }

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
    .btn-audit i { font-size: 13px; }

    /* ─── Empty state ──────────────────────────────── */
    .empty-state td {
        text-align: center;
        padding: 40px 16px;
        color: #94a3b8;
        font-size: 13px;
        font-style: italic;
    }
</style>
@endsection

@section('content')

<div class="page-header">
    <h1 class="page-title">Panel BPI — Approval Proposal</h1>
    <p class="page-subtitle">Tinjau dan sahkan draf proposal yang telah dinyatakan lolos kelayakan oleh BPH.</p>
</div>

<div class="section-card">
    <div class="section-header">
        <i class="ti ti-list-check"></i>
        <span>Berkas lolos BPH — siap di-approve</span>
    </div>

    <div style="overflow-x: auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Judul dokumen</th>
                    <th>Divisi</th>
                    <th>Tanggal pelaksanaan</th>
                    <th class="text-right">Alokasi anggaran</th>
                    <th class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse(\App\Models\Proposal::where('status', 'menunggu_bpi')->latest()->get() as $p)
                <tr>
                    <td>
                        <span style="font-weight: 500; color: #0f172a;">{{ $p->title }}</span>
                        <div class="division-tag">{{ strtoupper($p->division) }}</div>
                    </td>
                    <td style="color: #64748b;">{{ ucfirst($p->division) }}</td>
                    <td style="color: #64748b;">{{ \Carbon\Carbon::parse($p->event_date)->format('d M Y') }}</td>
                    <td class="text-right amount-blue">Rp {{ number_format($p->budget, 0, ',', '.') }}</td>
                    <td class="text-center">
                        <a href="{{ route('proposal.show', $p->id) }}" class="btn-audit">
                            Periksa <i class="ti ti-arrow-right"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr class="empty-state">
                    <td colspan="5">Belum ada berkas baru dari BPH yang masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection