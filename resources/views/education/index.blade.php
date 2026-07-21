@extends('layouts.app')

@section('title', $title)
@section('page_title', $title)
@section('page_subtitle', $description)

@section('content')
<style>
    .education-hero {
        background: linear-gradient(135deg, #0b6f73, #2563a9);
        color: white;
        border-radius: 8px;
        padding: 24px;
        margin-bottom: 22px;
        box-shadow: 0 18px 45px rgba(15, 118, 110, .18);
        display: grid;
        grid-template-columns: 1.2fr .8fr;
        gap: 18px;
        align-items: center;
    }

    .education-hero h2 {
        margin: 0 0 8px;
        font-size: 28px;
    }

    .education-hero p {
        margin: 0;
        color: #d9fffb;
        line-height: 1.7;
    }

    .education-note {
        background: rgba(255,255,255,.14);
        border: 1px solid rgba(255,255,255,.24);
        border-radius: 8px;
        padding: 16px;
        font-size: 14px;
        line-height: 1.6;
    }

    .education-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
    }

    .education-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 12px 35px rgba(15,23,42,.06);
        display: flex;
        flex-direction: column;
        min-height: 280px;
        transition: .18s;
    }

    .education-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 42px rgba(15,23,42,.09);
    }

    .education-icon {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        background: #edf7f8;
        color: #0b6f73;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 23px;
        margin-bottom: 14px;
    }

    .education-card h3 {
        margin: 0 0 9px;
        font-size: 18px;
        color: #0f172a;
        line-height: 1.4;
    }

    .education-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        margin-bottom: 12px;
    }

    .education-badge {
        display: inline-flex;
        padding: 5px 10px;
        border-radius: 999px;
        background: #e6f3f5;
        color: #0b6f73;
        font-size: 12px;
        font-weight: 900;
    }

    .education-category {
        display: inline-flex;
        padding: 5px 10px;
        border-radius: 999px;
        background: #dbeafe;
        color: #1d4ed8;
        font-size: 12px;
        font-weight: 800;
    }

    .education-excerpt {
        color: #475569;
        font-size: 14px;
        line-height: 1.65;
        margin-bottom: 18px;
        flex: 1;
    }

    .education-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: auto;
    }

    .empty-education {
        background: white;
        border: 1px dashed #cbd5e1;
        border-radius: 8px;
        padding: 34px;
        text-align: center;
        color: #64748b;
        line-height: 1.7;
    }

    .empty-education h3 {
        margin: 0 0 8px;
        color: #0f172a;
    }

    .education-pagination {
        margin-top: 22px;
    }

    @media(max-width: 1100px) {
        .education-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .education-hero {
            grid-template-columns: 1fr;
        }
    }

    @media(max-width: 700px) {
        .education-grid {
            grid-template-columns: 1fr;
        }

        .education-hero {
            padding: 22px;
        }

        .education-hero h2 {
            font-size: 23px;
        }
    }
</style>

@php
    $isPerawat = str_contains(strtolower($title), 'perawat');
@endphp

<div class="education-hero">
    <div>
        <h2>{{ $title }}</h2>
        <p>{{ $description }}</p>
    </div>

    <div class="education-note">
        @if($isPerawat)
            <strong>Fokus Edukasi Perawat</strong><br>
            Materi membantu perawat memahami loneliness pasien ICU, komunikasi terapeutik,
            dukungan emosional, dan edukasi kepada keluarga.
        @else
            <strong>Fokus Edukasi Keluarga</strong><br>
            Materi membantu keluarga memberikan dukungan emosional, komunikasi positif,
            dan pendampingan sesuai arahan perawat ICU.
        @endif
    </div>
</div>

<div class="clinical-note">
    <strong>Catatan:</strong>
    Materi edukasi digunakan sebagai panduan pendukung. Pelaksanaan edukasi tetap mengikuti
    kebijakan ruang ICU dan arahan tenaga kesehatan.
</div>

@if($contents->count() > 0)
    <div class="education-grid">
        @foreach($contents as $content)
            <div class="education-card">
                <div class="education-icon">
                    @include('partials.ui-icon', ['name' => $isPerawat ? 'book' : 'family'])
                </div>

                <h3>{{ $content->title }}</h3>

                <div class="education-meta">
                    <span class="education-badge">
                        {{ strtoupper($content->target) }}
                    </span>

                    @if($content->category)
                        <span class="education-category">
                            {{ $content->category }}
                        </span>
                    @endif
                </div>

                <div class="education-excerpt">
                    {{ \Illuminate\Support\Str::limit(strip_tags($content->content), 170) }}
                </div>

                <div class="education-actions">
                    <a href="{{ route('education.show', $content) }}" class="btn btn-sm">
                        Lihat Materi
                    </a>

                    <a href="{{ route('education.show', $content) }}" class="btn btn-light btn-sm">
                        Panduan
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="education-pagination">
        {{ $contents->links() }}
    </div>
@else
    <div class="empty-education">
        <h3>Belum ada materi edukasi</h3>
        <p>
            Materi edukasi untuk {{ strtolower($title) }} belum tersedia atau belum dipublikasikan.
            Silakan hubungi admin untuk menambahkan konten edukasi.
        </p>

        @if(auth()->user()->role === 'admin')
            <a href="{{ route('education.create') }}" class="btn">
                + Tambah Materi Edukasi
            </a>
        @endif
    </div>
@endif
@endsection
