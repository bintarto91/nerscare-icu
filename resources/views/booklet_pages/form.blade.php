@php
    $pointsText = old('points_text');

    if ($pointsText === null) {
        $pointsText = $bookletPage ? implode(PHP_EOL, $bookletPage->points ?? []) : '';
    }
@endphp

<style>
    .booklet-form-note {
        background: #edf7f8;
        border: 1px solid #a5f3fc;
        color: #155e75;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 18px;
        line-height: 1.6;
        font-size: 14px;
    }

    .required {
        color: #dc2626;
    }

    .input-help {
        margin-top: 6px;
        color: #64748b;
        font-size: 12px;
        line-height: 1.5;
    }
</style>

<div class="booklet-form-note">
    <strong>Petunjuk:</strong>
    Satu halaman booklet akan tampil seperti satu sisi buku. Isi dibuat singkat, hangat, dan mudah dipahami keluarga maupun perawat.
</div>

<div class="grid-2">
    <div class="form-group">
        <label>Label Halaman</label>
        <input
            type="text"
            name="kicker"
            value="{{ old('kicker', $bookletPage->kicker ?? '') }}"
            placeholder="Contoh: Halaman 1"
        >
        <div class="input-help">
            Label kecil di bagian atas halaman. Jika kosong, sistem tetap memakai urutan halaman.
        </div>
    </div>

    <div class="form-group">
        <label>Urutan <span class="required">*</span></label>
        <input
            type="number"
            name="sort_order"
            value="{{ old('sort_order', $bookletPage->sort_order ?? $nextOrder ?? 1) }}"
            min="1"
            required
        >
        <div class="input-help">
            Booklet akan dibuka berurutan dari angka terkecil.
        </div>
    </div>
</div>

<div class="form-group">
    <label>Judul Halaman <span class="required">*</span></label>
    <input
        type="text"
        name="title"
        value="{{ old('title', $bookletPage->title ?? '') }}"
        placeholder="Contoh: Emotional Loneliness"
        required
    >
</div>

<div class="form-group">
    <label>Isi Singkat <span class="required">*</span></label>
    <textarea
        name="body"
        style="min-height: 130px;"
        placeholder="Tulis penjelasan singkat untuk halaman booklet..."
        required
    >{{ old('body', $bookletPage->body ?? '') }}</textarea>
    <div class="input-help">
        Hindari paragraf terlalu panjang agar tampilan buku tetap rapi di desktop dan HP.
    </div>
</div>

<div class="form-group">
    <label>Poin Halaman</label>
    <textarea
        name="points_text"
        style="min-height: 150px;"
        placeholder="Tulis satu poin per baris"
    >{{ $pointsText }}</textarea>
    <div class="input-help">
        Setiap baris akan menjadi bullet point di halaman booklet.
    </div>
</div>

<div class="form-group">
    <label>Status</label>

    <div class="checkbox-row" style="margin-top: 12px;">
        <input type="hidden" name="is_active" value="0">
        <input
            type="checkbox"
            name="is_active"
            value="1"
            {{ old('is_active', $bookletPage->is_active ?? true) ? 'checked' : '' }}
        >
        <span>Aktif tampil di landing page</span>
    </div>
</div>
