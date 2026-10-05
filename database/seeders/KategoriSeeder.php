<?php

namespace Database\Seeders;

/**
 * Mengisi daftar kategori awal untuk pengelompokan berita.
 */
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Olahraga', 'Pendidikan', 'Pemerintahan'] as $nama) {
            Kategori::create(['nama' => $nama]);
        }
    }
}