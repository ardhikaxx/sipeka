<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_kunjungans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kehamilan_id')->constrained('kehamilans')->onDelete('cascade');
            $table->date('tanggal_rencana');
            $table->date('tanggal_realisasi')->nullable();
            $table->string('status')->default('Terjadwal'); // Terjadwal, Selesai, Terlewat
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_kunjungans');
    }
};
