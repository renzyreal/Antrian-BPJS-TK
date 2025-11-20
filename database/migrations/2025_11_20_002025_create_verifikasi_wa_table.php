<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('verifikasi_wa', function (Blueprint $table) {
            $table->id();
            $table->string('no_hp');
            $table->string('kode_verifikasi');
            $table->boolean('terverifikasi')->default(false);
            $table->timestamp('expired_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('verifikasi_wa');
    }
};