<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('keluarga_kk', function (Blueprint $table) {
            $table->id('kk_id');
            $table->string('kk_nomor')->unique();
            $table->unsignedBigInteger('kepala_keluarga_warga_id');
            $table->string('alamat');
            $table->string('rt', 5);
            $table->string('rw', 5);
            $table->timestamps();

            // Foreign Key yang benar
            $table->foreign('kepala_keluarga_warga_id')
                  ->references('warga_id')  // FK HARUS MENGARAH KE warga_id
                  ->on('warga')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('keluarga_kk');
    }
};
