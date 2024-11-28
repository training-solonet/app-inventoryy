<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateBarangsTable extends Migration
{
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barcode')->unique();
            $table->string('nama_barang');
            $table->string('kondisi');
            $table->string('jenis');
            $table->date('tgl_registrasi')->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('barangs');
    }
}
