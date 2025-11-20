<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warga', function (Blueprint $table) {
            $table->bigIncrements('warga_id');     // PK
            $table->string('no_ktp', 20)->unique();
            $table->string('nama', 100);
            $table->enum('jenis_kelamin', ['Laki-Laki','Perempuan']);
            $table->string('agama', 50);
            $table->string('pekerjaan', 100)->nullable();
            $table->string('telp', 25)->nullable();
            $table->string('email', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warga');
    }
};
