@extends('layouts.app')

@section('title', 'Pengaturan Interpretasi')
@section('page_title', 'Pengaturan Interpretasi')
@section('page_subtitle', 'Kelola kategori, interpretasi, dan rekomendasi hasil assessment.')

@section('content')
<div class="clinical-note">
    <strong>Catatan:</strong>
    Data di halaman ini digunakan sistem untuk menentukan kategori, interpretasi awal,
    rekomendasi dukungan keperawatan, dan rekomendasi edukasi keluarga berdasarkan total skor assessment.
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Daftar Pengaturan Interpretasi</h3>
            <p>Atur rentang skor dan kalimat hasil assessment.</p>
        </div>

        <a href="{{ route('interpretations.create') }}" class="btn btn-sm">
            + Tambah Pengaturan
        </a>
    </div>

    <form method="GET" action="{{ route('interpretations.index') }}" class="search-row">
        <input
            type="text"
            name="search"
            value="{{ $search }}"
            placeholder="Cari kategori, interpretasi, atau rekomendasi..."
        >

        <button class="btn" type="submit">Cari</button>

        @if($search)
            <a href="{{ route('interpretations.index') }}" class="btn btn-secondary">Reset</a>
        @endif
    </form>

    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Rentang Skor</th>
                <th>Interpretasi</th>
                <th>Status</th>
                <th width="210">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($interpretations as $item)
                <tr>
                    <td>
                        <strong>{{ $item->category }}</strong><br>
                        <span class="muted">Urutan: {{ $item->sort_order }}</span>
                    </td>

                    <td>
                        <span class="badge">
                            {{ $item->min_score }} - {{ $item->max_score }}
                        </span>
                    </td>

                    <td>
                        {{ \Illuminate\Support\Str::limit($item->interpretation, 130) }}
                    </td>

                    <td>
                        @if($item->is_active)
                            <span class="badge">Aktif</span>
                        @else
                            <span class="badge badge-danger">Nonaktif</span>
                        @endif
                    </td>

                    <td>
                        <div class="actions">
                            <a href="{{ route('interpretations.edit', $item) }}" class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form
                                method="POST"
                                action="{{ route('interpretations.destroy', $item) }}"
                                data-confirm="Yakin hapus pengaturan ini?"
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
                    <td colspan="5">
                        <div class="empty-state">
                            Belum ada pengaturan interpretasi.
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 18px;">
        {{ $interpretations->links() }}
    </div>
</div>
@endsection
