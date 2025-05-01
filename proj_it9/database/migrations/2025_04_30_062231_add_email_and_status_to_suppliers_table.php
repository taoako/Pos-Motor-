<?php
// filepath: c:\laravel\pos motor and vechicle parts\it9_proj\proj_it9\database\migrations\xxxx_xx_xx_xxxxxx_add_email_and_status_to_suppliers_table.php
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
        Schema::table('suppliers', function (Blueprint $table) {
            $table->string('email')->nullable()->after('address'); // Add email column
            $table->boolean('status')->default(true)->after('email'); // Add status column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropColumn(['email', 'status']); // Remove email and status columns
        });
    }
};
