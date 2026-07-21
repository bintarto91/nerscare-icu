@extends('layouts.app')

@section('title', 'Booklet Landing')
@section('page_title', 'Booklet Landing')
@section('page_subtitle', 'Kelola halaman booklet edukasi yang tampil di landing page.')

@section('content')
<style>
    .booklet-order {
        display: inline-flex;
        width: 38px;
        height: 38px;
        border-radius: 13px;
        align-items: center;
        justify-content: center;
        background: #edf7f8;
        color: #0b6f73;
        font-weight: 900;
    }

    .booklet-title {
        color: #0f172a;
        font-weight: 900;
        margin-bottom: 6px;
    }

    .booklet-preview {
        color: #475569;
        line-height: 1.6;
        font-size: 14px;
    }

    .booklet-points-preview {
        margin: 8px 0 0;
        padding-left: 18px;
        color: #64748b;
        font-size: 13px;
        line-height: 1.5;
    }

    .status-active {
        background: #dcfce7;
        color: #166534;
    }

    .status-inactive {
        background: #fee2e2;
        color: #991b1b;
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

    .table-responsive {
        overflow-x: auto;
    }

    @media(max-width: 800px) {
        .filter-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="clinical-note">
    <strong>Catatan:</strong>
    Halaman aktif akan muncul otomatis di booklet landing page. Urutan ganjil-genap akan dibaca seperti halaman kiri dan kanan buku.
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Daftar Halaman Booklet</h3>
            <p>Atur judul, isi, poin, urutan, dan status halaman booklet.</p>
        </div>

        <a href="{{ route('booklet-pages.create') }}" class="btn btn-sm">
            + Tambah Halaman
        </a>
    </div>

    <form method="GET" action="{{ route('booklet-pages.index') }}" class="filter-box">
        <div class="filter-grid">
            <div class="filter-group">
                <label>Cari Konten</label>
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Cari judul, isi, atau label halaman..."
                >
            </div>

            <div class="filter-group">
                <label>Status</label>
                <select name="status">
                    <option value="">Semua Status</option>
                    <option value="1" {{ $status === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ $status === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <button class="btn" type="submit">Filter</button>

            <a href="{{ route('booklet-pages.index') }}" class="btn btn-secondary">
                Reset
            </a>
        </div>
    </form>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th width="80">Urutan</th>
                    <th>Isi Halaman</th>
                    <th width="130">Status</th>
                    <th width="210">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pages as $page)
                    <tr>
                        <td>
                            <span class="booklet-order">{{ $page->sort_order }}</span>
                        </td>

                        <td>
                            <div class="booklet-title">{{ $page->title }}</div>
                            <div class="booklet-preview">
                                <strong>{{ $page->kicker ?: 'Halaman ' . $page->sort_order }}</strong>
                                <br>
                                {{ \Illuminate\Support\Str::limit($page->body, 180) }}
                            </div>

                            @if(!empty($page->points))
                                <ul class="booklet-points-preview">
                                    @foreach(array_slice($page->points, 0, 3) as $point)
                                        <li>{{ $point }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>

                        <td>
                            @if($page->is_active)
                                <span class="badge status-active">Aktif</span>
                            @else
                                <span class="badge status-inactive">Nonaktif</span>
                            @endif
                        </td>

                        <td>
                            <div class="actions">
                                <a href="{{ route('booklet-pages.edit', $page) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('booklet-pages.destroy', $page) }}"
                                    data-confirm="Yakin hapus halaman booklet ini?"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                Belum ada halaman booklet.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:18px;">
        {{ $pages->links() }}
    </div>
</div>
@endsection
