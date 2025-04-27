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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('product_name')->unique(); // Product name should be unique
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Foreign key to categories
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade'); // Foreign key to suppliers
            $table->string('sku')->unique()->nullable(); // SKU can be nullable
            $table->string('barcode')->unique()->nullable(); // Barcode can be nullable
            $table->string('unit')->nullable(); // Unit of the product (kg, pcs, etc.)
            $table->decimal('cost_price', 10, 2)->nullable(); // Nullable cost price field

            $table->timestamps(); // Created at and updated at fields
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
