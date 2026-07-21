@extends('layouts.app')

@section('title', 'Manajemen Pertanyaan')
@section('page_title', 'Manajemen Pertanyaan Assessment')
@section('page_subtitle', 'Kelola pertanyaan yang digunakan dalam assessment loneliness.')

@section('content')
<style>
    .question-text {
        font-weight: 800;
        color: #0f172a;
        line-height: 1.6;
    }

    .question-order {
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
    Pertanyaan aktif akan tampil pada menu Assessment Loneliness. Jika pertanyaan dinonaktifkan,
    pertanyaan tersebut tidak akan muncul saat perawat melakukan assessment baru.
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Daftar Pertanyaan Assessment</h3>
            <p>Atur pertanyaan, urutan, dan status aktif/nonaktif.</p>
        </div>

        <a href="{{ route('questions.create') }}" class="btn btn-sm">
            + Tambah Pertanyaan
        </a>
    </div>

    <form method="GET" action="{{ route('questions.index') }}" class="filter-box">
        <div class="filter-grid">
            <div class="filter-group">
                <label>Cari Pertanyaan</label>
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Cari teks pertanyaan..."
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

            <a href="{{ route('questions.index') }}" class="btn btn-secondary">
                Reset
            </a>
        </div>
    </form>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th width="80">Urutan</th>
                    <th>Pertanyaan</th>
                    <th width="130">Status</th>
                    <th width="210">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($questions as $question)
                    <tr>
                        <td>
                            <span class="question-order">{{ $question->sort_order }}</span>
                        </td>

                        <td>
                            <div class="question-text">
                                {{ $question->question_text }}
                            </div>
                        </td>

                        <td>
                            @if($question->is_active)
                                <span class="badge status-active">Aktif</span>
                            @else
                                <span class="badge status-inactive">Nonaktif</span>
                            @endif
                        </td>

                        <td>
                            <div class="actions">
                                <a href="{{ route('questions.edit', $question) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('questions.destroy', $question) }}"
                                    data-confirm="Yakin hapus pertanyaan ini?"
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
                                Belum ada pertanyaan assessment.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:18px;">
        {{ $questions->links() }}
    </div>
</div>
@endsection
