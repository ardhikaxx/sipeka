<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skrining_risikos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kunjungan_id')->constrained('kunjungan_ancs')->onDelete('cascade');
            $table->string('status')->default('NORMAL');
            $table->string('level_risiko'); // HIJAU, KUNING, MERAH, MERAH_KRITIS
            $table->json('detail_faktor')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skrining_risikos');
    }
};
