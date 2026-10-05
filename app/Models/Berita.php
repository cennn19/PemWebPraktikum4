<?php

/**
 * Model berita: relasi kategori/komentar, pencarian, dan pemetaan slug untuk URL.
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'berita';

    protected $fillable = [
        'kategori_id', 'judul', 'slug', 'penulis', 'ringkasan',
        'isi', 'gambar', 'tags', 'views', 'tanggal',
    ];

    protected $casts = [
        'tags' => 'array',
        'tanggal' => 'date',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function komentar()
    {
        return $this->hasMany(Komentar::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['q'] ?? null, function ($q, $cari) {
            $q->where(fn ($q) => $q->where('judul', 'like', "%{$cari}%")
                                   ->orWhere('ringkasan', 'like', "%{$cari}%"));
        });

        $query->when($filters['kategori'] ?? null, fn ($q, $id) => $q->where('kategori_id', $id));
    }
}