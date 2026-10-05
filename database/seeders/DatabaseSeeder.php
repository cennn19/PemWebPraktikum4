<?php

/**
 * Seeder utama yang mengisi data kategori lebih dulu, lalu berita contoh.
 */
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            KategoriSeeder::class,
            BeritaSeeder::class,
        ]);
    }
}