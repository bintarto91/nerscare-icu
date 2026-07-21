@extends('layouts.app')

@section('title', 'Riwayat Assessment')
@section('page_title', 'Riwayat Assessment')
@section('page_subtitle', 'Daftar hasil assessment loneliness pasien ICU yang telah tersimpan.')

@section('content')
<style>
    .history-summary {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 20px;
    }

    .summary-box {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 18px;
        box-shadow: 0 12px 35px rgba(15,23,42,.06);
    }

    .summary-label {
        color: #64748b;
        font-size: 13px;
        margin-bottom: 8px;
    }

    .summary-number {
        font-size: 28px;
        font-weight: 900;
        color: #0b6f73;
    }

    .filter-panel {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 18px;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: 1.4fr .8fr .8fr .8fr auto auto;
        gap: 10px;
        align-items: end;
    }

    .filter-group label {
        font-size: 12px;
        font-weight: 800;
        color: #475569;
        margin-bottom: 6px;
    }

    .assessment-patient {
        font-weight: 900;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .assessment-code {
        color: #0b6f73;
        font-size: 13px;
        font-weight: 800;
    }

    .category-badge {
        display: inline-flex;
        padding: 6px 11px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 900;
    }

    .cat-rendah {
        background: #dcfce7;
        color: #166534;
    }

    .cat-sedang {
        background: #fef3c7;
        color: #92400e;
    }

    .cat-tinggi {
        background: #fee2e2;
        color: #991b1b;
    }

    .cat-default {
        background: #e2e8f0;
        color: #334155;
    }

    .score-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 46px;
        height: 34px;
        padding: 0 10px;
        border-radius: 12px;
        background: #edf7f8;
        color: #0b6f73;
        font-weight: 900;
        font-size: 16px;
    }

    .recommendation-preview {
        max-width: 320px;
        color: #475569;
        font-size: 13px;
        line-height: 1.5;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .pagination-box {
        margin-top: 18px;
    }

    @media(max-width: 1150px) {
        .filter-grid {
            grid-template-columns: 1fr 1fr;
        }

        .history-summary {
            grid-template-columns: 1fr;
        }
    }

    @media(max-width: 700px) {
        .filter-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

@php
    $totalShown = $assessments->total();
@endphp

<div class="clinical-note">
    <strong>Catatan:</strong>
    Riwayat assessment digunakan untuk meninjau kembali hasil skor, kategori loneliness,
    interpretasi awal, dan rekomendasi edukasi pasien ICU.
</div>

<div class="history-summary">
    <div class="summary-box">
        <div class="summary-label">Total Riwayat Sesuai Filter</div>
        <div class="summary-number">{{ $totalShown }}</div>
    </div>

    <div class="summary-box">
        <div class="summary-label">Filter Kategori</div>
        <div class="summary-number" style="font-size:22px;">
            {{ $category ?: 'Semua' }}
        </div>
    </div>

    <div class="summary-box">
        <div class="summary-label">Pencarian</div>
        <div class="summary-number" style="font-size:22px;">
            {{ $search ?: 'Tidak Ada' }}
        </div>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Filter Riwayat Assessment</h3>
            <p>Cari berdasarkan pasien, kategori loneliness, dan tanggal assessment.</p>
        </div>

        <button class="btn btn-light btn-sm" onclick="window.print()" type="button">
            🖨️ Cetak Halaman
        </button>
    </div>

    <form method="GET" action="{{ route('assessments.index') }}" class="filter-panel">
        <div class="filter-grid">
            <div class="filter-group">
                <label>Cari Pasien</label>
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Kode pasien, inisial, atau diagnosis..."
                >
            </div>

            <div class="filter-group">
                <label>Kategori</label>
                <select name="category">
                    <option value="">Semua Kategori</option>
                    <option value="Not lonely" {{ $category === 'Not lonely' ? 'selected' : '' }}>Not lonely</option>
                    <option value="Moderate lonely" {{ $category === 'Moderate lonely' ? 'selected' : '' }}>Moderate lonely</option>
                    <option value="Severe lonely" {{ $category === 'Severe lonely' ? 'selected' : '' }}>Severe lonely</option>
                    <option value="Very severe lonely" {{ $category === 'Very severe lonely' ? 'selected' : '' }}>Very severe lonely</option>
                    <option value="Rendah" {{ $category === 'Rendah' ? 'selected' : '' }}>Rendah</option>
                    <option value="Sedang" {{ $category === 'Sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="Tinggi" {{ $category === 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                </select>
            </div>

            <!-- <div>
                <label>Status Tindak Lanjut</label>
                <select name="follow_up_status">
                    <option value="">Semua Status</option>
                    <option value="Belum Ditindaklanjuti" {{ request('follow_up_status') == 'Belum Ditindaklanjuti' ? 'selected' : '' }}>
                        Belum Ditindaklanjuti
                    </option>
                    <option value="Sudah Edukasi Perawat" {{ request('follow_up_status') == 'Sudah Edukasi Perawat' ? 'selected' : '' }}>
                        Sudah Edukasi Perawat
                    </option>
                    <option value="Sudah Edukasi Keluarga" {{ request('follow_up_status') == 'Sudah Edukasi Keluarga' ? 'selected' : '' }}>
                        Sudah Edukasi Keluarga
                    </option>
                    <option value="Perlu Monitoring Ulang" {{ request('follow_up_status') == 'Perlu Monitoring Ulang' ? 'selected' : '' }}>
                        Perlu Monitoring Ulang
                    </option>
                    <option value="Selesai" {{ request('follow_up_status') == 'Selesai' ? 'selected' : '' }}>
                        Selesai
                    </option>
                </select>
            </div> -->

            <div class="filter-group">
                <label>Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ $dateFrom ?? '' }}">
            </div>

            <div class="filter-group">
                <label>Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ $dateTo ?? '' }}">
            </div>

            <button class="btn" type="submit">
                🔍 Filter
            </button>

            <a class="btn btn-secondary" href="{{ route('assessments.index') }}">
                Reset
            </a>
        </div>
    </form>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Pasien</th>
                    <th>Tanggal</th>
                    <th>Skor</th>
                    <th>Kategori</th>
                    <th>Rekomendasi Edukasi</th>
                    <th width="210">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($assessments as $assessment)
                    @php
                        $categoryLower = strtolower($assessment->category ?? '');

                        if (str_contains($categoryLower, 'not') || str_contains($categoryLower, 'rendah')) {
                            $catClass = 'cat-rendah';
                        } elseif (str_contains($categoryLower, 'moderate') || str_contains($categoryLower, 'sedang')) {
                            $catClass = 'cat-sedang';
                        } elseif (str_contains($categoryLower, 'severe') || str_contains($categoryLower, 'tinggi')) {
                            $catClass = 'cat-tinggi';
                        } else {
                            $catClass = 'cat-default';
                        }

                        $assessmentDate = $assessment->assessment_date
                            ? \Carbon\Carbon::parse($assessment->assessment_date)->format('d/m/Y')
                            : '-';
                    @endphp

                    <tr>
                        <td>
                            <div class="assessment-patient">
                                {{ $assessment->patient->nama_inisial ?? '-' }}
                            </div>
                            <div class="assessment-code">
                                {{ $assessment->patient->kode_pasien ?? '-' }}
                            </div>
                            <div class="muted">
                                {{ $assessment->patient->diagnosis_medis_utama ?? '-' }}
                            </div>
                        </td>

                        <td>
                            <strong>{{ $assessmentDate }}</strong><br>
                            <span class="muted">
                                {{ $assessment->created_at ? $assessment->created_at->format('H:i') : '-' }}
                            </span>
                        </td>

                        <td>
                            <span class="score-pill">{{ $assessment->total_score }}</span>
                        </td>

                        <td>
                            <span class="category-badge {{ $catClass }}">
                                {{ $assessment->category }}
                            </span>
                        </td>

                        <td>
                            <div class="recommendation-preview">
                                {{ \Illuminate\Support\Str::limit($assessment->family_education_recommendation, 120) }}
                            </div>
                        </td>

                        <td>
                            <div class="actions">
                                <a class="btn btn-sm" href="{{ route('assessments.show', $assessment) }}">
                                    Detail
                                </a>

                                <a class="btn btn-light btn-sm" href="{{ route('patients.show', $assessment->patient) }}">
                                    Pasien
                                </a>

                                @if(auth()->user()->role === 'admin')
                                    <form
                                        method="POST"
                                        action="{{ route('assessments.destroy', $assessment) }}"
                                        data-confirm="Yakin hapus riwayat assessment ini?"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                Belum ada riwayat assessment sesuai filter.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-box">
        {{ $assessments->links() }}
    </div>
</div>
@endsection
