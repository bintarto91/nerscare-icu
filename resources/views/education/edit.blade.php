@extends('layouts.app')

@section('title', 'Edit Materi Edukasi')
@section('page_title', 'Edit Materi Edukasi')
@section('page_subtitle', 'Perbarui materi edukasi yang sudah ada.')

@section('content')
<div class="clinical-note">
    <strong>Catatan:</strong>
    Perubahan materi akan langsung berpengaruh pada menu Edukasi Perawat atau Edukasi Keluarga
    apabila status materi adalah <strong>Published</strong>.
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Form Edit Materi</h3>
            <p>
                Perbarui materi <strong>{{ $educationContent->title }}</strong>.
            </p>
        </div>

        <div class="actions">
            <a class="btn btn-light btn-sm" href="{{ route('education.show', $educationContent) }}">
                Preview
            </a>

            <a class="btn btn-secondary btn-sm" href="{{ route('education.manage') }}">
                Kembali
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('education.update', $educationContent) }}">
        @csrf
        @method('PUT')

        @include('education.form', ['educationContent' => $educationContent])

        <div class="actions" style="margin-top: 22px;">
            <button class="btn" type="submit">
                Update Materi
            </button>

            <a class="btn btn-light" href="{{ route('education.show', $educationContent) }}">
                Preview
            </a>

            <a class="btn btn-secondary" href="{{ route('education.manage') }}">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
