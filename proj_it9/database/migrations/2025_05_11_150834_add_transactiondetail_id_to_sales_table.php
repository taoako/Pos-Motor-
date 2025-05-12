<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionDetailIdToSalesTable extends Migration
{
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->unsignedBigInteger('transactiondetail_id')->nullable()->after('id');
            $table->foreign('transactiondetail_id')->references('id')->on('transaction_details')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['transactiondetail_id']);
            $table->dropColumn('transactiondetail_id');
        });
    }
}
