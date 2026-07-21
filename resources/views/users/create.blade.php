@extends('layouts.app')

@section('title', 'Tambah Pengguna')
@section('page_title', 'Tambah Pengguna')
@section('page_subtitle', 'Buat akun baru untuk admin, perawat, atau keluarga.')

@section('content')
<div class="clinical-note">
    <strong>Catatan:</strong>
    Role menentukan menu yang dapat diakses pengguna. Admin memiliki akses penuh,
    perawat dapat mengelola pasien dan assessment, keluarga hanya untuk edukasi keluarga.
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Form Tambah Pengguna</h3>
            <p>Lengkapi data akun dan role pengguna.</p>
        </div>

        <a href="{{ route('users.index') }}" class="btn btn-light btn-sm">
            Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('users.store') }}">
        @csrf

        @include('users.form', ['user' => null])

        <div class="actions" style="margin-top: 22px;">
            <button class="btn" type="submit">
                Simpan Pengguna
            </button>

            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
