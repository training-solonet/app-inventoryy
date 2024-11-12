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
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('borrow_item');
    }
}
