@extends('layouts.app')

@section('title', 'Manajemen Pengguna')
@section('page_title', 'Manajemen Pengguna')
@section('page_subtitle', 'Kelola akun admin, perawat, dan keluarga pasien.')

@section('content')
<style>
    .user-hero {
        background: linear-gradient(135deg, #0b6f73, #2563a9);
        color: white;
        border-radius: 8px;
        padding: 24px;
        margin-bottom: 22px;
        box-shadow: 0 18px 45px rgba(15, 118, 110, .18);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
    }

    .user-hero h2 {
        margin: 0 0 8px;
        font-size: 27px;
    }

    .user-hero p {
        margin: 0;
        color: #d9fffb;
        line-height: 1.6;
    }

    .filter-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 18px;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: 1fr 220px auto auto;
        gap: 10px;
        align-items: end;
    }

    .filter-group label {
        font-size: 12px;
        font-weight: 800;
        color: #475569;
        margin-bottom: 6px;
    }

    .user-name {
        font-weight: 900;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .user-email {
        color: #64748b;
        font-size: 13px;
    }

    .role-pill,
    .status-pill {
        display: inline-flex;
        padding: 6px 11px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 900;
    }

    .role-admin {
        background: #fee2e2;
        color: #991b1b;
    }

    .role-perawat {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .role-keluarga {
        background: #fce7f3;
        color: #be185d;
    }

    .status-aktif {
        background: #dcfce7;
        color: #166534;
    }

    .status-nonaktif {
        background: #fef3c7;
        color: #92400e;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .pagination-box {
        margin-top: 18px;
    }

    @media(max-width: 900px) {
        .filter-grid {
            grid-template-columns: 1fr;
        }

        .user-hero .btn {
            width: 100%;
        }
    }
</style>

@php
    $hasUnitKerja = \Illuminate\Support\Facades\Schema::hasColumn('users', 'unit_kerja');
    $hasStatus = \Illuminate\Support\Facades\Schema::hasColumn('users', 'status');
@endphp

<div class="user-hero">
    <div>
        <h2>Manajemen Pengguna</h2>
        <p>
            Tambah, edit, hapus, dan atur role pengguna sistem:
            admin, perawat, atau keluarga.
        </p>
    </div>

    <a href="{{ route('users.create') }}" class="btn">
        + Tambah Pengguna
    </a>
</div>

<div class="clinical-note">
    <strong>Catatan:</strong>
    Akun admin memiliki akses penuh. Akun perawat digunakan untuk input pasien dan assessment.
    Akun keluarga dibatasi untuk akses edukasi keluarga.
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Daftar Pengguna</h3>
            <p>Kelola akun pengguna dan hak akses sistem.</p>
        </div>
    </div>

    <form method="GET" action="{{ route('users.index') }}" class="filter-box">
        <div class="filter-grid">
            <div class="filter-group">
                <label>Cari Pengguna</label>
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Cari nama atau email..."
                >
            </div>

            <div class="filter-group">
                <label>Role</label>
                <select name="role">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="perawat" {{ $role === 'perawat' ? 'selected' : '' }}>Perawat</option>
                    <option value="keluarga" {{ $role === 'keluarga' ? 'selected' : '' }}>Keluarga</option>
                </select>
            </div>

            <button class="btn" type="submit">
                Filter
            </button>

            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                Reset
            </a>
        </div>
    </form>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Pengguna</th>
                    <th>Role</th>
                    @if($hasUnitKerja)
                        <th>Unit Kerja</th>
                    @endif
                    @if($hasStatus)
                        <th>Status</th>
                    @endif
                    <th>Dibuat</th>
                    <th width="210">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $user)
                    @php
                        $roleClass = match($user->role) {
                            'admin' => 'role-admin',
                            'perawat' => 'role-perawat',
                            'keluarga' => 'role-keluarga',
                            default => 'role-perawat',
                        };

                        $statusValue = $hasStatus ? ($user->status ?? 'aktif') : 'aktif';
                        $statusClass = $statusValue === 'aktif' ? 'status-aktif' : 'status-nonaktif';
                    @endphp

                    <tr>
                        <td>
                            <div class="user-name">{{ $user->name }}</div>
                            <div class="user-email">{{ $user->email }}</div>
                        </td>

                        <td>
                            <span class="role-pill {{ $roleClass }}">
                                {{ strtoupper($user->role) }}
                            </span>
                        </td>

                        @if($hasUnitKerja)
                            <td>{{ $user->unit_kerja ?: '-' }}</td>
                        @endif

                        @if($hasStatus)
                            <td>
                                <span class="status-pill {{ $statusClass }}">
                                    {{ strtoupper($statusValue) }}
                                </span>
                            </td>
                        @endif

                        <td>
                            {{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '-' }}
                        </td>

                        <td>
                            <div class="actions">
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                @if($user->id !== auth()->id())
                                    <form
                                        method="POST"
                                        action="{{ route('users.destroy', $user) }}"
                                        data-confirm="Yakin hapus pengguna ini?"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm" type="submit">
                                            Hapus
                                        </button>
                                    </form>
                                @else
                                    <span class="badge">Akun Aktif</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                Belum ada data pengguna.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-box">
        {{ $users->links() }}
    </div>
</div>
@endsection
