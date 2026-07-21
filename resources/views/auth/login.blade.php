<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="manifest" href="{{ asset('manifest.json') }}?v=8">
    <meta name="theme-color" content="#0f766e">
    <link rel="icon" href="{{ asset('icons/icon.svg') }}?v=8" type="image/svg+xml">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}?v=8" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icons/apple-touch-icon.png') }}?v=8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Login | AI-Assisted Assessment ICU</title>

    <style>
        :root {
            --ink: #17212f;
            --muted: #65758a;
            --line: #d8e4ea;
            --surface: #ffffff;
            --teal: #0f766e;
            --teal-deep: #064b55;
            --teal-soft: #e6f7f6;
            --danger: #b42318;
            --shadow: 0 26px 70px rgba(8, 47, 73, .18);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            color: var(--ink);
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #138779 0%, #0f766e 48%, #075263 78%, #073b4d 100%);
            max-width: 100%;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
        }

        .page {
            min-height: 100vh;
            display: grid;
            grid-template-columns: minmax(0, 1.15fr) minmax(520px, .85fr);
            align-items: stretch;
        }

        .intro {
            color: white;
            padding: 64px 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .intro-inner {
            width: 100%;
            max-width: 760px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            min-height: 38px;
            padding: 0 20px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .22);
            color: white;
            font-size: 14px;
            font-weight: 800;
            margin-bottom: 34px;
        }

        .badge::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: white;
        }

        .intro h1 {
            max-width: 680px;
            color: white;
            font-size: 56px;
            line-height: 1.12;
            margin-bottom: 24px;
        }

        .intro p {
            max-width: 720px;
            color: #ecfffd;
            font-size: 20px;
            line-height: 1.75;
        }

        .feature-grid {
            margin-top: 40px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .feature-card {
            min-height: 160px;
            padding: 20px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .13);
            border: 1px solid rgba(255, 255, 255, .18);
            box-shadow: 0 16px 36px rgba(0, 0, 0, .10);
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            border-radius: 15px;
            background: rgba(255, 255, 255, .14);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .feature-icon svg {
            width: 25px;
            height: 25px;
            stroke: currentColor;
            stroke-width: 2.2;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .feature-card strong {
            display: block;
            color: white;
            font-size: 17px;
            margin-bottom: 9px;
        }

        .feature-card span {
            display: block;
            color: #d8fffb;
            font-size: 14px;
            line-height: 1.55;
        }

        .login-wrap {
            min-height: 100vh;
            padding: 32px 44px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 100%;
            max-width: 640px;
            background: white;
            border-radius: 30px 30px 0 0;
            padding: 44px 48px;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto;
            height: 8px;
            background: linear-gradient(90deg, var(--teal), #22d3ee);
        }

        .login-head {
            text-align: center;
            margin-bottom: 34px;
        }

        .logo {
            width: 88px;
            height: 88px;
            border-radius: 26px;
            background: #f4fbfb;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 22px;
            overflow: hidden;
            box-shadow: 0 18px 38px rgba(15, 118, 110, .22);
        }

        .logo img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
        }

        .login-head h2 {
            color: var(--teal);
            font-size: 34px;
            margin-bottom: 12px;
        }

        .login-head p {
            color: var(--muted);
            font-size: 16px;
            line-height: 1.55;
        }

        .alert {
            padding: 12px 14px;
            border-radius: 14px;
            margin-bottom: 18px;
            font-size: 14px;
            line-height: 1.5;
        }

        .alert-error {
            background: #fde7e5;
            color: var(--danger);
            border: 1px solid #f6b8b1;
        }

        .form-group {
            margin-bottom: 22px;
        }

        label {
            display: block;
            color: var(--ink);
            font-size: 15px;
            font-weight: 900;
            margin-bottom: 10px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            min-height: 58px;
            border: 1px solid #c7d6de;
            border-radius: 18px;
            padding: 0 18px;
            color: var(--ink);
            font-size: 18px;
            outline: none;
            background: white;
            transition: .18s;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 4px rgba(15, 118, 110, .12);
        }

        .row-between {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin: 6px 0 26px;
            font-size: 15px;
        }

        .remember {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: var(--muted);
            font-weight: 800;
            margin: 0;
        }

        .remember input {
            width: 16px;
            height: 16px;
            accent-color: var(--teal);
        }

        .forgot {
            color: var(--teal);
            font-weight: 900;
        }

        .btn-login {
            width: 100%;
            min-height: 64px;
            border: none;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--teal), #14988f);
            color: white;
            font-size: 20px;
            font-weight: 900;
            cursor: pointer;
            transition: .18s;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, var(--teal-deep), var(--teal));
            box-shadow: 0 16px 32px rgba(15, 118, 110, .22);
        }

        .info-box {
            margin-top: 28px;
            background: #f7fbfc;
            border: 1px solid var(--line);
            border-radius: 18px;
            color: #425867;
            padding: 18px 20px;
            font-size: 15px;
            line-height: 1.65;
        }

        .info-box strong {
            display: block;
            color: var(--ink);
            margin-bottom: 8px;
        }

        .clinical-note {
            margin-top: 18px;
            color: #6b7c8f;
            font-size: 13px;
            line-height: 1.6;
        }

        @media(max-width: 1100px) {
            .page {
                grid-template-columns: 1fr;
            }

            .login-wrap {
                min-height: auto;
            }
        }

        @media(max-width: 720px) {
            body {
                background: #eef6f8;
            }

            .page {
                min-height: 100dvh;
            }

            .intro,
            .login-wrap {
                padding: 28px 18px;
            }

            .intro {
                align-items: flex-start;
                padding-bottom: 14px;
            }

            .badge {
                margin-bottom: 18px;
            }

            .intro h1 {
                font-size: 30px;
                line-height: 1.16;
            }

            .intro p {
                font-size: 15px;
                line-height: 1.65;
            }

            .feature-grid {
                display: none;
            }

            .login-wrap {
                padding: 0 14px 24px;
            }

            .login-card {
                width: 100%;
                padding: 28px 20px;
                border-radius: 24px;
            }

            .logo {
                width: 74px;
                height: 74px;
                border-radius: 24px;
                margin-bottom: 18px;
                font-size: 25px;
            }

            .login-head h2 {
                font-size: 27px;
            }

            .row-between {
                align-items: flex-start;
                flex-direction: column;
                gap: 12px;
            }

            input,
            .login-btn {
                min-height: 52px;
            }
        }
    </style>
</head>
<body>
    <main class="page">
        <section class="intro">
            <div class="intro-inner">
                <div class="badge">AI-Assisted Assessment</div>
                <h1>Penilaian Loneliness Pasien ICU</h1>
                <p>
                    Sistem digital untuk membantu perawat melakukan assessment loneliness
                    secara terstruktur, terdokumentasi, serta mendukung edukasi bagi perawat
                    dan keluarga pasien.
                </p>

                <div class="feature-grid">
                    <div class="feature-card">
                        <div class="feature-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24">
                                <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"/>
                                <path d="M4 21a8 8 0 0 1 16 0"/>
                            </svg>
                        </div>
                        <strong>Data Pasien ICU</strong>
                        <span>Input dan pilih pasien yang sadar serta mampu berkomunikasi.</span>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24">
                                <path d="M9 3h6l1 2h3v16H5V5h3l1-2Z"/>
                                <path d="M9 12l2 2 4-5"/>
                                <path d="M8 18h8"/>
                            </svg>
                        </div>
                        <strong>Assessment</strong>
                        <span>Pengisian instrumen loneliness secara bertahap dan rapi.</span>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24">
                                <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v17H6.5A2.5 2.5 0 0 0 4 22V5.5Z"/>
                                <path d="M4 5.5A2.5 2.5 0 0 1 6.5 8H20"/>
                                <path d="M12 12v4"/>
                                <path d="M10 14h4"/>
                            </svg>
                        </div>
                        <strong>Edukasi</strong>
                        <span>Panduan dukungan emosional bagi perawat dan keluarga.</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="login-wrap">
            <div class="login-card">
                <div class="login-head">
                    <div class="logo">
                        <img src="{{ asset('icons/icon.svg') }}?v=8" alt="NersCare ICU">
                    </div>
                    <h2>AI-Assisted Assessment ICU</h2>
                    <p>Masuk untuk mengelola assessment loneliness dan edukasi perawat-keluarga.</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-error">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-error">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="alert alert-error" id="forgotNotice" style="display:none;">
                    Silakan hubungi admin untuk reset password.
                </div>

                <form method="POST" action="{{ route('login.process') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email / Username</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Masukkan email"
                            required
                            autofocus
                        >
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password"
                            required
                        >
                    </div>

                    <div class="row-between">
                        <label class="remember">
                            <input type="checkbox" name="remember">
                            <span>Ingat saya</span>
                        </label>

                        <a href="#" class="forgot" onclick="document.getElementById('forgotNotice').style.display = 'block'; return false;">
                            Lupa password?
                        </a>
                    </div>

                    <button type="submit" class="btn-login">Login</button>
                </form>

                <div class="info-box">
                    <strong>Akses Sistem</strong>
                    Gunakan akun yang diberikan admin. Untuk bantuan login atau reset password,
                    hubungi pengelola sistem.
                </div>

                <div class="clinical-note">
                    Catatan: Sistem ini merupakan alat bantu assessment dan tidak menggantikan penilaian klinis.
                </div>
            </div>
        </section>
    </main>
</body>
</html>
