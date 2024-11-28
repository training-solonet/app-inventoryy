<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('barang_projects', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang'); // Nama Barang
            $table->string('kode_barcode')->unique(); // Kode Barcode
            $table->string('gambar'); // Gambar
            $table->string('kondisi'); // Kondisi
            $table->integer('qty'); // Quantity
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('barang_projects');
    }
}
