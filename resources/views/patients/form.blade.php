<style>
    .form-section {
        margin-bottom: 24px;
    }

    .form-section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e2e8f0;
    }

    .section-icon {
        width: 38px;
        height: 38px;
        border-radius: 13px;
        background: #edf7f8;
        color: #0b6f73;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .form-section-title h3 {
        margin: 0;
        font-size: 17px;
        color: #0f172a;
    }

    .form-section-title p {
        margin: 3px 0 0;
        font-size: 13px;
        color: #64748b;
    }

    .input-help {
        margin-top: 6px;
        color: #64748b;
        font-size: 12px;
        line-height: 1.4;
    }

    .required {
        color: #dc2626;
    }

    .assessment-check-box {
        background: linear-gradient(135deg, #f8fafc, #edf7f8);
        border: 1px solid #bae6fd;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .assessment-check-box h3 {
        margin: 0 0 6px;
        color: #0f172a;
        font-size: 17px;
    }

    .assessment-check-box p {
        margin: 0 0 16px;
        color: #64748b;
        font-size: 13px;
        line-height: 1.6;
    }

    .check-card {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 13px;
        border-radius: 8px;
        background: white;
        border: 1px solid #e2e8f0;
        margin-bottom: 10px;
        cursor: pointer;
        transition: .18s;
    }

    .check-card:hover {
        border-color: #0b6f73;
        box-shadow: 0 10px 24px rgba(15, 118, 110, .08);
    }

    .check-card input {
        width: 18px;
        height: 18px;
        margin-top: 2px;
        flex-shrink: 0;
        accent-color: #0b6f73;
    }

    .check-card strong {
        display: block;
        color: #0f172a;
        font-size: 14px;
        margin-bottom: 4px;
    }

    .check-card span {
        display: block;
        color: #64748b;
        font-size: 13px;
        line-height: 1.5;
    }

    .eligibility-result {
        margin-top: 14px;
        padding: 13px 15px;
        border-radius: 8px;
        font-size: 13px;
        line-height: 1.5;
        font-weight: 700;
    }

    .eligible-ok {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .eligible-no {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    @media(max-width: 700px) {
        .form-section-title {
            align-items: flex-start;
        }
    }

    .section-icon .ui-icon {
        width: 20px;
        height: 20px;
        stroke-width: 2.2;
    }
</style>

<div class="form-section">
    <div class="form-section-title">
        <div class="section-icon">@include('partials.ui-icon', ['name' => 'patient'])</div>
        <div>
            <h3>Identitas Pasien</h3>
            <p>Data dasar pasien ICU yang akan dilakukan assessment loneliness.</p>
        </div>
    </div>

    <div class="grid-2">
        <div class="form-group">
            <label>Kode Pasien / No. Rekam Medis <span class="required">*</span></label>
            <input
                type="text"
                name="kode_pasien"
                value="{{ old('kode_pasien', $patient->kode_pasien ?? '') }}"
                placeholder="Contoh: ICU-001 / RM-0001"
                required
            >
            <div class="input-help">Gunakan kode pasien atau nomor rekam medis yang unik.</div>
        </div>

        <div class="form-group">
            <label>Nama atau Inisial Pasien <span class="required">*</span></label>
            <input
                type="text"
                name="nama_inisial"
                value="{{ old('nama_inisial', $patient->nama_inisial ?? '') }}"
                placeholder="Contoh: Tn. A / Ny. B"
                required
            >
            <div class="input-help">Boleh menggunakan inisial untuk menjaga privasi pasien.</div>
        </div>

        <div class="form-group">
            <label>Usia <span class="required">*</span></label>
            <input
                type="number"
                name="usia"
                value="{{ old('usia', $patient->usia ?? '') }}"
                min="1"
                max="120"
                placeholder="Contoh: 55"
                required
            >
        </div>

        <div class="form-group">
            <label>Jenis Kelamin <span class="required">*</span></label>
            <select name="jenis_kelamin" required>
                <option value="">-- Pilih jenis kelamin --</option>
                <option value="Laki-laki" {{ old('jenis_kelamin', $patient->jenis_kelamin ?? '') === 'Laki-laki' ? 'selected' : '' }}>
                    Laki-laki
                </option>
                <option value="Perempuan" {{ old('jenis_kelamin', $patient->jenis_kelamin ?? '') === 'Perempuan' ? 'selected' : '' }}>
                    Perempuan
                </option>
            </select>
        </div>
    </div>
</div>

<div class="form-section">
    <div class="form-section-title">
        <div class="section-icon">@include('partials.ui-icon', ['name' => 'home'])</div>
        <div>
            <h3>Informasi Klinis ICU</h3>
            <p>Data klinis singkat sebagai konteks sebelum assessment dilakukan.</p>
        </div>
    </div>

    <div class="grid-2">
        <div class="form-group">
            <label>Tanggal Masuk ICU</label>
            <input
                type="date"
                name="tanggal_masuk_icu"
                value="{{ old('tanggal_masuk_icu', isset($patient) && $patient->tanggal_masuk_icu ? $patient->tanggal_masuk_icu->format('Y-m-d') : '') }}"
            >
        </div>

        <div class="form-group">
            <label>Diagnosis Medis Utama</label>
            <input
                type="text"
                name="diagnosis_medis_utama"
                value="{{ old('diagnosis_medis_utama', $patient->diagnosis_medis_utama ?? '') }}"
                placeholder="Contoh: Pneumonia, Stroke, Post Operasi"
            >
        </div>

        <div class="form-group">
            <label>Status Kesadaran</label>
            <input
                type="text"
                name="status_kesadaran"
                value="{{ old('status_kesadaran', $patient->status_kesadaran ?? '') }}"
                placeholder="Contoh: Compos mentis"
            >
        </div>

        <div class="form-group">
            <label>Kemampuan Komunikasi</label>
            <input
                type="text"
                name="kemampuan_komunikasi"
                value="{{ old('kemampuan_komunikasi', $patient->kemampuan_komunikasi ?? '') }}"
                placeholder="Contoh: Verbal / nonverbal / tulisan / gesture"
            >
        </div>
    </div>
</div>

<div class="form-section">
    <div class="form-section-title">
        <div class="section-icon">@include('partials.ui-icon', ['name' => 'assessment'])</div>
        <div>
            <h3>Data Pengisian</h3>
            <p>Identitas perawat dan tanggal pengisian data pasien.</p>
        </div>
    </div>

    <div class="grid-2">
        <div class="form-group">
            <label>Nama Perawat Pengisi</label>
            <input
                type="text"
                name="nama_perawat_pengisi"
                value="{{ old('nama_perawat_pengisi', isset($patient) ? $patient->nama_perawat_pengisi : auth()->user()->name) }}"
                placeholder="Nama perawat pengisi"
            >
        </div>

        <div class="form-group">
            <label>Tanggal Pengisian</label>
            <input
                type="date"
                name="tanggal_pengisian"
                value="{{ old('tanggal_pengisian', isset($patient) && $patient->tanggal_pengisian ? $patient->tanggal_pengisian->format('Y-m-d') : date('Y-m-d')) }}"
            >
        </div>
    </div>
</div>

<div class="assessment-check-box">
    <h3>Konfirmasi Kondisi Sebelum Assessment</h3>
    <p>
        Bagian ini wajib diperhatikan. Assessment loneliness hanya dilanjutkan apabila
        pasien sadar, mampu berkomunikasi, memahami pertanyaan sederhana, dan bersedia mengikuti assessment.
    </p>

    <label class="check-card">
        <input
            type="checkbox"
            name="sadar"
            value="1"
            class="eligibility-check"
            {{ old('sadar', $patient->sadar ?? false) ? 'checked' : '' }}
        >
        <div>
            <strong>Pasien dalam kondisi sadar</strong>
            <span>Pasien dapat merespons atau menunjukkan kesadaran sesuai penilaian perawat.</span>
        </div>
    </label>

    <label class="check-card">
        <input
            type="checkbox"
            name="mampu_berkomunikasi"
            value="1"
            class="eligibility-check"
            {{ old('mampu_berkomunikasi', $patient->mampu_berkomunikasi ?? false) ? 'checked' : '' }}
        >
        <div>
            <strong>Pasien mampu berkomunikasi</strong>
            <span>Komunikasi dapat berupa verbal, nonverbal, tulisan, isyarat, atau alat bantu komunikasi.</span>
        </div>
    </label>

    <label class="check-card">
        <input
            type="checkbox"
            name="memahami_pertanyaan"
            value="1"
            class="eligibility-check"
            {{ old('memahami_pertanyaan', $patient->memahami_pertanyaan ?? false) ? 'checked' : '' }}
        >
        <div>
            <strong>Pasien memahami pertanyaan sederhana</strong>
            <span>Pasien mampu memahami instruksi atau pertanyaan sederhana dari perawat.</span>
        </div>
    </label>

    <label class="check-card">
        <input
            type="checkbox"
            name="bersedia_assessment"
            value="1"
            class="eligibility-check"
            {{ old('bersedia_assessment', $patient->bersedia_assessment ?? false) ? 'checked' : '' }}
        >
        <div>
            <strong>Pasien bersedia mengikuti assessment</strong>
            <span>Pasien menyetujui atau menunjukkan kesediaan untuk mengikuti proses assessment.</span>
        </div>
    </label>

    <div id="eligibilityResult" class="eligibility-result eligible-no">
        Lengkapi seluruh konfirmasi agar pasien dapat dilanjutkan ke assessment.
    </div>
</div>

<script>
    function updateEligibilityStatus() {
        const checks = document.querySelectorAll('.eligibility-check');
        const result = document.getElementById('eligibilityResult');

        let allChecked = true;

        checks.forEach(function (check) {
            if (!check.checked) {
                allChecked = false;
            }
        });

        if (allChecked) {
            result.className = 'eligibility-result eligible-ok';
            result.innerHTML = 'Pasien memenuhi syarat awal untuk dilanjutkan ke assessment loneliness.';
        } else {
            result.className = 'eligibility-result eligible-no';
            result.innerHTML = 'Lengkapi seluruh konfirmasi agar pasien dapat dilanjutkan ke assessment.';
        }
    }

    document.querySelectorAll('.eligibility-check').forEach(function (check) {
        check.addEventListener('change', updateEligibilityStatus);
    });

    updateEligibilityStatus();
</script>
