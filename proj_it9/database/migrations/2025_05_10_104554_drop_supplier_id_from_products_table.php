<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropSupplierIdFromProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['supplier_id']);

            // Drop the supplier_id column
            $table->dropColumn('supplier_id');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Re-add the supplier_id column
            $table->unsignedBigInteger('supplier_id')->nullable();

            // Re-add the foreign key constraint
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
    }
}
