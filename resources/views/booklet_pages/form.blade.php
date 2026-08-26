<style>
    .booklet-form-note { background:#edf7f8; border:1px solid #a5f3fc; color:#155e75; border-radius:10px; padding:16px; margin-bottom:18px; line-height:1.6; font-size:14px; }
    .required { color:#dc2626; }
    .input-help { margin-top:6px; color:#64748b; font-size:12px; line-height:1.5; }
    .current-page-image { width:min(220px,100%); border:1px solid #d8e4ea; border-radius:10px; margin:8px 0; }
</style>

<div class="booklet-form-note"><strong>Petunjuk:</strong> unggah satu gambar untuk setiap halaman. Format JPG/PNG/WebP, maksimum 10 MB. Urutan halaman dibaca terpisah untuk booklet keluarga dan perawat.</div>

<div class="grid-2">
    <div class="form-group">
        <label>Jenis Booklet <span class="required">*</span></label>
        @php($selectedAudience = old('audience', $bookletPage->audience ?? $audience ?? 'keluarga'))
        <select name="audience" required>
            <option value="keluarga" {{ $selectedAudience === 'keluarga' ? 'selected' : '' }}>Keluarga</option>
            <option value="perawat" {{ $selectedAudience === 'perawat' ? 'selected' : '' }}>Perawat</option>
        </select>
    </div>
    <div class="form-group">
        <label>Urutan <span class="required">*</span></label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $bookletPage->sort_order ?? $nextOrder ?? 1) }}" min="1" required>
    </div>
</div>

<div class="form-group">
    <label>{{ $bookletPage ? 'Ganti Gambar Halaman (opsional)' : 'Gambar Halaman' }} <span class="required">{{ $bookletPage ? '' : '*' }}</span></label>
    @if($bookletPage)
        <img class="current-page-image" src="{{ $bookletPage->image_url }}" alt="Pratinjau gambar yang aktif">
    @endif
    <input type="file" name="image" accept="image/jpeg,image/png,image/webp" {{ $bookletPage ? '' : 'required' }}>
    <div class="input-help">Rasio potret seperti halaman PDF akan memberikan hasil terbaik.</div>
</div>

<div class="grid-2">
    <div class="form-group">
        <label>Label Halaman</label>
        <input type="text" name="kicker" value="{{ old('kicker', $bookletPage->kicker ?? '') }}" placeholder="Contoh: Halaman 1">
    </div>
    <div class="form-group">
        <label>Judul Internal <span class="required">*</span></label>
        <input type="text" name="title" value="{{ old('title', $bookletPage->title ?? '') }}" placeholder="Contoh: Sampul keluarga" required>
        <div class="input-help">Untuk membantu admin mengenali halaman.</div>
    </div>
</div>

<div class="form-group">
    <label>Teks Alternatif Gambar <span class="required">*</span></label>
    <input type="text" name="alt_text" value="{{ old('alt_text', $bookletPage->alt_text ?? '') }}" placeholder="Contoh: Sampul booklet edukasi keluarga pasien ICU" required>
    <div class="input-help">Dibaca oleh teknologi bantu dan penting untuk aksesibilitas.</div>
</div>

<div class="form-group">
    <label>Catatan Internal <span class="required">*</span></label>
    <textarea name="body" style="min-height:100px" placeholder="Ringkasan isi halaman untuk pengelola" required>{{ old('body', $bookletPage->body ?? '') }}</textarea>
    <div class="input-help">Catatan ini hanya untuk pengelolaan admin, tidak ditempel di atas gambar booklet.</div>
</div>

<div class="form-group">
    <label>Status</label>
    <div class="checkbox-row" style="margin-top:12px"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $bookletPage->is_active ?? true) ? 'checked' : '' }}><span>Aktif dan tampil di flipbook publik</span></div>
</div>
