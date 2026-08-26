@extends('layouts.app')

@section('title', 'Instrumen De Jong Gierveld 11 Item')
@section('page_title', 'Instrumen De Jong Gierveld 11 Item')
@section('page_subtitle', 'Daftar pertanyaan baku yang digunakan dalam assessment loneliness.')

@section('content')
<style>
    .instrument-summary {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 18px;
    }

    .instrument-summary div {
        padding: 15px;
        border: 1px solid #dbe6ea;
        border-radius: 14px;
        background: #f8fbfc;
    }

    .instrument-summary strong,
    .instrument-summary span {
        display: block;
    }

    .instrument-summary strong {
        color: #0b6f73;
        font-size: 20px;
    }

    .instrument-summary span {
        margin-top: 4px;
        color: #526978;
        font-size: 12px;
        font-weight: 800;
    }

    .question-order {
        display: inline-flex;
        width: 38px;
        height: 38px;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: #0b6f73;
        color: white;
        font-weight: 900;
    }

    .question-text {
        color: #0f172a;
        font-weight: 800;
        line-height: 1.55;
    }

    .dimension-badge,
    .rule-badge {
        display: inline-flex;
        padding: 7px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 900;
    }

    .dimension-badge.emotional {
        background: #fce7f3;
        color: #9d174d;
    }

    .dimension-badge.social {
        background: #e6f0fc;
        color: #1d4f86;
    }

    .rule-badge {
        background: #eef4f5;
        color: #425867;
        white-space: nowrap;
    }

    .search-instrument {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto auto;
        gap: 10px;
        margin-bottom: 18px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    @media(max-width: 760px) {
        .instrument-summary,
        .search-instrument {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="clinical-note">
    <strong>Instrumen baku dan baca-saja:</strong>
    Sebelas pertanyaan harus disampaikan secara verbatim. Pilihan respons adalah STS, TS, KL, S, dan SS. Penguncian mencegah perubahan teks, urutan, atau status yang dapat merusak aturan skoring dokumen terbaru.
</div>

<div class="instrument-summary">
    <div><strong>11</strong><span>Total item wajib</span></div>
    <div><strong>6</strong><span>Item emotional loneliness</span></div>
    <div><strong>5</strong><span>Item social loneliness</span></div>
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Daftar Pertanyaan Baku</h3>
            <p>Urutan item menentukan domain dan aturan skoring 0 atau 1.</p>
        </div>
    </div>

    <form method="GET" action="{{ route('questions.index') }}" class="search-instrument">
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari teks pertanyaan...">
        <button class="btn" type="submit">Cari</button>
        @if($search)
            <a href="{{ route('questions.index') }}" class="btn btn-secondary">Reset</a>
        @endif
    </form>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th width="75">Item</th>
                    <th width="130">Domain</th>
                    <th>Pertanyaan verbatim</th>
                    <th width="210">Respons bernilai 1</th>
                </tr>
            </thead>
            <tbody>
                @forelse($questions as $question)
                    @php
                        $dimension = \App\Support\DeJongGierveldScale::dimensionForQuestion($question);
                    @endphp
                    <tr>
                        <td><span class="question-order">{{ $question->sort_order }}</span></td>
                        <td><span class="dimension-badge {{ $dimension }}">{{ ucfirst($dimension) }}</span></td>
                        <td><div class="question-text">{{ $question->question_text }}</div></td>
                        <td>
                            <span class="rule-badge">
                                {{ $dimension === 'emotional' ? 'KL, S, atau SS' : 'STS, TS, atau KL' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4"><div class="empty-state">Instrumen belum tersinkronisasi. Jalankan migrasi aplikasi.</div></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($questions->hasPages())
        <div style="margin-top:18px;">{{ $questions->links() }}</div>
    @endif
</div>
@endsection
