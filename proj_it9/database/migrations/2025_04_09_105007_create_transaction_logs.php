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
        Schema::create('transaction_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade');
            $table->foreignId('stock_in_transaction_id')->constrained('stock_in_transactions')->onDelete('cascade');
            $table->string('transaction_type'); // Type of transaction: 'sale', 'stock_in', stock_out, etc.
            $table->integer('quantity'); // Quantity of the product involved in the transaction
            $table->date('logged_at'); // Date when the transaction was logged



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_logs');
    }
};
