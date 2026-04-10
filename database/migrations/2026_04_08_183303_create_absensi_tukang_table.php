<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('absensi_tukang', function (Blueprint $table) {
        $table->id();
        $table->date('tanggal');
        $table->string('nama_tukang');
        $table->string('jabatan');
        $table->string('proyek');
        $table->time('jam_masuk')->nullable();
        $table->time('jam_pulang')->nullable();
        $table->string('status');
        $table->integer('upah_harian');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_tukang');
    }
};
