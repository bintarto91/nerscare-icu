<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="manifest" href="{{ asset('manifest.json') }}?v=8">
    <meta name="theme-color" content="#0f766e">
    <link rel="icon" href="{{ asset('icons/icon.svg') }}?v=8" type="image/svg+xml">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}?v=8" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icons/apple-touch-icon.png') }}?v=8">
    <meta charset="UTF-8">
    <title>{{ $settings['app_name'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

    <style>
        :root {
            --ink: #10212b;
            --muted: #64748b;
            --line: #d8e4ea;
            --surface: #ffffff;
            --soft: #f2f8fa;
            --teal: #0f766e;
            --teal-deep: #07575b;
            --navy: #082f49;
            --cyan: #9df4ee;
            --amber: #fff7e6;
            --amber-text: #8a5b0e;
            --shadow: 0 24px 70px rgba(8, 47, 73, .24);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: var(--soft);
            color: var(--ink);
            font-family: Arial, Helvetica, sans-serif;
        }

        a {
            text-decoration: none;
        }

        .navbar {
            position: sticky;
            top: 0;
            z-index: 20;
            background: rgba(255, 255, 255, .96);
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(14px);
        }

        .nav-inner {
            max-width: 1180px;
            min-height: 78px;
            margin: auto;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--ink);
        }

        .brand-logo {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            background: #f4fbfb;
            display: block;
            overflow: hidden;
            flex: 0 0 46px;
            box-shadow: 0 14px 26px rgba(15, 118, 110, .22);
        }

        .brand-logo img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
        }

        .brand strong {
            display: block;
            color: var(--teal);
            font-size: 18px;
            line-height: 1.2;
        }

        .brand span {
            display: block;
            margin-top: 3px;
            color: var(--muted);
            font-size: 13px;
            font-weight: 800;
        }

        .nav-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 46px;
            padding: 0 20px;
            border-radius: 14px;
            border: 1px solid transparent;
            background: var(--teal);
            color: white;
            cursor: pointer;
            font-size: 15px;
            font-weight: 900;
            box-shadow: 0 13px 26px rgba(15, 118, 110, .2);
            transition: .18s;
        }

        .btn:hover {
            transform: translateY(-1px);
            background: var(--teal-deep);
        }

        .btn-light {
            background: #e8eef5;
            border-color: #d6e1ea;
            color: var(--ink);
            box-shadow: none;
        }

        .btn-light:hover {
            background: #dfe8f2;
        }

        .btn-white {
            background: white;
            color: var(--teal);
            box-shadow: 0 16px 34px rgba(0, 0, 0, .16);
        }

        .hero {
            min-height: 650px;
            background:
                linear-gradient(90deg, rgba(255, 255, 255, .08) 1px, transparent 1px),
                linear-gradient(135deg, #138779 0%, #0f766e 43%, #075263 70%, var(--navy) 100%);
            background-size: 54px 100%, 100% 100%;
            color: white;
            display: flex;
            align-items: center;
            padding: 74px 24px 56px;
            border-bottom: 1px solid #d8e4ea;
        }

        .hero-inner {
            width: 100%;
            max-width: 1180px;
            margin: auto;
            display: grid;
            grid-template-columns: minmax(0, 1.12fr) minmax(390px, .88fr);
            gap: 54px;
            align-items: center;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            min-height: 38px;
            padding: 0 18px;
            border: 1px solid rgba(255, 255, 255, .32);
            border-radius: 999px;
            background: rgba(255, 255, 255, .14);
            color: white;
            font-size: 13px;
            font-weight: 900;
            letter-spacing: .5px;
            text-transform: uppercase;
            margin-bottom: 24px;
        }

        .hero h1 {
            max-width: 820px;
            color: white;
            font-size: 56px;
            line-height: 1.12;
            margin-bottom: 22px;
        }

        .hero p {
            max-width: 760px;
            color: #ecfffd;
            font-size: 18px;
            line-height: 1.85;
            margin-bottom: 30px;
        }

        .hero-actions {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .hero-actions .btn:not(.btn-white) {
            background: rgba(255, 255, 255, .12);
            color: white;
            border-color: rgba(255, 255, 255, .14);
            box-shadow: none;
        }

        .hero-actions .btn:not(.btn-white):hover {
            background: rgba(255, 255, 255, .18);
        }

        .trust-row {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            max-width: 800px;
        }

        .trust-item {
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .16);
            border-radius: 16px;
            padding: 14px 16px;
            backdrop-filter: blur(8px);
        }

        .trust-item strong {
            display: block;
            margin-bottom: 6px;
            color: white;
            font-size: 14px;
        }

        .trust-item span {
            color: #d8fffb;
            font-size: 13px;
            line-height: 1.5;
        }

        .flow-card {
            background: rgba(255, 255, 255, .13);
            border: 1px solid rgba(255, 255, 255, .22);
            border-radius: 28px;
            padding: 30px;
            box-shadow: var(--shadow);
            backdrop-filter: blur(14px);
        }

        .flow-card h2 {
            color: white;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .flow-list {
            display: grid;
            gap: 14px;
        }

        .flow-item {
            display: grid;
            grid-template-columns: 42px 1fr;
            gap: 14px;
            align-items: center;
            min-height: 66px;
            border-radius: 18px;
            padding: 14px 16px;
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .08);
        }

        .flow-number {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: white;
            color: var(--teal);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 900;
        }

        .flow-item strong {
            display: block;
            color: white;
            font-size: 16px;
            margin-bottom: 3px;
        }

        .flow-item span {
            display: block;
            color: #d8fffb;
            font-size: 14px;
            line-height: 1.4;
        }

        .section {
            position: relative;
            padding: 66px 24px;
        }

        .section-inner {
            max-width: 1180px;
            margin: auto;
        }

        .features-section {
            background:
                linear-gradient(180deg, #f2f8fa 0%, #ffffff 46%, #eef7f8 100%);
        }

        .section-title {
            max-width: 760px;
            margin-bottom: 34px;
        }

        .section-title-center {
            max-width: 820px;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }

        .section-kicker {
            display: inline-flex;
            align-items: center;
            min-height: 30px;
            margin-bottom: 12px;
            padding: 0 13px;
            border-radius: 999px;
            background: rgba(15, 118, 110, .12);
            color: var(--teal);
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .45px;
            text-transform: uppercase;
        }

        .section-title h2 {
            color: var(--ink);
            font-size: 36px;
            margin-bottom: 11px;
        }

        .section-title p {
            color: var(--muted);
            line-height: 1.75;
            font-size: 15px;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .feature-card {
            --card-accent: var(--teal);
            --card-soft: #e6f7f6;
            --card-text: var(--teal);
            position: relative;
            overflow: hidden;
            min-height: 236px;
            background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
            border: 1px solid #d6e5eb;
            border-radius: 22px;
            padding: 26px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 18px 42px rgba(8, 47, 73, .08);
            transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
        }

        .feature-card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto;
            height: 6px;
            background: var(--card-accent);
        }

        .feature-card:hover {
            transform: translateY(-4px);
            border-color: rgba(15, 118, 110, .35);
            box-shadow: 0 26px 58px rgba(8, 47, 73, .13);
        }

        .feature-card.feature-blue {
            --card-accent: #2563eb;
            --card-soft: #eaf2ff;
            --card-text: #1d4ed8;
        }

        .feature-card.feature-amber {
            --card-accent: #d97706;
            --card-soft: #fff4dc;
            --card-text: #b45309;
        }

        .feature-card.feature-rose {
            --card-accent: #e11d48;
            --card-soft: #fff1f2;
            --card-text: #be123c;
        }

        .feature-icon {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            background: var(--card-soft);
            color: var(--card-text);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
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

        .feature-card h3 {
            color: var(--ink);
            font-size: 20px;
            margin-bottom: 10px;
        }

        .feature-card p {
            color: var(--muted);
            line-height: 1.65;
            font-size: 14px;
        }

        .feature-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: auto;
            padding-top: 18px;
            color: var(--card-text);
            font-size: 14px;
            font-weight: 900;
        }

        .feature-link::after {
            content: ">";
            font-size: 16px;
        }

        .audience-section {
            background:
                linear-gradient(180deg, #eef7f8 0%, #ffffff 38%, #f7fbfc 100%);
            padding-top: 58px;
        }

        .audience-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .audience-card {
            position: relative;
            overflow: hidden;
            background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
            border: 1px solid #d6e5eb;
            border-radius: 24px;
            padding: 26px;
            min-height: 310px;
            box-shadow: 0 18px 42px rgba(8, 47, 73, .07);
            transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
        }

        .audience-card:hover {
            transform: translateY(-4px);
            border-color: rgba(15, 118, 110, .28);
            box-shadow: 0 26px 58px rgba(8, 47, 73, .12);
        }

        .audience-card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto;
            height: 78px;
            background: var(--audience-band);
        }

        .audience-card.public {
            --audience-band: linear-gradient(135deg, #dff7f5, #eefbff);
            --audience-color: #0f766e;
        }

        .audience-card.nurse {
            --audience-band: linear-gradient(135deg, #e7f0ff, #f6fbff);
            --audience-color: #1d4ed8;
        }

        .audience-card.family {
            --audience-band: linear-gradient(135deg, #fff3d7, #fff9ee);
            --audience-color: #b45309;
        }

        .audience-icon {
            position: relative;
            z-index: 1;
            width: 56px;
            height: 56px;
            border-radius: 18px;
            background: #ffffff;
            color: var(--audience-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            box-shadow: 0 12px 28px rgba(8, 47, 73, .12);
        }

        .audience-icon svg {
            width: 27px;
            height: 27px;
            stroke: currentColor;
            stroke-width: 2.2;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .audience-card h3 {
            color: var(--ink);
            font-size: 21px;
            margin-bottom: 10px;
        }

        .audience-card p {
            color: var(--muted);
            line-height: 1.65;
            font-size: 14px;
        }

        .audience-list {
            list-style: none;
            display: grid;
            gap: 10px;
            margin-top: 18px;
        }

        .audience-list li {
            display: grid;
            grid-template-columns: 16px 1fr;
            gap: 9px;
            color: #425867;
            font-size: 14px;
            line-height: 1.5;
        }

        .audience-list li::before {
            content: "";
            width: 9px;
            height: 9px;
            margin-top: 6px;
            border-radius: 3px;
            background: var(--audience-color);
        }

        .calculator-cta {
            padding-top: 28px;
            background: #eef7f8;
        }

        .cta-panel {
            overflow: hidden;
            position: relative;
            border-radius: 28px;
            padding: 36px;
            background:
                linear-gradient(90deg, rgba(255, 255, 255, .06) 1px, transparent 1px),
                linear-gradient(135deg, #0f766e 0%, #07575b 48%, #082f49 100%);
            background-size: 46px 100%, 100% 100%;
            color: white;
            display: grid;
            grid-template-columns: minmax(0, 1fr) 360px;
            gap: 28px;
            align-items: center;
            box-shadow: 0 28px 70px rgba(8, 47, 73, .20);
        }

        .cta-panel h2 {
            color: white;
            font-size: 34px;
            margin-bottom: 12px;
        }

        .cta-panel p {
            max-width: 720px;
            color: #e9fffd;
            line-height: 1.75;
            margin-bottom: 18px;
        }

        .cta-kicker {
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .22);
            color: white;
        }

        .cta-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        .cta-note {
            max-width: 780px;
            border-left: 4px solid #fbbf24;
            background: rgba(255, 255, 255, .12);
            color: #fff8db;
            border-radius: 16px;
            padding: 15px 18px;
            font-size: 14px;
        }

        .score-preview {
            background: #ffffff;
            color: var(--ink);
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 22px 44px rgba(0, 0, 0, .18);
        }

        .score-preview h3 {
            font-size: 18px;
            margin-bottom: 18px;
        }

        .score-row {
            display: grid;
            grid-template-columns: 118px 1fr;
            gap: 18px;
            align-items: center;
            margin-bottom: 18px;
        }

        .score-circle {
            width: 118px;
            height: 118px;
            border-radius: 50%;
            background: conic-gradient(#0f766e 0 55%, #2563eb 55% 78%, #d9eef1 78% 100%);
            display: grid;
            place-items: center;
        }

        .score-circle span {
            width: 82px;
            height: 82px;
            border-radius: 50%;
            background: white;
            display: grid;
            place-items: center;
            color: var(--teal);
            font-size: 34px;
            font-weight: 900;
        }

        .score-copy strong {
            display: block;
            color: var(--ink);
            font-size: 16px;
            margin-bottom: 6px;
        }

        .score-copy small {
            color: var(--muted);
            line-height: 1.5;
        }

        .mini-question {
            border: 1px solid #d8e4ea;
            border-radius: 18px;
            padding: 15px;
            background: #f7fbfc;
        }

        .mini-question span {
            display: block;
            color: var(--muted);
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .mini-question strong {
            display: block;
            color: var(--ink);
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 12px;
        }

        .mini-options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }

        .mini-options div {
            border: 1px solid #d8e4ea;
            border-radius: 12px;
            padding: 9px 8px;
            color: #425867;
            text-align: center;
            font-size: 12px;
            font-weight: 800;
            background: #ffffff;
        }

        .booklet-section {
            background:
                radial-gradient(circle at 13% 18%, rgba(15, 118, 110, .18), transparent 30%),
                radial-gradient(circle at 88% 22%, rgba(37, 99, 235, .13), transparent 31%),
                radial-gradient(circle at 72% 82%, rgba(251, 191, 36, .16), transparent 30%),
                linear-gradient(180deg, #f7fbfc 0%, #ffffff 45%, #eef7f8 100%);
            padding-top: 58px;
            padding-bottom: 70px;
        }

        .booklet-layout {
            display: grid;
            grid-template-columns: minmax(0, .82fr) minmax(520px, 1.18fr);
            gap: 36px;
            align-items: center;
        }

        .booklet-copy {
            max-width: 520px;
        }

        .booklet-copy h2 {
            color: var(--ink);
            font-size: 36px;
            line-height: 1.18;
            margin-bottom: 14px;
        }

        .booklet-copy p {
            color: var(--muted);
            line-height: 1.75;
            margin-bottom: 20px;
            font-size: 15px;
        }

        .booklet-points {
            list-style: none;
            display: grid;
            gap: 12px;
            margin-bottom: 24px;
        }

        .booklet-points li {
            display: grid;
            grid-template-columns: 36px 1fr;
            gap: 12px;
            align-items: center;
            color: #334155;
            line-height: 1.5;
            font-size: 14px;
        }

        .booklet-points span {
            width: 36px;
            height: 36px;
            border-radius: 14px;
            background: #e6f7f6;
            color: var(--teal);
            display: grid;
            place-items: center;
            font-weight: 900;
        }

        .booklet-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .book-shell {
            position: relative;
            perspective: 1400px;
        }

        .book-shell::before {
            content: "";
            position: absolute;
            inset: 34px 28px -18px;
            border-radius: 28px;
            background: rgba(8, 47, 73, .14);
            filter: blur(24px);
            z-index: 0;
        }

        .book-spread {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 430px;
            border-radius: 28px;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #d8e4ea;
            box-shadow: 0 28px 70px rgba(8, 47, 73, .17);
            transform-style: preserve-3d;
        }

        .book-spread.is-turning {
            animation: bookLift .58s ease;
        }

        .book-spread::before {
            content: "";
            position: absolute;
            inset: 0 calc(50% - 1px);
            width: 2px;
            background: linear-gradient(180deg, transparent, rgba(8, 47, 73, .24), transparent);
            z-index: 3;
        }

        .book-spread::after {
            content: "";
            position: absolute;
            top: 0;
            bottom: 0;
            left: calc(50% - 24px);
            width: 48px;
            background: linear-gradient(90deg, rgba(8, 47, 73, .08), transparent 45%, rgba(8, 47, 73, .08));
            pointer-events: none;
            z-index: 2;
        }

        .book-page {
            position: relative;
            min-height: 430px;
            padding: 34px;
            background:
                linear-gradient(90deg, rgba(15, 118, 110, .035) 1px, transparent 1px),
                linear-gradient(180deg, #fffefe 0%, #fbfdff 100%);
            background-size: 28px 100%, 100% 100%;
            transition: transform .22s ease, opacity .22s ease;
        }

        .book-page::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: .58;
        }

        .book-page.left {
            border-right: 1px solid #edf3f6;
            transform-origin: right center;
        }

        .book-page.left::after {
            background: linear-gradient(90deg, transparent 74%, rgba(8, 47, 73, .06));
        }

        .book-page.right {
            transform-origin: left center;
        }

        .book-page.right::after {
            background: linear-gradient(90deg, rgba(8, 47, 73, .06), transparent 24%);
        }

        .book-spread.is-turning .book-page.left {
            animation: pageLeftFlip .58s ease;
        }

        .book-spread.is-turning .book-page.right {
            animation: pageRightFlip .58s ease;
        }

        @keyframes bookLift {
            0% { transform: translateY(0); }
            45% { transform: translateY(-5px); }
            100% { transform: translateY(0); }
        }

        @keyframes pageLeftFlip {
            0% { transform: rotateY(0deg); }
            45% { transform: rotateY(-11deg); }
            100% { transform: rotateY(0deg); }
        }

        @keyframes pageRightFlip {
            0% { transform: rotateY(0deg); }
            45% { transform: rotateY(11deg); }
            100% { transform: rotateY(0deg); }
        }

        .book-page-kicker {
            display: inline-flex;
            align-items: center;
            min-height: 28px;
            padding: 0 10px;
            border-radius: 999px;
            background: #e6f7f6;
            color: var(--teal);
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .35px;
            margin-bottom: 18px;
        }

        .book-page h3 {
            color: var(--ink);
            font-size: 26px;
            line-height: 1.22;
            margin-bottom: 14px;
        }

        .book-page p {
            color: #425867;
            line-height: 1.72;
            font-size: 14px;
            margin-bottom: 16px;
        }

        .book-list {
            list-style: none;
            display: grid;
            gap: 10px;
            margin-top: 16px;
        }

        .book-list li {
            display: grid;
            grid-template-columns: 14px 1fr;
            gap: 10px;
            color: #334155;
            line-height: 1.5;
            font-size: 14px;
        }

        .book-list li::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 3px;
            background: linear-gradient(135deg, var(--spread-accent), var(--spread-accent-2));
            margin-top: 7px;
        }

        .book-page-number {
            position: absolute;
            bottom: 22px;
            color: #94a3b8;
            font-size: 12px;
            font-weight: 900;
        }

        .book-page.left .book-page-number {
            left: 34px;
        }

        .book-page.right .book-page-number {
            right: 34px;
        }

        .book-controls {
            margin-top: 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }

        .book-control-buttons {
            display: flex;
            gap: 10px;
        }

        .book-control-buttons button {
            min-height: 42px;
            border-radius: 14px;
            border: 1px solid #d8e4ea;
            background: #ffffff;
            color: var(--ink);
            padding: 0 15px;
            font-weight: 900;
            cursor: pointer;
        }

        .book-control-buttons button:hover {
            border-color: rgba(15, 118, 110, .45);
            color: var(--teal);
        }

        .book-step {
            color: #64748b;
            font-size: 13px;
            font-weight: 900;
        }

        .book-browser-bar {
            position: relative;
            z-index: 4;
            width: min(500px, calc(100% - 58px));
            min-height: 58px;
            margin: 0 auto -22px;
            border-radius: 7px;
            background: #1f1b1d;
            color: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            box-shadow: 0 18px 42px rgba(8, 47, 73, .20);
            font-size: 16px;
        }

        .book-browser-bar span {
            color: #d9e4ea;
        }

        .book-browser-icon {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #f8fafc;
            color: var(--teal) !important;
            display: inline-grid;
            place-items: center;
            font-size: 11px;
            font-weight: 900;
            margin-right: 8px;
        }

        .book-stage {
            position: relative;
            min-height: 590px;
            display: grid;
            place-items: center;
            padding: 54px 24px 22px;
        }

        .book-info-card {
            position: absolute;
            z-index: 1;
            width: 190px;
            min-height: 118px;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            background: rgba(255, 255, 255, .93);
            box-shadow: 0 18px 42px rgba(8, 47, 73, .12);
            padding: 18px;
            display: grid;
            align-content: center;
            gap: 8px;
        }

        .book-info-card strong {
            color: var(--ink);
            font-size: 17px;
        }

        .book-info-card span {
            color: var(--muted);
            line-height: 1.45;
            font-size: 13px;
            font-weight: 800;
        }

        .book-info-left {
            left: 0;
            top: 170px;
        }

        .book-info-right {
            right: 0;
            top: 220px;
        }

        .booklet-viewer {
            --book-accent: #0f766e;
            --book-accent-2: #2563eb;
            position: relative;
            z-index: 2;
            width: min(430px, 100%);
            min-height: 560px;
            perspective: 1600px;
        }

        .booklet-page-stack,
        .booklet-card {
            position: absolute;
            inset: 0;
            border-radius: 4px;
            box-shadow: 0 22px 54px rgba(8, 47, 73, .18);
        }

        .booklet-page-stack {
            background: #fffdf8;
            border: 1px solid #efe6d0;
        }

        .booklet-page-stack.stack-one {
            transform: translate(18px, -22px);
            opacity: .55;
        }

        .booklet-page-stack.stack-two {
            transform: translate(-18px, 22px);
            opacity: .42;
        }

        .booklet-card {
            position: relative;
            overflow: hidden;
            min-height: 560px;
            padding: 34px 34px 86px;
            color: #ffffff;
            background:
                radial-gradient(circle at 82% 26%, rgba(255, 255, 255, .15), transparent 20%),
                linear-gradient(135deg, var(--book-accent) 0%, #07575b 54%, #082f49 100%);
            transform-origin: right center;
            transition: background .28s ease, transform .28s ease;
        }

        .booklet-viewer.is-flipping .booklet-card {
            animation: bookletFlip .72s ease;
        }

        @keyframes bookletFlip {
            0% { transform: rotateY(0deg) translateX(0); filter: brightness(1); }
            42% { transform: rotateY(-17deg) translateX(-10px); filter: brightness(.94); }
            100% { transform: rotateY(0deg) translateX(0); filter: brightness(1); }
        }

        .booklet-brand {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 24px;
        }

        .booklet-brand span {
            width: 18px;
            height: 18px;
            border-radius: 4px 10px 4px 10px;
            background: #fbbf24;
            display: inline-flex;
        }

        .booklet-brand strong {
            color: white;
            font-size: 15px;
            letter-spacing: .2px;
        }

        .booklet-kicker {
            display: inline-flex;
            min-height: 28px;
            align-items: center;
            padding: 0 11px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .14);
            color: #ecfffd;
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .45px;
            margin-bottom: 20px;
        }

        .booklet-card h3 {
            color: white;
            font-size: 42px;
            line-height: 1.05;
            margin-bottom: 18px;
            max-width: 330px;
        }

        .booklet-card p {
            color: #e9fffd;
            line-height: 1.75;
            margin-bottom: 20px;
            max-width: 330px;
        }

        .booklet-list {
            position: relative;
            z-index: 2;
            margin-top: 24px;
            padding: 18px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .18);
        }

        .booklet-list li {
            color: #f8fffe;
        }

        .booklet-list li::before {
            background: #fbbf24;
        }

        .booklet-visual-strip {
            position: absolute;
            left: 0;
            bottom: 74px;
            width: 88px;
            display: grid;
            grid-template-columns: repeat(2, 44px);
            z-index: 1;
        }

        .booklet-visual-strip span {
            width: 44px;
            height: 44px;
            background: #fbbf24;
        }

        .booklet-visual-strip span:nth-child(2n) {
            border-radius: 0 26px 0 0;
        }

        .booklet-visual-strip span:nth-child(3n) {
            background: #38bdf8;
            border-radius: 26px 0 0 0;
        }

        .booklet-visual-strip span:nth-child(4n) {
            background: #0f766e;
            border-radius: 0 0 26px 0;
        }

        .booklet-curl {
            position: absolute;
            right: 0;
            bottom: 52px;
            width: 112px;
            height: 190px;
            background:
                linear-gradient(135deg, #ffffff 0%, #f8fafc 40%, #dbe4ea 62%, rgba(15, 118, 110, .24) 100%);
            clip-path: polygon(38% 0, 100% 0, 100% 100%, 0 100%);
            box-shadow: -14px 2px 24px rgba(8, 47, 73, .22);
            transform: skewX(-12deg);
            transform-origin: bottom right;
            z-index: 3;
        }

        .booklet-viewer.is-flipping .booklet-curl {
            animation: curlFlip .72s ease;
        }

        @keyframes curlFlip {
            0% { transform: skewX(-12deg) translateX(0); }
            44% { transform: skewX(-18deg) translateX(-22px) rotate(-4deg); }
            100% { transform: skewX(-12deg) translateX(0); }
        }

        .booklet-toolbar {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            min-height: 58px;
            background: rgba(2, 6, 23, .88);
            color: white;
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 14px;
            padding: 12px 18px;
            z-index: 5;
        }

        .booklet-toolbar > span {
            font-size: 13px;
            font-weight: 900;
            min-width: 42px;
        }

        .booklet-progress {
            height: 7px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .22);
            overflow: hidden;
        }

        .booklet-progress div {
            height: 100%;
            width: 12.5%;
            border-radius: 999px;
            background: #fbbf24;
            transition: width .3s ease;
        }

        .booklet-buttons {
            display: flex;
            gap: 8px;
        }

        .booklet-buttons button {
            width: 34px;
            height: 34px;
            border: none;
            border-radius: 10px;
            background: rgba(255, 255, 255, .16);
            color: white;
            cursor: pointer;
            font-weight: 900;
        }

        .booklet-buttons button:hover {
            background: rgba(255, 255, 255, .26);
        }

        .booklet-book {
            --spread-accent: #0f766e;
            --spread-accent-2: #2563eb;
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 470px;
            border-radius: 22px;
            background: linear-gradient(135deg, #dff7f5, #eaf2ff);
            box-shadow:
                0 34px 80px rgba(8, 47, 73, .18),
                inset 0 0 0 1px rgba(15, 118, 110, .08);
            transform: rotateX(2deg);
            transform-style: preserve-3d;
        }

        .booklet-book::before,
        .booklet-book::after {
            content: "";
            position: absolute;
            inset: 18px;
            border-radius: 18px;
            background: #fffdf7;
            z-index: -1;
        }

        .booklet-book::before {
            transform: translate(14px, -12px);
            opacity: .72;
            box-shadow: 0 16px 34px rgba(8, 47, 73, .08);
        }

        .booklet-book::after {
            transform: translate(-14px, 12px);
            opacity: .52;
        }

        .booklet-open-page {
            position: relative;
            overflow: hidden;
            min-height: 470px;
            padding: 34px 34px 72px;
            background:
                radial-gradient(circle at 88% 12%, rgba(251, 191, 36, .16), transparent 22%),
                linear-gradient(90deg, rgba(15, 118, 110, .035) 1px, transparent 1px),
                linear-gradient(180deg, #fffdfa 0%, #f9fbfc 100%);
            background-size: 100% 100%, 30px 100%, 100% 100%;
            border: 1px solid #eadfca;
        }

        .booklet-left-page {
            border-radius: 22px 4px 4px 22px;
            border-top: 8px solid var(--spread-accent);
            box-shadow: inset -18px 0 30px rgba(8, 47, 73, .08);
        }

        .booklet-right-page {
            border-radius: 4px 22px 22px 4px;
            border-top: 8px solid var(--spread-accent-2);
            box-shadow: inset 18px 0 30px rgba(8, 47, 73, .08);
        }

        .booklet-gutter {
            position: absolute;
            top: 0;
            bottom: 0;
            left: calc(50% - 12px);
            width: 24px;
            background:
                linear-gradient(90deg, rgba(8, 47, 73, .10), rgba(255, 255, 255, .55), rgba(8, 47, 73, .10));
            z-index: 3;
            pointer-events: none;
        }

        .booklet-page-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 22px;
        }

        .booklet-page-top span {
            display: inline-flex;
            align-items: center;
            min-height: 28px;
            padding: 0 11px;
            border-radius: 999px;
            background: #e6f7f6;
            color: var(--teal);
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .35px;
            text-transform: uppercase;
        }

        .booklet-page-top small {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--teal);
            color: white;
            display: grid;
            place-items: center;
            font-weight: 900;
        }

        .booklet-open-page h3 {
            color: var(--ink);
            font-size: 31px;
            line-height: 1.16;
            margin-bottom: 14px;
        }

        .booklet-open-page p {
            color: #425867;
            line-height: 1.72;
            font-size: 15px;
            margin-bottom: 18px;
        }

        .booklet-open-page .book-list {
            margin-top: 18px;
        }

        .booklet-open-page .book-list li {
            font-size: 14px;
        }

        .booklet-open-page .book-list li::before {
            background: linear-gradient(135deg, var(--spread-accent), #fbbf24);
        }

        .booklet-left-page::before {
            content: "ICU";
            position: absolute;
            right: 28px;
            bottom: 24px;
            color: rgba(15, 118, 110, .08);
            font-size: 76px;
            font-weight: 900;
            line-height: 1;
        }

        .booklet-right-page::before {
            content: "";
            position: absolute;
            right: 24px;
            top: 24px;
            width: 78px;
            height: 78px;
            border-radius: 28px 28px 8px 28px;
            background:
                linear-gradient(135deg, rgba(251, 191, 36, .95) 0 48%, transparent 49%),
                linear-gradient(135deg, transparent 0 48%, rgba(37, 99, 235, .16) 49%);
            opacity: .9;
        }

        .booklet-corner {
            position: absolute;
            right: 0;
            bottom: 0;
            width: 88px;
            height: 88px;
            background:
                linear-gradient(135deg, transparent 0 48%, #ffffff 49% 63%, #dde8ee 64% 100%);
            filter: drop-shadow(-8px -7px 15px rgba(8, 47, 73, .16));
        }

        .booklet-turn-page {
            position: absolute;
            top: 18px;
            bottom: 18px;
            left: 50%;
            width: calc(50% - 18px);
            border-radius: 4px 18px 18px 4px;
            background:
                linear-gradient(90deg, rgba(8, 47, 73, .10), transparent 24%),
                linear-gradient(180deg, #fffdfa 0%, #f8fafc 100%);
            border: 1px solid #eadfca;
            box-shadow: -18px 0 34px rgba(8, 47, 73, .16);
            transform-origin: left center;
            transform: rotateY(0deg);
            opacity: 0;
            pointer-events: none;
            z-index: 8;
        }

        .booklet-book.is-flipping .booklet-turn-page {
            animation: openBookPage .84s ease forwards;
            opacity: 1;
        }

        @keyframes openBookPage {
            0% {
                transform: rotateY(0deg);
                opacity: 1;
            }
            46% {
                transform: rotateY(-92deg);
                opacity: 1;
            }
            100% {
                transform: rotateY(-178deg);
                opacity: .05;
            }
        }

        .booklet-book.is-flipping {
            animation: bookBreath .84s ease;
        }

        @keyframes bookBreath {
            0%, 100% { transform: rotateX(2deg) translateY(0); }
            50% { transform: rotateX(2deg) translateY(-4px); }
        }

        .booklet-control-panel {
            margin: 18px auto 0;
            max-width: 720px;
            display: grid;
            grid-template-columns: 1fr 160px auto;
            gap: 16px;
            align-items: center;
            padding: 16px;
            border: 1px solid #d8e4ea;
            border-radius: 18px;
            background: rgba(255, 255, 255, .88);
            box-shadow: 0 18px 42px rgba(8, 47, 73, .08);
        }

        .booklet-control-panel strong {
            display: block;
            color: var(--ink);
            font-size: 14px;
            margin-bottom: 4px;
        }

        .booklet-control-panel span {
            color: var(--muted);
            font-size: 12px;
            font-weight: 800;
            line-height: 1.4;
        }

        .booklet-progress-line {
            height: 8px;
            border-radius: 999px;
            background: #e2e8f0;
            overflow: hidden;
        }

        .booklet-progress-line div {
            width: 25%;
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--spread-accent), var(--spread-accent-2), #fbbf24);
            transition: width .24s ease;
        }

        .booklet-control-buttons {
            display: flex;
            gap: 8px;
        }

        .booklet-control-buttons button {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            border: 1px solid #d8e4ea;
            background: #ffffff;
            color: var(--spread-accent);
            font-size: 18px;
            font-weight: 900;
            cursor: pointer;
        }

        .booklet-control-buttons button:hover {
            background: #e6f7f6;
            border-color: rgba(15, 118, 110, .36);
        }

        .footer {
            background: #082f49;
            color: #c8dce8;
            padding: 24px;
            text-align: center;
            font-size: 13px;
        }

        @media(max-width: 980px) {
            .hero {
                min-height: auto;
            }

            .hero-inner,
            .cta-panel,
            .booklet-layout {
                grid-template-columns: 1fr;
            }

            .hero h1 {
                font-size: 40px;
            }

            .audience-grid,
            .trust-row {
                grid-template-columns: 1fr;
            }

            .feature-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .booklet-copy {
                max-width: none;
            }

            .book-info-card {
                display: none;
            }

            .book-stage {
                min-height: 640px;
            }

            .booklet-control-panel {
                grid-template-columns: 1fr;
            }

            .booklet-progress-line {
                width: 100%;
            }
        }

        @media(max-width: 720px) {
            .nav-inner {
                align-items: center;
                flex-direction: row;
                padding: 14px 18px;
                min-height: 64px;
            }

            .brand {
                min-width: 0;
                max-width: calc(100% - 92px);
            }

            .brand-logo {
                width: 42px;
                height: 42px;
                flex: 0 0 42px;
                border-radius: 13px;
                font-size: 15px;
            }

            .brand strong {
                font-size: 15px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .brand span {
                font-size: 11px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .hero-actions .btn {
                width: 100%;
            }

            .nav-actions {
                flex: 0 0 auto;
            }

            .nav-actions .btn {
                min-height: 40px;
                padding: 0 14px;
                font-size: 13px;
            }

            .hero {
                padding: 44px 18px 38px;
            }

            .hero h1 {
                font-size: 32px;
            }

            .hero p {
                font-size: 16px;
            }

            .flow-card {
                padding: 22px;
                border-radius: 22px;
            }

            .section {
                padding: 42px 18px;
            }

            .section-title h2,
            .cta-panel h2 {
                font-size: 28px;
            }

            .feature-grid {
                grid-template-columns: 1fr;
            }

            .cta-panel {
                padding: 24px;
                border-radius: 22px;
            }

            .score-row {
                grid-template-columns: 1fr;
            }

            .mini-options {
                grid-template-columns: 1fr;
            }

            .book-spread {
                grid-template-columns: 1fr;
                min-height: auto;
            }

            .book-spread::before,
            .book-spread::after {
                display: none;
            }

            .book-page {
                min-height: 340px;
                padding: 24px;
            }

            .book-page.left {
                border-right: none;
                border-bottom: 1px solid #edf3f6;
            }

            .book-page h3,
            .booklet-copy h2 {
                font-size: 27px;
            }

            .book-browser-bar {
                width: 100%;
                min-height: 52px;
                margin-bottom: -16px;
                font-size: 13px;
            }

            .book-stage {
                min-height: 580px;
                padding: 38px 0 10px;
            }

            .booklet-viewer {
                width: min(360px, calc(100vw - 48px));
                min-height: 510px;
            }

            .booklet-card {
                min-height: 510px;
                padding: 26px 24px 82px;
            }

            .booklet-book {
                grid-template-columns: 1fr;
                min-height: auto;
                transform: none;
            }

            .booklet-book.is-flipping {
                animation: none;
            }

            .booklet-left-page,
            .booklet-right-page {
                min-height: 340px;
                border-radius: 18px;
                padding: 24px;
                box-shadow: none;
            }

            .booklet-left-page {
                border-bottom: none;
                border-radius: 18px 18px 4px 4px;
            }

            .booklet-right-page {
                border-radius: 4px 4px 18px 18px;
            }

            .booklet-gutter,
            .booklet-turn-page {
                display: none;
            }

            .booklet-open-page h3 {
                font-size: 25px;
            }

            .booklet-control-panel {
                padding: 14px;
            }

            .booklet-control-buttons {
                justify-content: space-between;
            }

            .booklet-card h3 {
                font-size: 32px;
                max-width: 260px;
            }

            .booklet-card p {
                font-size: 14px;
                max-width: 260px;
            }

            .booklet-list {
                padding: 14px;
            }

            .booklet-curl {
                width: 82px;
                height: 150px;
            }

            .booklet-toolbar {
                grid-template-columns: auto 1fr auto;
                gap: 9px;
                padding: 10px 12px;
            }

            .book-controls {
                align-items: stretch;
                flex-direction: column;
            }

            .book-control-buttons,
            .book-control-buttons button {
                width: 100%;
            }

            .booklet-book {
                grid-template-columns: 1fr 1fr !important;
                min-height: 360px;
                border-radius: 18px;
                transform: rotateX(1deg);
            }

            .booklet-book.is-flipping {
                animation: bookBreath .84s ease !important;
            }

            .booklet-left-page,
            .booklet-right-page {
                min-height: 360px;
                padding: 17px 14px 48px;
                box-shadow: inset -10px 0 18px rgba(8, 47, 73, .06);
            }

            .booklet-left-page {
                border-radius: 18px 3px 3px 18px;
                border-bottom: 1px solid #eadfca;
            }

            .booklet-right-page {
                border-radius: 3px 18px 18px 3px;
                box-shadow: inset 10px 0 18px rgba(8, 47, 73, .06);
            }

            .booklet-gutter {
                display: block;
                left: calc(50% - 8px);
                width: 16px;
            }

            .booklet-turn-page {
                display: block;
                top: 12px;
                bottom: 12px;
                width: calc(50% - 12px);
            }

            .booklet-page-top {
                margin-bottom: 12px;
                gap: 8px;
            }

            .booklet-page-top span {
                min-height: 23px;
                padding: 0 8px;
                font-size: 9px;
            }

            .booklet-page-top small {
                width: 27px;
                height: 27px;
                font-size: 11px;
            }

            .booklet-open-page h3 {
                font-size: 18px;
                line-height: 1.18;
                margin-bottom: 10px;
            }

            .booklet-open-page p {
                font-size: 11px;
                line-height: 1.58;
                margin-bottom: 10px;
            }

            .booklet-open-page .book-list {
                gap: 7px;
                margin-top: 10px;
            }

            .booklet-open-page .book-list li {
                grid-template-columns: 10px 1fr;
                gap: 6px;
                font-size: 10.5px;
                line-height: 1.35;
            }

            .booklet-open-page .book-list li::before {
                width: 6px;
                height: 6px;
                margin-top: 5px;
            }

            .booklet-left-page::before {
                font-size: 42px;
                right: 15px;
                bottom: 14px;
            }

            .booklet-right-page::before {
                width: 42px;
                height: 42px;
                right: 12px;
                top: 14px;
                border-radius: 16px 16px 5px 16px;
            }

            .booklet-corner {
                width: 52px;
                height: 52px;
            }

            .booklet-control-panel {
                margin-top: 14px;
                grid-template-columns: 1fr;
                gap: 11px;
            }

            .booklet-progress-line {
                width: 100%;
            }

            .booklet-control-buttons {
                justify-content: space-between;
            }
        }

        @media(max-width: 420px) {
            .brand span {
                display: none;
            }

            .nav-actions .btn {
                min-height: 38px;
                padding: 0 12px;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="nav-inner">
            <a href="{{ route('public.landing') }}" class="brand">
                <div class="brand-logo">
                    <img src="{{ asset('icons/icon.svg') }}?v=8" alt="NersCare ICU">
                </div>
                <div>
                    <strong>{{ $settings['app_name'] }}</strong>
                    <span>Loneliness Assessment & Edukasi</span>
                </div>
            </a>

            <div class="nav-actions">
                <a href="{{ route('login') }}" class="btn">Login</a>
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-inner">
            <div>
                <div class="eyebrow">{{ $settings['landing_badge'] }}</div>
                <h1>{{ $settings['landing_title'] }}</h1>
                <p>{{ $settings['landing_description'] }}</p>

                <div class="hero-actions">
                    <a href="{{ route('public.calculator') }}" class="btn btn-white">Coba Kalkulator Loneliness</a>
                    <a href="#booklet-edukasi" class="btn">Lihat Booklet Edukasi</a>
                    <a href="{{ route('login') }}" class="btn">Masuk ke Sistem</a>
                </div>

                <div class="trust-row">
                    <div class="trust-item">
                        <strong>Assessment Terstruktur</strong>
                        <span>Skor, kategori, interpretasi, dan riwayat tersimpan rapi.</span>
                    </div>
                    <div class="trust-item">
                        <strong>Konteks ICU</strong>
                        <span>Dirancang untuk pasien sadar dan mampu berkomunikasi.</span>
                    </div>
                    <div class="trust-item">
                        <strong>Edukasi Lanjutan</strong>
                        <span>Rekomendasi untuk perawat dan keluarga pasien.</span>
                    </div>
                </div>
            </div>

            <div class="flow-card">
                <h2>Alur Penggunaan Sistem</h2>
                <div class="flow-list">
                    <div class="flow-item">
                        <div class="flow-number">1</div>
                        <div>
                            <strong>Login petugas</strong>
                            <span>Masuk sebagai admin, perawat, atau keluarga.</span>
                        </div>
                    </div>
                    <div class="flow-item">
                        <div class="flow-number">2</div>
                        <div>
                            <strong>Pilih pasien ICU</strong>
                            <span>Pastikan pasien sadar dan mampu berkomunikasi.</span>
                        </div>
                    </div>
                    <div class="flow-item">
                        <div class="flow-number">3</div>
                        <div>
                            <strong>Isi assessment</strong>
                            <span>Jawab instrumen loneliness secara bertahap.</span>
                        </div>
                    </div>
                    <div class="flow-item">
                        <div class="flow-number">4</div>
                        <div>
                            <strong>Lihat hasil</strong>
                            <span>Skor, kategori, interpretasi, dan rekomendasi edukasi.</span>
                        </div>
                    </div>
                    <div class="flow-item">
                        <div class="flow-number">5</div>
                        <div>
                            <strong>Cetak laporan</strong>
                            <span>Dokumentasikan hasil dan tindak lanjut pasien.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @php
        $bookletSpreads = collect($bookletSpreads ?? []);
        $bookletTotal = (int) ($bookletTotal ?? 0);
        $initialBookletSpread = $bookletSpreads->first();
        $initialLeftPage = $initialBookletSpread['left'] ?? [
            'kicker' => 'Halaman 1',
            'title' => 'Booklet Edukasi ICU Loneliness',
            'text' => 'Panduan singkat untuk mengenali loneliness pada pasien ICU.',
            'list' => [],
            'number' => '1',
        ];
        $initialRightPage = $initialBookletSpread['right'] ?? [
            'kicker' => 'Halaman 2',
            'title' => 'Booklet Edukasi',
            'text' => 'Isi booklet dapat diatur dari dashboard admin.',
            'list' => [],
            'number' => '2',
        ];
        $initialBookletProgress = $bookletSpreads->count() > 0 ? 100 / $bookletSpreads->count() : 100;
    @endphp

    <section class="section booklet-section" id="booklet-edukasi">
        <div class="section-inner">
            <div class="booklet-layout">
                <div class="booklet-copy">
                    <div class="section-kicker">Booklet edukasi</div>
                    <h2>Panduan ringkas untuk memahami loneliness pasien ICU</h2>
                    <p>
                        Booklet ini dibuat sebagai pendamping web agar perawat, keluarga,
                        dan pengunjung awam dapat memahami tujuan assessment, arti hasil,
                        serta bentuk dukungan yang dapat diberikan.
                    </p>

                    <ul class="booklet-points">
                        <li><span>1</span><strong>Berisi penjelasan singkat loneliness pada pasien ICU.</strong></li>
                        <li><span>2</span><strong>Memakai acuan De Jong Gierveld Loneliness Scale 11 item.</strong></li>
                        <li><span>3</span><strong>Disusun dengan bahasa edukatif dan mudah dibaca.</strong></li>
                    </ul>

                    <div class="booklet-actions">
                        <a href="#booklet-edukasi" class="btn" onclick="nextBookletPage(); return false;">Balik Halaman</a>
                        <a href="{{ route('public.calculator') }}" class="btn btn-light">Coba Kalkulator</a>
                    </div>
                </div>

                <div class="book-shell" id="bookletShell" aria-label="Booklet edukasi interaktif">
                    <div class="booklet-book" id="bookletBook" aria-live="polite">
                        <article class="booklet-open-page booklet-left-page">
                            <div class="booklet-page-top">
                                <span id="bookLeftKicker">{{ $initialLeftPage['kicker'] }}</span>
                                <small id="bookLeftNumber">{{ $initialLeftPage['number'] }}</small>
                            </div>
                            <h3 id="bookLeftTitle">{{ $initialLeftPage['title'] }}</h3>
                            <p id="bookLeftText">{{ $initialLeftPage['text'] }}</p>
                            <ul class="book-list" id="bookLeftList">
                                @foreach($initialLeftPage['list'] as $point)
                                    <li>{{ $point }}</li>
                                @endforeach
                            </ul>
                        </article>

                        <div class="booklet-gutter" aria-hidden="true"></div>

                        <article class="booklet-open-page booklet-right-page">
                            <div class="booklet-page-top">
                                <span id="bookRightKicker">{{ $initialRightPage['kicker'] }}</span>
                                <small id="bookRightNumber">{{ $initialRightPage['number'] }}</small>
                            </div>
                            <h3 id="bookRightTitle">{{ $initialRightPage['title'] }}</h3>
                            <p id="bookRightText">{{ $initialRightPage['text'] }}</p>
                            <ul class="book-list" id="bookRightList">
                                @foreach($initialRightPage['list'] as $point)
                                    <li>{{ $point }}</li>
                                @endforeach
                            </ul>
                            <div class="booklet-corner" aria-hidden="true"></div>
                        </article>

                        <div class="booklet-turn-page" aria-hidden="true"></div>
                    </div>

                    <div class="booklet-control-panel">
                        <div>
                            <strong id="bookStepText">Halaman {{ $initialLeftPage['number'] }}-{{ $initialRightPage['number'] }} dari {{ $bookletTotal }}</strong>
                            <span>Otomatis membuka halaman, arahkan kursor untuk jeda.</span>
                        </div>
                        <div class="booklet-progress-line">
                            <div id="bookletProgress" style="width: {{ $initialBookletProgress }}%;"></div>
                        </div>
                        <div class="booklet-control-buttons">
                            <button type="button" onclick="prevBookletPage()" aria-label="Halaman sebelumnya">&lt;</button>
                            <button type="button" onclick="nextBookletPage()" aria-label="Halaman berikutnya">&gt;</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section features-section">
        <div class="section-inner">
            <div class="section-title">
                <div class="section-kicker">Kenapa web ini membantu</div>
                <h2>Fitur Utama Web</h2>
                <p>
                    Satu alur kerja untuk mendata pasien, melakukan assessment, membaca hasil,
                    dan menyiapkan edukasi yang sesuai untuk perawat maupun keluarga.
                </p>
            </div>

            <div class="feature-grid">
                <div class="feature-card">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"/>
                            <path d="M4 21a8 8 0 0 1 16 0"/>
                            <path d="M19 8v4"/>
                            <path d="M17 10h4"/>
                        </svg>
                    </div>
                    <h3>Data Pasien ICU</h3>
                    <p>Mengelola identitas pasien, kondisi komunikasi, status kesadaran, dan kelayakan assessment.</p>
                    <a href="{{ route('login') }}" class="feature-link">Kelola data</a>
                </div>

                <div class="feature-card feature-blue">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <path d="M9 3h6l1 2h3v16H5V5h3l1-2Z"/>
                            <path d="M9 12l2 2 4-5"/>
                            <path d="M8 18h8"/>
                        </svg>
                    </div>
                    <h3>Assessment Loneliness</h3>
                    <p>Instrumen diisi bertahap dengan skor otomatis, kategori, interpretasi, dan rekomendasi awal.</p>
                    <a href="{{ route('login') }}" class="feature-link">Mulai assessment</a>
                </div>

                <div class="feature-card feature-amber">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <path d="M4 19V5"/>
                            <path d="M4 19h16"/>
                            <path d="m7 15 4-4 3 3 5-7"/>
                            <path d="M18 7h1v1"/>
                        </svg>
                    </div>
                    <h3>Hasil dan Riwayat</h3>
                    <p>Riwayat assessment dapat dilihat kembali, ditindaklanjuti, dan dicetak untuk dokumentasi.</p>
                    <a href="{{ route('login') }}" class="feature-link">Lihat hasil</a>
                </div>

                <div class="feature-card feature-blue">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v17H6.5A2.5 2.5 0 0 0 4 22V5.5Z"/>
                            <path d="M4 5.5A2.5 2.5 0 0 1 6.5 8H20"/>
                            <path d="M12 12v4"/>
                            <path d="M10 14h4"/>
                        </svg>
                    </div>
                    <h3>Edukasi Perawat</h3>
                    <p>Materi komunikasi terapeutik, dukungan emosional, dan dokumentasi edukasi keperawatan.</p>
                    <a href="{{ route('login') }}" class="feature-link">Buka edukasi</a>
                </div>

                <div class="feature-card feature-rose">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <path d="M16 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                            <path d="M7 12a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                            <path d="M2 21a5 5 0 0 1 10 0"/>
                            <path d="M12 20a5 5 0 0 1 10 0"/>
                        </svg>
                    </div>
                    <h3>Edukasi Keluarga</h3>
                    <p>Panduan komunikasi positif dan dukungan emosional keluarga sesuai arahan petugas ICU.</p>
                    <a href="{{ route('login') }}" class="feature-link">Pelajari panduan</a>
                </div>

                <div class="feature-card feature-amber">
                    <div class="feature-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <rect x="5" y="3" width="14" height="18" rx="2"/>
                            <path d="M8 7h8"/>
                            <path d="M8 11h2"/>
                            <path d="M12 11h2"/>
                            <path d="M16 11h.01"/>
                            <path d="M8 15h2"/>
                            <path d="M12 15h2"/>
                            <path d="M16 15h.01"/>
                        </svg>
                    </div>
                    <h3>Kalkulator Public</h3>
                    <p>Simulasi edukatif tanpa login, tanpa menyimpan data, dan bukan pengganti penilaian klinis.</p>
                    <a href="{{ route('public.calculator') }}" class="feature-link">Coba sekarang</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section calculator-cta">
        <div class="section-inner">
            <div class="cta-panel">
                <div>
                    <div class="section-kicker cta-kicker">Mulai dari simulasi singkat</div>
                    <h2>{{ $settings['landing_calculator_title'] }}</h2>
                    <p>{{ $settings['landing_calculator_description'] }}</p>
                    <div class="cta-actions">
                        <a href="{{ route('public.calculator') }}" class="btn btn-white">Mulai Cek Loneliness</a>
                        <a href="{{ route('login') }}" class="btn">Masuk sebagai Petugas</a>
                    </div>
                    <div class="cta-note">
                        {{ $settings['clinical_disclaimer'] }}
                    </div>
                </div>

                <div class="score-preview" aria-label="Contoh tampilan hasil kalkulator">
                    <h3>Contoh ringkasan hasil</h3>
                    <div class="score-row">
                        <div class="score-circle">
                            <span>18</span>
                        </div>
                        <div class="score-copy">
                            <strong>Perlu dukungan emosional</strong>
                            <small>Skor, kategori, dan rekomendasi awal muncul dalam format yang mudah dibaca.</small>
                        </div>
                    </div>
                    <div class="mini-question">
                        <span>Contoh pertanyaan</span>
                        <strong>Seberapa sering pasien merasa tidak memiliki teman berbicara?</strong>
                        <div class="mini-options">
                            <div>Jarang</div>
                            <div>Kadang</div>
                            <div>Sering</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section audience-section">
        <div class="section-inner">
            <div class="section-title section-title-center">
                <div class="section-kicker">Dibuat agar mudah dipahami</div>
                <h2>Nyaman Dipakai oleh Perawat, Keluarga, dan Pengunjung Awam</h2>
                <p>
                    Tampilan dibuat ringkas supaya pengguna tidak merasa sedang membaca sistem yang rumit.
                    Setiap bagian memberi konteks, langkah, dan hasil yang mudah dipahami.
                </p>
            </div>

            <div class="audience-grid">
                <div class="audience-card public">
                    <div class="audience-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z"/>
                            <path d="M9 10h.01"/>
                            <path d="M15 10h.01"/>
                            <path d="M8 15c1.1 1 2.4 1.5 4 1.5s2.9-.5 4-1.5"/>
                        </svg>
                    </div>
                    <h3>Pengunjung Awam</h3>
                    <p>Bisa mencoba simulasi tanpa login dan memahami gambaran loneliness secara edukatif.</p>
                    <ul class="audience-list">
                        <li>Bahasa sederhana dan tidak terasa teknis.</li>
                        <li>Hasil langsung tampil setelah pertanyaan dijawab.</li>
                        <li>Ada catatan bahwa hasil bukan diagnosis klinis.</li>
                    </ul>
                </div>

                <div class="audience-card nurse">
                    <div class="audience-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 3v6"/>
                            <path d="M9 6h6"/>
                            <path d="M6 10h12v9a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2v-9Z"/>
                            <path d="M9 14h6"/>
                            <path d="M12 17v-6"/>
                        </svg>
                    </div>
                    <h3>Perawat ICU</h3>
                    <p>Alur kerja dibuat tertata untuk mendata pasien, menilai, membaca hasil, dan menyiapkan edukasi.</p>
                    <ul class="audience-list">
                        <li>Assessment bertahap dengan skor otomatis.</li>
                        <li>Riwayat dapat dipantau dan dicetak.</li>
                        <li>Rekomendasi awal membantu dokumentasi edukasi.</li>
                    </ul>
                </div>

                <div class="audience-card family">
                    <div class="audience-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24">
                            <path d="M7 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"/>
                            <path d="M17 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                            <path d="M2 21a5 5 0 0 1 10 0"/>
                            <path d="M14 21a4 4 0 0 1 8 0"/>
                        </svg>
                    </div>
                    <h3>Keluarga Pasien</h3>
                    <p>Materi edukasi membantu keluarga memahami bentuk dukungan emosional yang aman dan positif.</p>
                    <ul class="audience-list">
                        <li>Panduan komunikasi lebih mudah diikuti.</li>
                        <li>Fokus pada dukungan yang realistis di ruang ICU.</li>
                        <li>Tetap mengikuti arahan petugas kesehatan.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        {{ $settings['footer_text'] }}
    </footer>

    <script>
        const fallbackBookletPages = [
            {
                left: {
                    kicker: 'Halaman 1',
                    title: 'Booklet Edukasi ICU Loneliness',
                    text: 'Panduan singkat untuk mengenali loneliness pada pasien ICU dan membaca hasil assessment secara hati-hati.',
                    list: [
                        'Untuk perawat, keluarga, dan pengunjung awam.',
                        'Membantu memahami hasil tanpa menggantikan penilaian klinis.',
                        'Dapat dibaca sebelum atau sesudah mencoba kalkulator.'
                    ],
                    number: '1'
                },
                right: {
                    kicker: 'Halaman 2',
                    title: 'Apa yang dinilai?',
                    text: 'Skala De Jong Gierveld membantu melihat gambaran loneliness dari dua sisi: emotional loneliness dan social loneliness.',
                    list: [
                        'Emotional loneliness berkaitan dengan rasa kosong, ditolak, atau kehilangan kedekatan.',
                        'Social loneliness berkaitan dengan dukungan sosial dan orang yang dapat dipercaya.',
                        'Total skor dipakai untuk melihat kategori loneliness secara umum.'
                    ],
                    number: '2'
                }
            },
            {
                left: {
                    kicker: 'Halaman 3',
                    title: 'Emotional Loneliness',
                    text: 'Bagian ini menggambarkan perasaan kehilangan kedekatan emosional atau tidak adanya relasi yang benar-benar terasa dekat.',
                    list: [
                        'Merindukan teman yang benar-benar dekat.',
                        'Merasakan kekosongan secara umum.',
                        'Merasa ditolak atau kehilangan kehadiran orang lain.'
                    ],
                    number: '3'
                },
                right: {
                    kicker: 'Halaman 4',
                    title: 'Social Loneliness',
                    text: 'Bagian ini menggambarkan apakah pasien merasa memiliki jaringan sosial, orang yang dapat dipercaya, dan dukungan saat membutuhkan bantuan.',
                    list: [
                        'Ada orang yang bisa diajak bicara tentang masalah sehari-hari.',
                        'Ada orang yang dapat diandalkan ketika mengalami masalah.',
                        'Ada cukup orang yang dirasa dekat dan dapat dipercaya.'
                    ],
                    number: '4'
                }
            },
            {
                left: {
                    kicker: 'Halaman 5',
                    title: 'Membaca Kategori Hasil',
                    text: 'Total skor loneliness berada pada rentang 0 sampai 11. Semakin tinggi skor, semakin besar kebutuhan dukungan emosional dan sosial.',
                    list: [
                        '0-2: Not lonely.',
                        '3-8: Moderate lonely.',
                        '9-10: Severe lonely.',
                        '11: Very severe lonely.'
                    ],
                    number: '5'
                },
                right: {
                    kicker: 'Halaman 6',
                    title: 'Catatan Klinis',
                    text: 'Hasil assessment adalah alat bantu edukasi dan dokumentasi awal. Keputusan klinis tetap perlu menyesuaikan kondisi pasien dan kebijakan ruang ICU.',
                    list: [
                        'Lihat kemampuan komunikasi pasien.',
                        'Perhatikan observasi perawat dan kondisi klinis.',
                        'Gunakan hasil sebagai dasar tindak lanjut, bukan diagnosis tunggal.'
                    ],
                    number: '6'
                }
            },
            {
                left: {
                    kicker: 'Halaman 7',
                    title: 'Panduan untuk Perawat',
                    text: 'Perawat dapat menggunakan hasil assessment untuk menyusun komunikasi terapeutik dan edukasi yang lebih sesuai.',
                    list: [
                        'Validasi perasaan pasien dengan bahasa tenang.',
                        'Jelaskan tindakan perawatan secara sederhana.',
                        'Fasilitasi dukungan keluarga sesuai kebijakan ICU.'
                    ],
                    number: '7'
                },
                right: {
                    kicker: 'Halaman 8',
                    title: 'Panduan untuk Keluarga',
                    text: 'Keluarga dapat membantu pasien merasa lebih didampingi melalui komunikasi yang positif dan konsisten.',
                    list: [
                        'Gunakan kalimat singkat, lembut, dan menenangkan.',
                        'Yakinkan pasien bahwa ia tidak sendiri.',
                        'Ikuti arahan perawat saat berkomunikasi dengan pasien.'
                    ],
                    number: '8'
                }
            }
        ];

        const dynamicBookletPages = @json($bookletSpreads->values());
        const bookletPages = dynamicBookletPages.length ? dynamicBookletPages : fallbackBookletPages;
        const bookletTotalPages = {{ (int) $bookletTotal }} || 8;

        let activeBookletSpread = 0;
        let bookletAutoTimer = null;
        const bookletSpreadThemes = [
            ['#0f766e', '#2563eb'],
            ['#0b7285', '#0f766e'],
            ['#1d4ed8', '#d97706'],
            ['#0f766e', '#b45309'],
        ];

        function setBookletList(elementId, items) {
            const list = document.getElementById(elementId);
            if (!list) {
                return;
            }

            list.innerHTML = '';

            items.forEach(function(item) {
                const listItem = document.createElement('li');
                listItem.textContent = item;
                list.appendChild(listItem);
            });
        }

        function setBookletPage(side, page) {
            document.getElementById('book' + side + 'Kicker').textContent = page.kicker;
            document.getElementById('book' + side + 'Title').textContent = page.title;
            document.getElementById('book' + side + 'Text').textContent = page.text;
            document.getElementById('book' + side + 'Number').textContent = page.number;
            setBookletList('book' + side + 'List', page.list);
        }

        function renderBooklet() {
            const spread = bookletPages[activeBookletSpread];
            const book = document.getElementById('bookletBook');

            if (!spread || !book) {
                return;
            }

            book.classList.add('is-flipping');

            window.setTimeout(function() {
                const progress = ((activeBookletSpread + 1) / bookletPages.length) * 100;
                const theme = bookletSpreadThemes[activeBookletSpread] || bookletSpreadThemes[0];

                setBookletPage('Left', spread.left);
                setBookletPage('Right', spread.right);
                book.style.setProperty('--spread-accent', theme[0]);
                book.style.setProperty('--spread-accent-2', theme[1]);
                document.getElementById('bookStepText').textContent =
                    'Halaman ' + spread.left.number + '-' + spread.right.number + ' dari ' + bookletTotalPages;
                document.getElementById('bookletProgress').style.width = progress + '%';
            }, 300);

            window.setTimeout(function() {
                book.classList.remove('is-flipping');
            }, 860);
        }

        function changeBookletPage(direction, restartAuto) {
            activeBookletSpread += direction;

            if (activeBookletSpread >= bookletPages.length) {
                activeBookletSpread = 0;
            }

            if (activeBookletSpread < 0) {
                activeBookletSpread = bookletPages.length - 1;
            }

            renderBooklet();

            if (restartAuto) {
                startBookletAuto();
            }
        }

        function nextBookletPage() {
            changeBookletPage(1, true);
        }

        function prevBookletPage() {
            changeBookletPage(-1, true);
        }

        function startBookletAuto() {
            stopBookletAuto();
            bookletAutoTimer = window.setInterval(function() {
                changeBookletPage(1, false);
            }, 5200);
        }

        function stopBookletAuto() {
            if (bookletAutoTimer) {
                window.clearInterval(bookletAutoTimer);
                bookletAutoTimer = null;
            }
        }

        window.addEventListener('load', function() {
            const bookletShell = document.getElementById('bookletShell');

            renderBooklet();
            startBookletAuto();

            if (bookletShell) {
                bookletShell.addEventListener('mouseenter', stopBookletAuto);
                bookletShell.addEventListener('mouseleave', startBookletAuto);
                bookletShell.addEventListener('focusin', stopBookletAuto);
                bookletShell.addEventListener('focusout', startBookletAuto);
            }
        });

        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function () {
                navigator.serviceWorker.register('/service-worker.js');
            });
        }
    </script>
</body>
</html>
