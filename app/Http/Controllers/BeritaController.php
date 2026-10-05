<?php

/**
 * Mengatur daftar dan detail berita, pencatatan kunjungan, serta pengiriman komentar.
 */
namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $berita = Berita::with('kategori')
            ->filter($request->only('q', 'kategori'))
            ->latest('tanggal')
            ->paginate(9)
            ->withQueryString();

        $kategori = Kategori::orderBy('nama')->get();

        return view('berita.index', compact('berita', 'kategori'));
    }

    public function show(Berita $berita)
    {
        $kunci = 'viewed_' . $berita->id;

        if (! session()->has($kunci)) {
            $berita->increment('views');
            session([$kunci => true]);
        }

        $terkait = Berita::where('id', '!=', $berita->id)
            ->latest('tanggal')
            ->take(5)
            ->get();

        $komentar = $berita->komentar()->latest()->get();

        $angka1 = random_int(1, 9);
        $angka2 = random_int(1, 9);
        session(['captcha_answer' => $angka1 + $angka2]);

        return view('berita.show', compact('berita', 'terkait', 'komentar', 'angka1', 'angka2'));
    }

    public function komentar(Request $request, Berita $berita)
    {
        $data = $request->validate([
            'nama' => 'required|max:100',
            'email' => 'required|email|max:100',
            'no_hp' => 'required|max:20',
            'pesan' => 'required|max:300',
            'captcha' => 'required|numeric',
        ]);

        if ((int) $data['captcha'] !== (int) session('captcha_answer')) {
            return back()
                ->withInput()
                ->withErrors(['captcha' => 'Jawaban captcha salah, coba lagi.']);
        }

        $berita->komentar()->create([
            'nama' => $data['nama'],
            'email' => $data['email'],
            'no_hp' => $data['no_hp'],
            'pesan' => $data['pesan'],
        ]);

        return redirect()
            ->to(route('berita.show', $berita) . '#komentar')
            ->with('success', 'Komentar berhasil dikirim.');
    }
}