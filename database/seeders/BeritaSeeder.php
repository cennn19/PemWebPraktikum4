<?php

/**
 * Mengisi contoh artikel berita beserta kategori, slug, tanggal, tag, dan jumlah kunjungan awal.
 */
namespace Database\Seeders;

use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'kategori' => 'Olahraga',
                'judul' => 'Malam Penuh Gengsi Dimulai! 16 Tim Berebut Mahkota Juara di Ajang CVC Cup 2026 Desa Jalatrang',
                'penulis' => 'Dadi Haryadi',
                'ringkasan' => 'Himpunan Pemuda-Pemudi Dusun Cikandung menggelar turnamen voli antar tim.',
                'isi' => "JalatrangNews; Himpunan Pemuda-Pemudi Dusun Cikandung yang tergabung dalam Cikandung Voli Ball Club (CVC) resmi menyelenggarakan ajang olahraga bertajuk CVC Cup 2026.\n\nTurnamen bola voli putra antar-dusun se-Kecamatan Cipaku ini resmi dibuka pada Sabtu, 26 September 2026, dan dijadwalkan berlangsung hingga 10 Oktober 2026.\n\nSebanyak 16 tim akan saling berebut mahkota juara dalam pertandingan sistem gugur yang digelar setiap malam.",
                'gambar' => 'foto1.jpeg',
                'tags' => ['cikandung', 'dusun', '2026', 'voli', 'desa', 'jalatrang', 'cipaku'],
                'views' => 405,
                'tanggal' => '2026-09-26',
            ],
            [
                'kategori' => 'Pendidikan',
                'judul' => 'Pemerintah Desa Jalatrang Kukuhkan Desa Siaga TB, Perkuat Kolaborasi Lintas Sektor',
                'penulis' => 'Admin Desa',
                'ringkasan' => 'Pemerintah Desa Jalatrang menunjukkan komitmen dalam pencegahan penyakit menular.',
                'isi' => "JalatrangNews; Pemerintah Desa Jalatrang, Kecamatan Cipaku, Kabupaten Ciamis, menunjukkan komitmennya dalam upaya pencegahan penyakit menular.\n\nKegiatan pengukuhan Desa Siaga TB dihadiri perangkat desa, tenaga kesehatan, dan kader posyandu.\n\nKolaborasi lintas sektor diharapkan mampu mempercepat deteksi dini dan penanganan kasus TB di tingkat desa.",
                'gambar' => 'foto2.jpeg',
                'tags' => ['desa', 'jalatrang', 'siaga'],
                'views' => 157,
                'tanggal' => '2026-09-28',
            ],
        ];

        foreach ($data as $d) {
            Berita::create([
                'kategori_id' => Kategori::where('nama', $d['kategori'])->value('id'),
                'judul' => $d['judul'],
                'slug' => Str::slug($d['judul']),
                'penulis' => $d['penulis'],
                'ringkasan' => $d['ringkasan'],
                'isi' => $d['isi'],
                'gambar' => $d['gambar'],
                'tags' => $d['tags'],
                'views' => $d['views'],
                'tanggal' => $d['tanggal'],
            ]);
        }
    }
}