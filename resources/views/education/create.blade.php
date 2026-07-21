@extends('layouts.app')

@section('title', 'Tambah Materi Edukasi')
@section('page_title', 'Tambah Materi Edukasi')
@section('page_subtitle', 'Input materi edukasi untuk perawat atau keluarga pasien ICU.')

@section('content')
<div class="clinical-note">
    <strong>Catatan:</strong>
    Materi edukasi dapat ditujukan untuk perawat atau keluarga pasien.
    Materi yang ingin tampil di menu edukasi harus disimpan dengan status <strong>Published</strong>.
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Form Tambah Materi</h3>
            <p>Lengkapi judul, sasaran, kategori, isi materi, dan status publikasi.</p>
        </div>

        <a class="btn btn-light btn-sm" href="{{ route('education.manage') }}">
            Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('education.store') }}">
        @csrf

        @include('education.form', ['educationContent' => null])

        <div class="actions" style="margin-top: 22px;">
            <button class="btn" type="submit">
                Simpan Materi
            </button>

            <a class="btn btn-secondary" href="{{ route('education.manage') }}">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
