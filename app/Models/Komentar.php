<?php

/**
 * Model komentar yang tersimpan pada satu berita.
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    protected $table = 'komentar';

    protected $fillable = ['berita_id', 'nama', 'email', 'no_hp', 'pesan'];

    public function berita()
    {
        return $this->belongsTo(Berita::class);
    }
}