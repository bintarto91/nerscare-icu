@extends('layouts.app')

@section('title', 'Edit Pengguna')
@section('page_title', 'Edit Pengguna')
@section('page_subtitle', 'Perbarui data akun dan hak akses pengguna.')

@section('content')
<div class="clinical-note">
    <strong>Catatan:</strong>
    Kosongkan password apabila tidak ingin mengganti password pengguna.
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Form Edit Pengguna</h3>
            <p>
                Perbarui akun <strong>{{ $user->name }}</strong>.
            </p>
        </div>

        <a href="{{ route('users.index') }}" class="btn btn-light btn-sm">
            Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf
        @method('PUT')

        @include('users.form', ['user' => $user])

        <div class="actions" style="margin-top: 22px;">
            <button class="btn" type="submit">
                Update Pengguna
            </button>

            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
