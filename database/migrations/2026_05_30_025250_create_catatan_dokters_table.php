<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catatan_dokters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rujukan_id')->constrained('rujukans')->onDelete('cascade');
            $table->foreignId('dokter_id')->constrained('users')->onDelete('restrict');
            $table->text('diagnosis')->nullable();
            $table->text('resep')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catatan_dokters');
    }
};
