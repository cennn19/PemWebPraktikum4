<?php

/**
 * Model kategori berita beserta relasi ke kumpulan berita.
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';

    protected $fillable = ['nama'];

    public function berita()
    {
        return $this->hasMany(Berita::class);
    }
}