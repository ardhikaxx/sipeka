<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peringatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade');
            $table->foreignId('kunjungan_id')->nullable()->constrained('kunjungan_ancs')->onDelete('cascade');
            $table->string('level');
            $table->text('deskripsi');
            $table->string('status')->default('baru'); // baru, ditangani
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peringatans');
    }
};
