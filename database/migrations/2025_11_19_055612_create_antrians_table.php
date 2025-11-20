<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('antrians', function (Blueprint $table) {
        $table->id();
        $table->string('nama_tk');
        $table->string('nik_tk');
        $table->string('ahli_waris');
        $table->string('no_hp');
        $table->string('foto_ktp_aw');
        $table->string('foto_diri_aw');
        $table->date('tanggal');
        $table->string('jam');
        $table->integer('nomor'); // nomor antrian
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antrians');
    }
};
