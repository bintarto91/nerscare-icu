@extends('layouts.app')

@section('title', 'Edit Pasien ICU')
@section('page_title', 'Edit Pasien ICU')
@section('page_subtitle', 'Perbarui data pasien ICU dan status kelayakan assessment.')

@section('content')
<div class="clinical-note">
    <strong>Catatan:</strong>
    Perubahan pada konfirmasi kondisi pasien akan memengaruhi tombol lanjut assessment.
    Pastikan pasien sadar, mampu berkomunikasi, memahami pertanyaan, dan bersedia mengikuti assessment.
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Form Edit Pasien</h3>
            <p>Perbarui data pasien <strong>{{ $patient->nama_inisial }}</strong> dengan kode <strong>{{ $patient->kode_pasien }}</strong>.</p>
        </div>

        <a class="btn btn-light btn-sm" href="{{ route('patients.show', $patient) }}">
            Detail Pasien
        </a>
    </div>

    <form method="POST" action="{{ route('patients.update', $patient) }}">
        @csrf
        @method('PUT')

        @include('patients.form', ['patient' => $patient])

        <div class="actions" style="margin-top: 22px;">
            <button class="btn" type="submit">
                Update Data Pasien
            </button>

            <a class="btn btn-secondary" href="{{ route('patients.index') }}">
                Kembali
            </a>
        </div>
    </form>
</div>
@endsection
