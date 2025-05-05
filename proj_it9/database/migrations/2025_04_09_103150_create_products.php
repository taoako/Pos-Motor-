<?php

// Migration for Products table
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProducts extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('supplier_id'); // Foreign key to the suppliers table
            $table->string('sku')->nullable();
            $table->string('barcode')->nullable();
            $table->string('unit')->nullable();
            $table->decimal('cost_price', 10, 2)->default(0.00);
            $table->integer('stock')->default(0);
            $table->string('image')->nullable();
            $table->timestamps();

            // Defining foreign key constraints
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
