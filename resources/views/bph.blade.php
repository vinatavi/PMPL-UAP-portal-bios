@extends('layouts.app')

@section('title', 'Dashboard BPH')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
    /* ─── Base ─────────────────────────────────────── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    #dashBph {
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 14px;
        color: #1e293b;
        background: #f8fafc;
        min-height: 100vh;
        padding: 28px 24px;
    }

    /* ─── Page header ──────────────────────────────── */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 28px;
    }
    .page-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #0369a1;
        background: #f0f9ff;
        border: 1px solid #bae6fd;
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

    /* ─── Buttons ──────────────────────────────────── */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        font-size: 13px;
        font-weight: 500;
        border-radius: 8px;
        cursor: pointer;
        text-decoration: none;
        font-family: inherit;
        transition: background 0.15s, border-color 0.15s;
        white-space: nowrap;
    }
    .btn i { font-size: 15px; }
    .btn-primary { background: #1d4ed8; color: #fff; border: 1px solid #1e40af; }
    .btn-primary:hover { background: #1e40af; }
    .btn-default { background: #fff; color: #334155; border: 1px solid #e2e8f0; }
    .btn-default:hover { background: #f8fafc; }
    .btn-success { background: #16a34a; color: #fff; border: 1px solid #15803d; }
    .btn-success:hover { background: #15803d; }
    .btn-danger  { background: #dc2626; color: #fff; border: 1px solid #b91c1c; }
    .btn-danger:hover  { background: #b91c1c; }
    .btn-sm { padding: 5px 10px; font-size: 12px; }

    /* ─── Alerts ───────────────────────────────────── */
    .alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 20px;
    }
    .alert i { font-size: 16px; flex-shrink: 0; }
    .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .alert-warning { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }

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
    .section-title-text { font-size: 14px; font-weight: 600; color: #1e293b; }
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
        vertical-align: top;
        color: #334155;
    }
    .data-table tbody tr:last-child td { border-bottom: none; }
    .data-table tbody tr:hover { background: #fafafa; }

    .td-title { font-weight: 500; color: #0f172a; }
    .td-sub   { font-size: 11px; color: #94a3b8; margin-top: 2px; }

    /* ─── Badges ───────────────────────────────────── */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 9px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
    }
    .badge i { font-size: 11px; }
    .badge-blue   { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .badge-orange { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; }

    /* ─── BPI notes preview ────────────────────────── */
    .note-preview {
        background: #fff7ed;
        border-left: 3px solid #ea580c;
        padding: 7px 10px;
        border-radius: 0 6px 6px 0;
        font-size: 12px;
        color: #7c2d12;
        font-style: italic;
        line-height: 1.4;
        max-height: 60px;
        overflow-y: auto;
    }
    .note-empty { font-size: 12px; color: #cbd5e1; font-style: italic; }

    /* ─── Inline revisi form ───────────────────────── */
    .revisi-form {
        display: flex;
        gap: 6px;
        align-items: center;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 8px 10px;
        margin-top: 6px;
    }
    .revisi-form input {
        flex: 1;
        padding: 6px 10px;
        font-size: 12px;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        outline: none;
        font-family: inherit;
        background: #fff;
        color: #1e293b;
        transition: border-color 0.15s;
        min-width: 0;
    }
    .revisi-form input:focus { border-color: #93c5fd; }

    /* ─── Action cell ──────────────────────────────── */
    .action-cell {
        display: flex;
        flex-direction: column;
        gap: 6px;
        min-width: 260px;
    }
    .action-row { display: flex; gap: 6px; }

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
<div id="dashBph">

    {{-- ── Page Header ─────────────────────────────── --}}
    <div class="page-header">
        <div>
            <div class="page-eyebrow">
                <i class="ti ti-eye-check"></i> BPH — Pengawasan &amp; Validasi
            </div>
            <h1 class="page-title">Panel Pengawasan BPH</h1>
            <p class="page-subtitle">Validasi draf staff sebelum diteruskan ke tingkat pimpinan eksekutif BPI.</p>
        </div>
        <a href="{{ route('proposal.form') }}" class="btn btn-primary">
            <i class="ti ti-plus"></i> Ajukan proker divisi
        </a>
    </div>

    {{-- ── Flash Messages ───────────────────────────── --}}
    @if(session('success'))
    <div class="alert alert-success">
        <i class="ti ti-circle-check"></i> {{ session('success') }}
    </div>
    @endif
    @if(session('warning'))
    <div class="alert alert-warning">
        <i class="ti ti-alert-triangle"></i> {{ session('warning') }}
    </div>
    @endif

    {{-- ── Proposal Table ──────────────────────────── --}}
    <div class="section-card">
        <div class="section-header">
            <div class="section-header-left">
                <i class="ti ti-inbox"></i>
                <span class="section-title-text">Dokumen masuk butuh validasi</span>
                <span class="count-badge">{{ $proposals->count() }}</span>
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Judul proposal</th>
                        <th>Divisi</th>
                        <th>Tanggal eksekusi</th>
                        <th>Status</th>
                        <th>Catatan dari BPI</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($proposals as $proposal)
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
                            @if($proposal->notes && str_contains($proposal->notes, '[REVISI BPI]'))
                                <span class="badge badge-orange">
                                    <i class="ti ti-arrow-back-up"></i> Balikan BPI
                                </span>
                            @else
                                <span class="badge badge-blue">
                                    <i class="ti ti-file-plus"></i> Baru (Staff)
                                </span>
                            @endif
                        </td>

                        <td style="min-width: 180px; max-width: 220px;">
                            @if($proposal->notes)
                                <div class="note-preview">{{ $proposal->notes }}</div>
                            @else
                                <span class="note-empty">Tidak ada catatan</span>
                            @endif
                        </td>

                        <td>
                            <div class="action-cell">
                                {{-- Row 1: Buka & Setujui --}}
                                <div class="action-row">
                                    <a href="{{ route('proposal.show', $proposal->id) }}" class="btn btn-default btn-sm">
                                        <i class="ti ti-eye"></i> Buka berkas
                                    </a>
                                    <form
                                        action="{{ route('proposal.approve.bph', $proposal->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Setujui proposal ini dan teruskan ke BPI?')"
                                    >
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="ti ti-check"></i> Setujui ke BPI
                                        </button>
                                    </form>
                                </div>

                                {{-- Row 2: Inline revisi form --}}
                                <form
                                    action="{{ route('proposal.revisi.bph', $proposal->id) }}"
                                    method="POST"
                                    class="revisi-form"
                                >
                                    @csrf
                                    <input
                                        type="text"
                                        name="notes"
                                        value="{{ $proposal->notes }}"
                                        placeholder="Tulis alasan revisi ke staff..."
                                        required
                                    >
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="ti ti-send"></i> Revisi
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-state">
                        <td colspan="6">
                            <i class="ti ti-checks"></i>
                            Antrean bersih. Seluruh berkas divisi sudah divalidasi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection