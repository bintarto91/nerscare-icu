@extends('layouts.app')

@section('title', 'Pengaturan Laporan')
@section('page_title', 'Pengaturan Laporan Cetak')
@section('page_subtitle', 'Kelola header, footer, catatan klinis, dan tanda tangan laporan assessment.')

@section('content')
<style>
    .setting-section {
        margin-bottom: 24px;
    }

    .setting-title {
        display: flex;
        gap: 10px;
        align-items: center;
        padding-bottom: 12px;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 16px;
    }

    .setting-icon {
        width: 38px;
        height: 38px;
        border-radius: 13px;
        background: #edf7f8;
        color: #0b6f73;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .setting-title h3 {
        margin: 0;
        font-size: 17px;
        color: #0f172a;
    }

    .setting-title p {
        margin: 3px 0 0;
        color: #64748b;
        font-size: 13px;
    }

    .required {
        color: #dc2626;
    }

    .input-help {
        margin-top: 6px;
        color: #64748b;
        font-size: 12px;
        line-height: 1.5;
    }

    .preview-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 18px;
    }
</style>

<div class="clinical-note">
    <strong>Catatan:</strong>
    Pengaturan ini akan digunakan pada halaman <strong>Cetak / Unduh PDF</strong>
    hasil assessment. Admin dapat menyesuaikan nama institusi, judul laporan, disclaimer,
    dan bagian tanda tangan tanpa mengubah coding.
</div>

<div class="preview-box">
    <strong>Tips:</strong>
    Setelah menyimpan pengaturan, buka salah satu hasil assessment lalu klik
    <strong>Cetak / Unduh PDF</strong> untuk melihat hasilnya.
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Form Pengaturan Laporan</h3>
            <p>Atur tampilan laporan hasil assessment.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('report-settings.update') }}">
        @csrf
        @method('PUT')

        <div class="setting-section">
            <div class="setting-title">
                <div class="setting-icon">🏥</div>
                <div>
                    <h3>Header Laporan</h3>
                    <p>Identitas institusi dan judul laporan.</p>
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Nama Institusi / Unit <span class="required">*</span></label>
                    <input
                        type="text"
                        name="report_institution_name"
                        value="{{ old('report_institution_name', $settings['report_institution_name']) }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Nama Aplikasi <span class="required">*</span></label>
                    <input
                        type="text"
                        name="report_app_name"
                        value="{{ old('report_app_name', $settings['report_app_name']) }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Judul Laporan <span class="required">*</span></label>
                    <input
                        type="text"
                        name="report_title"
                        value="{{ old('report_title', $settings['report_title']) }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Subjudul Laporan <span class="required">*</span></label>
                    <input
                        type="text"
                        name="report_subtitle"
                        value="{{ old('report_subtitle', $settings['report_subtitle']) }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Nama Ruang / Unit</label>
                    <input
                        type="text"
                        name="report_unit_name"
                        value="{{ old('report_unit_name', $settings['report_unit_name']) }}"
                    >
                    <div class="input-help">Contoh: Ruang ICU, ICU RS X, Intensive Care Unit.</div>
                </div>
            </div>
        </div>

        <div class="setting-section">
            <div class="setting-title">
                <div class="setting-icon">⚠️</div>
                <div>
                    <h3>Catatan Klinis</h3>
                    <p>Disclaimer yang tampil pada laporan assessment.</p>
                </div>
            </div>

            <div class="form-group">
                <label>Catatan Klinis <span class="required">*</span></label>
                <textarea
                    name="report_clinical_note"
                    style="min-height: 150px;"
                    required
                >{{ old('report_clinical_note', $settings['report_clinical_note']) }}</textarea>
            </div>
        </div>

        <div class="setting-section">
            <div class="setting-title">
                <div class="setting-icon">✍️</div>
                <div>
                    <h3>Tanda Tangan</h3>
                    <p>Label dan nama bagian tanda tangan laporan.</p>
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Label Tanda Tangan Kiri <span class="required">*</span></label>
                    <input
                        type="text"
                        name="report_left_signature_label"
                        value="{{ old('report_left_signature_label', $settings['report_left_signature_label']) }}"
                        required
                    >
                    <div class="input-help">Contoh: Perawat Pengisi.</div>
                </div>

                <div class="form-group">
                    <label>Label Tanda Tangan Kanan <span class="required">*</span></label>
                    <input
                        type="text"
                        name="report_right_signature_label"
                        value="{{ old('report_right_signature_label', $settings['report_right_signature_label']) }}"
                        required
                    >
                    <div class="input-help">Contoh: Mengetahui / Kepala Ruangan.</div>
                </div>

                <div class="form-group">
                    <label>Nama Tanda Tangan Kanan</label>
                    <input
                        type="text"
                        name="report_right_signature_name"
                        value="{{ old('report_right_signature_name', $settings['report_right_signature_name']) }}"
                    >
                    <div class="input-help">Boleh dikosongkan atau isi dengan nama kepala ruangan.</div>
                </div>
            </div>
        </div>

        <div class="setting-section">
            <div class="setting-title">
                <div class="setting-icon">📄</div>
                <div>
                    <h3>Footer Laporan</h3>
                    <p>Teks kecil di bagian bawah laporan.</p>
                </div>
            </div>

            <div class="form-group">
                <label>Footer Text</label>
                <input
                    type="text"
                    name="report_footer_text"
                    value="{{ old('report_footer_text', $settings['report_footer_text']) }}"
                >
            </div>
        </div>

        <div class="actions" style="margin-top: 22px;">
            <button type="submit" class="btn">
                💾 Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection