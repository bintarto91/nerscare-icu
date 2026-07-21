@extends('layouts.app')

@section('title', 'Tambah Pertanyaan')
@section('page_title', 'Tambah Pertanyaan Assessment')
@section('page_subtitle', 'Tambah pertanyaan baru untuk instrumen loneliness.')

@section('content')
<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Form Tambah Pertanyaan</h3>
            <p>Lengkapi teks pertanyaan, urutan, dan status aktif.</p>
        </div>

        <a href="{{ route('questions.index') }}" class="btn btn-light btn-sm">
            ← Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('questions.store') }}">
        @csrf

        @include('assessment_questions.form', ['question' => null, 'nextOrder' => $nextOrder])

        <div class="actions" style="margin-top: 22px;">
            <button type="submit" class="btn">
                Simpan Pertanyaan
            </button>

            <a href="{{ route('questions.index') }}" class="btn btn-secondary">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection