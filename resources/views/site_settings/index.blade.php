@extends('layouts.app')

@section('title', 'Pengaturan Landing Page')
@section('page_title', 'Pengaturan Landing Page')
@section('page_subtitle', 'Kelola teks halaman public dan kalkulator loneliness.')

@section('content')
<style>
    .setting-section {
        margin-bottom: 24px;
    }

    .setting-section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e2e8f0;
    }

    .setting-icon {
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

    .setting-icon .ui-icon {
        width: 20px;
        height: 20px;
        stroke-width: 2.2;
    }

    .setting-section-title h3 {
        margin: 0;
        font-size: 17px;
        color: #0f172a;
    }

    .setting-section-title p {
        margin: 3px 0 0;
        color: #64748b;
        font-size: 13px;
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

    .preview-link-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 18px;
        display: flex;
        justify-content: space-between;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
    }
</style>

<div class="clinical-note">
    <strong>Catatan:</strong>
    Perubahan di halaman ini akan langsung memengaruhi landing page public dan teks kalkulator public.
    Fitur ini memudahkan admin mengubah konten tanpa edit coding.
</div>

<div class="preview-link-box">
    <div>
        <strong>Preview halaman public</strong><br>
        <span class="muted">Cek hasil perubahan setelah disimpan.</span>
    </div>

    <div class="actions">
        <a href="{{ route('public.landing') }}" target="_blank" class="btn btn-light btn-sm">
            Landing Page
        </a>

        <a href="{{ route('public.calculator') }}" target="_blank" class="btn btn-light btn-sm">
            Kalkulator Public
        </a>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <div>
            <h3>Form Pengaturan Landing Page</h3>
            <p>Atur nama aplikasi, judul, deskripsi, disclaimer, dan footer.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('site-settings.update') }}">
        @csrf
        @method('PUT')

        <div class="setting-section">
            <div class="setting-section-title">
                <div class="setting-icon">@include('partials.ui-icon', ['name' => 'landing'])</div>
                <div>
                    <h3>Identitas Aplikasi</h3>
                    <p>Nama aplikasi dan label utama pada halaman public.</p>
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Nama Aplikasi <span class="required">*</span></label>
                    <input
                        type="text"
                        name="app_name"
                        value="{{ old('app_name', $settings['app_name']) }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Badge Landing Page</label>
                    <input
                        type="text"
                        name="landing_badge"
                        value="{{ old('landing_badge', $settings['landing_badge']) }}"
                    >
                    <div class="input-help">
                        Contoh: Web Public + Sistem Petugas ICU
                    </div>
                </div>
            </div>
        </div>

        <div class="setting-section">
            <div class="setting-section-title">
                <div class="setting-icon">@include('partials.ui-icon', ['name' => 'home'])</div>
                <div>
                    <h3>Konten Landing Page</h3>
                    <p>Judul dan deskripsi utama halaman depan.</p>
                </div>
            </div>

            <div class="form-group">
                <label>Judul Landing Page <span class="required">*</span></label>
                <input
                    type="text"
                    name="landing_title"
                    value="{{ old('landing_title', $settings['landing_title']) }}"
                    required
                >
            </div>

            <div class="form-group">
                <label>Deskripsi Landing Page <span class="required">*</span></label>
                <textarea
                    name="landing_description"
                    style="min-height: 130px;"
                    required
                >{{ old('landing_description', $settings['landing_description']) }}</textarea>
            </div>
        </div>

        <div class="setting-section">
            <div class="setting-section-title">
                <div class="setting-icon">@include('partials.ui-icon', ['name' => 'assessment'])</div>
                <div>
                    <h3>Konten Kalkulator Public</h3>
                    <p>Judul dan deskripsi fitur kalkulator tanpa login.</p>
                </div>
            </div>

            <div class="form-group">
                <label>Judul Kalkulator <span class="required">*</span></label>
                <input
                    type="text"
                    name="landing_calculator_title"
                    value="{{ old('landing_calculator_title', $settings['landing_calculator_title']) }}"
                    required
                >
            </div>

            <div class="form-group">
                <label>Deskripsi Kalkulator <span class="required">*</span></label>
                <textarea
                    name="landing_calculator_description"
                    style="min-height: 120px;"
                    required
                >{{ old('landing_calculator_description', $settings['landing_calculator_description']) }}</textarea>
            </div>
        </div>

        <div class="setting-section">
            <div class="setting-section-title">
                <div class="setting-icon">@include('partials.ui-icon', ['name' => 'alert'])</div>
                <div>
                    <h3>Disclaimer dan Footer</h3>
                    <p>Catatan klinis dan teks bagian bawah halaman public.</p>
                </div>
            </div>

            <div class="form-group">
                <label>Disclaimer Klinis <span class="required">*</span></label>
                <textarea
                    name="clinical_disclaimer"
                    style="min-height: 130px;"
                    required
                >{{ old('clinical_disclaimer', $settings['clinical_disclaimer']) }}</textarea>
            </div>

            <div class="form-group">
                <label>Footer Text <span class="required">*</span></label>
                <input
                    type="text"
                    name="footer_text"
                    value="{{ old('footer_text', $settings['footer_text']) }}"
                    required
                >
            </div>
        </div>

        <div class="actions" style="margin-top: 22px;">
            <button type="submit" class="btn">
                Simpan Pengaturan
            </button>

            <a href="{{ route('public.landing') }}" target="_blank" class="btn btn-light">
                Preview Landing
            </a>

            <a href="{{ route('public.calculator') }}" target="_blank" class="btn btn-secondary">
                Preview Kalkulator
            </a>
        </div>
    </form>
</div>
@endsection
