{{-- Halaman detail artikel: menampilkan isi, berita terkait, form captcha, dan komentar. --}}
@extends('layouts.app')

@section('title', $berita->judul)
@section('hero_title', 'Detail Berita')
@section('breadcrumb_extra', \Illuminate\Support\Str::limit($berita->judul, 50))

@section('content')
<style>
    .detail-img { display: block; width: 100%; height: auto; }

    .detail-title {
        font-family: var(--font-display);
        font-weight: 700;
        font-size: 2.6rem;
        line-height: 1.1;
        color: #111827;
        margin: 1rem 0 1.5rem;
    }

    .detail-meta { color: #555; font-size: 0.95rem; }
    .detail-meta i { margin-right: 0.2rem; }

    .detail-isi { font-size: 1.05rem; line-height: 1.9; color: #222; }

    .tag-outline {
        display: inline-block;
        font-size: 0.8rem;
        background: #f1f3f5;
        color: #333;
        border: 1px solid #dee2e6;
        padding: 0.1rem 0.7rem;
        border-radius: 999px;
        margin: 0 0.15rem 0.35rem 0;
    }

    .komentar-title {
        font-family: var(--font-display);
        font-weight: 700;
        font-size: 2rem;
        color: #13294b;
    }

    .komentar-title i { color: var(--accent); }

    .komentar-form {
        background: #f8f9fb;
        border: 1px solid #e3e6ec;
        border-radius: 0.7rem;
        padding: 1.25rem;
    }

    .captcha-box {
        background: #fff;
        border: 1px solid #e3e6ec;
        border-radius: 0.6rem;
        padding: 0.8rem 1rem;
    }

    .captcha-q {
        background: #0d6efd;
        color: #fff;
        font-weight: 700;
        letter-spacing: 0.1em;
        padding: 0.55rem 0.9rem;
        border-radius: 0.5rem;
        white-space: nowrap;
    }

    .btn-kirim { background: var(--nav-bg); color: #fff; font-weight: 600; }
    .btn-kirim:hover { background: #0f1424; color: #fff; }

    .avatar {
        flex: none;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: var(--nav-bg);
        color: var(--accent);
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .terkait-item {
        display: flex;
        gap: 0.9rem;
        padding: 1rem 0;
        border-bottom: 1px solid #e9ecf1;
        text-decoration: none;
        color: inherit;
    }

    .terkait-item:last-child { border-bottom: 0; }

    .terkait-item img {
        flex: none;
        width: 80px;
        height: 60px;
        object-fit: cover;
        border-radius: 0.5rem;
    }

    .terkait-judul { font-weight: 700; font-size: 0.92rem; line-height: 1.5; color: #1b2233; }
    .terkait-item:hover .terkait-judul { color: #1c3f94; }
</style>

<div class="row g-4">

    {{-- ===================== KOLOM UTAMA ===================== --}}
    <div class="col-lg-8">

        {{-- Artikel --}}
        <article class="card-berita mb-4">
            <img class="detail-img" src="{{ asset($berita->gambar) }}" alt="{{ $berita->judul }}">

            <div class="p-4">
                <div class="detail-meta d-flex flex-wrap align-items-center gap-3">
                    <span class="badge badge-kategori">{{ $berita->kategori->nama }}</span>
                    <span><i class="bi bi-calendar3"></i>{{ $berita->tanggal->translatedFormat('l, d F Y') }}</span>
                    <span><i class="bi bi-person-fill"></i>{{ $berita->penulis }}</span>
                    <span><i class="bi bi-eye-fill"></i>{{ $berita->views }} dibaca</span>
                </div>

                <h1 class="detail-title">{{ $berita->judul }}</h1>

                <div class="detail-isi">
                    {!! nl2br(e($berita->isi)) !!}
                </div>

                {{-- Tags --}}
                @if (!empty($berita->tags))
                    <hr class="my-4">
                    <div>
                        <strong class="me-2"><i class="bi bi-tags-fill"></i> Tags:</strong>
                        @foreach ($berita->tags as $tag)
                            <span class="tag-outline">#{{ $tag }}</span>
                        @endforeach
                    </div>
                @endif

                {{-- Bagikan --}}
                <hr class="my-4">
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <strong class="me-2">Bagikan:</strong>

                    <a target="_blank" rel="noopener"
                       href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                       class="btn btn-sm text-white" style="background:#1877f2">
                        <i class="bi bi-facebook"></i> Facebook
                    </a>

                    <a target="_blank" rel="noopener"
                       href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($berita->judul) }}"
                       class="btn btn-sm text-white" style="background:#1da1f2">
                        <i class="bi bi-twitter"></i> Twitter
                    </a>

                    <a target="_blank" rel="noopener"
                       href="https://wa.me/?text={{ urlencode($berita->judul . ' ' . url()->current()) }}"
                       class="btn btn-sm text-white" style="background:#25d366">
                        <i class="bi bi-whatsapp"></i> WhatsApp
                    </a>
                </div>
            </div>
        </article>

        {{-- Komentar --}}
        <section class="card-berita p-4" id="komentar">
            <h2 class="komentar-title mb-3">
                <i class="bi bi-chat-dots-fill me-2"></i>Komentar ({{ $komentar->count() }})
            </h2>

            <div class="komentar-form">
                <h6 class="fw-bold mb-3"><i class="bi bi-pencil-square me-1"></i> Tulis Komentar Anda:</h6>

                @if ($errors->any())
                    <div class="alert alert-danger py-2">
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('berita.komentar', $berita) }}">


                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Nama Lengkap *</label>
                            <input type="text" name="nama" value="{{ old('nama') }}"
                                   class="form-control" placeholder="Nama Anda" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Alamat Email * <span class="badge bg-secondary">Privat</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="form-control" placeholder="nama@email.com" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Nomor HP * <span class="badge bg-secondary">Privat</span>
                            </label>
                            <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                                   class="form-control" placeholder="08xxxxxxxxxx" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pesan Komentar *</label>
                        <textarea name="pesan" id="pesan" rows="4" maxlength="300"
                                  class="form-control" placeholder="Tuliskan masukan atau komentar Anda..."
                                  required>{{ old('pesan') }}</textarea>
                        <div class="d-flex justify-content-between small text-muted mt-1">
                            <span>Dilarang menggunakan kata kasar / ujaran kebencian.</span>
                            <span><span id="sisa">300</span> karakter tersisa</span>
                        </div>
                    </div>

                    <div class="captcha-box mb-3">
                        <div class="fw-semibold mb-2">
                            <i class="bi bi-shield-fill-check text-primary me-1"></i>
                            Pertanyaan Keamanan (Captcha Anti-Bot) *
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <span class="captcha-q">{{ $angka1 }} + {{ $angka2 }} = ?</span>

                            <input type="number" name="captcha" class="form-control"
                                   style="max-width: 150px" placeholder="Jawaban" required>

                            <a href="{{ route('berita.show', $berita) }}#komentar"
                               class="btn btn-outline-secondary" title="Soal baru">
                                <i class="bi bi-arrow-repeat"></i>
                            </a>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-kirim">
                        <i class="bi bi-send-fill me-1"></i> Kirim Komentar
                    </button>
                </form>
            </div>

            {{-- Daftar komentar --}}
            @if ($komentar->isNotEmpty())
                <div class="mt-4">
                    @foreach ($komentar as $k)
                        <div class="d-flex gap-3 py-3 border-bottom">
                            <span class="avatar">{{ strtoupper(mb_substr($k->nama, 0, 1)) }}</span>
                            <div>
                                <div class="fw-bold">{{ $k->nama }}</div>
                                <small class="text-muted">{{ $k->created_at->translatedFormat('d M Y, H:i') }}</small>
                                <p class="mb-0 mt-1">{{ $k->pesan }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

    </div>

    {{-- ===================== SIDEBAR ===================== --}}
    <div class="col-lg-4">
        <div class="filter-box">
            <div class="filter-header">
                <i class="bi bi-newspaper me-2"></i>Berita Terkait
            </div>

            <div class="px-3">
                @forelse ($terkait as $r)
                    <a href="{{ route('berita.show', $r) }}" class="terkait-item">
                        <img src="{{ asset($r->gambar) }}" alt="{{ $r->judul }}">
                        <div>
                            <div class="terkait-judul">{{ \Illuminate\Support\Str::limit($r->judul, 70) }}</div>
                            <small class="text-muted">
                                <i class="bi bi-calendar3"></i> {{ $r->tanggal->translatedFormat('d M Y') }}
                            </small>
                        </div>
                    </a>
                @empty
                    <p class="text-muted py-3 mb-0">Belum ada berita terkait.</p>
                @endforelse
            </div>
        </div>
    </div>

</div>

<script>
    const pesan = document.getElementById('pesan');
    const sisa = document.getElementById('sisa');
    const hitung = () => { sisa.textContent = 300 - pesan.value.length; };
    pesan.addEventListener('input', hitung);
    hitung();
</script>
@endsection