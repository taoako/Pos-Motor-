><?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::table('products', function (Blueprint $table) {
                $table->renameColumn('cost_price', 'selling_price'); // Rename the column
            });
        }

        public function down(): void
        {
            Schema::table('products', function (Blueprint $table) {
                $table->renameColumn('selling_price', 'cost_price'); // Revert the column name
            });
        }
    };
