<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rujukans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kehamilan_id')->constrained('kehamilans')->onDelete('cascade');
            $table->foreignId('bidan_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('dokter_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('fasilitas_tujuan_id')->constrained('fasilitas_kesehatans')->onDelete('restrict');
            $table->string('status')->default('dibuat'); // dibuat, dikirim, diterima, selesai
            $table->text('diagnosa_sementara')->nullable();
            $table->text('alasan_rujukan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rujukans');
    }
};
