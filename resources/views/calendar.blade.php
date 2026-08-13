@extends('layouts.app')

@section('title', 'Kalender Aktivitas Organisasi')

@section('content')

{{-- Tabler Icons CDN --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">

<style>
    /* ─── Base ─────────────────────────────────────── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    #calendarApp {
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
        font-family: inherit;
    }
    .btn i { font-size: 15px; line-height: 1; }

    .btn-default {
        background: #ffffff;
        color: #334155;
        border: 1px solid #cbd5e1;
    }
    .btn-default:hover { background: #f1f5f9; }

    .btn-primary {
        background: #1d4ed8;
        color: #ffffff;
        border: 1px solid #1e40af;
    }
    .btn-primary:hover { background: #1e40af; }

    .btn-success {
        background: #16a34a;
        color: #ffffff;
        border: 1px solid #15803d;
    }
    .btn-success:hover { background: #15803d; }

    /* ─── Calendar Card ────────────────────────────── */
    .calendar-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 24px;
    }

    /* ─── FullCalendar overrides ───────────────────── */
    .fc .fc-toolbar-title {
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
    }
    .fc .fc-button-primary {
        background-color: #1d4ed8;
        border-color: #1d4ed8;
        font-weight: 500;
        font-size: 12px;
        text-transform: capitalize;
        box-shadow: none;
    }
    .fc .fc-button-primary:hover {
        background-color: #1e40af;
        border-color: #1e40af;
    }
    .fc .fc-button-primary:not(:disabled):active,
    .fc .fc-button-primary:not(:disabled).fc-button-active {
        background-color: #1e3a8a;
        border-color: #1e3a8a;
        box-shadow: none;
    }
    .fc .fc-button-primary:disabled {
        background-color: #94a3b8;
        border-color: #94a3b8;
    }
    .fc .fc-button:focus { box-shadow: none; }
    .fc-event {
        cursor: pointer;
        padding: 2px 5px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 500;
        border: none;
    }
    .fc-day-today { background: #eff6ff !important; }
    .fc .fc-daygrid-day-number { font-size: 13px; color: #475569; }

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
    .modal-overlay.is-open { display: flex; }

    .modal-box {
        background: #ffffff;
        border-radius: 14px;
        width: 100%;
        max-width: 440px;
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
        transition: background 0.15s;
    }
    .modal-close:hover { color: #475569; background: #f1f5f9; }

    .modal-body { padding: 20px; }

    .form-group { margin-bottom: 14px; }
    .form-group:last-child { margin-bottom: 0; }

    .form-label {
        display: block;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-bottom: 6px;
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

    .modal-foot {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        padding: 14px 20px;
        border-top: 1px solid #f1f5f9;
        background: #f8fafc;
    }
</style>

<div id="calendarApp">

    {{-- ── Page Header ─────────────────────────────── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Kalender Aktivitas BIOS</h1>
            <p class="page-subtitle">Pantau jadwal eksekusi program kerja divisi dan linimasa kegiatan mendatang.</p>
        </div>
        <button onclick="openModal()" class="btn btn-primary">
            <i class="ti ti-plus"></i> Buat aktivitas baru
        </button>
    </div>

    {{-- ── Calendar ─────────────────────────────────── --}}
    <div class="calendar-card">
        <div id="calendar"></div>
    </div>

</div>

{{-- ── Modal Tambah Aktivitas ───────────────────────── --}}
<div id="activityModal" class="modal-overlay" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="modal-box">
        <div class="modal-head">
            <span id="modalTitle" class="modal-title">Tambah Aktivitas Kerja</span>
            <button class="modal-close" onclick="closeModal()" aria-label="Tutup modal">
                <i class="ti ti-x"></i>
            </button>
        </div>

        <form action="{{ route('proposal.submit') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="title">Nama / Judul Kegiatan</label>
                    <input type="text" id="title" name="title" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="division">Divisi Pelaksana</label>
                    <input
                        type="text"
                        id="division"
                        name="division"
                        class="form-control"
                        placeholder="Contoh: humas, rnt, finance"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="event_date">Tanggal Eksekusi</label>
                    <input type="date" id="event_date" name="event_date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="budget">Estimasi Anggaran Dana (Rp)</label>
                    <input type="number" id="budget" name="budget" class="form-control" value="0" min="0" required>
                </div>
            </div>

            <div class="modal-foot">
                <button type="button" onclick="closeModal()" class="btn btn-default">Batal</button>
                <button type="submit" class="btn btn-success">
                    <i class="ti ti-check"></i> Simpan jadwal
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/id.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var eventData  = {!! $events !!};

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id',
            headerToolbar: {
                left:   'prev,next today',
                center: 'title',
                right:  'dayGridMonth,timeGridWeek,listMonth'
            },
            events:     eventData,
            editable:   false,
            selectable: true,

            // Klik tanggal kosong → buka modal & isi tanggal otomatis
            select: function (info) {
                document.getElementById('event_date').value = info.startStr;
                openModal();
            }
        });

        calendar.render();
    });

    function openModal() {
        document.getElementById('activityModal').classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('activityModal').classList.remove('is-open');
        document.body.style.overflow = '';
    }

    // Tutup modal klik di luar box
    document.getElementById('activityModal').addEventListener('click', function (e) {
        if (e.target === this) closeModal();
    });

    // Tutup modal dengan Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeModal();
    });
</script>

@endsection