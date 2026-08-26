@extends('layouts.app')

@section('title', 'Matriks Keputusan AI')
@section('page_title', 'Matriks Keputusan AI')
@section('page_subtitle', 'Referensi 11 kode keputusan berdasarkan skor emotional dan social loneliness.')

@section('content')
<style>
    .category-scale {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 10px;
        margin-bottom: 18px;
    }

    .category-scale div {
        padding: 14px;
        border: 1px solid #dbe6ea;
        border-radius: 14px;
        background: #f8fbfc;
    }

    .category-scale strong,
    .category-scale span {
        display: block;
    }

    .category-scale strong {
        color: #0b6f73;
        font-size: 18px;
    }

    .category-scale span {
        margin-top: 4px;
        color: #526978;
        font-size: 12px;
        font-weight: 800;
    }

    .decision-list {
        display: grid;
        gap: 16px;
    }

    .decision-card {
        overflow: hidden;
        border: 1px solid #dbe6ea;
        border-radius: 18px;
        background: white;
    }

    .decision-card-header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        border-bottom: 1px solid #dbe6ea;
        background: #edf7f8;
    }

    .decision-code {
        min-width: 52px;
        height: 38px;
        display: grid;
        place-items: center;
        border-radius: 12px;
        background: #0b6f73;
        color: white;
        font-size: 15px;
        font-weight: 900;
    }

    .decision-card-header strong {
        color: #0f172a;
    }

    .decision-card-header span {
        display: block;
        margin-top: 3px;
        color: #526978;
        font-size: 12px;
    }

    .decision-output-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .decision-output {
        padding: 16px;
        border-right: 1px solid #e5edf0;
        border-bottom: 1px solid #e5edf0;
    }

    .decision-output:nth-child(2n) {
        border-right: 0;
    }

    .decision-output:nth-last-child(-n+2) {
        border-bottom: 0;
    }

    .decision-output strong {
        display: block;
        margin-bottom: 7px;
        color: #0b6f73;
        font-size: 12px;
        letter-spacing: .25px;
        text-transform: uppercase;
    }

    .decision-output p {
        margin: 0;
        color: #3f5664;
        font-size: 13px;
        line-height: 1.65;
    }

    @media(max-width: 760px) {
        .category-scale,
        .decision-output-grid {
            grid-template-columns: 1fr;
        }

        .decision-output,
        .decision-output:nth-child(2n),
        .decision-output:nth-last-child(-n+2) {
            border-right: 0;
            border-bottom: 1px solid #e5edf0;
        }

        .decision-output:last-child {
            border-bottom: 0;
        }
    }
</style>

<div class="clinical-note">
    <strong>Referensi baku:</strong>
    Matriks ini mengikuti dokumen Decision AI terbaru dan dibuat baca-saja untuk mencegah perubahan yang dapat membuat hasil klinis tidak konsisten. Profil emotional dan social dibandingkan setelah dinormalisasi; selisih maksimal 15 poin persentase dinilai relatif seimbang.
</div>

<div class="category-scale" aria-label="Kategori skor loneliness">
    <div><strong>0-2</strong><span>Tidak kesepian</span></div>
    <div><strong>3-8</strong><span>Kesepian tingkat sedang</span></div>
    <div><strong>9-10</strong><span>Kesepian tingkat berat</span></div>
    <div><strong>11</strong><span>Kesepian tingkat sangat berat</span></div>
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Daftar Kode dan Empat Keluaran Keputusan</h3>
            <p>Setiap kode selalu menghasilkan interpretasi, dukungan keperawatan, edukasi keluarga, dan catatan keputusan klinis.</p>
        </div>
    </div>

    <div class="decision-list">
        @foreach($decisions as $decision)
            <article class="decision-card">
                <header class="decision-card-header">
                    <span class="decision-code">{{ $decision['code'] }}</span>
                    <div>
                        <strong>Kode Keputusan {{ $decision['code'] }}</strong>
                        <span>Digunakan otomatis berdasarkan kombinasi skor emotional dan social.</span>
                    </div>
                </header>

                <div class="decision-output-grid">
                    <section class="decision-output">
                        <strong>Interpretasi</strong>
                        <p>{{ $decision['interpretation'] }}</p>
                    </section>
                    <section class="decision-output">
                        <strong>Dukungan Keperawatan</strong>
                        <p>{{ $decision['nursing_recommendation'] }}</p>
                    </section>
                    <section class="decision-output">
                        <strong>Edukasi Keluarga</strong>
                        <p>{{ $decision['family_education_recommendation'] }}</p>
                    </section>
                    <section class="decision-output">
                        <strong>Catatan Keputusan Klinis</strong>
                        <p>{{ $decision['clinical_decision_note'] }}</p>
                    </section>
                </div>
            </article>
        @endforeach
    </div>
</div>
@endsection
