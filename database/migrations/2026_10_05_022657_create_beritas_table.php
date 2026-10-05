<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** Membuat tabel berita, termasuk kategori, slug, isi, tag, tanggal, dan jumlah kunjungan. */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori')->cascadeOnDelete();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('penulis')->default('Admin');
            $table->text('ringkasan');
            $table->longText('isi');
            $table->string('gambar')->nullable();
            $table->json('tags')->nullable();
            $table->unsignedInteger('views')->default(0);
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};