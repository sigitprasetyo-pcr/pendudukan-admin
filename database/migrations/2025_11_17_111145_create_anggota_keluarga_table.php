<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('anggota_keluarga', function (Blueprint $table) {
            $table->id('anggota_id');

            // Foreign key ke keluarga_kk
            $table->unsignedBigInteger('kk_id');

            // Foreign key ke tabel warga
            $table->unsignedBigInteger('warga_id');

            $table->string('hubungan');
            $table->timestamps();

            // FK ke keluarga_kk
            $table->foreign('kk_id')
                  ->references('kk_id')
                  ->on('keluarga_kk')
                  ->onDelete('cascade');

            // FK ke warga (PK = warga_id)
            $table->foreign('warga_id')
                  ->references('warga_id')   // BENAR
                  ->on('warga')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('anggota_keluarga');
    }
};
