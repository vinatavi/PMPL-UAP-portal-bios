@extends('layouts.app')

@section('title', 'Sistem Informasi Akuntansi BPI')

@section('content')

{{-- Tabler Icons CDN --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

<style>
    /* ─── Reset & Base ─────────────────────────────── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    #financeApp {
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 14px;
        color: #1e293b;
        background: #f8fafc;
        min-height: 100vh;
        padding: 24px;
    }

    /* ─── Page Header ──────────────────────────────── */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 24px;
    }
    .page-title {
        font-size: 20px;
        font-weight: 600;
        color: #0f172a;
        letter-spacing: -0.3px;
    }
    .page-subtitle {
        font-size: 13px;
        color: #64748b;
        margin-top: 4px;
        line-height: 1.5;
    }
    .btn-row {
        display: flex;
        gap: 8px;
        flex-shrink: 0;
    }

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
        transition: background 0.15s, border-color 0.15s;
        text-decoration: none;
        white-space: nowrap;
    }
    .btn i { font-size: 15px; line-height: 1; }

    .btn-default {
        background: #ffffff;
        color: #334155;
        border: 1px solid #cbd5e1;
    }
    .btn-default:hover { background: #f1f5f9; }

    .btn-success {
        background: #16a34a;
        color: #ffffff;
        border: 1px solid #15803d;
    }
    .btn-success:hover { background: #15803d; }

    .btn-primary {
        background: #1d4ed8;
        color: #ffffff;
        border: 1px solid #1e40af;
    }
    .btn-primary:hover { background: #1e40af; }

    .btn-sm {
        padding: 5px 10px;
        font-size: 12px;
    }

    /* ─── Alert ────────────────────────────────────── */
    .alert-success {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #dcfce7;
        color: #166534;
        padding: 12px 16px;
        border-radius: 10px;
        border-left: 4px solid #22c55e;
        margin-bottom: 24px;
        font-size: 13px;
        font-weight: 500;
    }

    /* ─── Metric Cards ─────────────────────────────── */
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }
    .metric-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 18px 20px;
    }
    .metric-card.danger {
        background: #fef2f2;
        border-color: #fca5a5;
    }
    .metric-label {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-bottom: 10px;
    }
    .metric-label i { font-size: 14px; }
    .metric-card.danger .metric-label { color: #b91c1c; }
    .metric-value {
        font-size: 22px;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.2;
        margin-bottom: 4px;
    }
    .metric-value.green  { color: #16a34a; }
    .metric-value.blue   { color: #1d4ed8; }
    .metric-value.red    { color: #b91c1c; }
    .metric-note {
        font-size: 11px;
        color: #94a3b8;
    }
    .metric-card.danger .metric-note { color: #ef4444; }

    /* ─── Section Cards ────────────────────────────── */
    .section-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 24px;
    }
    .section-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 14px 18px;
        border-bottom: 1px solid #f1f5f9;
    }
    .section-header i {
        font-size: 17px;
        color: #64748b;
    }
    .section-title {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
    }

    /* ─── Tables ───────────────────────────────────── */
    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .data-table thead tr {
        background: #f8fafc;
    }
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
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
    }
    .data-table tbody tr:last-child td {
        border-bottom: none;
    }
    .data-table tbody tr:hover {
        background: #f8fafc;
    }
    .text-right { text-align: right !important; }
    .text-center { text-align: center !important; }
    .text-green  { color: #16a34a; font-weight: 600; }
    .text-red    { color: #b91c1c; font-weight: 600; }
    .text-blue   { color: #1d4ed8; font-weight: 600; }
    .text-muted  { color: #94a3b8; }
    .font-mono   { font-family: 'SFMono-Regular', Consolas, monospace; font-size: 12px; }
    .tag-division {
        display: inline-block;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-top: 3px;
    }
    .badge-bank {
        display: inline-block;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 11px;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 5px;
        margin-bottom: 3px;
    }
    .empty-row td {
        text-align: center;
        padding: 28px 16px;
        color: #94a3b8;
        font-style: italic;
    }

    /* ─── Two-column grid (Divisi + Antrean) ───────── */
    .two-col-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 20px;
        margin-bottom: 24px;
    }
    @media (max-width: 860px) {
        .two-col-grid { grid-template-columns: 1fr; }
    }

    /* ─── Division Progress ────────────────────────── */
    .division-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
        padding: 16px 18px;
    }
    .division-row { display: flex; flex-direction: column; gap: 6px; }
    .division-meta {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        font-size: 13px;
    }
    .division-name { font-weight: 500; color: #334155; }
    .division-amount { font-size: 12px; color: #64748b; }
    .progress-track {
        width: 100%;
        background: #f1f5f9;
        height: 6px;
        border-radius: 6px;
        overflow: hidden;
    }
    .progress-fill {
        height: 100%;
        border-radius: 6px;
        background: #475569;
    }

    /* ─── Modal ────────────────────────────────────── */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: rgba(15, 23, 42, 0.45);
        align-items: center;
        justify-content: center;
        padding: 16px;
    }
    .modal-overlay.is-open {
        display: flex;
    }
    .modal-box {
        background: #ffffff;
        border-radius: 14px;
        width: 100%;
        max-width: 420px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.12);
        overflow: hidden;
    }
    .modal-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
    }
    .modal-title {
        font-size: 15px;
        font-weight: 600;
        color: #0f172a;
    }
    .modal-close {
        background: none;
        border: none;
        cursor: pointer;
        color: #94a3b8;
        font-size: 20px;
        line-height: 1;
        padding: 4px;
        border-radius: 6px;
        display: flex;
        align-items: center;
    }
    .modal-close:hover { color: #475569; background: #f1f5f9; }
    .modal-body { padding: 20px; }
    .form-group { margin-bottom: 14px; }
    .form-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .form-control {
        width: 100%;
        padding: 9px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 13px;
        color: #1e293b;
        background: #ffffff;
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s;
        font-family: inherit;
    }
    .form-control:focus {
        border-color: #93c5fd;
        box-shadow: 0 0 0 3px rgba(147, 197, 253, 0.25);
    }
    textarea.form-control { resize: none; }
    .modal-foot {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        padding: 14px 20px;
        border-top: 1px solid #f1f5f9;
        background: #f8fafc;
    }

    /* ─── Print ────────────────────────────────────── */
    @media print {
        body { background: white !important; color: black !important; }
        .no-print, nav, aside, header, .modal-overlay { display: none !important; }
        #financeApp { padding: 0 !important; background: white !important; }
        .metric-card, .section-card { border: 1px solid #e2e8f0 !important; box-shadow: none !important; }
    }
</style>

<div id="financeApp" id="printableArea">

    {{-- ── Page Header ─────────────────────────────── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Sistem Informasi Finansial — BPI Finance</h1>
            <p class="page-subtitle">Pusat otorisasi keuangan, realisasi anggaran dinamis, dan pengawasan likuiditas kas BIOS.</p>
        </div>
        <div class="btn-row no-print">
            <button onclick="window.print()" class="btn btn-default">
                <i class="ti ti-printer"></i> Cetak laporan
            </button>
            <button onclick="openCashModal()" class="btn btn-success">
                <i class="ti ti-plus"></i> Input kas masuk
            </button>
        </div>
    </div>

    {{-- ── Flash Message ────────────────────────────── --}}
    @if(session('success'))
        <div class="alert-success no-print">
            <i class="ti ti-circle-check" style="font-size:16px;"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- ── Metric Cards ─────────────────────────────── --}}
    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-label">
                <i class="ti ti-wallet"></i> Total Pemasukan Kas
            </div>
            <div class="metric-value">Rp {{ number_format($totalKasOrganisasi, 0, ',', '.') }}</div>
            <div class="metric-note">Termasuk suntikan dana sponsor luar</div>
        </div>

        <div class="metric-card">
            <div class="metric-label">
                <i class="ti ti-arrow-up-right"></i> Total Dana Keluar
            </div>
            <div class="metric-value green">− Rp {{ number_format($totalDanaCair, 0, ',', '.') }}</div>
            <div class="metric-note">Pengeluaran terotorisasi sah</div>
        </div>

        <div class="metric-card">
            <div class="metric-label">
                <i class="ti ti-safe"></i> Sisa Saldo Kas Bersih
            </div>
            <div class="metric-value blue">Rp {{ number_format($sisaKasSekarang, 0, ',', '.') }}</div>
            <div class="metric-note">Tersimpan di brankas BIOS</div>
        </div>

        <div class="metric-card danger">
            <div class="metric-label">
                <i class="ti ti-clock-pause"></i> Beban Kas Tertunda
            </div>
            <div class="metric-value red">Rp {{ number_format($totalDanaPending, 0, ',', '.') }}</div>
            <div class="metric-note">Menanti persetujuan pencairan</div>
        </div>
    </div>

    {{-- ── Buku Harian Dana Masuk ───────────────────── --}}
    <div class="section-card">
        <div class="section-header">
            <i class="ti ti-arrow-bar-to-down"></i>
            <span class="section-title">Buku Harian Dana Tambahan / Sponsor Masuk</span>
        </div>
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Sumber Dana</th>
                        <th>Keterangan / Catatan</th>
                        <th>Tanggal Masuk</th>
                        <th class="text-right">Jumlah Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cashInflows as $inflow)
                    <tr>
                        <td style="font-weight: 500;">{{ $inflow->source }}</td>
                        <td>{{ $inflow->description ?? '—' }}</td>
                        <td class="text-muted">{{ $inflow->created_at->format('d M Y') }}</td>
                        <td class="text-right text-green">+ Rp {{ number_format($inflow->amount, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr class="empty-row">
                        <td colspan="4">Belum ada suntikan dana eksternal yang diinput bendahara.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── Realisasi Divisi + Antrean Validasi ─────── --}}
    <div class="two-col-grid">

        {{-- Realisasi Anggaran Divisi --}}
        <div class="section-card">
            <div class="section-header">
                <i class="ti ti-chart-bar"></i>
                <span class="section-title">Realisasi Anggaran Divisi</span>
            </div>
            <div class="division-list">
                @foreach($divisiStats as $stat)
                <div class="division-row">
                    <div class="division-meta">
                        <span class="division-name">Divisi {{ ucfirst($stat->division) }}</span>
                        <span class="division-amount">Rp {{ number_format($stat->total_budget, 0, ',', '.') }}</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width: {{ $totalKasOrganisasi > 0 ? min(($stat->total_budget / $totalKasOrganisasi) * 100 * 3, 100) : 0 }}%;"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Antrean Validasi --}}
        <div class="section-card">
            <div class="section-header">
                <i class="ti ti-list-check"></i>
                <span class="section-title">Antrean Validasi &amp; Rekening Tujuan Transfer</span>
            </div>
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nama Kegiatan</th>
                            <th>Rekening Tujuan</th>
                            <th class="text-right">Jumlah Dana</th>
                            <th class="text-center no-print">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingProposals as $p)
                        <tr>
                            <td>
                                <span style="font-weight: 500; color: #0f172a;">{{ $p->title }}</span>
                                <div class="tag-division">{{ strtoupper($p->division) }}</div>
                            </td>
                            <td>
                                <span class="badge-bank">{{ $p->bank_name ?? 'BANK NOT SET' }}</span><br>
                                <span class="font-mono">{{ $p->account_number ?? '0000000000' }}</span><br>
                                <span style="font-size: 11px; color: #64748b;">a.n. {{ $p->account_name ?? 'Tidak Ada Nama' }}</span>
                            </td>
                            <td class="text-right text-red">Rp {{ number_format($p->budget, 0, ',', '.') }}</td>
                            <td class="text-center no-print">
                                <a href="{{ route('proposal.show', $p->id) }}" class="btn btn-primary btn-sm">
                                    Audit <i class="ti ti-arrow-right" style="font-size:12px;"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr class="empty-row">
                            <td colspan="4">Tidak ada antrean beban kas masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

{{-- ── Modal Input Kas Masuk ────────────────────────── --}}
<div id="cashModal" class="modal-overlay no-print" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="modal-box">
        <div class="modal-head">
            <span id="modalTitle" class="modal-title">Pembukuan Uang Masuk Kas</span>
            <button class="modal-close" onclick="closeCashModal()" aria-label="Tutup modal">
                <i class="ti ti-x"></i>
            </button>
        </div>

        <form action="{{ route('finance.cashflow.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="source">Sumber Asal Dana</label>
                    <input
                        type="text"
                        id="source"
                        name="source"
                        class="form-control"
                        placeholder="Contoh: Dana RKAT Kampus, Sponsor Astra"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="amount">Jumlah Nominal (Rp)</label>
                    <input
                        type="number"
                        id="amount"
                        name="amount"
                        class="form-control"
                        placeholder="Contoh: 5000000"
                        min="1"
                        required
                    >
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" for="description">Catatan / Deskripsi</label>
                    <textarea
                        id="description"
                        name="description"
                        class="form-control"
                        rows="3"
                        placeholder="Opsional…"
                    ></textarea>
                </div>
            </div>

            <div class="modal-foot">
                <button type="button" onclick="closeCashModal()" class="btn btn-default">Batal</button>
                <button type="submit" class="btn btn-success">
                    <i class="ti ti-check"></i> Simpan dana
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCashModal() {
        const modal = document.getElementById('cashModal');
        modal.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    function closeCashModal() {
        const modal = document.getElementById('cashModal');
        modal.classList.remove('is-open');
        document.body.style.overflow = '';
    }

    // Tutup modal jika klik di luar box
    document.getElementById('cashModal').addEventListener('click', function(e) {
        if (e.target === this) closeCashModal();
    });

    // Tutup modal dengan tombol Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeCashModal();
    });
</script>

@endsection