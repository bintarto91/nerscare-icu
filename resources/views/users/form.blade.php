@php
    $hasUnitKerja = \Illuminate\Support\Facades\Schema::hasColumn('users', 'unit_kerja');
    $hasStatus = \Illuminate\Support\Facades\Schema::hasColumn('users', 'status');
    $isEdit = isset($user) && $user;
@endphp

<style>
    .user-form-section {
        margin-bottom: 24px;
    }

    .user-section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e2e8f0;
    }

    .user-section-icon {
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

    .user-section-icon .ui-icon {
        width: 20px;
        height: 20px;
        stroke-width: 2.2;
    }

    .user-section-title h3 {
        margin: 0;
        font-size: 17px;
        color: #0f172a;
    }

    .user-section-title p {
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

    .role-info {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 18px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }

    .role-info-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 13px;
        font-size: 13px;
        line-height: 1.5;
        color: #475569;
    }

    .role-info-card strong {
        display: block;
        color: #0f172a;
        margin-bottom: 5px;
    }

    @media(max-width: 800px) {
        .role-info {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="role-info">
    <div class="role-info-card">
        <strong>Admin</strong>
        Akses penuh: pengguna, pasien, assessment, edukasi, dan manajemen konten.
    </div>

    <div class="role-info-card">
        <strong>Perawat</strong>
        Akses pasien, assessment loneliness, riwayat, dan edukasi perawat-keluarga.
    </div>

    <div class="role-info-card">
        <strong>Keluarga</strong>
        Akses terbatas untuk membaca edukasi keluarga.
    </div>
</div>

<div class="user-form-section">
    <div class="user-section-title">
        <div class="user-section-icon">@include('partials.ui-icon', ['name' => 'users'])</div>
        <div>
            <h3>Identitas Akun</h3>
            <p>Data dasar pengguna sistem.</p>
        </div>
    </div>

    <div class="grid-2">
        <div class="form-group">
            <label>Nama Pengguna <span class="required">*</span></label>
            <input
                type="text"
                name="name"
                value="{{ old('name', $user->name ?? '') }}"
                placeholder="Contoh: Perawat ICU 1"
                required
            >
        </div>

        <div class="form-group">
            <label>Email / Username <span class="required">*</span></label>
            <input
                type="email"
                name="email"
                value="{{ old('email', $user->email ?? '') }}"
                placeholder="contoh@email.com"
                required
            >
        </div>

        <div class="form-group">
            <label>Role Pengguna <span class="required">*</span></label>
            <select name="role" required>
                <option value="">-- Pilih role --</option>
                <option value="admin" {{ old('role', $user->role ?? '') === 'admin' ? 'selected' : '' }}>
                    Admin
                </option>
                <option value="perawat" {{ old('role', $user->role ?? '') === 'perawat' ? 'selected' : '' }}>
                    Perawat
                </option>
                <option value="keluarga" {{ old('role', $user->role ?? '') === 'keluarga' ? 'selected' : '' }}>
                    Keluarga
                </option>
            </select>
        </div>

        @if($hasUnitKerja)
            <div class="form-group">
                <label>Unit Kerja</label>
                <input
                    type="text"
                    name="unit_kerja"
                    value="{{ old('unit_kerja', $user->unit_kerja ?? '') }}"
                    placeholder="Contoh: ICU / Ruang Intensif"
                >
            </div>
        @endif

        @if($hasStatus)
            <div class="form-group">
                <label>Status Akun <span class="required">*</span></label>
                <select name="status" required>
                    <option value="aktif" {{ old('status', $user->status ?? 'aktif') === 'aktif' ? 'selected' : '' }}>
                        Aktif
                    </option>
                    <option value="nonaktif" {{ old('status', $user->status ?? '') === 'nonaktif' ? 'selected' : '' }}>
                        Nonaktif
                    </option>
                </select>
            </div>
        @endif
    </div>
</div>

<div class="user-form-section">
    <div class="user-section-title">
        <div class="user-section-icon">@include('partials.ui-icon', ['name' => 'settings'])</div>
        <div>
            <h3>Password</h3>
            <p>
                {{ $isEdit ? 'Kosongkan jika tidak ingin mengganti password.' : 'Masukkan password awal untuk pengguna baru.' }}
            </p>
        </div>
    </div>

    <div class="grid-2">
        <div class="form-group">
            <label>
                Password
                @if(!$isEdit)
                    <span class="required">*</span>
                @endif
            </label>

            <input
                type="password"
                name="password"
                placeholder="{{ $isEdit ? 'Kosongkan jika tidak diganti' : 'Minimal 6 karakter' }}"
                {{ $isEdit ? '' : 'required' }}
            >

            <div class="input-help">
                Minimal 6 karakter.
            </div>
        </div>

        <div class="form-group">
            <label>
                Konfirmasi Password
                @if(!$isEdit)
                    <span class="required">*</span>
                @endif
            </label>

            <input
                type="password"
                name="password_confirmation"
                placeholder="Ulangi password"
                {{ $isEdit ? '' : 'required' }}
            >
        </div>
    </div>
</div>
