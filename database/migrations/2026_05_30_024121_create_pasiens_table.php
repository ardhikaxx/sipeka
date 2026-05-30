<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pasiens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('nik', 16)->unique();
            $table->string('nama');
            $table->date('tgl_lahir');
            $table->text('alamat');
            $table->string('no_hp')->nullable();
            $table->decimal('tinggi_badan', 5, 2)->nullable();
            $table->string('golongan_darah', 5)->nullable();
            $table->string('status_pernikahan')->nullable();
            $table->string('nama_suami')->nullable();
            $table->foreignId('bidan_id')->constrained('users')->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};
