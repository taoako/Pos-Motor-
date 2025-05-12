<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReasonAndSaleIdToTransactionLogs extends Migration
{
    public function up()
    {
        Schema::table('transaction_logs', function (Blueprint $table) {
            $table->string('reason')->nullable(); // Reason for stock-out (e.g., damaged, returned)
            $table->unsignedBigInteger('sale_id')->nullable(); // Link to a specific sale for returns
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('transaction_logs', function (Blueprint $table) {
            $table->dropColumn('reason');
            $table->dropForeign(['sale_id']);
            $table->dropColumn('sale_id');
        });
    }
}
