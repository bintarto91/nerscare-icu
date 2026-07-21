@extends('layouts.app')

@section('title', 'Edit Pertanyaan')
@section('page_title', 'Edit Pertanyaan Assessment')
@section('page_subtitle', 'Perbarui pertanyaan assessment loneliness.')

@section('content')
<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Form Edit Pertanyaan</h3>
            <p>Perbarui teks pertanyaan, urutan, dan status aktif.</p>
        </div>

        <a href="{{ route('questions.index') }}" class="btn btn-light btn-sm">
            ← Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('questions.update', $question) }}">
        @csrf
        @method('PUT')

        @include('assessment_questions.form', ['question' => $question])

        <div class="actions" style="margin-top: 22px;">
            <button type="submit" class="btn">
                Update Pertanyaan
            </button>

            <a href="{{ route('questions.index') }}" class="btn btn-secondary">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection