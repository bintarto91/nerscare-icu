@extends('layouts.app')

@section('title', 'Tambah Pasien ICU')
@section('page_title', 'Tambah Pasien ICU')
@section('page_subtitle', 'Input data pasien ICU sebelum dilakukan assessment loneliness.')

@section('content')
<div class="clinical-note">
    <strong>Konfirmasi sebelum assessment:</strong>
    Pasien yang dapat dilakukan assessment adalah pasien ICU yang sadar, mampu berkomunikasi,
    memahami pertanyaan sederhana, dan bersedia mengikuti assessment.
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Form Tambah Pasien</h3>
            <p>Lengkapi identitas, kondisi komunikasi, dan data perawat pengisi.</p>
        </div>

        <a class="btn btn-light btn-sm" href="{{ route('patients.index') }}">
            Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('patients.store') }}">
        @csrf

        @include('patients.form', ['patient' => null])

        <div class="actions" style="margin-top: 22px;">
            <button class="btn" type="submit">
                Simpan Data Pasien
            </button>

            <a class="btn btn-secondary" href="{{ route('patients.index') }}">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
