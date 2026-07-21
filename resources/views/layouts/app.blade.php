<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="manifest" href="{{ asset('manifest.json') }}?v=8">
    <meta name="theme-color" content="#0b6f73">
    <link rel="icon" href="{{ asset('icons/icon.svg') }}?v=8" type="image/svg+xml">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}?v=8" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icons/apple-touch-icon.png') }}?v=8">
    <meta charset="UTF-8">
    <title>@yield('title', 'AI Assisted Assessment ICU')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

    <style>
        :root {
            --ink: #10212b;
            --muted: #5f7180;
            --line: #d8e4ea;
            --surface: #ffffff;
            --surface-soft: #f4f9fb;
            --teal: #0b6f73;
            --teal-dark: #084e55;
            --blue: #2563a9;
            --amber: #b7791f;
            --danger: #b42318;
            --success: #17623a;
            --shadow: 0 12px 32px rgba(16, 33, 43, .07);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #eef6f8;
            color: var(--ink);
            font-family: Arial, Helvetica, sans-serif;
            max-width: 100%;
            overflow-x: hidden;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .app-layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 320px;
            background: linear-gradient(180deg, #0f766e 0%, #0c5d60 52%, #073b4d 100%);
            color: white;
            padding: 28px 20px;
            position: fixed;
            inset: 0 auto 0 0;
            overflow-y: auto;
            z-index: 20;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 8px 0 28px;
            border-bottom: 1px solid rgba(255, 255, 255, .13);
            margin-bottom: 22px;
        }

        .brand-logo {
            width: 58px;
            height: 58px;
            border-radius: 18px;
            background: #f4fbfb;
            display: block;
            overflow: hidden;
            flex: 0 0 58px;
            box-shadow: 0 16px 34px rgba(0, 0, 0, .14);
        }

        .brand-logo img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
        }

        .brand-title strong {
            display: block;
            font-size: 19px;
            line-height: 1.25;
        }

        .brand-title span {
            display: block;
            margin-top: 3px;
            color: #d8fffb;
            font-size: 14px;
            line-height: 1.35;
        }

        .user-box {
            background: rgba(255, 255, 255, .13);
            border: 1px solid rgba(255, 255, 255, .22);
            border-radius: 24px;
            padding: 18px;
            margin-bottom: 24px;
        }

        .user-name {
            font-weight: 800;
            font-size: 17px;
            margin-bottom: 6px;
        }

        .user-email {
            color: #d8fffb;
            font-size: 14px;
            margin-bottom: 14px;
            word-break: break-all;
        }

        .role-badge {
            display: inline-flex;
            padding: 5px 9px;
            border-radius: 999px;
            background: #e6fff8;
            color: var(--teal);
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .3px;
        }

        .menu-title {
            color: #baf5ef;
            font-size: 13px;
            font-weight: 900;
            letter-spacing: .8px;
            margin: 22px 12px 10px;
            text-transform: uppercase;
        }

        .menu a,
        .logout-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            min-height: 56px;
            padding: 12px 14px;
            margin-bottom: 8px;
            border-radius: 18px;
            border: 1px solid transparent;
            background: transparent;
            color: #edf5f7;
            cursor: pointer;
            font-family: inherit;
            font-size: 16px;
            text-align: left;
            transition: .18s;
        }

        .menu a:hover,
        .logout-btn:hover {
            background: rgba(255, 255, 255, .08);
            border-color: rgba(255, 255, 255, .1);
        }

        .menu a.active {
            background: white;
            color: var(--teal);
            font-weight: 900;
        }

        .menu-icon {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            background: rgba(255, 255, 255, .12);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: #dffdfa;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 0;
        }

        .menu-icon .ui-icon {
            width: 18px;
            height: 18px;
            stroke-width: 2.2;
        }

        .menu a.active .menu-icon {
            background: #e6fbf8;
            color: var(--teal);
        }

        .logout-form {
            margin: 14px 0 0;
        }

        .main {
            flex: 1;
            min-height: 100vh;
            margin-left: 320px;
            min-width: 0;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 10;
            min-height: 72px;
            background: rgba(244, 249, 251, .92);
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(12px);
            padding: 14px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .mobile-toggle {
            display: none;
            width: 42px;
            height: 42px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: white;
            color: var(--ink);
            cursor: pointer;
            font-size: 18px;
            font-weight: 900;
        }

        .page-title {
            color: var(--ink);
            font-size: 22px;
            margin: 0;
        }

        .page-subtitle {
            color: var(--muted);
            font-size: 13px;
            margin: 4px 0 0;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--muted);
            font-size: 13px;
        }

        .topbar-right strong {
            color: #42526a;
        }

        .content {
            padding: 26px 28px 38px;
        }

        .alert-success,
        .alert-error {
            border-radius: 8px;
            padding: 13px 15px;
            margin-bottom: 18px;
            font-size: 14px;
            line-height: 1.5;
        }

        .alert-success {
            background: #e6f5ea;
            color: var(--success);
            border: 1px solid #b9dfc5;
        }

        .alert-error {
            background: #fde7e5;
            color: var(--danger);
            border: 1px solid #f6b8b1;
        }

        .alert-error ul {
            margin: 8px 0 0 18px;
            padding: 0;
        }

        .card,
        .panel {
            background: white;
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 20px;
            box-shadow: var(--shadow);
        }

        .confirm-overlay {
            position: fixed;
            inset: 0;
            z-index: 80;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgba(15, 23, 42, .54);
            backdrop-filter: blur(6px);
        }

        .confirm-overlay.show {
            display: flex;
        }

        .confirm-dialog {
            width: min(440px, 100%);
            background: white;
            border: 1px solid #d8e4ea;
            border-radius: 18px;
            box-shadow: 0 28px 80px rgba(15, 23, 42, .28);
            overflow: hidden;
        }

        .confirm-head {
            display: flex;
            gap: 14px;
            padding: 22px 22px 14px;
            align-items: flex-start;
        }

        .confirm-icon {
            width: 46px;
            height: 46px;
            border-radius: 15px;
            background: #fff7e6;
            color: #9a5b00;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex: 0 0 46px;
        }

        .confirm-title {
            margin: 0;
            color: var(--ink);
            font-size: 20px;
            line-height: 1.25;
        }

        .confirm-message {
            margin: 7px 0 0;
            color: var(--muted);
            line-height: 1.55;
            font-size: 14px;
        }

        .confirm-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 16px 22px 22px;
            border-top: 1px solid #edf2f5;
            background: #fbfdfe;
        }

        .confirm-actions .btn {
            min-height: 42px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 22px;
        }

        .card .label {
            color: var(--muted);
            font-size: 14px;
        }

        .card .number {
            color: var(--teal);
            font-size: 32px;
            font-weight: 900;
            margin-top: 9px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }

        th,
        td {
            padding: 13px 12px;
            border-bottom: 1px solid var(--line);
            text-align: left;
            vertical-align: top;
            font-size: 14px;
        }

        th {
            background: #f8fbfc;
            color: #425867;
            font-size: 13px;
        }

        tr:hover td {
            background: #f8fbfc;
        }

        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 8px;
            background: #e6f3f5;
            color: var(--teal);
            font-size: 12px;
            font-weight: 900;
        }

        .badge-danger {
            background: #fde7e5;
            color: var(--danger);
        }

        .badge-warning {
            background: #fff4d6;
            color: #8a5b0e;
        }

        .badge-info {
            background: #e8f1fb;
            color: var(--blue);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-height: 40px;
            padding: 0 14px;
            border-radius: 8px;
            border: 1px solid transparent;
            background: var(--teal);
            color: white;
            cursor: pointer;
            font-size: 14px;
            font-weight: 800;
            text-decoration: none;
            transition: .18s;
        }

        .btn:hover {
            background: var(--teal-dark);
            box-shadow: 0 10px 22px rgba(11, 111, 115, .18);
        }

        .btn-secondary {
            background: #425867;
        }

        .btn-danger {
            background: var(--danger);
        }

        .btn-warning {
            background: var(--amber);
        }

        .btn-light {
            background: white;
            border-color: var(--line);
            color: var(--ink);
        }

        .btn-light:hover {
            background: #edf5f7;
            box-shadow: none;
        }

        .btn-sm {
            min-height: 32px;
            padding: 0 10px;
            font-size: 12px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            color: var(--ink);
            font-size: 14px;
            font-weight: 800;
            margin-bottom: 7px;
        }

        input,
        select,
        textarea {
            width: 100%;
            border: 1px solid #c7d6de;
            border-radius: 8px;
            padding: 12px;
            background: white;
            color: var(--ink);
            font-size: 14px;
            outline: none;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 4px rgba(11, 111, 115, .12);
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .checkbox-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .checkbox-row input {
            width: auto;
            accent-color: var(--teal);
        }

        .search-row {
            display: flex;
            gap: 10px;
            margin-bottom: 16px;
        }

        .search-row input {
            flex: 1;
        }

        .clinical-note {
            background: #edf7f8;
            border: 1px solid #c1e2e6;
            color: #245763;
            border-radius: 8px;
            padding: 14px 16px;
            font-size: 13px;
            line-height: 1.6;
            margin-bottom: 18px;
        }

        .sidebar-overlay {
            display: none;
        }

        @media(max-width: 1100px) {
            .cards,
            .grid-3 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width: 900px) {
            .sidebar {
                transform: translateX(-100%);
                transition: .22s;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(16, 33, 43, .48);
                z-index: 15;
            }

            .sidebar-overlay.show {
                display: block;
            }

            .main {
                margin-left: 0;
            }

            .mobile-toggle {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .topbar {
                padding: 14px 16px;
            }

            .topbar-right {
                display: none;
            }

            .content {
                padding: 18px 16px 30px;
            }

            .cards,
            .grid-2,
            .grid-3 {
                grid-template-columns: 1fr;
            }

            .search-row {
                flex-direction: column;
            }

            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }
        /* =========================
        Mobile Polish & Responsive
        ========================= */

        .sidebar-close {
            display: none;
            margin-left: auto;
            width: 38px;
            height: 38px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,.22);
            background: rgba(255,255,255,.13);
            color: white;
            font-size: 28px;
            line-height: 1;
            cursor: pointer;
        }

        body.sidebar-open {
            overflow: hidden;
        }

        .panel,
        .card {
            overflow-wrap: anywhere;
        }

        .actions {
            row-gap: 10px;
        }

        @media(max-width: 900px) {
            .sidebar {
                width: min(320px, 88vw);
                padding: 22px 16px;
                box-shadow: 18px 0 45px rgba(16, 33, 43, .22);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .sidebar-close {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .brand {
                gap: 12px;
                padding-bottom: 20px;
                margin-bottom: 18px;
            }

            .brand-logo {
                width: 44px;
                height: 44px;
                border-radius: 16px;
                flex: 0 0 44px;
                font-size: 16px;
            }

            .brand-title strong {
                font-size: 16px;
            }

            .brand-title span {
                font-size: 12px;
            }

            .main {
                width: 100%;
                min-width: 0;
            }

            .user-box {
                border-radius: 20px;
                padding: 15px;
                margin-bottom: 18px;
            }

            .menu-title {
                margin: 18px 10px 9px;
                font-size: 12px;
            }

            .menu a,
            .logout-btn {
                min-height: 50px;
                border-radius: 15px;
                font-size: 14px;
                padding: 10px 12px;
            }

            .menu-icon {
                width: 28px;
                height: 28px;
                font-size: 18px;
            }

            .topbar {
                min-height: 68px;
                padding: 12px 14px;
                align-items: flex-start;
            }

            .topbar-left {
                align-items: flex-start;
                width: 100%;
            }

            .mobile-toggle {
                width: 40px;
                height: 40px;
                border-radius: 13px;
                font-size: 21px;
                flex: 0 0 auto;
                box-shadow: 0 8px 20px rgba(16, 33, 43, .07);
            }

            .page-title {
                font-size: 17px;
                line-height: 1.25;
            }

            .page-subtitle {
                font-size: 12px;
                line-height: 1.45;
            }

            .content {
                padding: 16px 12px 28px;
            }

            .card,
            .panel {
                border-radius: 18px;
                padding: 16px;
            }

            .btn {
                min-height: 42px;
                border-radius: 12px;
            }

            .actions .btn {
                flex: 1 1 auto;
            }

            input,
            select,
            textarea {
                min-height: 44px;
                border-radius: 12px;
                font-size: 14px;
            }

            .alert-success,
            .alert-error,
            .clinical-note {
                border-radius: 14px;
            }

            table {
                min-width: 720px;
            }

            .panel table {
                margin-top: 10px;
            }
        }

        @media(max-width: 560px) {
            .content {
                padding: 14px 10px 24px;
            }

            .topbar {
                min-height: 60px;
                padding: 10px 12px;
            }

            .mobile-toggle {
                width: 38px;
                height: 38px;
                border-radius: 12px;
            }

            .page-title {
                font-size: 17px;
            }

            .page-subtitle {
                display: none;
            }

            .cards {
                gap: 12px;
            }

            .card .number {
                font-size: 28px;
            }

            .actions {
                flex-direction: column;
                align-items: stretch;
            }

            .actions .btn,
            .result-actions .btn,
            .hero-actions .btn {
                width: 100%;
            }

            .search-row {
                gap: 8px;
            }

            th,
            td {
                padding: 11px 10px;
                font-size: 13px;
            }
        }
    </style>
</head>

<body>
@php
    $user = auth()->user();
    $role = $user->role ?? '-';

    $pageTitle = trim($__env->yieldContent('page_title')) ?: trim($__env->yieldContent('title', 'Dashboard'));
    $pageSubtitle = trim($__env->yieldContent('page_subtitle')) ?: 'AI-Assisted Assessment untuk penilaian loneliness pasien ICU.';
@endphp

<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<div class="app-layout">
    <aside class="sidebar" id="sidebar">
        <div class="brand">
            <div class="brand-logo">
                <img src="{{ asset('icons/icon.svg') }}?v=8" alt="NersCare ICU">
            </div>
            <div class="brand-title">
                <strong>AI Assessment ICU</strong>
                <span>Loneliness Assessment & Edukasi</span>
            </div>

            <button type="button" class="sidebar-close" onclick="closeSidebar()" aria-label="Tutup menu">
                &times;
            </button>
        </div>

        <div class="user-box">
            <div class="user-name">{{ $user->name ?? 'Pengguna' }}</div>
            <div class="user-email">{{ $user->email ?? '-' }}</div>
            <span class="role-badge">{{ strtoupper($role) }}</span>
        </div>

        <nav class="menu">
            <div class="menu-title">Menu Utama</div>

            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="menu-icon">@include('partials.ui-icon', ['name' => 'home'])</span>
                <span>Dashboard</span>
            </a>

            @if($role !== 'keluarga')
                <a href="{{ route('patients.index') }}" class="{{ request()->routeIs('patients.*') ? 'active' : '' }}">
                    <span class="menu-icon">@include('partials.ui-icon', ['name' => 'patient'])</span>
                    <span>Data Pasien</span>
                </a>

                <a href="{{ route('assessments.select_patient') }}"
                class="{{ request()->routeIs('assessments.select_patient') || request()->routeIs('assessments.create') ? 'active' : '' }}">
                    <span class="menu-icon">@include('partials.ui-icon', ['name' => 'assessment'])</span>
                    <span>Assessment Loneliness</span>
                </a>

                <a href="{{ route('assessments.index') }}"
                class="{{ request()->routeIs('assessments.index') || request()->routeIs('assessments.show') ? 'active' : '' }}">
                    <span class="menu-icon">@include('partials.ui-icon', ['name' => 'result'])</span>
                    <span>Hasil / Riwayat Assessment</span>
                </a>
            @endif

            @if($role !== 'keluarga')
                <div class="menu-title">Edukasi</div>

                <a href="{{ route('education.perawat') }}" class="{{ request()->routeIs('education.perawat') ? 'active' : '' }}">
                    <span class="menu-icon">@include('partials.ui-icon', ['name' => 'book'])</span>
                    <span>Edukasi Perawat</span>
                </a>
            @endif

            <a href="{{ route('education.keluarga') }}" class="{{ request()->routeIs('education.keluarga') ? 'active' : '' }}">
                <span class="menu-icon">@include('partials.ui-icon', ['name' => 'family'])</span>
                <span>Edukasi Keluarga</span>
            </a>

            @if($role === 'admin')
                <div class="menu-title">Administrator</div>

                <a href="{{ route('education.manage') }}" class="{{ request()->routeIs('education.manage') || request()->routeIs('education.create') || request()->routeIs('education.edit') ? 'active' : '' }}">
                    <span class="menu-icon">@include('partials.ui-icon', ['name' => 'content'])</span>
                    <span>Manajemen Konten</span>
                </a>
                <a href="{{ route('interpretations.index') }}" class="{{ request()->routeIs('interpretations.*') ? 'active' : '' }}">
                    <span class="menu-icon">@include('partials.ui-icon', ['name' => 'settings'])</span>
                    <span>Pengaturan Interpretasi</span>
                </a>
                <a href="{{ route('questions.index') }}" class="{{ request()->routeIs('questions.*') ? 'active' : '' }}">
                    <span class="menu-icon">@include('partials.ui-icon', ['name' => 'question'])</span>
                    <span>Manajemen Pertanyaan</span>
                </a>
                <a href="{{ route('site-settings.index') }}" class="{{ request()->routeIs('site-settings.*') ? 'active' : '' }}">
                    <span class="menu-icon">@include('partials.ui-icon', ['name' => 'landing'])</span>
                    <span>Pengaturan Landing</span>
                </a>
                <a href="{{ route('booklet-pages.index') }}" class="{{ request()->routeIs('booklet-pages.*') ? 'active' : '' }}">
                    <span class="menu-icon">@include('partials.ui-icon', ['name' => 'booklet'])</span>
                    <span>Booklet Landing</span>
                </a>
                <a href="{{ route('report-settings.index') }}" class="{{ request()->routeIs('report-settings.*') ? 'active' : '' }}">
                    <span class="menu-icon">@include('partials.ui-icon', ['name' => 'report'])</span>
                    <span>Pengaturan Laporan</span>
                </a>

                <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <span class="menu-icon">@include('partials.ui-icon', ['name' => 'users'])</span>
                    <span>Manajemen Pengguna</span>
                </a>
            @endif

            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button class="logout-btn" type="submit">
                    <span class="menu-icon">@include('partials.ui-icon', ['name' => 'logout'])</span>
                    <span>Logout</span>
                </button>
            </form>
        </nav>
    </aside>

    <main class="main">
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="mobile-toggle" onclick="openSidebar()" aria-label="Buka menu">
                    &#9776;
                </button>
                <div>
                    <h1 class="page-title">{{ $pageTitle }}</h1>
                    <p class="page-subtitle">{{ $pageSubtitle }}</p>
                </div>
            </div>

            <div class="topbar-right">
                <span>{{ now()->translatedFormat('d F Y') }}</span>
                <span>&bull;</span>
                <strong>{{ strtoupper($role) }}</strong>
            </div>
        </header>

        <section class="content">
            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert-error">
                    <strong>Data belum sesuai.</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </section>
    </main>
</div>

<div class="confirm-overlay" id="confirmOverlay" aria-hidden="true">
    <div class="confirm-dialog" role="dialog" aria-modal="true" aria-labelledby="confirmTitle" aria-describedby="confirmMessage">
        <div class="confirm-head">
            <div class="confirm-icon" aria-hidden="true">!</div>
            <div>
                <h2 class="confirm-title" id="confirmTitle">Konfirmasi tindakan</h2>
                <p class="confirm-message" id="confirmMessage">Yakin melanjutkan tindakan ini?</p>
            </div>
        </div>
        <div class="confirm-actions">
            <button type="button" class="btn btn-secondary" id="confirmCancel">Batal</button>
            <button type="button" class="btn btn-danger" id="confirmOk">Ya, lanjutkan</button>
        </div>
    </div>
</div>

<script>
    let appConfirmCallback = null;

    function showAppConfirm(message, onConfirm, options = {}) {
        const overlay = document.getElementById('confirmOverlay');
        const title = document.getElementById('confirmTitle');
        const messageEl = document.getElementById('confirmMessage');
        const okButton = document.getElementById('confirmOk');
        const cancelButton = document.getElementById('confirmCancel');

        if (!overlay || !messageEl || !okButton || !cancelButton) {
            return;
        }

        title.textContent = options.title || 'Konfirmasi tindakan';
        messageEl.textContent = message || 'Yakin melanjutkan tindakan ini?';
        okButton.textContent = options.confirmText || 'Ya, lanjutkan';
        cancelButton.style.display = options.hideCancel ? 'none' : '';
        appConfirmCallback = onConfirm;

        overlay.classList.add('show');
        overlay.setAttribute('aria-hidden', 'false');
        okButton.focus();
    }

    function showAppNotice(message, options = {}) {
        showAppConfirm(message, function () {}, {
            title: options.title || 'Informasi',
            confirmText: options.confirmText || 'Mengerti',
            hideCancel: true
        });
    }

    function closeAppConfirm() {
        const overlay = document.getElementById('confirmOverlay');

        if (overlay) {
            overlay.classList.remove('show');
            overlay.setAttribute('aria-hidden', 'true');
        }

        const cancelButton = document.getElementById('confirmCancel');
        if (cancelButton) {
            cancelButton.style.display = '';
        }

        appConfirmCallback = null;
    }

    document.addEventListener('submit', function (event) {
        const form = event.target.closest('form[data-confirm]');

        if (!form || form.dataset.confirmed === 'true') {
            return;
        }

        event.preventDefault();

        showAppConfirm(form.dataset.confirm, function () {
            form.dataset.confirmed = 'true';
            form.submit();
        }, {
            title: form.dataset.confirmTitle || 'Hapus data?',
            confirmText: form.dataset.confirmText || 'Ya, hapus'
        });
    });

    document.addEventListener('click', function (event) {
        const overlay = document.getElementById('confirmOverlay');

        if (event.target.id === 'confirmCancel') {
            closeAppConfirm();
            return;
        }

        if (event.target.id === 'confirmOk') {
            const callback = appConfirmCallback;
            closeAppConfirm();

            if (callback) {
                callback();
            }

            return;
        }

        if (overlay && event.target === overlay) {
            closeAppConfirm();
        }
    });

    function openSidebar() {
        document.getElementById('sidebar').classList.add('show');
        document.getElementById('sidebarOverlay').classList.add('show');
        document.body.classList.add('sidebar-open');
    }

    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('show');
        document.getElementById('sidebarOverlay').classList.remove('show');
        document.body.classList.remove('sidebar-open');
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeAppConfirm();
            closeSidebar();
        }
    });

    document.addEventListener('click', function (event) {
        const sidebar = document.getElementById('sidebar');
        const toggle = document.querySelector('.mobile-toggle');

        if (
            window.innerWidth <= 900 &&
            sidebar.classList.contains('show') &&
            sidebar.contains(event.target) &&
            event.target.closest('a')
        ) {
            closeSidebar();
        }

        if (
            window.innerWidth <= 900 &&
            sidebar.classList.contains('show') &&
            !sidebar.contains(event.target) &&
            !toggle.contains(event.target)
        ) {
            closeSidebar();
        }
    });
</script>
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function () {
            navigator.serviceWorker.register('/service-worker.js')
                .then(function () {
                    console.log('Service Worker registered');
                })
                .catch(function (error) {
                    console.log('Service Worker registration failed:', error);
                });
        });
    }
</script>
</body>
</html>
