@extends('layouts.app')

@section('title', isset($proposal) ? 'Revisi Dokumen Proposal' : 'Upload Proposal Baru')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
    /* ─── Layout ───────────────────────────────────── */
    .form-wrapper {
        max-width: 1000px;
        margin: 0 auto;
        padding: 8px 0;
    }
    .form-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
    }
    @media (max-width: 720px) {
        .form-grid { grid-template-columns: 1fr; }
    }

    /* ─── Cards ────────────────────────────────────── */
    .form-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 18px;
    }
    .side-card {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 14px;
        padding: 20px;
    }

    /* ─── Alert revisi ─────────────────────────────── */
    .alert-revisi {
        display: flex;
        gap: 12px;
        background: #fff7ed;
        border-left: 4px solid #ea580c;
        border-radius: 10px;
        padding: 14px 18px;
        margin-bottom: 24px;
    }
    .alert-revisi i { font-size: 18px; color: #ea580c; flex-shrink: 0; margin-top: 1px; }
    .alert-revisi h4 { font-size: 14px; font-weight: 600; color: #c2410c; margin-bottom: 4px; }
    .alert-revisi p  { font-size: 13px; color: #7c2d12; line-height: 1.5; margin: 0; }

    /* ─── Form elements ────────────────────────────── */
    .field-group { display: flex; flex-direction: column; gap: 6px; }
    .field-label {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
    }
    .field-input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 13px;
        font-family: inherit;
        color: #1e293b;
        background: #ffffff;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .field-input:focus {
        border-color: #93c5fd;
        box-shadow: 0 0 0 3px rgba(147, 197, 253, 0.2);
    }
    textarea.field-input { resize: vertical; }

    .field-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }
    @media (max-width: 540px) {
        .field-row { grid-template-columns: 1fr; }
    }

    /* ─── File upload zone ─────────────────────────── */
    .upload-zone {
        border: 1.5px dashed #cbd5e1;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        background: #f8fafc;
    }
    .upload-zone input { font-size: 13px; }
    .upload-note { font-size: 12px; color: #94a3b8; margin-top: 6px; }
    .text-danger { color: #dc2626; font-size: 12px; margin-top: 4px; font-weight: 500; }

    /* ─── Sidebar tips ─────────────────────────────── */
    .tips-title {
        font-size: 14px;
        font-weight: 600;
        color: #1e40af;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .tips-title i { font-size: 16px; }
    .tips-list {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 8px;
        padding: 0;
    }
    .tips-list li {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        font-size: 13px;
        color: #1e3a8a;
        line-height: 1.4;
    }
    .tips-list li i { font-size: 13px; flex-shrink: 0; margin-top: 1px; }

    /* ─── Buttons ──────────────────────────────────── */
    .btn-submit {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        width: 100%;
        padding: 12px;
        font-size: 13px;
        font-weight: 500;
        border-radius: 8px;
        cursor: pointer;
        font-family: inherit;
        transition: background 0.15s;
    }
    .btn-submit i { font-size: 15px; }
    .btn-primary-submit {
        background: #1d4ed8;
        color: #ffffff;
        border: 1px solid #1e40af;
    }
    .btn-primary-submit:hover { background: #1e40af; }
    .btn-cancel {
        background: #f8fafc;
        color: #475569;
        border: 1px solid #e2e8f0;
        text-decoration: none;
    }
    .btn-cancel:hover { background: #f1f5f9; }
</style>
@endsection

@section('content')
<div class="form-wrapper">

    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 20px; font-weight: 600; color: #0f172a;">
            {{ isset($proposal) ? 'Revisi Dokumen Proposal' : 'Upload Proposal Baru' }}
        </h1>
        <p style="color: #64748b; font-size: 13px; margin-top: 4px;">
            {{ isset($proposal) ? 'Perbarui informasi dan wajib mengunggah ulang berkas proposal yang baru.' : 'Isi formulir berikut untuk mengajukan proposal kegiatan divisi Anda.' }}
        </p>
    </div>

    @if(isset($proposal) && strtolower($proposal->status) === 'butuh revisi')
    <div class="alert-revisi">
        <i class="ti ti-alert-circle"></i>
        <div>
            <h4>Catatan Revisi dari Pimpinan</h4>
            <p>{{ $proposal->notes ?? 'Ada beberapa bagian berkas yang perlu diperbaiki. Silakan cek kembali isi draf atau tanyakan langsung ke BPH/BPI.' }}</p>
        </div>
    </div>
    @endif

    {{-- Aksi form dinamis: jika ada $proposal maka mengarah ke update, jika tidak maka ke store/submit --}}
    <form action="{{ isset($proposal) ? route('proposal.update', $proposal->id) : route('proposal.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($proposal))
            @method('PUT')
        @endif
        
        <div class="form-grid">

            {{-- ── Kolom Kiri: Form Utama ─────────────── --}}
            <div class="form-card">

                <div class="field-group">
                    <label class="field-label" for="title">Judul Kegiatan / Acara</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        class="field-input"
                        placeholder="Contoh: Workshop Desain Grafis BIOS 2026"
                        value="{{ old('title', $proposal->title ?? '') }}"
                        required
                    >
                    @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="field-row">
                    <div class="field-group">
                        <label class="field-label" for="division">Divisi Pengaju</label>
                        <input
                            type="text"
                            id="division"
                            name="division"
                            class="field-input"
                            placeholder="Contoh: Divisi Minat dan Bakat"
                            value="{{ old('division', $proposal->division ?? '') }}"
                            required
                        >
                        @error('division') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="field-group">
                        <label class="field-label" for="category">Kategori Kegiatan</label>
                        <select id="category" name="category" class="field-input" required>
                            <option value="" disabled selected>— Pilih kategori —</option>
                            @foreach(['Olahraga', 'Seni', 'Teknologi', 'Sosial', 'Lainnya'] as $cat)
                                <option value="{{ $cat }}" {{ old('category', $proposal->category ?? '') === $cat ? 'selected' : '' }}>
                                    {{ $cat === 'Sosial' ? 'Sosial / Pengabdian' : $cat }}
                                </option>
                            @endforeach
                        </select>
                        @error('category') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="field-row">
                    <div class="field-group">
                        <label class="field-label" for="event_date">Tanggal Acara</label>
                        <input
                            type="date"
                            id="event_date"
                            name="event_date"
                            class="field-input"
                            value="{{ old('event_date', isset($proposal) ? \Carbon\Carbon::parse($proposal->event_date)->format('Y-m-d') : '') }}"
                            required
                        >
                        @error('event_date') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="field-group">
                        <label class="field-label" for="budget">Total Anggaran (Rp)</label>
                        <input
                            type="number"
                            id="budget"
                            name="budget"
                            class="field-input"
                            placeholder="Contoh: 1500000"
                            value="{{ old('budget', $proposal->budget ?? '') }}"
                            min="0"
                            required
                        >
                        @error('budget') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="field-group">
                    <label class="field-label" for="description">Penjelasan Singkat Acara</label>
                    <textarea
                        id="description"
                        name="description"
                        class="field-input"
                        rows="4"
                        placeholder="Tuliskan tujuan dan konsep umum dari acara ini..."
                        required
                    >{{ old('description', $proposal->description ?? '') }}</textarea>
                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="field-group">
                    <label class="field-label">File Berkas Proposal {{ isset($proposal) ? '(Wajib Unggah Ulang Berkas Baru)' : '' }}</label>
                    <div class="upload-zone">
                        {{-- Pada saat revisi berkas ini wajib diisi ulang untuk mengganti berkas usang --}}
                        <input type="file" name="document" required>
                        <p class="upload-note">PDF, DOCX, XLSX — maks. 10 MB</p>
                    </div>
                    @error('document') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

            </div>

            {{-- ── Kolom Kanan: Sidebar ───────────────── --}}
            <div style="display: flex; flex-direction: column; gap: 16px;">

                <div class="side-card">
                    <div class="tips-title">
                        <i class="ti ti-info-circle"></i> Tips Pengisian
                    </div>
                    <ul class="tips-list">
                        <li><i class="ti ti-point-filled"></i> Pilih kategori yang paling sesuai dengan tema utama acara.</li>
                        <li><i class="ti ti-point-filled"></i> Pastikan rincian anggaran logis sebelum dikirim ke pimpinan.</li>
                        @if(isset($proposal))
                        <li><i class="ti ti-point-filled"></i> Dokumen baru yang Anda unggah akan otomatis menghapus file lama di server.</li>
                        @endif
                    </ul>
                </div>

                <div style="border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0;">
                    <img src="https://filkom.ub.ac.id/wp-content/uploads/2025/03/Head-BIOS-2.png" alt="BIOS" style="width: 100%; display: block;">
                </div>

                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <button type="submit" class="btn-submit btn-primary-submit">
                        <i class="ti ti-send"></i> {{ isset($proposal) ? 'Kirim Ulang Revisi' : 'Kirim pengajuan' }}
                    </button>
                    <a href="{{ route('dashboard.staff') }}" class="btn-submit btn-cancel">
                        Batal
                    </a>
                </div>

            </div>

        </div>
    </form>
</div>
@endsection