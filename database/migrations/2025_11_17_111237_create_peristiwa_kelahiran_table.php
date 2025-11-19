<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peristiwa_kelahiran', function (Blueprint $table) {
            // Kolom dari skema Anda
            $table->id('kelahiran_id'); // PK

            // FK Warga yang baru lahir (data warga yang baru akan di-input)
            $table->unsignedBigInteger('warga_id'); // FK

            $table->date('tgl_lahir');
            $table->string('tempat_lahir');

            // FK Ayah
            $table->unsignedBigInteger('ayah_warga_id')->nullable(); // FK

            // FK Ibu
            $table->unsignedBigInteger('ibu_warga_id')->nullable(); // FK

            $table->string('no_akta', 100)->unique(); // UNQ

            $table->timestamps();

            // Definisi Foreign Key
            $table->foreign('warga_id')->references('warga_id')->on('warga')->onDelete('cascade');
            $table->foreign('ayah_warga_id')->references('warga_id')->on('warga')->onDelete('set null');
            $table->foreign('ibu_warga_id')->references('warga_id')->on('warga')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peristiwa_kelahiran');
    }
};
