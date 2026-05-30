<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasil_persalinans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kehamilan_id')->constrained('kehamilans')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('jenis'); // Normal, SC, Vakum, Forceps
            $table->text('indikasi_sc')->nullable();
            $table->string('kondisi_ibu')->nullable();
            $table->integer('bb_bayi')->nullable(); // in grams
            $table->integer('panjang_bayi')->nullable(); // in cm
            $table->string('apgar_score')->nullable();
            $table->string('kondisi_bayi')->nullable(); // Hidup, Lahir mati
            $table->string('komplikasi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_persalinans');
    }
};
