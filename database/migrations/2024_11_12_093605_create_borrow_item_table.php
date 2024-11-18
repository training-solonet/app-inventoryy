<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowItemTable extends Migration
{
    public function up()
    {
        Schema::create('borrow_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrow_id')->constrained()->onDelete('cascade');
            $table->string('barcode');
            // Menambahkan foreign key untuk barcode
            $table->foreign('barcode')->references('kode_barcode')->on('barangs')->onDelete('cascade');
            $table->string('status')->default('Sedang Dipinjam'); // Status barang
            $table->dateTime('return_date')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::table('borrow_item', function (Blueprint $table) {
            $table->dropColumn(['status', 'return_date']);
        });
    }
}
