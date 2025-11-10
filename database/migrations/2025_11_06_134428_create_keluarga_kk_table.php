<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keluarga_kk', function (Blueprint $table) {
            $table->bigIncrements('kk_id');

            $table->string('kk_nomor', 20)->unique();

            // FK ke warga.warga_id (tipe harus sama: unsignedBigInteger)
            $table->unsignedBigInteger('kepala_keluarga_warga_id');
            $table->foreign('kepala_keluarga_warga_id')
                  ->references('warga_id')->on('warga')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->string('alamat', 255);
            $table->unsignedTinyInteger('rt');
            $table->unsignedTinyInteger('rw');
            $table->timestamps();

            $table->index(['rt', 'rw']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keluarga_kk'); // <- tadinya salah nge-drop 'warga'
    }
};
