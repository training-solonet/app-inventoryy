<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowsTable extends Migration
{
    public function up()
    {
        Schema::create('borrows', function (Blueprint $table) {
            $table->id(); // ID unik
            $table->string('barcode'); // Barcode barang yang dipinjam, tidak unik
            $table->enum('status', ['Sedang Dipinjam', 'Dikembalikan']); // Status peminjaman
            $table->dateTime('borrow_date'); // Tanggal dan waktu peminjaman
            $table->string('borrower_name'); // Nama peminjam
            $table->dateTime('return_date')->nullable(); // Tanggal dan waktu pengembalian, bisa NULL
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('borrows'); // Menghapus tabel jika migrasi dibatalkan
    }
}
