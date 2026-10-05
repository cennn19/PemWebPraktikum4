{{-- Kerangka bersama halaman publik: memuat navigasi, header, konten, dan footer situs. --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Berita & Informasi') - Desa Jalatrang</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Teko:wght@500;600;700&display=swap"
        rel="stylesheet"
    >

    <style>
        :root {
            --bar-bg: #0f1424;
            --nav-bg: #1d2134;
            --nav-border: rgba(255, 255, 255, 0.08);
            --accent: #fbbf24;
            --accent-soft: rgba(251, 191, 36, 0.14);
            --hero-from: #0b3a6b;
            --hero-to: #1c1b7a;
            --page-bg: #f1f4f9;
            --font-display: 'Teko', 'Arial Narrow', sans-serif;
        }

        body {
            background: var(--page-bg);
            font-family: system-ui, -apple-system, 'Segoe UI', Arial, sans-serif;
        }

        /* =========================================================
           TICKER / INFO TERKINI
        ========================================================= */

        .topbar {
            background: var(--bar-bg);
            color: #cbd2e6;
            font-size: 10px;
        }

        .topbar-inner {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.55rem 0;
        }

        .ticker-label {
            flex: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;

            background: linear-gradient(90deg, #f97316, #ef4444);
            color: #fff;

            font-weight: 700;
            letter-spacing: 0.04em;

            padding: 0.3rem 1rem;
            border-radius: 999px;
        }

        .ticker-track {
            flex: 1;
            overflow: hidden;
            white-space: nowrap;
            min-width: 0;

            mask-image: linear-gradient(
                90deg,
                transparent,
                #000 4%,
                #000 96%,
                transparent
            );
        }

        .ticker-move {
            display: inline-flex;
            gap: 3rem;
            padding-left: 100%;

            animation: ticker 40s linear infinite;
        }

        .ticker-track:hover .ticker-move {
            animation-play-state: paused;
        }

        .ticker-item::before {
            content: '';

            display: inline-block;
            width: 0.55rem;
            height: 0.55rem;

            border: 2px solid var(--accent);
            border-radius: 50%;

            margin-right: 0.6rem;
        }

        .ticker-date {
            flex: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .ticker-date i {
            color: var(--accent);
        }

        @keyframes ticker {
            to {
                transform: translateX(-100%);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .ticker-move {
                animation: none;
                padding-left: 0;
            }
        }

        /* =========================================================
           NAVBAR
        ========================================================= */

        .wrap {
            width: 100%;
            padding-inline: clamp(1rem, 2.5vw, 2.25rem);
        }

        .site-nav {
            background: var(--nav-bg);
            border-bottom: 1px solid var(--nav-border);
        }

        .nav-inner {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding-block: 0.6rem;
        }

        .brand {
            flex: none;

            display: flex;
            align-items: center;
            gap: 0.7rem;

            text-decoration: none;

            padding: 0.35rem 0.9rem 0.35rem 0.6rem;

            border: 1px solid var(--nav-border);
            border-radius: 0.9rem;

            background: rgba(255, 255, 255, 0.03);
        }

        .brand img {
            width: 34px;
            height: 40px;
            object-fit: contain;
            flex: none;
        }

        .logo-fallback {
            display: none;

            width: 34px;
            height: 40px;

            place-items: center;
            flex: none;

            color: var(--accent);
            font-size: 1.6rem;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            white-space: nowrap;
        }

        .brand-title {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 15px;
            line-height: 1;

            color: #fff;
            letter-spacing: 0.01em;
        }

        .brand-sub {
            margin-top: 0.15rem;

            font-size: 0.7rem;
            line-height: 1.1;

            color: #9aa3bd;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .nav-wrap {
            display: flex;
            align-items: center;
            gap: 0.75rem;

            flex: 1;
            min-width: 0;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            justify-content: flex-end;

            flex: 1;

            gap: 0.15rem;

            margin: 0;
            padding: 0;

            list-style: none;
        }

        .nav-menu a:not(.nav-circle) {
            display: block;

            white-space: nowrap;

            padding: 0.1rem clamp(0.5rem, 0.8vw, 0.9rem);

            border-radius: 999px;

            text-decoration: none;

            font-family: var(--font-display);
            font-weight: 500;
            font-size: 15px;
            line-height: 1.6;

            color: #d6dbec;

            border: 1px solid transparent;

            transition:
                color 0.15s,
                background 0.15s;
        }

        .nav-menu a:not(.nav-circle):hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.06);
        }

        .nav-menu a.active {
            color: var(--accent);
            background: var(--accent-soft);

            border-color: rgba(251, 191, 36, 0.55);

            font-weight: 700;
        }

        .nav-circle {
            flex: none;

            width: 46px;
            height: 46px;
            padding: 0;

            border-radius: 50%;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            font-size: 1.3rem;
            line-height: 1;

            text-decoration: none;
            border: 0;
        }

        .nav-circle i {
            display: block;
            line-height: 1;
        }

        .nav-home {
            background: #4a2a3a;
            color: #fff;
            margin-right: 0.35rem;
        }

        .nav-apps {
            background: #2a2418;
            color: var(--accent);

            border: 1px solid rgba(251, 191, 36, 0.5);
        }

        .nav-toggle {
            display: none;

            margin-left: auto;

            background: none;
            border: 1px solid var(--nav-border);

            color: #fff;

            border-radius: 0.5rem;

            padding: 0.25rem 0.6rem;

            font-size: 20px;
            line-height: 1.2;
        }

        /* =========================================================
           RESPONSIVE NAVBAR
        ========================================================= */

        @media (max-width: 1099.98px) {
            .nav-inner {
                flex-wrap: wrap;
            }

            .nav-toggle {
                display: block;
            }

            .nav-wrap {
                display: none;

                flex-basis: 100%;
                flex-direction: column;
                align-items: stretch;

                padding-top: 0.5rem;
            }

            .nav-wrap.open {
                display: flex;
            }

            .nav-menu {
                flex-direction: column;
                align-items: stretch;
            }

            .nav-menu a:not(.nav-circle) {
                font-size: 1.3rem;
            }

            .nav-menu li:first-child {
                align-self: flex-start;
                margin-bottom: 0.25rem;
            }

            .nav-wrap > .nav-apps {
                align-self: flex-start;
            }
        }

        /* =========================================================
           HERO
        ========================================================= */

        .hero {
            background: linear-gradient(
                115deg,
                var(--hero-from) 0%,
                #14307a 55%,
                var(--hero-to) 100%
            );

            color: #fff;

            padding: 4.5rem 0 5rem;
        }

        .hero-crumb {
            display: flex;
            gap: 0.9rem;

            font-size: 1.25rem;

            margin-bottom: 1.4rem;
        }

        .hero-crumb a {
            color: var(--accent);
            text-decoration: none;
        }

        .hero-crumb .sep {
            color: rgba(255, 255, 255, 0.25);
        }

        .hero h1 {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 40px;
            line-height: 1;

            margin: 0 0 0.6rem;
        }

        .hero p {
            margin: 0;

            font-size: 20px;
            color: #b9c4e4;
        }

        /* =========================================================
           KONTEN
        ========================================================= */

        main.page {
            padding: 2.5rem 0 4rem;
        }

        .card-berita,
        .filter-box {
            border: 0;
            border-radius: 0.9rem;

            background: #fff;

            box-shadow: 0 2px 12px rgba(15, 20, 36, 0.08);

            overflow: hidden;
        }

        .filter-header {
            background: var(--nav-bg);
            color: #fff;

            font-weight: 600;

            padding: 0.75rem 1rem;
        }

        .filter-body {
            padding: 1rem;
        }

        .badge-kategori {
            background: #1c3f94;
        }

        .tag-pill {
            display: inline-block;

            font-size: 0.75rem;

            background: #e8edf8;
            color: #1c3f94;

            padding: 0.1rem 0.55rem;

            border-radius: 999px;

            margin-right: 0.25rem;
        }

        .btn-baca {
            background: var(--accent-soft);
            color: #8a5a00;

            font-weight: 600;
        }

        .btn-baca:hover {
            background: var(--accent);
            color: #000;
        }

        /* =========================================================
           GAMBAR KARTU & FOOTER
        ========================================================= */

        .card-berita img.thumb {
            display: block;
            width: 100%;
            height: 240px;
            object-fit: cover;
        }

        .site-footer {
            background: var(--bar-bg);
            color: #cbd2e6;
            padding-top: 3rem;
        }

        .site-footer h6 {
            color: var(--accent);
            letter-spacing: 0.08em;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .site-footer a {
            color: #cbd2e6;
            text-decoration: none;
        }

        .site-footer a:hover {
            color: #fff;
        }

        .footer-bottom {
            background: #0a0e1a;
            text-align: center;
            font-size: 0.85rem;
            padding: 0.9rem 0;
            margin-top: 2rem;
        }
    </style>
</head>

<body>

    {{-- =========================================================
         INFO TERKINI
    ========================================================== --}}
    <div class="topbar">
        <div class="wrap topbar-inner">

            <span class="ticker-label">
                <i class="bi bi-megaphone-fill"></i>
                INFO TERKINI
            </span>

            <div class="ticker-track">
                <div class="ticker-move">

                    @foreach ($infoTerkini ?? [
                        'Warga dapat memeriksa pembayaran PBB langsung pada website',
                        'Desa Jalatrang akan membuka layanan publik untuk mempermudah akses informasi',
                    ] as $info)
                        <span class="ticker-item">
                            {{ $info }}
                        </span>
                    @endforeach

                </div>
            </div>

            <span class="ticker-date d-none d-md-inline-flex">
                <i class="bi bi-clock"></i>

                {{ now()->locale('id')->translatedFormat('l, j F Y') }}
            </span>

        </div>
    </div>

    {{-- =========================================================
         NAVBAR
    ========================================================== --}}
    <header class="site-nav">
        <div class="wrap nav-inner">

            {{-- Brand --}}
            <a href="{{ url('/') }}" class="brand">

                <img
                    src="{{ asset('images/logo-desa.png') }}"
                    alt=""
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex'"
                >

                <span class="logo-fallback">
                    <img src="{{ asset('logo-desa.png') }}" alt="Logo Desa">
                </span>

                <span class="brand-text">
                    <span class="brand-title">
                        PEMERINTAH DESA JALATRANG
                    </span>

                    <span class="brand-sub">
                        Kecamatan Cipaku Kabupaten Ciamis
                    </span>
                </span>

            </a>

            {{-- Mobile menu button --}}
            <button
                class="nav-toggle"
                type="button"
                aria-label="Buka menu"
                aria-expanded="false"
                onclick="
                    const w = document.getElementById('navWrap');
                    const o = w.classList.toggle('open');
                    this.setAttribute('aria-expanded', o);
                "
            >
                <i class="bi bi-list"></i>
            </button>

            {{-- Navigation --}}
            <div class="nav-wrap" id="navWrap">

                <ul class="nav-menu">

                    <li>
                        <a
                            href="{{ url('/') }}"
                            class="nav-circle nav-home"
                            aria-label="Beranda"
                        >
                            <i class="bi bi-house-fill"></i>
                        </a>
                    </li>

                    <li>
                        <a href="#">Profil</a>
                    </li>

                    <li>
                        <a href="#">Kependudukan</a>
                    </li>

                    <li>
                        <a
                            href="{{ route('berita.index') }}"
                            class="{{ request()->routeIs('berita.*') ? 'active' : '' }}"
                        >
                            Berita
                        </a>
                    </li>

                    <li>
                        <a href="#">Potensi Wisata</a>
                    </li>

                    <li>
                        <a href="#">IDM &amp; SDGs</a>
                    </li>

                    <li>
                        <a href="#">Ketahanan Pangan</a>
                    </li>

                    <li>
                        <a href="#">Keuangan</a>
                    </li>

                    <li>
                        <a href="#">Download</a>
                    </li>

                </ul>

                {{-- Menu lainnya --}}
                <a
                    href="#"
                    class="nav-circle nav-apps"
                    aria-label="Menu lainnya"
                >
                    <i class="bi bi-grid-3x3-gap-fill"></i>
                </a>

            </div>
        </div>
    </header>

    {{-- =========================================================
         HERO
    ========================================================== --}}
    <section class="hero">
        <div class="container">

            <nav class="hero-crumb" aria-label="breadcrumb">

                <a href="{{ url('/') }}">
                    Beranda
                </a>

                <span class="sep">
                    /
                </span>

                @hasSection('breadcrumb_extra')

                    <a
                        href="{{ route('berita.index') }}"
                        style="color: #fff"
                    >
                        Berita
                    </a>

                    <span class="sep">
                        /
                    </span>

                    <span>
                        @yield('breadcrumb_extra')
                    </span>

                @else

                    <span>
                        Berita
                    </span>

                @endif

            </nav>

            <h1>
                @yield('hero_title', 'Berita & Informasi')
            </h1>

            <p>
                @yield('hero_subtitle', 'Informasi terkini dari Desa Jalatrang')
            </p>

        </div>
    </section>

    {{-- =========================================================
         KONTEN HALAMAN
    ========================================================== --}}
    <main class="page">
        <div class="container">

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')

        </div>
    </main>

    {{-- =========================================================
         FOOTER
    ========================================================== --}}
    <footer class="site-footer">
        <div class="container">
            <div class="row g-4">

                <div class="col-md-5">
                    <h5 class="text-white mb-0">PEMERINTAH DESA</h5>
                    <h5 class="mb-3" style="color: var(--accent)">JALATRANG</h5>

                    <p class="mb-2">
                        Jalan Raya Cipaku Nomor 181<br>
                        Desa Jalatrang, Kecamatan Cipaku<br>
                        Kabupaten Ciamis
                    </p>

                    <p class="mb-0">
                        <i class="bi bi-envelope-fill me-1"></i>
                        pemerintahdesajalatrang@gmail.com
                    </p>
                </div>

                <div class="col-md-3">
                    <h6>MENU</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><a href="{{ url('/') }}">Beranda</a></li>
                        <li class="mb-2"><a href="{{ route('berita.index') }}">Berita</a></li>
                    </ul>
                </div>

                <div class="col-md-4">
                    <h6>MEDIA SOSIAL</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="bi bi-facebook me-2"></i>facebook</li>
                        <li class="mb-2"><i class="bi bi-youtube me-2"></i>youtube</li>
                        <li class="mb-2"><i class="bi bi-instagram me-2"></i>instagram</li>
                    </ul>
                </div>

            </div>
        </div>

        <div class="footer-bottom">
            &copy; {{ date('Y') }} Pemerintah Desa Jalatrang — Semua hak dilindungi.
        </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>