<style>
    .preview-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 16px;
        margin-top: 14px;
    }

    .preview-box h4 {
        margin: 0 0 10px;
        color: #0b6f73;
    }

    .required {
        color: #dc2626;
    }

    .input-help {
        margin-top: 6px;
        color: #64748b;
        font-size: 12px;
    }
</style>

<div class="grid-2">
    <div class="form-group">
        <label>Kategori <span class="required">*</span></label>
        <input
            type="text"
            name="category"
            value="{{ old('category', $interpretation->category ?? '') }}"
            placeholder="Contoh: Not lonely / Moderate lonely / Severe lonely"
            required
        >
    </div>

    <div class="form-group">
        <label>Urutan</label>
        <input
            type="number"
            name="sort_order"
            value="{{ old('sort_order', $interpretation->sort_order ?? 0) }}"
            min="0"
        >
    </div>

    <div class="form-group">
        <label>Skor Minimal <span class="required">*</span></label>
        <input
            type="number"
            name="min_score"
            value="{{ old('min_score', $interpretation->min_score ?? '') }}"
            min="0"
            required
        >
    </div>

    <div class="form-group">
        <label>Skor Maksimal <span class="required">*</span></label>
        <input
            type="number"
            name="max_score"
            value="{{ old('max_score', $interpretation->max_score ?? '') }}"
            min="0"
            required
        >
        <div class="input-help">Contoh: Not lonely 0-2, Moderate lonely 3-8, Severe lonely 9-10, Very severe lonely 11.</div>
    </div>
</div>

<div class="form-group">
    <label>Interpretasi Awal <span class="required">*</span></label>
    <textarea
        name="interpretation"
        required
        placeholder="Tuliskan interpretasi awal berdasarkan kategori skor..."
    >{{ old('interpretation', $interpretation->interpretation ?? '') }}</textarea>
</div>

<div class="form-group">
    <label>Rekomendasi Dukungan Keperawatan <span class="required">*</span></label>
    <textarea
        name="nursing_recommendation"
        required
        placeholder="Tuliskan rekomendasi untuk perawat..."
    >{{ old('nursing_recommendation', $interpretation->nursing_recommendation ?? '') }}</textarea>
</div>

<div class="form-group">
    <label>Rekomendasi Edukasi Keluarga <span class="required">*</span></label>
    <textarea
        name="family_education_recommendation"
        required
        placeholder="Tuliskan rekomendasi edukasi untuk keluarga..."
    >{{ old('family_education_recommendation', $interpretation->family_education_recommendation ?? '') }}</textarea>
</div>

<div class="checkbox-row">
    <input
        type="checkbox"
        name="is_active"
        value="1"
        {{ old('is_active', $interpretation->is_active ?? true) ? 'checked' : '' }}
    >
    <span>Aktif digunakan oleh sistem</span>
</div>

<div class="preview-box">
    <h4>Catatan Penggunaan</h4>
    <p>
        Saat perawat submit assessment, sistem akan mencari pengaturan aktif yang rentang skornya
        sesuai dengan total skor. Kalimat dari pengaturan ini akan tersimpan ke hasil assessment.
    </p>
</div>
