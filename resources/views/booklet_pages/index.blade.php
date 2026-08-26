@extends('layouts.app')

@section('title', 'Kelola Booklet')
@section('page_title', 'Kelola Booklet')
@section('page_subtitle', 'Atur seluruh teks, PDF, halaman, urutan, dan penayangan flipbook tanpa mengubah kode.')

@section('content')
<style>
    .booklet-admin-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:18px; }
    .settings-role { padding:18px; border:1px solid #dbe7eb; border-radius:14px; background:#f8fbfc; }
    .settings-role h4 { margin:0 0 14px; color:#0f172a; }
    .current-file { margin-top:8px; font-size:13px; }
    .current-file a { color:#0f766e; font-weight:800; }
    .filter-box { background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:16px; margin-bottom:18px; }
    .filter-grid { display:grid; grid-template-columns:1fr 190px 160px auto auto; gap:10px; align-items:end; }
    .filter-group label { font-size:12px; font-weight:800; color:#475569; margin-bottom:6px; }
    .page-thumb { width:76px; aspect-ratio:1190/1684; object-fit:cover; border-radius:7px; border:1px solid #d8e4ea; background:#eef4f6; }
    .booklet-order { display:inline-flex; width:38px; height:38px; border-radius:13px; align-items:center; justify-content:center; background:#edf7f8; color:#0b6f73; font-weight:900; }
    .booklet-title { color:#0f172a; font-weight:900; margin-bottom:5px; }
    .booklet-preview { color:#64748b; font-size:13px; line-height:1.5; }
    .audience-family { background:#dff8f2; color:#0f766e; }
    .audience-nurse { background:#e7efff; color:#1d4ed8; }
    .status-active { background:#dcfce7; color:#166534; }
    .status-inactive { background:#fee2e2; color:#991b1b; }
    .table-responsive { overflow-x:auto; }
    @media(max-width:900px) { .booklet-admin-grid,.filter-grid { grid-template-columns:1fr; } }
</style>

<div class="clinical-note">
    <strong>Sudah dinamis:</strong> perubahan di halaman ini langsung dipakai oleh flipbook beranda dan pembaca lengkap. Auto-flip saat ini diatur setiap {{ $settings['booklet_autoplay_seconds'] }} detik dan berhenti setelah pengunjung mengontrol booklet secara manual.
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Identitas & PDF Booklet</h3>
            <p>Atur judul bagian, deskripsi, kecepatan otomatis, dan dokumen PDF untuk kedua peran.</p>
        </div>
        <a href="{{ route('public.landing') }}#booklet-edukasi" class="btn btn-light btn-sm" target="_blank">Lihat di Web</a>
    </div>

    <form method="POST" action="{{ route('booklet-settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group" style="max-width:360px">
            <label>Label Kecil Bagian</label>
            <input type="text" name="booklet_section_kicker" value="{{ old('booklet_section_kicker', $settings['booklet_section_kicker']) }}" required>
        </div>
        <div class="form-group">
            <label>Judul Bagian Booklet</label>
            <input type="text" name="booklet_section_title" value="{{ old('booklet_section_title', $settings['booklet_section_title']) }}" required>
        </div>
        <div class="form-group">
            <label>Deskripsi Bagian</label>
            <textarea name="booklet_section_description" style="min-height:90px" required>{{ old('booklet_section_description', $settings['booklet_section_description']) }}</textarea>
        </div>
        <div class="booklet-admin-grid">
            <div class="form-group"><label>Catatan Klinis di Beranda</label><textarea name="booklet_clinical_note" style="min-height:100px" required>{{ old('booklet_clinical_note', $settings['booklet_clinical_note']) }}</textarea></div>
            <div class="form-group"><label>Catatan di Pembaca Lengkap</label><textarea name="booklet_reader_note" style="min-height:100px" required>{{ old('booklet_reader_note', $settings['booklet_reader_note']) }}</textarea></div>
        </div>
        <div class="form-group" style="max-width:260px">
            <label>Auto-flip (detik)</label>
            <input type="number" name="booklet_autoplay_seconds" min="1" max="30" value="{{ old('booklet_autoplay_seconds', $settings['booklet_autoplay_seconds']) }}" required>
            <small>Di beranda; berhenti setelah interaksi manual.</small>
        </div>

        <div class="booklet-admin-grid">
            @foreach(['family' => 'Keluarga', 'nurse' => 'Perawat'] as $role => $label)
                <section class="settings-role">
                    <h4>Booklet {{ $label }}</h4>
                    <div class="form-group">
                        <label>Judul</label>
                        <input type="text" name="booklet_{{ $role }}_title" value="{{ old('booklet_'.$role.'_title', $settings['booklet_'.$role.'_title']) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="booklet_{{ $role }}_description" style="min-height:100px" required>{{ old('booklet_'.$role.'_description', $settings['booklet_'.$role.'_description']) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Ganti PDF (opsional)</label>
                        <input type="file" name="booklet_{{ $role }}_pdf_upload" accept="application/pdf">
                        <div class="current-file"><a href="{{ asset($settings['booklet_'.$role.'_pdf']) }}" target="_blank">Buka PDF yang sedang aktif</a></div>
                    </div>
                </section>
            @endforeach
        </div>

        <div class="actions" style="margin-top:20px">
            <button class="btn" type="submit">Simpan Pengaturan Booklet</button>
        </div>
    </form>
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Halaman Flipbook</h3>
            <p>Unggah gambar halaman, atur urutan, teks aksesibilitas, dan status tampil.</p>
        </div>
        <a href="{{ route('booklet-pages.create', ['audience' => $audience ?: 'keluarga']) }}" class="btn btn-sm">+ Tambah Halaman</a>
    </div>

    <form method="GET" action="{{ route('booklet-pages.index') }}" class="filter-box">
        <div class="filter-grid">
            <div class="filter-group"><label>Cari</label><input type="text" name="search" value="{{ $search }}" placeholder="Judul atau deskripsi halaman"></div>
            <div class="filter-group"><label>Booklet</label><select name="audience"><option value="">Semua</option><option value="keluarga" {{ $audience === 'keluarga' ? 'selected' : '' }}>Keluarga</option><option value="perawat" {{ $audience === 'perawat' ? 'selected' : '' }}>Perawat</option></select></div>
            <div class="filter-group"><label>Status</label><select name="status"><option value="">Semua</option><option value="1" {{ $status === '1' ? 'selected' : '' }}>Aktif</option><option value="0" {{ $status === '0' ? 'selected' : '' }}>Nonaktif</option></select></div>
            <button class="btn" type="submit">Filter</button>
            <a href="{{ route('booklet-pages.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <div class="table-responsive">
        <table>
            <thead><tr><th width="70">Urutan</th><th width="100">Gambar</th><th>Halaman</th><th width="120">Booklet</th><th width="100">Status</th><th width="190">Aksi</th></tr></thead>
            <tbody>
            @forelse($pages as $page)
                <tr>
                    <td><span class="booklet-order">{{ $page->sort_order }}</span></td>
                    <td><img class="page-thumb" src="{{ $page->image_url }}" alt=""></td>
                    <td><div class="booklet-title">{{ $page->title }}</div><div class="booklet-preview">{{ $page->kicker ?: 'Halaman '.$page->sort_order }} · {{ \Illuminate\Support\Str::limit($page->body, 120) }}</div></td>
                    <td><span class="badge {{ $page->audience === 'keluarga' ? 'audience-family' : 'audience-nurse' }}">{{ ucfirst($page->audience) }}</span></td>
                    <td><span class="badge {{ $page->is_active ? 'status-active' : 'status-inactive' }}">{{ $page->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                    <td><div class="actions"><a href="{{ route('booklet-pages.edit', $page) }}" class="btn btn-warning btn-sm">Edit</a><form method="POST" action="{{ route('booklet-pages.destroy', $page) }}" data-confirm="Yakin hapus halaman ini?">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm">Hapus</button></form></div></td>
                </tr>
            @empty
                <tr><td colspan="6"><div class="empty-state">Belum ada halaman sesuai filter.</div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:18px">{{ $pages->links() }}</div>
</div>
@endsection
