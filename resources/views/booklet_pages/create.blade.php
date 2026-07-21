@extends('layouts.app')

@section('title', 'Tambah Halaman Booklet')
@section('page_title', 'Tambah Halaman Booklet')
@section('page_subtitle', 'Tambahkan halaman baru untuk booklet landing page.')

@section('content')
<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Form Tambah Halaman</h3>
            <p>Lengkapi label, judul, isi, poin, urutan, dan status aktif.</p>
        </div>

        <a href="{{ route('booklet-pages.index') }}" class="btn btn-light btn-sm">
            &lt; Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('booklet-pages.store') }}">
        @csrf

        @include('booklet_pages.form', ['bookletPage' => null, 'nextOrder' => $nextOrder])

        <div class="actions" style="margin-top: 22px;">
            <button type="submit" class="btn">
                Simpan Halaman
            </button>

            <a href="{{ route('booklet-pages.index') }}" class="btn btn-secondary">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
