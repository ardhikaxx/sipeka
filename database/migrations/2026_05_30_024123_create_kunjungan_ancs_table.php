<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kunjungan_ancs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kehamilan_id')->constrained('kehamilans')->onDelete('cascade');
            $table->foreignId('bidan_id')->constrained('users')->onDelete('restrict');
            $table->date('tanggal');
            $table->integer('usia_kehamilan_minggu');
            $table->decimal('berat_badan', 5, 2);
            $table->decimal('imt', 5, 2)->nullable();
            $table->decimal('penambahan_bb', 5, 2)->nullable();
            $table->integer('tekanan_darah_sistolik');
            $table->integer('tekanan_darah_diastolik');
            $table->decimal('map', 5, 2)->nullable();
            $table->integer('nadi');
            $table->decimal('suhu', 4, 1)->nullable();
            $table->integer('respirasi')->nullable();
            $table->integer('tinggi_fundus_uteri');
            $table->integer('djj');
            $table->enum('edema', ['Tidak', '+1', '+2', '+3']);
            $table->enum('protein_urine', ['Negatif', '+1', '+2', '+3', '+4']);
            $table->enum('glukosa_urine', ['Negatif', 'Positif'])->nullable();
            $table->decimal('hb', 5, 2)->nullable();
            $table->integer('trombosit')->nullable();
            $table->decimal('kreatinin', 5, 2)->nullable();
            $table->integer('sgot')->nullable();
            $table->integer('sgpt')->nullable();
            $table->boolean('ada_riwayat_kejang')->default(false);
            $table->boolean('nyeri_kepala_hebat')->default(false);
            $table->boolean('gangguan_penglihatan')->default(false);
            $table->boolean('nyeri_ulu_hati')->default(false);
            $table->boolean('edema_paru')->default(false);
            $table->text('keluhan_subjektif')->nullable();
            $table->text('catatan_bidan')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            $table->unique(['kehamilan_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunjungan_ancs');
    }
};
