@extends('layouts.app')

@section('title', $educationContent->title)
@section('page_title', 'Detail Materi Edukasi')
@section('page_subtitle', 'Panduan edukasi digital untuk perawat dan keluarga pasien ICU.')

@section('content')
@php
    $target = $educationContent->target ?? '-';
    $isPerawat = $target === 'perawat';

    $backRoute = $isPerawat ? route('education.perawat') : route('education.keluarga');
    $backLabel = $isPerawat ? 'Kembali ke Edukasi Perawat' : 'Kembali ke Edukasi Keluarga';
@endphp

<style>
    .education-detail-hero {
        background: linear-gradient(135deg, #0b6f73, #2563a9);
        color: white;
        border-radius: 8px;
        padding: 26px;
        margin-bottom: 22px;
        box-shadow: 0 18px 45px rgba(15, 118, 110, .18);
        display: grid;
        grid-template-columns: 1.2fr .8fr;
        gap: 18px;
        align-items: center;
    }

    .education-detail-hero h2 {
        margin: 0 0 10px;
        font-size: 29px;
        line-height: 1.25;
    }

    .education-detail-hero p {
        margin: 0;
        color: #d9fffb;
        line-height: 1.7;
    }

    .education-info-box {
        background: rgba(255,255,255,.14);
        border: 1px solid rgba(255,255,255,.24);
        border-radius: 8px;
        padding: 16px;
        display: grid;
        gap: 8px;
        font-size: 14px;
    }

    .education-info-box div {
        display: flex;
        justify-content: space-between;
        gap: 12px;
    }

    .education-info-box span {
        color: #d9fffb;
    }

    .education-detail-grid {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 22px;
        align-items: start;
    }

    .education-content-body {
        font-size: 15px;
        line-height: 1.85;
        color: #334155;
    }

    .education-content-body p {
        margin: 0 0 14px;
    }

    .education-content-body ul,
    .education-content-body ol {
        margin-top: 8px;
        margin-bottom: 16px;
        padding-left: 24px;
    }

    .education-content-body li {
        margin-bottom: 8px;
    }

    .side-box {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 18px;
        box-shadow: 0 12px 35px rgba(15,23,42,.06);
        margin-bottom: 16px;
    }

    .side-box h3 {
        margin: 0 0 12px;
        font-size: 17px;
        color: #0f172a;
    }

    .side-actions {
        display: grid;
        gap: 10px;
    }

    .side-actions .btn {
        width: 100%;
    }

    .checklist {
        display: grid;
        gap: 10px;
    }

    .checklist label {
        display: flex;
        gap: 10px;
        align-items: flex-start;
        font-weight: normal;
        color: #334155;
        line-height: 1.5;
        padding: 10px;
        border-radius: 12px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        cursor: pointer;
    }

    .checklist input {
        width: auto;
        margin-top: 3px;
        accent-color: #0b6f73;
    }

    .read-status {
        margin-top: 12px;
        padding: 12px;
        border-radius: 8px;
        background: #fef3c7;
        border: 1px solid #fde68a;
        color: #92400e;
        font-size: 13px;
        line-height: 1.5;
        font-weight: 700;
    }

    .read-status.done {
        background: #dcfce7;
        border-color: #bbf7d0;
        color: #166534;
    }

    .print-only {
        display: none;
    }

    @media(max-width: 1000px) {
        .education-detail-hero,
        .education-detail-grid {
            grid-template-columns: 1fr;
        }

        .education-info-box div {
            display: block;
        }
    }

    @media print {
        .sidebar,
        .topbar,
        .side-box,
        .btn,
        .no-print {
            display: none !important;
        }

        .main {
            margin-left: 0 !important;
        }

        .content {
            padding: 0 !important;
        }

        .education-detail-hero,
        .panel {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }

        .education-detail-hero {
            color: #0f172a !important;
            background: white !important;
        }

        .education-detail-hero p,
        .education-info-box span {
            color: #334155 !important;
        }

        .education-info-box {
            background: white !important;
            border: 1px solid #ddd !important;
        }

        .print-only {
            display: block;
        }
    }
</style>

<div class="print-only">
    <h2>{{ $educationContent->title }}</h2>
    <p>Materi Edukasi {{ ucfirst($target) }} - AI-Assisted Assessment ICU</p>
</div>

<div class="education-detail-hero">
    <div>
        <h2>{{ $educationContent->title }}</h2>
        <p>
            Materi edukasi untuk membantu {{ $isPerawat ? 'perawat dalam memahami dan menangani loneliness pasien ICU' : 'keluarga memberikan dukungan emosional kepada pasien ICU' }}.
        </p>
    </div>

    <div class="education-info-box">
        <div>
            <span>Sasaran</span>
            <strong>{{ ucfirst($target) }}</strong>
        </div>

        <div>
            <span>Kategori</span>
            <strong>{{ $educationContent->category ?: '-' }}</strong>
        </div>

        <div>
            <span>Status</span>
            <strong>{{ ucfirst($educationContent->status) }}</strong>
        </div>

        <div>
            <span>Diperbarui</span>
            <strong>{{ $educationContent->updated_at ? $educationContent->updated_at->format('d/m/Y') : '-' }}</strong>
        </div>
    </div>
</div>

<div class="education-detail-grid">
    <div class="panel">
        <div class="panel-header">
            <div>
                <h3>Isi Materi</h3>
                <p>Baca materi edukasi berikut dan gunakan sesuai kebutuhan pasien.</p>
            </div>
        </div>

        <div class="education-content-body">
            {!! nl2br(e($educationContent->content)) !!}
        </div>

        <div class="clinical-note" style="margin-top: 22px;">
            <strong>Catatan:</strong>
            Materi edukasi ini bersifat pendukung. Pelaksanaan edukasi tetap perlu mengikuti
            kebijakan ruang ICU, kondisi klinis pasien, dan arahan perawat/dokter penanggung jawab.
        </div>
    </div>

    <aside>
        <div class="side-box">
            <h3>Tools Materi</h3>

            <div class="side-actions">
                <button type="button" class="btn" onclick="window.print()">
                    Cetak / Unduh Panduan
                </button>

                <button type="button" class="btn btn-light" onclick="copyEducationLink()">
                    Bagikan Link Materi
                </button>

                @if($isPerawat)
                    <a href="{{ route('education.keluarga') }}" class="btn btn-secondary">
                        Edukasi Keluarga
                    </a>
                @else
                    <a href="{{ route('education.perawat') }}" class="btn btn-secondary">
                        Edukasi Perawat
                    </a>
                @endif

                <a href="{{ $backRoute }}" class="btn btn-light">
                    ← {{ $backLabel }}
                </a>

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('education.edit', $educationContent) }}" class="btn btn-warning">
                        Edit Materi
                    </a>
                @endif
            </div>
        </div>

        <div class="side-box">
            <h3>{{ $isPerawat ? 'Checklist Perawat' : 'Checklist Keluarga' }}</h3>

            <div class="checklist">
                @if($isPerawat)
                    <label>
                        <input type="checkbox" class="read-check">
                        Materi telah dibaca dan dipahami.
                    </label>

                    <label>
                        <input type="checkbox" class="read-check">
                        Rekomendasi disesuaikan dengan kondisi pasien.
                    </label>

                    <label>
                        <input type="checkbox" class="read-check">
                        Edukasi keluarga diberikan sesuai arahan ruang ICU.
                    </label>
                @else
                    <label>
                        <input type="checkbox" class="read-check">
                        Materi telah dibaca oleh keluarga.
                    </label>

                    <label>
                        <input type="checkbox" class="read-check">
                        Keluarga memahami cara memberi dukungan emosional.
                    </label>

                    <label>
                        <input type="checkbox" class="read-check">
                        Keluarga bersedia mengikuti arahan perawat.
                    </label>
                @endif
            </div>

            <div id="readStatus" class="read-status">
                Tandai semua checklist jika materi sudah selesai dibaca.
            </div>
        </div>
    </aside>
</div>

<script>
    function copyEducationLink() {
        navigator.clipboard.writeText(window.location.href)
            .then(function () {
                showAppNotice('Link materi edukasi berhasil disalin.', {
                    title: 'Link disalin'
                });
            })
            .catch(function () {
                showAppNotice('Gagal menyalin link. Silakan salin URL secara manual.', {
                    title: 'Gagal menyalin'
                });
            });
    }

    function updateReadStatus() {
        const checks = document.querySelectorAll('.read-check');
        const status = document.getElementById('readStatus');

        let allChecked = true;

        checks.forEach(function (check) {
            if (!check.checked) {
                allChecked = false;
            }
        });

        if (allChecked && checks.length > 0) {
            status.classList.add('done');
            status.innerText = 'Materi ditandai selesai dibaca.';
        } else {
            status.classList.remove('done');
            status.innerText = 'Tandai semua checklist jika materi sudah selesai dibaca.';
        }
    }

    document.querySelectorAll('.read-check').forEach(function (check) {
        check.addEventListener('change', updateReadStatus);
    });

    updateReadStatus();
</script>
@endsection
