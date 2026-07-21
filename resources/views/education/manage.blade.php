@extends('layouts.app')

@section('title', 'Manajemen Konten Edukasi')
@section('page_title', 'Manajemen Konten Edukasi')
@section('page_subtitle', 'Kelola materi edukasi untuk perawat dan keluarga pasien ICU.')

@section('content')
<style>
    .manage-hero {
        background: linear-gradient(135deg, #0b6f73, #2563a9);
        color: white;
        border-radius: 8px;
        padding: 24px;
        margin-bottom: 22px;
        box-shadow: 0 18px 45px rgba(15, 118, 110, .18);
        display: flex;
        justify-content: space-between;
        gap: 18px;
        align-items: center;
        flex-wrap: wrap;
    }

    .manage-hero h2 {
        margin: 0 0 8px;
        font-size: 27px;
    }

    .manage-hero p {
        margin: 0;
        color: #d9fffb;
        line-height: 1.6;
        max-width: 760px;
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
        grid-template-columns: 1fr 240px auto auto;
        gap: 10px;
        align-items: end;
    }

    .filter-group label {
        font-size: 12px;
        font-weight: 800;
        color: #475569;
        margin-bottom: 6px;
    }

    .content-title {
        font-weight: 900;
        color: #0f172a;
        margin-bottom: 6px;
        line-height: 1.4;
    }

    .content-excerpt {
        color: #64748b;
        font-size: 13px;
        line-height: 1.5;
        max-width: 420px;
    }

    .target-badge,
    .status-badge {
        display: inline-flex;
        padding: 6px 11px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 900;
    }

    .target-perawat {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .target-keluarga {
        background: #fce7f3;
        color: #be185d;
    }

    .status-published {
        background: #dcfce7;
        color: #166534;
    }

    .status-draft {
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

        .manage-hero {
            align-items: stretch;
        }

        .manage-hero .btn {
            width: 100%;
        }
    }
</style>

<div class="manage-hero">
    <div>
        <h2>Manajemen Konten Edukasi</h2>
        <p>
            Tambahkan dan kelola materi edukasi untuk perawat maupun keluarga.
            Materi dapat disimpan sebagai draft atau dipublikasikan.
        </p>
    </div>

    <a href="{{ route('education.create') }}" class="btn">
        + Tambah Materi
    </a>
</div>

<div class="clinical-note">
    <strong>Catatan:</strong>
    Materi yang tampil pada menu Edukasi Perawat dan Edukasi Keluarga hanya materi dengan status
    <strong>Published</strong>. Materi berstatus <strong>Draft</strong> hanya terlihat oleh admin.
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Daftar Materi Edukasi</h3>
            <p>Kelola judul, sasaran materi, kategori, status publikasi, dan isi konten.</p>
        </div>
    </div>

    <form method="GET" action="{{ route('education.manage') }}" class="filter-box">
        <div class="filter-grid">
            <div class="filter-group">
                <label>Cari Materi</label>
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Cari judul, kategori, atau isi materi..."
                >
            </div>

            <div class="filter-group">
                <label>Sasaran Materi</label>
                <select name="target">
                    <option value="">Semua Sasaran</option>
                    <option value="perawat" {{ $target === 'perawat' ? 'selected' : '' }}>
                        Perawat
                    </option>
                    <option value="keluarga" {{ $target === 'keluarga' ? 'selected' : '' }}>
                        Keluarga
                    </option>
                </select>
            </div>

            <button class="btn" type="submit">
                Filter
            </button>

            <a href="{{ route('education.manage') }}" class="btn btn-secondary">
                Reset
            </a>
        </div>
    </form>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Materi</th>
                    <th>Sasaran</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Diperbarui</th>
                    <th width="260">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contents as $content)
                    @php
                        $targetClass = $content->target === 'perawat' ? 'target-perawat' : 'target-keluarga';
                        $statusClass = $content->status === 'published' ? 'status-published' : 'status-draft';
                    @endphp

                    <tr>
                        <td>
                            <div class="content-title">
                                {{ $content->title }}
                            </div>

                            <div class="content-excerpt">
                                {{ \Illuminate\Support\Str::limit(strip_tags($content->content), 140) }}
                            </div>
                        </td>

                        <td>
                            <span class="target-badge {{ $targetClass }}">
                                {{ ucfirst($content->target) }}
                            </span>
                        </td>

                        <td>
                            {{ $content->category ?: '-' }}
                        </td>

                        <td>
                            <span class="status-badge {{ $statusClass }}">
                                {{ ucfirst($content->status) }}
                            </span>
                        </td>

                        <td>
                            {{ $content->updated_at ? $content->updated_at->format('d/m/Y H:i') : '-' }}
                        </td>

                        <td>
                            <div class="actions">
                                <a href="{{ route('education.show', $content) }}" class="btn btn-light btn-sm">
                                    Preview
                                </a>

                                <a href="{{ route('education.edit', $content) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('education.destroy', $content) }}"
                                    data-confirm="Yakin hapus materi edukasi ini?"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm" type="submit">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                Belum ada materi edukasi.
                                <br>
                                Klik tombol <strong>Tambah Materi</strong> untuk membuat konten edukasi baru.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-box">
        {{ $contents->links() }}
    </div>
</div>
@endsection
