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
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('order_batch_id')->nullable()->after('user_id');

            $table->foreign('order_batch_id')
                ->references('id')
                ->on('orders_batch')
                ->onDelete('set null'); // Jika batch dihapus, order tetap ada
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['order_batch_id']);
            $table->dropColumn('order_batch_id');
        });
    }
};
