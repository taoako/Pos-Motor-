<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAndRenameTransactionLogsTable extends Migration
{
    public function up()
    {
        // Rename the table only if it exists and hasn't already been renamed
        if (Schema::hasTable('transaction_logs') && !Schema::hasTable('stock_outs')) {
            Schema::rename('transaction_logs', 'stock_outs');
        }

        // Modify the renamed table
        if (Schema::hasTable('stock_outs')) {
            Schema::table('stock_outs', function (Blueprint $table) {
                // Drop the foreign key constraint on 'transaction_id' if it exists
                if (Schema::hasColumn('stock_outs', 'transaction_id')) {
                    try {
                        $table->dropForeign('transaction_logs_transaction_id_foreign');
                    } catch (\Exception $e) {
                        // Ignore if the foreign key does not exist
                    }
                    $table->dropColumn('transaction_id');
                }

                // Drop the foreign key constraint on 'stock_in_transaction_id' if it exists
                if (Schema::hasColumn('stock_outs', 'stock_in_transaction_id')) {
                    try {
                        $table->dropForeign('transaction_logs_stock_in_transaction_id_foreign');
                    } catch (\Exception $e) {
                        // Ignore if the foreign key does not exist
                    }
                    $table->dropColumn('stock_in_transaction_id');
                }

                // Add stock-out-specific fields if they don't already exist
                if (!Schema::hasColumn('stock_outs', 'sale_id')) {
                    $table->unsignedBigInteger('sale_id')->nullable()->after('reason'); // Link to a sale for returned items
                    $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
                }
            });
        }
    }

    public function down()
    {
        // Revert the table modifications
        if (Schema::hasTable('stock_outs')) {
            Schema::table('stock_outs', function (Blueprint $table) {
                // Re-add removed fields if they don't already exist
                if (!Schema::hasColumn('stock_outs', 'transaction_id')) {
                    $table->unsignedBigInteger('transaction_id')->nullable();
                    $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
                }

                if (!Schema::hasColumn('stock_outs', 'stock_in_transaction_id')) {
                    $table->unsignedBigInteger('stock_in_transaction_id')->nullable();
                    $table->foreign('stock_in_transaction_id')->references('id')->on('stock_in_transactions')->onDelete('cascade');
                }

                // Remove added fields if they exist
                if (Schema::hasColumn('stock_outs', 'sale_id')) {
                    $table->dropForeign(['sale_id']);
                    $table->dropColumn('sale_id');
                }
            });

            // Rename the table back to its original name if it exists
            if (Schema::hasTable('stock_outs') && !Schema::hasTable('transaction_logs')) {
                Schema::rename('stock_outs', 'transaction_logs');
            }
        }
    }
}
