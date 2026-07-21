<style>
    .question-form-note {
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

<div class="question-form-note">
    <strong>Petunjuk:</strong>
    Gunakan kalimat sederhana, jelas, dan mudah dipahami pasien. Pertanyaan aktif akan muncul
    pada instrumen assessment sesuai nomor urutan.
</div>

<div class="grid-2">
    <div class="form-group">
        <label>Urutan Pertanyaan <span class="required">*</span></label>
        <input
            type="number"
            name="sort_order"
            value="{{ old('sort_order', $question->sort_order ?? $nextOrder ?? 1) }}"
            min="1"
            required
        >
        <div class="input-help">
            Contoh: 1, 2, 3. Sistem akan menampilkan pertanyaan berdasarkan urutan ini.
        </div>
    </div>

    <div class="form-group">
        <label>Status</label>

        <div class="checkbox-row" style="margin-top: 12px;">
            <input
                type="checkbox"
                name="is_active"
                value="1"
                {{ old('is_active', $question->is_active ?? true) ? 'checked' : '' }}
            >
            <span>Aktif digunakan dalam assessment</span>
        </div>
    </div>
</div>

<div class="form-group">
    <label>Teks Pertanyaan <span class="required">*</span></label>
    <textarea
        name="question_text"
        style="min-height: 150px;"
        placeholder="Contoh: Saya merasakan kekosongan secara umum."
        required
    >{{ old('question_text', $question->question_text ?? '') }}</textarea>

    <div class="input-help">
        Pertanyaan dijawab dengan 5 pilihan: Tidak pernah, Jarang, Kadang-kadang, Sering, Selalu.
        Skor item dihitung otomatis menjadi 0 atau 1 sesuai aturan De Jong Gierveld.
    </div>
</div>
