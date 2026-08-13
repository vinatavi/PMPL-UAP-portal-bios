@extends('layouts.app')

@section('title', 'Detail Proposal — ' . $proposal->title)

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
    /* ─── Layout ───────────────────────────────────── */
    .detail-wrapper {
        max-width: 1000px;
        margin: 0 auto;
        padding: 8px 0;
        font-family: 'Inter', system-ui, sans-serif;
    }

    /* ─── Back link ────────────────────────────────── */
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #64748b;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 20px;
        transition: color 0.15s;
    }
    .back-link:hover { color: #1d4ed8; }
    .back-link i { font-size: 15px; }

    /* ─── Main card ────────────────────────────────── */
    .main-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
    }

    /* ─── Hero banner ──────────────────────────────── */
    .hero-banner {
        height: 190px;
        background-image:
            linear-gradient(to bottom, rgba(15, 79, 207, 0.85), rgba(15, 79, 207, 0.6)),
            url('https://cdn-web.ruangguru.com/landing-pages/assets/hs/mengenal-proposal.jpg');
        background-size: cover;
        background-position: center;
        padding: 28px 30px;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        box-sizing: border-box;
    }
    .hero-title {
        color: #ffffff;
        font-size: 22px;
        font-weight: 600;
        margin: 0 0 10px;
        line-height: 1.3;
    }
    .hero-meta {
        display: flex;
        align-items: center;
        gap: 14px;
        color: rgba(255,255,255,0.88);
        font-size: 13px;
        flex-wrap: wrap;
    }
    .hero-meta i { font-size: 14px; vertical-align: -1px; margin-right: 3px; }
    .hero-meta .sep { opacity: 0.5; }

    /* ─── Content body ─────────────────────────────── */
    .content-body { padding: 28px 30px; }

    /* ─── Info grid ────────────────────────────────── */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 30px;
    }
    .info-block {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        padding: 14px 16px;
    }
    .info-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-bottom: 6px;
    }
    .info-value {
        font-size: 15px;
        font-weight: 600;
        color: #1e293b;
    }

    /* ─── Badge status ─────────────────────────────── */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }
    .badge-status i { font-size: 12px; }
    .badge-pending  { background: #fefce8; color: #92400e; border: 1px solid #fde68a; }
    .badge-wait-bpi { background: #f0f9ff; color: #075985; border: 1px solid #bae6fd; }
    .badge-approved { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .badge-revisi   { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
    .badge-default  { background: #f8fafc; color: #475569; border: 1px solid #e2e8f0; }

    /* ─── Section heading ──────────────────────────── */
    .section-heading {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #1d4ed8;
        margin-bottom: 14px;
    }
    .section-heading i { font-size: 15px; }

    /* ─── Document box ─────────────────────────────── */
    .document-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 16px;
        background: #ffffff;
        margin-bottom: 20px;
        gap: 12px;
    }
    .doc-icon {
        background: #eff6ff;
        color: #1d4ed8;
        padding: 10px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        flex-shrink: 0;
    }
    .doc-icon i { font-size: 22px; }
    .doc-name {
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .doc-open {
        font-size: 12px;
        color: #1d4ed8;
        text-decoration: underline;
    }
    .btn-download {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #1d4ed8;
        color: #ffffff;
        text-decoration: none;
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 500;
        white-space: nowrap;
        flex-shrink: 0;
        transition: background 0.15s;
    }
    .btn-download:hover { background: #1e40af; }
    .btn-download i { font-size: 13px; }

    .preview-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-bottom: 10px;
    }
    .preview-box {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        background: #f8fafc;
        height: 580px;
    }
    .doc-empty {
        border: 1.5px dashed #e2e8f0;
        border-radius: 12px;
        padding: 32px;
        text-align: center;
        color: #94a3b8;
        font-size: 13px;
    }
    .doc-empty i { font-size: 36px; color: #cbd5e1; display: block; margin-bottom: 8px; }

    /* ─── Revision note ────────────────────────────── */
    .revisi-box {
        background: #fef2f2;
        border: 1px solid #fca5a5;
        border-radius: 12px;
        padding: 18px 20px;
        margin-top: 28px;
    }
    .revisi-header {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 700;
        color: #991b1b;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 10px;
    }
    .revisi-header i { font-size: 14px; }
    .revisi-note {
        font-size: 13px;
        color: #475569;
        line-height: 1.6;
        font-style: italic;
        background: #ffffff;
        padding: 12px 14px;
        border-radius: 8px;
        border-left: 4px solid #ef4444;
        margin: 0;
    }

    /* ─── Action bar (BPI) ─────────────────────────── */
    .action-bar {
        margin-top: 36px;
        padding-top: 22px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        flex-wrap: wrap;
    }
    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 20px;
        font-size: 13px;
        font-weight: 500;
        border-radius: 8px;
        cursor: pointer;
        font-family: inherit;
        transition: background 0.15s, border-color 0.15s;
    }
    .btn-action i { font-size: 15px; }
    .btn-reject {
        background: #ffffff;
        color: #dc2626;
        border: 1px solid #fca5a5;
    }
    .btn-reject:hover { background: #fef2f2; }
    .btn-approve {
        background: #16a34a;
        color: #ffffff;
        border: 1px solid #15803d;
    }
    .btn-approve:hover { background: #15803d; }

    /* ─── Modal ────────────────────────────────────── */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.5);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }
    .modal-overlay.is-open { display: flex; }
    .modal-box {
        background: #ffffff;
        border-radius: 14px;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.12);
        overflow: hidden;
    }
    .modal-head {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
    }
    .modal-head h3 {
        font-size: 15px;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 4px;
    }
    .modal-head p { font-size: 13px; color: #64748b; margin: 0; }
    .modal-body { padding: 16px 20px; }
    .modal-body textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 13px;
        font-family: inherit;
        box-sizing: border-box;
        resize: vertical;
        outline: none;
        transition: border-color 0.15s;
    }
    .modal-body textarea:focus { border-color: #93c5fd; }
    .modal-foot {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        padding: 12px 20px;
        border-top: 1px solid #f1f5f9;
        background: #f8fafc;
    }
    .btn-modal {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 500;
        border-radius: 7px;
        cursor: pointer;
        font-family: inherit;
        border: 1px solid transparent;
    }
    .btn-modal-cancel {
        background: #f1f5f9;
        color: #475569;
        border-color: #e2e8f0;
    }
    .btn-modal-cancel:hover { background: #e2e8f0; }
    .btn-modal-danger {
        background: #dc2626;
        color: #ffffff;
    }
    .btn-modal-danger:hover { background: #b91c1c; }
    .btn-modal i { font-size: 14px; }
</style>
@endsection

@section('content')
<div class="detail-wrapper">

    <a href="{{ route('proposal.list') }}" class="back-link">
        <i class="ti ti-arrow-left"></i> Kembali ke arsip
    </a>

    <div class="main-card">

        {{-- ── Hero Banner ─────────────────────────── --}}
        <div class="hero-banner">
            <h1 class="hero-title">{{ $proposal->title }}</h1>
            <div class="hero-meta">
                <span><i class="ti ti-users"></i>Divisi {{ strtoupper($proposal->division) }}</span>
                <span class="sep">•</span>
                <span><i class="ti ti-calendar-event"></i>{{ \Carbon\Carbon::parse($proposal->event_date)->format('d M Y') }}</span>
            </div>
        </div>

        {{-- ── Content ─────────────────────────────── --}}
        <div class="content-body">

            {{-- Info grid --}}
            <div class="info-grid">
                <div class="info-block">
                    <div class="info-label">Estimasi Anggaran</div>
                    <div class="info-value" style="font-size: 18px; color: #1d4ed8;">
                        Rp {{ number_format($proposal->budget, 0, ',', '.') }}
                    </div>
                </div>

                <div class="info-block">
                    <div class="info-label">Status Saat Ini</div>
                    <div style="margin-top: 4px;">
                        @php $status = strtolower($proposal->status); @endphp
                        @if($status === 'menunggu_bph')
                            <span class="badge-status badge-pending"><i class="ti ti-clock"></i>Menunggu BPH</span>
                        @elseif($status === 'menunggu_bpi')
                            <span class="badge-status badge-wait-bpi"><i class="ti ti-clock"></i>Menunggu BPI</span>
                        @elseif($status === 'approved')
                            <span class="badge-status badge-approved"><i class="ti ti-circle-check"></i>Approved</span>
                        @elseif(in_array($status, ['butuh revisi', 'revisi']))
                            <span class="badge-status badge-revisi"><i class="ti ti-alert-circle"></i>Butuh Revisi</span>
                        @else
                            <span class="badge-status badge-default">{{ strtoupper($proposal->status) }}</span>
                        @endif
                    </div>
                </div>

                <div class="info-block">
                    <div class="info-label">Dibuat Pada</div>
                    <div class="info-value" style="font-size: 13px; font-weight: 500; color: #475569;">
                        {{ $proposal->created_at ? $proposal->created_at->format('d M Y, H:i') : '—' }} WIB
                    </div>
                </div>
            </div>

            {{-- Document section --}}
            <div class="section-heading">
                <i class="ti ti-paperclip"></i> Berkas lampiran digital
            </div>

            @if($proposal->document)
                <div class="document-box">
                    <div style="display: flex; align-items: center; gap: 12px; min-width: 0;">
                        <div class="doc-icon"><i class="ti ti-file-description"></i></div>
                        <div style="min-width: 0;">
                            <div class="doc-name">{{ basename($proposal->document) }}</div>
                            <a href="{{ asset('storage/' . $proposal->document) }}" target="_blank" class="doc-open">
                                Buka di tab baru jika pratinjau gagal
                            </a>
                        </div>
                    </div>
                    <a href="{{ asset('storage/' . $proposal->document) }}" download class="btn-download">
                        <i class="ti ti-download"></i> Unduh berkas
                    </a>
                </div>

                <div class="preview-label">Pratinjau dokumen</div>
                <div class="preview-box">
                    <embed src="{{ asset('storage/' . $proposal->document) }}" type="application/pdf" width="100%" height="100%">
                </div>
            @else
                <div class="doc-empty">
                    <i class="ti ti-file-off"></i>
                    Berkas pengajuan belum diunggah atau tidak ditemukan.
                </div>
            @endif

            {{-- Revision note --}}
            @if(in_array(strtolower($proposal->status), ['butuh revisi', 'revisi']) && $proposal->notes)
            <div class="revisi-box">
                <div class="revisi-header">
                    <i class="ti ti-message-report"></i> Catatan evaluasi revisi
                </div>
                <p class="revisi-note">{!! nl2br(e($proposal->notes)) !!}</p>
            </div>
            @endif

            {{-- BPI action bar --}}
            @if(Auth::user() && strtolower(Auth::user()->role) === 'bpi' && in_array(strtolower($proposal->status), ['menunggu_bpi', 'butuh revisi']))
            <div class="action-bar">
                <button
                    type="button"
                    class="btn-action btn-reject"
                    onclick="document.getElementById('modalRevisiBpi').classList.add('is-open'); document.body.style.overflow='hidden';"
                >
                    <i class="ti ti-x"></i> Tolak &amp; minta revisi
                </button>

                <form
                    action="{{ route('proposal.approve.bpi', $proposal->id) }}"
                    method="POST"
                    onsubmit="return confirm('Setujui dan sahkan finansial proposal ini?')"
                >
                    @csrf
                    <button type="submit" class="btn-action btn-approve">
                        <i class="ti ti-circle-check"></i> Setujui &amp; selesaikan (ACC)
                    </button>
                </form>
            </div>
            @endif

        </div>
    </div>
</div>

{{-- ── Modal Revisi BPI ──────────────────────────────── --}}
@if(Auth::user() && strtolower(Auth::user()->role) === 'bpi')
<div id="modalRevisiBpi" class="modal-overlay" role="dialog" aria-modal="true" aria-labelledby="revisiModalTitle">
    <div class="modal-box">
        <div class="modal-head">
            <h3 id="revisiModalTitle">Berikan Catatan Evaluasi</h3>
            <p>Tulis instruksi perbaikan secara detail agar dapat dibaca oleh staff pengaju.</p>
        </div>
        <form action="{{ route('proposal.revisi.bpi', $proposal->id) }}" method="POST">
            @csrf
            <div class="modal-body">
                <textarea
                    name="notes"
                    rows="5"
                    placeholder="Contoh: Lampiran anggaran pada halaman 4 belum mencantumkan PPN 11%..."
                    required
                ></textarea>
            </div>
            <div class="modal-foot">
                <button
                    type="button"
                    class="btn-modal btn-modal-cancel"
                    onclick="document.getElementById('modalRevisiBpi').classList.remove('is-open'); document.body.style.overflow='';"
                >
                    Batal
                </button>
                <button type="submit" class="btn-modal btn-modal-danger">
                    <i class="ti ti-send"></i> Kirim ke staff
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('modalRevisiBpi').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.remove('is-open');
            document.body.style.overflow = '';
        }
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.getElementById('modalRevisiBpi').classList.remove('is-open');
            document.body.style.overflow = '';
        }
    });
</script>
@endif

@endsection