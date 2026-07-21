<style>
    .edu-form-section {
        margin-bottom: 24px;
    }

    .edu-section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e2e8f0;
    }

    .edu-section-icon {
        width: 38px;
        height: 38px;
        border-radius: 13px;
        background: #edf7f8;
        color: #0b6f73;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .edu-section-icon .ui-icon {
        width: 20px;
        height: 20px;
        stroke-width: 2.2;
    }

    .edu-section-title h3 {
        margin: 0;
        font-size: 17px;
        color: #0f172a;
    }

    .edu-section-title p {
        margin: 3px 0 0;
        font-size: 13px;
        color: #64748b;
    }

    .required {
        color: #dc2626;
    }

    .input-help {
        margin-top: 6px;
        color: #64748b;
        font-size: 12px;
        line-height: 1.4;
    }

    .template-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 16px;
    }

    .template-box h4 {
        margin: 0 0 10px;
        color: #0f172a;
        font-size: 15px;
    }

    .template-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .template-btn {
        border: none;
        border-radius: 999px;
        padding: 8px 12px;
        cursor: pointer;
        background: #edf7f8;
        color: #0b6f73;
        font-weight: 800;
        font-size: 12px;
    }

    .template-btn:hover {
        background: #e6f3f5;
    }

    .content-helper {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 14px;
    }

    .helper-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 14px;
        font-size: 13px;
        line-height: 1.6;
        color: #475569;
    }

    .helper-card strong {
        display: block;
        color: #0f172a;
        margin-bottom: 6px;
    }

    .textarea-wrap {
        position: relative;
    }

    .content-counter {
        text-align: right;
        color: #64748b;
        font-size: 12px;
        margin-top: 6px;
    }

    @media(max-width: 800px) {
        .content-helper {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="edu-form-section">
    <div class="edu-section-title">
        <div class="edu-section-icon">@include('partials.ui-icon', ['name' => 'book'])</div>
        <div>
            <h3>Informasi Materi</h3>
            <p>Tentukan judul, sasaran, kategori, dan status publikasi materi edukasi.</p>
        </div>
    </div>

    <div class="grid-2">
        <div class="form-group">
            <label>Judul Materi <span class="required">*</span></label>
            <input
                type="text"
                name="title"
                value="{{ old('title', $educationContent->title ?? '') }}"
                placeholder="Contoh: Komunikasi Terapeutik pada Pasien ICU"
                required
            >
            <div class="input-help">
                Gunakan judul singkat dan mudah dipahami.
            </div>
        </div>

        <div class="form-group">
            <label>Sasaran Materi <span class="required">*</span></label>
            <select name="target" id="targetSelect" required>
                <option value="">-- Pilih sasaran materi --</option>
                <option value="perawat" {{ old('target', $educationContent->target ?? '') === 'perawat' ? 'selected' : '' }}>
                    Perawat
                </option>
                <option value="keluarga" {{ old('target', $educationContent->target ?? '') === 'keluarga' ? 'selected' : '' }}>
                    Keluarga
                </option>
            </select>
            <div class="input-help">
                Sasaran menentukan materi tampil di menu Edukasi Perawat atau Edukasi Keluarga.
            </div>
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <input
                type="text"
                name="category"
                value="{{ old('category', $educationContent->category ?? '') }}"
                placeholder="Contoh: Dasar, Komunikasi, Dukungan Emosional"
            >
            <div class="input-help">
                Kategori membantu pengelompokan materi edukasi.
            </div>
        </div>

        <div class="form-group">
            <label>Status Publikasi <span class="required">*</span></label>
            <select name="status" required>
                <option value="published" {{ old('status', $educationContent->status ?? 'published') === 'published' ? 'selected' : '' }}>
                    Published
                </option>
                <option value="draft" {{ old('status', $educationContent->status ?? '') === 'draft' ? 'selected' : '' }}>
                    Draft
                </option>
            </select>
            <div class="input-help">
                Published tampil ke pengguna, Draft hanya tersimpan untuk admin.
            </div>
        </div>
    </div>
</div>

<div class="edu-form-section">
    <div class="edu-section-title">
        <div class="edu-section-icon">@include('partials.ui-icon', ['name' => 'assessment'])</div>
        <div>
            <h3>Isi Materi Edukasi</h3>
            <p>Tulis materi edukasi dengan bahasa sederhana, klinis, dan mudah dipahami.</p>
        </div>
    </div>

    <div class="template-box">
        <h4>Template Cepat</h4>

        <div class="template-actions">
            <button type="button" class="template-btn" onclick="fillTemplate('perawat')">
                Template Edukasi Perawat
            </button>

            <button type="button" class="template-btn" onclick="fillTemplate('keluarga')">
                Template Edukasi Keluarga
            </button>

            <button type="button" class="template-btn" onclick="fillTemplate('checklist')">
                Template Checklist
            </button>
        </div>
    </div>

    <div class="content-helper">
        <div class="helper-card">
            <strong>Untuk Perawat</strong>
            Materi dapat berisi pengertian loneliness, tanda/gejala, komunikasi terapeutik,
            dukungan emosional, keterlibatan keluarga, dan dokumentasi edukasi.
        </div>

        <div class="helper-card">
            <strong>Untuk Keluarga</strong>
            Materi dapat berisi cara menyapa pasien, contoh kalimat dukungan,
            hal yang perlu dilakukan/dihindari, dan kerja sama dengan perawat.
        </div>
    </div>

    <div class="form-group">
        <label>Isi Materi Edukasi <span class="required">*</span></label>

        <div class="textarea-wrap">
            <textarea
                name="content"
                id="educationContentTextarea"
                style="min-height:320px;"
                placeholder="Tulis isi materi edukasi di sini..."
                required
            >{{ old('content', $educationContent->content ?? '') }}</textarea>
        </div>

        <div class="content-counter">
            <span id="contentCounter">0</span> karakter
        </div>

        <div class="input-help">
            Tips: gunakan paragraf pendek, poin-poin, dan bahasa yang mudah dipahami oleh perawat atau keluarga.
        </div>
    </div>
</div>

<script>
    const contentTextarea = document.getElementById('educationContentTextarea');
    const contentCounter = document.getElementById('contentCounter');
    const targetSelect = document.getElementById('targetSelect');

    function updateContentCounter() {
        contentCounter.innerText = contentTextarea.value.length;
    }

    function fillTemplate(type) {
        let template = '';

        if (type === 'perawat') {
            template =
`Pengertian:
Loneliness pada pasien ICU adalah kondisi ketika pasien merasa sendiri, terisolasi, atau kurang mendapat dukungan emosional selama menjalani perawatan intensif.

Tujuan Edukasi:
Membantu perawat mengenali tanda loneliness dan memberikan dukungan emosional yang sesuai.

Poin Penting:
1. Observasi perubahan ekspresi, respons komunikasi, dan tanda kecemasan pasien.
2. Gunakan komunikasi terapeutik secara singkat, jelas, dan menenangkan.
3. Berikan orientasi waktu, tempat, dan proses perawatan secara sederhana.
4. Fasilitasi komunikasi dengan keluarga sesuai kebijakan ruang ICU.
5. Dokumentasikan hasil assessment dan edukasi yang diberikan.

Contoh Kalimat Perawat:
"Bapak/Ibu tidak sendiri, kami akan mendampingi selama proses perawatan."
"Keluarga Bapak/Ibu tetap mendukung dan mendoakan dari luar ruangan."

Catatan:
Edukasi dan intervensi tetap disesuaikan dengan kondisi klinis pasien serta kebijakan ruang ICU.`;

            targetSelect.value = 'perawat';
        }

        if (type === 'keluarga') {
            template =
`Pengertian:
Pasien ICU dapat merasa kesepian karena berada di ruang perawatan intensif, terbatas berkomunikasi, dan jauh dari keluarga.

Tujuan Edukasi:
Membantu keluarga memberikan dukungan emosional yang aman dan menenangkan bagi pasien.

Hal yang Dapat Dilakukan Keluarga:
1. Sapa pasien dengan lembut dan tenang.
2. Gunakan kalimat positif dan menenangkan.
3. Ingatkan pasien bahwa keluarga tetap mendukung.
4. Ikuti arahan perawat saat berkomunikasi dengan pasien.
5. Gunakan video call apabila diperbolehkan dan sesuai kondisi pasien.

Contoh Kalimat Dukungan:
"Kami ada untuk mendukung Bapak/Ibu."
"Tetap semangat, kami selalu mendoakan."
"Bapak/Ibu tidak sendiri."

Hal yang Perlu Dihindari:
1. Menyampaikan kabar yang membuat pasien cemas.
2. Berbicara dengan nada panik.
3. Memaksa pasien merespons jika tampak lelah.

Catatan:
Dukungan keluarga perlu mengikuti aturan kunjungan dan arahan perawat ICU.`;

            targetSelect.value = 'keluarga';
        }

        if (type === 'checklist') {
            template =
`Checklist Edukasi:
[ ] Materi telah dibaca dan dipahami.
[ ] Edukasi diberikan sesuai kondisi pasien.
[ ] Komunikasi dilakukan dengan bahasa sederhana.
[ ] Dukungan emosional diberikan secara positif.
[ ] Keluarga/perawat memahami hal yang perlu dilakukan.
[ ] Keluarga/perawat memahami hal yang sebaiknya dihindari.
[ ] Edukasi telah didokumentasikan bila diperlukan.

Catatan Tambahan:
Tuliskan catatan atau arahan khusus sesuai kondisi pasien.`;
        }

        if (contentTextarea.value.trim().length > 0) {
            showAppConfirm('Isi materi saat ini akan diganti dengan template. Lanjutkan?', function() {
                applyEducationTemplate(template);
            }, {
                title: 'Ganti isi materi?',
                confirmText: 'Ya, ganti'
            });
            return;
        }

        applyEducationTemplate(template);
    }

    function applyEducationTemplate(template) {
        contentTextarea.value = template;
        updateContentCounter();
    }

    contentTextarea.addEventListener('input', updateContentCounter);
    updateContentCounter();
</script>
