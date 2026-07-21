@extends('layouts.app')

@section('title', 'Edit Halaman Booklet')
@section('page_title', 'Edit Halaman Booklet')
@section('page_subtitle', 'Perbarui isi halaman booklet landing page.')

@section('content')
<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Form Edit Halaman</h3>
            <p>Perbarui label, judul, isi, poin, urutan, dan status aktif.</p>
        </div>

        <a href="{{ route('booklet-pages.index') }}" class="btn btn-light btn-sm">
            &lt; Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('booklet-pages.update', $bookletPage) }}">
        @csrf
        @method('PUT')

        @include('booklet_pages.form', ['bookletPage' => $bookletPage])

        <div class="actions" style="margin-top: 22px;">
            <button type="submit" class="btn">
                Update Halaman
            </button>

            <a href="{{ route('booklet-pages.index') }}" class="btn btn-secondary">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
