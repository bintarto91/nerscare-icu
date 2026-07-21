@extends('layouts.app')

@section('title', 'Edit Pengaturan Interpretasi')
@section('page_title', 'Edit Pengaturan Interpretasi')
@section('page_subtitle', 'Perbarui rentang skor, kategori, interpretasi, dan rekomendasi.')

@section('content')
<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Form Edit Pengaturan</h3>
            <p>Perbarui kategori <strong>{{ $interpretation->category }}</strong>.</p>
        </div>

        <a href="{{ route('interpretations.index') }}" class="btn btn-light btn-sm">
            ← Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('interpretations.update', $interpretation) }}">
        @csrf
        @method('PUT')

        @include('assessment_interpretations.form', ['interpretation' => $interpretation])

        <div class="actions" style="margin-top: 22px;">
            <button class="btn" type="submit">
                Update Pengaturan
            </button>

            <a href="{{ route('interpretations.index') }}" class="btn btn-secondary">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection