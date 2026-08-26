<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="{{ $audience === 'keluarga' ? '#0f766e' : '#2563a9' }}">
    <link rel="icon" href="{{ asset('icons/icon.svg') }}" type="image/svg+xml">
    <title>{{ $booklet['title'] }}</title>
    <style>
        :root {
            --ink: #10212b;
            --muted: #5b6f7d;
            --line: #d9e5ea;
            --paper: #ffffff;
            --soft: #f4f9fa;
            --accent: #0f766e;
            --accent-deep: #075c57;
            --accent-soft: #e4f6f2;
            --shadow: 0 24px 64px rgba(15, 43, 58, .14);
        }

        body.theme-nurse {
            --accent: #2563a9;
            --accent-deep: #174d83;
            --accent-soft: #e6f0fc;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
            margin: 0;
            color: var(--ink);
            background:
                radial-gradient(circle at 8% 4%, color-mix(in srgb, var(--accent-soft) 82%, transparent), transparent 30%),
                linear-gradient(180deg, #fbfdfd 0%, #eef5f7 100%);
            font-family: Arial, Helvetica, sans-serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button,
        input {
            font: inherit;
        }

        .topbar {
            position: sticky;
            z-index: 20;
            top: 0;
            border-bottom: 1px solid rgba(217, 229, 234, .9);
            background: rgba(255, 255, 255, .93);
            backdrop-filter: blur(16px);
        }

        .topbar-inner,
        .reader {
            width: min(1280px, calc(100% - 40px));
            margin: 0 auto;
        }

        .topbar-inner {
            min-height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }

        .brand {
            display: flex;
            min-width: 0;
            align-items: center;
            gap: 11px;
            font-weight: 900;
        }

        .brand img {
            width: 42px;
            height: 42px;
            border-radius: 12px;
        }

        .brand span {
            display: block;
            margin-top: 3px;
            overflow: hidden;
            color: var(--muted);
            font-size: 11px;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .audience-switch {
            display: flex;
            gap: 5px;
            padding: 4px;
            border: 1px solid var(--line);
            border-radius: 12px;
            background: #f5f8f9;
        }

        .audience-switch a {
            min-height: 34px;
            display: inline-flex;
            align-items: center;
            padding: 0 11px;
            border-radius: 9px;
            color: #526978;
            font-size: 12px;
            font-weight: 900;
        }

        .audience-switch a.active {
            background: var(--paper);
            color: var(--accent);
            box-shadow: 0 4px 12px rgba(20, 48, 64, .09);
        }

        .back-link {
            color: var(--accent);
            font-size: 13px;
            font-weight: 900;
        }

        .reader {
            padding: 38px 0 48px;
        }

        .reader-intro {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 28px;
            align-items: end;
            margin-bottom: 24px;
        }

        .eyebrow {
            display: inline-flex;
            min-height: 30px;
            align-items: center;
            padding: 0 11px;
            border-radius: 999px;
            background: var(--accent-soft);
            color: var(--accent);
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .35px;
            text-transform: uppercase;
        }

        h1 {
            max-width: 820px;
            margin: 12px 0 10px;
            font-size: clamp(30px, 4.2vw, 48px);
            line-height: 1.08;
            letter-spacing: -1.15px;
        }

        .reader-intro p {
            max-width: 800px;
            margin: 0;
            color: var(--muted);
            font-size: 15px;
            line-height: 1.7;
        }

        .document-meta {
            display: flex;
            gap: 8px;
            margin-top: 15px;
            flex-wrap: wrap;
        }

        .meta-chip {
            min-height: 31px;
            display: inline-flex;
            align-items: center;
            padding: 0 10px;
            border: 1px solid var(--line);
            border-radius: 999px;
            background: rgba(255, 255, 255, .8);
            color: #425867;
            font-size: 11px;
            font-weight: 800;
        }

        .intro-actions {
            display: flex;
            justify-content: flex-end;
            gap: 9px;
            flex-wrap: wrap;
        }

        .button {
            min-height: 43px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 15px;
            border: 1px solid var(--accent);
            border-radius: 12px;
            background: var(--accent);
            color: white;
            font-size: 13px;
            font-weight: 900;
            transition: .2s ease;
        }

        .button:hover {
            border-color: var(--accent-deep);
            background: var(--accent-deep);
            transform: translateY(-1px);
        }

        .button.secondary {
            border-color: var(--line);
            background: var(--paper);
            color: var(--accent);
        }

        .reading-workspace {
            display: grid;
            grid-template-columns: 148px minmax(0, 1fr);
            gap: 18px;
            align-items: start;
        }

        .thumbnail-panel {
            position: sticky;
            top: 92px;
            max-height: calc(100vh - 112px);
            overflow: hidden;
            padding: 14px 10px 14px 14px;
            border: 1px solid var(--line);
            border-radius: 20px;
            background: rgba(255, 255, 255, .9);
            box-shadow: 0 16px 38px rgba(15, 43, 58, .08);
        }

        .thumbnail-title {
            margin: 0 4px 10px;
            color: #526978;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .3px;
            text-transform: uppercase;
        }

        .thumbnail-list {
            display: grid;
            gap: 10px;
            max-height: calc(100vh - 162px);
            overflow-y: auto;
            padding: 2px 5px 2px 0;
            scrollbar-width: thin;
        }

        .thumbnail-button {
            position: relative;
            width: 100%;
            padding: 6px;
            border: 2px solid transparent;
            border-radius: 13px;
            background: #eef3f5;
            cursor: pointer;
            transition: .18s ease;
        }

        .thumbnail-button:hover,
        .thumbnail-button.active {
            border-color: var(--accent);
            background: var(--accent-soft);
        }

        .thumbnail-button img {
            display: block;
            width: 100%;
            aspect-ratio: 1190 / 1684;
            object-fit: cover;
            border-radius: 8px;
            background: white;
        }

        .thumbnail-number {
            position: absolute;
            right: 10px;
            bottom: 10px;
            min-width: 24px;
            height: 24px;
            display: grid;
            place-items: center;
            border-radius: 999px;
            background: rgba(16, 33, 43, .88);
            color: white;
            font-size: 10px;
            font-weight: 900;
        }

        .document-viewer {
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 24px;
            background: rgba(255, 255, 255, .9);
            box-shadow: var(--shadow);
        }

        .viewer-toolbar {
            min-height: 64px;
            display: grid;
            grid-template-columns: minmax(170px, 1fr) minmax(180px, 320px) auto;
            gap: 18px;
            align-items: center;
            padding: 11px 16px;
            border-bottom: 1px solid var(--line);
            background: #f9fbfc;
        }

        .page-status strong,
        .page-status span {
            display: block;
        }

        .page-status strong {
            font-size: 13px;
        }

        .page-status span {
            margin-top: 3px;
            color: var(--muted);
            font-size: 11px;
            font-weight: 700;
        }

        .page-range {
            width: 100%;
            accent-color: var(--accent);
            cursor: pointer;
        }

        .viewer-buttons {
            display: flex;
            gap: 7px;
        }

        .viewer-buttons button {
            min-width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border: 1px solid var(--line);
            border-radius: 11px;
            background: var(--paper);
            color: var(--accent);
            cursor: pointer;
            font-size: 18px;
            font-weight: 900;
        }

        .viewer-buttons button:hover:not(:disabled) {
            border-color: var(--accent);
            background: var(--accent-soft);
        }

        .viewer-buttons button:disabled {
            cursor: not-allowed;
            opacity: .36;
        }

        .page-stage {
            position: relative;
            min-height: 660px;
            display: grid;
            place-items: center;
            padding: 26px;
            touch-action: pan-y;
            perspective: 2400px;
            background:
                linear-gradient(45deg, rgba(16, 33, 43, .025) 25%, transparent 25%),
                linear-gradient(-45deg, rgba(16, 33, 43, .025) 25%, transparent 25%),
                #edf3f5;
            background-position: 0 0, 12px 12px;
            background-size: 24px 24px;
        }

        .flipbook {
            position: relative;
            width: min(100%, 1040px);
            display: flex;
            aspect-ratio: 2380 / 1684;
            transform-style: preserve-3d;
            filter: drop-shadow(0 28px 32px rgba(15, 43, 58, .22));
        }

        .book-page {
            position: relative;
            width: 50%;
            height: 100%;
            overflow: hidden;
            background:
                linear-gradient(90deg, rgba(16, 33, 43, .025), transparent 7%),
                white;
            transition: opacity .18s ease;
        }

        .book-page.left {
            border-radius: 9px 2px 2px 9px;
            box-shadow: inset -18px 0 28px -26px rgba(16, 33, 43, .7);
        }

        .book-page.right {
            border-radius: 2px 9px 9px 2px;
            box-shadow: inset 18px 0 28px -26px rgba(16, 33, 43, .7);
        }

        .book-page.blank {
            background:
                linear-gradient(135deg, #fbfdfd, #edf3f5),
                white;
        }

        .book-page.blank img {
            visibility: hidden;
        }

        .book-page img,
        .turn-face img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: contain;
            background: white;
        }

        .book-spine {
            position: absolute;
            z-index: 7;
            top: 0;
            bottom: 0;
            left: 50%;
            width: 22px;
            transform: translateX(-50%);
            background: linear-gradient(90deg, transparent, rgba(16, 33, 43, .2), rgba(255, 255, 255, .55), rgba(16, 33, 43, .16), transparent);
            pointer-events: none;
        }

        .turn-sheet {
            position: absolute;
            z-index: 10;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            display: none;
            transform-style: preserve-3d;
            pointer-events: none;
        }

        .turn-face {
            position: absolute;
            inset: 0;
            overflow: hidden;
            border-radius: 3px 9px 9px 3px;
            background: white;
            box-shadow: 0 12px 32px rgba(16, 33, 43, .24);
            backface-visibility: hidden;
        }

        .turn-back {
            transform: rotateY(180deg);
        }

        .flipbook.is-turning .turn-sheet {
            display: block;
        }

        .flipbook.turn-next .turn-sheet {
            left: 50%;
            transform-origin: left center;
            animation: turnPageNext .64s cubic-bezier(.62, .02, .28, 1) both;
        }

        .flipbook.turn-previous .turn-sheet {
            left: 0;
            transform-origin: right center;
            animation: turnPagePrevious .64s cubic-bezier(.62, .02, .28, 1) both;
        }

        @keyframes turnPageNext {
            0% { transform: rotateY(0deg); }
            45% { box-shadow: 18px 10px 34px rgba(16, 33, 43, .22); }
            100% { transform: rotateY(-180deg); }
        }

        @keyframes turnPagePrevious {
            0% { transform: rotateY(0deg); }
            45% { box-shadow: -18px 10px 34px rgba(16, 33, 43, .22); }
            100% { transform: rotateY(180deg); }
        }

        .page-stage::after {
            position: absolute;
            right: 18px;
            bottom: 12px;
            color: #607582;
            content: 'Geser atau klik sisi halaman';
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .15px;
            pointer-events: none;
        }

        .page-progress {
            height: 5px;
            background: #dfe8eb;
        }

        .page-progress div {
            width: 10%;
            height: 100%;
            border-radius: 0 999px 999px 0;
            background: var(--accent);
            transition: width .2s ease;
        }

        .reader-note {
            display: flex;
            gap: 11px;
            margin-top: 18px;
            padding: 15px 17px;
            border: 1px solid #ead6a1;
            border-radius: 16px;
            background: #fff9e9;
            color: #735416;
            font-size: 12px;
            line-height: 1.6;
        }

        .reader-note strong {
            white-space: nowrap;
        }

        :focus-visible {
            outline: 3px solid color-mix(in srgb, var(--accent) 28%, transparent);
            outline-offset: 3px;
        }

        @media(max-width: 860px) {
            .topbar-inner,
            .reader {
                width: min(100% - 28px, 1280px);
            }

            .topbar-inner {
                padding: 10px 0;
            }

            .brand span,
            .back-link {
                display: none;
            }

            .reader {
                padding-top: 28px;
            }

            .reader-intro {
                grid-template-columns: 1fr;
            }

            .intro-actions {
                justify-content: flex-start;
            }

            .reading-workspace {
                grid-template-columns: 1fr;
            }

            .thumbnail-panel {
                position: static;
                max-height: none;
                padding: 11px;
            }

            .thumbnail-title {
                margin-bottom: 8px;
            }

            .thumbnail-list {
                display: flex;
                max-height: none;
                overflow-x: auto;
                overflow-y: hidden;
                padding: 2px 2px 7px;
                scroll-snap-type: x proximity;
            }

            .thumbnail-button {
                width: 82px;
                flex: 0 0 82px;
                scroll-snap-align: start;
            }

            .viewer-toolbar {
                grid-template-columns: minmax(0, 1fr) auto;
            }

            .page-range {
                display: none;
            }

            .page-stage {
                min-height: 0;
                padding: 14px;
            }
        }

        @media(max-width: 899px) {
            .flipbook {
                width: min(100%, 620px);
                aspect-ratio: 1190 / 1684;
            }

            .book-page.left {
                width: 100%;
                border-radius: 9px;
                box-shadow: none;
            }

            .book-page.right,
            .book-spine {
                display: none;
            }

            .turn-sheet,
            .flipbook.turn-next .turn-sheet,
            .flipbook.turn-previous .turn-sheet {
                left: 0;
                width: 100%;
            }

            .flipbook.turn-next .turn-sheet {
                transform-origin: left center;
            }

            .flipbook.turn-previous .turn-sheet {
                transform-origin: right center;
            }

            .turn-face {
                border-radius: 9px;
            }
        }

        @media(max-width: 560px) {
            .audience-switch a {
                padding: 0 8px;
                font-size: 11px;
            }

            .brand > div {
                display: none;
            }

            h1 {
                font-size: 30px;
            }

            .intro-actions .button {
                flex: 1 1 150px;
            }

            .document-viewer {
                border-radius: 18px;
            }

            .viewer-toolbar {
                min-height: 58px;
                padding: 8px 10px;
            }

            .viewer-buttons button {
                min-width: 39px;
                height: 39px;
            }

            .page-stage {
                padding: 9px;
            }

            .page-stage::after {
                display: none;
            }

            .reader-note strong {
                white-space: normal;
            }
        }

        @media(prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }

            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition: none !important;
            }
        }
    </style>
</head>
<body class="theme-{{ $booklet['theme'] }}">
    @php
        $bookletPages = collect($booklet['pages']);
        $firstPage = $bookletPages->first();
    @endphp

    <header class="topbar">
        <div class="topbar-inner">
            <a class="brand" href="{{ route('public.landing') }}">
                <img src="{{ asset('icons/icon.svg') }}" alt="NersCare ICU">
                <div>
                    NersCare ICU
                    <span>Loneliness assessment dan edukasi</span>
                </div>
            </a>

            <div class="topbar-actions">
                <nav class="audience-switch" aria-label="Pilih booklet">
                    <a href="{{ route('public.booklet', 'keluarga') }}" class="{{ $audience === 'keluarga' ? 'active' : '' }}" @if($audience === 'keluarga') aria-current="page" @endif>Keluarga</a>
                    <a href="{{ route('public.booklet', 'perawat') }}" class="{{ $audience === 'perawat' ? 'active' : '' }}" @if($audience === 'perawat') aria-current="page" @endif>Perawat</a>
                </nav>
                <a class="back-link" href="{{ route('public.landing') }}#booklet-edukasi">Kembali ke beranda</a>
            </div>
        </div>
    </header>

    <main class="reader">
        <section class="reader-intro">
            <div>
                <span class="eyebrow">{{ $booklet['audience_label'] }}</span>
                <h1>{{ $booklet['title'] }}</h1>
                <p>{{ $booklet['description'] }}</p>
                <div class="document-meta" aria-label="Informasi dokumen">
                    <span class="meta-chip">{{ $booklet['page_count'] }} halaman</span>
                    <span class="meta-chip">Dokumen final</span>
                    <span class="meta-chip">Bisa dibaca dan diunduh</span>
                </div>
            </div>

            <div class="intro-actions">
                <a class="button secondary" href="{{ asset($booklet['file']) }}" target="_blank" rel="noopener">Buka PDF</a>
                <a class="button" href="{{ asset($booklet['file']) }}" download>Unduh PDF</a>
            </div>
        </section>

        <section class="reading-workspace" aria-label="Pembaca {{ $booklet['title'] }}">
            <aside class="thumbnail-panel" aria-label="Daftar halaman">
                <p class="thumbnail-title">Pilih halaman</p>
                <div class="thumbnail-list" id="thumbnailList">
                    @foreach($bookletPages as $page)
                        <button
                            class="thumbnail-button {{ $loop->first ? 'active' : '' }}"
                            type="button"
                            data-page-index="{{ $loop->index }}"
                            aria-label="Buka halaman {{ $page['number'] }}"
                            @if($loop->first) aria-current="page" @endif
                        >
                            <img src="{{ $page['src'] }}" alt="" loading="lazy" decoding="async">
                            <span class="thumbnail-number">{{ $page['number'] }}</span>
                        </button>
                    @endforeach
                </div>
            </aside>

            <div>
                <div class="document-viewer">
                    <div class="viewer-toolbar">
                        <div class="page-status" aria-live="polite">
                            <strong id="pageStatus">Halaman 1 dari {{ $booklet['page_count'] }}</strong>
                            <span>Flipbook responsif: klik, geser, atau gunakan panah keyboard</span>
                        </div>

                        <input
                            class="page-range"
                            id="pageRange"
                            type="range"
                            min="1"
                            max="{{ $booklet['page_count'] }}"
                            value="1"
                            step="1"
                            aria-label="Pilih nomor halaman"
                        >

                        <div class="viewer-buttons">
                            <button id="previousPage" type="button" aria-label="Halaman sebelumnya" title="Halaman sebelumnya" disabled>&larr;</button>
                            <button id="nextPage" type="button" aria-label="Halaman berikutnya" title="Halaman berikutnya">&rarr;</button>
                        </div>
                    </div>

                    <div class="page-stage" id="pageStage">
                        <div class="flipbook" id="flipbook" aria-label="Flipbook {{ $booklet['title'] }}">
                            <div class="book-page left blank" id="leftPage" aria-hidden="true">
                                <img id="leftPageImage" src="{{ $firstPage['src'] }}" alt="" decoding="async">
                            </div>
                            <div class="book-page right" id="rightPage">
                                <img
                                    id="rightPageImage"
                                    src="{{ $firstPage['src'] }}"
                                    alt="{{ $firstPage['alt'] }}"
                                    fetchpriority="high"
                                    decoding="async"
                                >
                            </div>
                            <div class="book-spine" aria-hidden="true"></div>
                            <div class="turn-sheet" id="turnSheet" aria-hidden="true">
                                <div class="turn-face turn-front">
                                    <img id="turnFrontImage" src="{{ $firstPage['src'] }}" alt="">
                                </div>
                                <div class="turn-face turn-back">
                                    <img id="turnBackImage" src="{{ $firstPage['src'] }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="page-progress" aria-hidden="true">
                        <div id="pageProgress"></div>
                    </div>
                </div>

                <div class="reader-note">
                    <strong>Materi pendamping:</strong>
                    <span>{{ $booklet['reader_note'] }}</span>
                </div>
            </div>
        </section>
    </main>

    <script>
        const bookletPages = @json($bookletPages);
        const bookletTitle = @json($booklet['title']);
        const flipbook = document.getElementById('flipbook');
        const leftPage = document.getElementById('leftPage');
        const rightPage = document.getElementById('rightPage');
        const leftPageImage = document.getElementById('leftPageImage');
        const rightPageImage = document.getElementById('rightPageImage');
        const turnFrontImage = document.getElementById('turnFrontImage');
        const turnBackImage = document.getElementById('turnBackImage');
        const pageStatus = document.getElementById('pageStatus');
        const pageRange = document.getElementById('pageRange');
        const pageProgress = document.getElementById('pageProgress');
        const previousPage = document.getElementById('previousPage');
        const nextPage = document.getElementById('nextPage');
        const pageStage = document.getElementById('pageStage');
        const thumbnailButtons = Array.from(document.querySelectorAll('.thumbnail-button'));
        const spreadMedia = window.matchMedia('(min-width: 900px)');
        const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
        const requestedPage = Number.parseInt(new URLSearchParams(window.location.search).get('page') || '1', 10);
        let activePageIndex = Number.isInteger(requestedPage)
            ? Math.min(Math.max(requestedPage - 1, 0), bookletPages.length - 1)
            : 0;
        let pointerStartX = null;
        let isTurning = false;

        function normalizePageIndex(index) {
            const boundedIndex = Math.min(Math.max(index, 0), bookletPages.length - 1);

            if (!spreadMedia.matches || boundedIndex === 0) {
                return boundedIndex;
            }

            return boundedIndex % 2 === 0 ? boundedIndex - 1 : boundedIndex;
        }

        function visiblePageIndexes(index = activePageIndex) {
            const normalizedIndex = normalizePageIndex(index);

            if (!spreadMedia.matches) {
                return [normalizedIndex];
            }

            if (normalizedIndex === 0) {
                return [null, 0];
            }

            return [
                normalizedIndex,
                normalizedIndex + 1 < bookletPages.length ? normalizedIndex + 1 : null,
            ];
        }

        function updatePageSlot(container, image, pageIndex) {
            const page = pageIndex === null ? null : bookletPages[pageIndex];
            container.classList.toggle('blank', page === null);

            if (!page) {
                container.setAttribute('aria-hidden', 'true');
                image.alt = '';
                return;
            }

            container.removeAttribute('aria-hidden');
            image.src = page.src;
            image.alt = 'Halaman ' + page.number + ' dari ' + bookletTitle;
        }

        function targetPageIndex(direction) {
            if (!spreadMedia.matches) {
                const target = activePageIndex + direction;
                return target >= 0 && target < bookletPages.length ? target : null;
            }

            if (direction > 0) {
                if (activePageIndex === 0) {
                    return bookletPages.length > 1 ? 1 : null;
                }

                const target = activePageIndex + 2;
                return target < bookletPages.length ? target : null;
            }

            if (activePageIndex <= 0) {
                return null;
            }

            return activePageIndex === 1 ? 0 : Math.max(1, activePageIndex - 2);
        }

        function renderPages(options = {}) {
            activePageIndex = normalizePageIndex(activePageIndex);
            const visibleIndexes = visiblePageIndexes();
            const actualIndexes = visibleIndexes.filter(index => index !== null);

            if (spreadMedia.matches) {
                updatePageSlot(leftPage, leftPageImage, visibleIndexes[0]);
                updatePageSlot(rightPage, rightPageImage, visibleIndexes[1]);
            } else {
                updatePageSlot(leftPage, leftPageImage, activePageIndex);
                updatePageSlot(rightPage, rightPageImage, null);
            }

            const firstNumber = bookletPages[actualIndexes[0]].number;
            const lastNumber = bookletPages[actualIndexes[actualIndexes.length - 1]].number;
            pageStatus.textContent = firstNumber === lastNumber
                ? 'Halaman ' + firstNumber + ' dari ' + bookletPages.length
                : 'Halaman ' + firstNumber + '\u2013' + lastNumber + ' dari ' + bookletPages.length;
            pageRange.value = firstNumber;
            pageProgress.style.width = ((lastNumber / bookletPages.length) * 100) + '%';
            previousPage.disabled = targetPageIndex(-1) === null || isTurning;
            nextPage.disabled = targetPageIndex(1) === null || isTurning;

            thumbnailButtons.forEach(function(button, index) {
                const isActive = actualIndexes.includes(index);
                button.classList.toggle('active', isActive);
                if (index === activePageIndex) {
                    button.setAttribute('aria-current', 'page');
                } else {
                    button.removeAttribute('aria-current');
                }
            });

            const activeThumbnail = thumbnailButtons[activePageIndex];
            if (activeThumbnail && options.scrollThumbnail !== false) {
                activeThumbnail.scrollIntoView({ block: 'nearest', inline: 'nearest', behavior: 'smooth' });
            }

            const url = new URL(window.location.href);
            url.searchParams.set('page', firstNumber);
            window.history.replaceState({}, '', url);

            const nextIndex = targetPageIndex(1);
            const next = nextIndex === null ? null : bookletPages[nextIndex];
            if (next) {
                const preload = new Image();
                preload.src = next.src;
            }
        }

        function changePage(direction) {
            const nextIndex = targetPageIndex(direction);
            if (nextIndex === null || isTurning) {
                return;
            }

            const currentVisible = visiblePageIndexes();
            const nextVisible = visiblePageIndexes(nextIndex);
            const currentTurnIndex = spreadMedia.matches
                ? (direction > 0 ? currentVisible[1] ?? currentVisible[0] : currentVisible[0] ?? currentVisible[1])
                : currentVisible[0];
            const nextTurnIndex = spreadMedia.matches
                ? (direction > 0 ? nextVisible[0] ?? nextVisible[1] : nextVisible[1] ?? nextVisible[0])
                : nextVisible[0];

            if (reducedMotion.matches) {
                activePageIndex = nextIndex;
                renderPages();
                return;
            }

            isTurning = true;
            turnFrontImage.src = bookletPages[currentTurnIndex].src;
            turnBackImage.src = bookletPages[nextTurnIndex].src;
            activePageIndex = nextIndex;
            renderPages();
            flipbook.classList.remove('turn-next', 'turn-previous');
            void flipbook.offsetWidth;
            flipbook.classList.add('is-turning', direction > 0 ? 'turn-next' : 'turn-previous');

            window.setTimeout(function() {
                flipbook.classList.remove('is-turning', 'turn-next', 'turn-previous');
                isTurning = false;
                renderPages({ scrollThumbnail: false });
            }, 680);
        }

        thumbnailButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                if (isTurning) {
                    return;
                }
                activePageIndex = Number.parseInt(button.dataset.pageIndex, 10);
                renderPages({ scrollThumbnail: false });
            });
        });

        previousPage.addEventListener('click', function() {
            changePage(-1);
        });

        nextPage.addEventListener('click', function() {
            changePage(1);
        });

        pageRange.addEventListener('input', function() {
            activePageIndex = Number.parseInt(pageRange.value, 10) - 1;
            renderPages();
        });

        window.addEventListener('keydown', function(event) {
            if (event.target.matches('input:not([type="range"]), textarea, select')) {
                return;
            }

            if (event.key === 'ArrowLeft') {
                changePage(-1);
            } else if (event.key === 'ArrowRight') {
                changePage(1);
            }
        });

        pageStage.addEventListener('pointerdown', function(event) {
            pointerStartX = event.clientX;
        });

        pageStage.addEventListener('pointerup', function(event) {
            if (pointerStartX === null) {
                return;
            }

            const distance = event.clientX - pointerStartX;
            pointerStartX = null;

            if (Math.abs(distance) >= 45) {
                changePage(distance > 0 ? -1 : 1);
                return;
            }

            const bounds = pageStage.getBoundingClientRect();
            changePage(event.clientX < bounds.left + (bounds.width / 2) ? -1 : 1);
        });

        pageStage.addEventListener('pointercancel', function() {
            pointerStartX = null;
        });

        spreadMedia.addEventListener('change', function() {
            activePageIndex = normalizePageIndex(activePageIndex);
            renderPages({ scrollThumbnail: false });
        });

        renderPages({ scrollThumbnail: false });
    </script>
</body>
</html>
