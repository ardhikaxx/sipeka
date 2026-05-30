<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kehamilans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade');
            $table->date('hpht');
            $table->date('tp')->nullable();
            $table->integer('gravida');
            $table->integer('para');
            $table->integer('abortus');
            $table->boolean('riwayat_preeklampsia')->default(false);
            $table->boolean('riwayat_hipertensi')->default(false);
            $table->boolean('riwayat_diabetes')->default(false);
            $table->boolean('riwayat_ginjal')->default(false);
            $table->boolean('riwayat_bblr')->default(false);
            $table->boolean('keluarga_preeklampsia')->default(false);
            $table->boolean('kehamilan_kembar')->default(false);
            $table->boolean('nullipara')->default(false);
            $table->boolean('interval_lebih_10')->default(false);
            $table->string('status')->default('aktif'); // aktif, selesai, dll.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kehamilans');
    }
};
