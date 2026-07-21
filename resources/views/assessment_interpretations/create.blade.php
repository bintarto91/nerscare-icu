@extends('layouts.app')

@section('title', 'Tambah Pengaturan Interpretasi')
@section('page_title', 'Tambah Pengaturan Interpretasi')
@section('page_subtitle', 'Tambah rentang skor, kategori, interpretasi, dan rekomendasi.')

@section('content')
<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Form Tambah Pengaturan</h3>
            <p>Lengkapi rentang skor dan kalimat hasil assessment.</p>
        </div>

        <a href="{{ route('interpretations.index') }}" class="btn btn-light btn-sm">
            ← Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('interpretations.store') }}">
        @csrf

        @include('assessment_interpretations.form', ['interpretation' => null])

        <div class="actions" style="margin-top: 22px;">
            <button class="btn" type="submit">
                Simpan Pengaturan
            </button>

            <a href="{{ route('interpretations.index') }}" class="btn btn-secondary">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection