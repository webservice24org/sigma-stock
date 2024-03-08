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
        Schema::create('quotations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('user_id')->index('user_id');
			$table->date('date');
			$table->unsignedBigInteger('customer_id')->index('customer_id');
			$table->unsignedBigInteger('warehouse_id')->index('warehouse_id');
            $table->integer('tax_percentage')->default(0);
			$table->float('discount', 10, 0)->nullable()->default(0);
			$table->float('shipping_amount', 10, 0)->nullable()->default(0);
			$table->float('total_amount', 10, 0);
			$table->tinyInteger('status' )
                ->default(0)
                ->comment('0=Pending, 1=Approved');
            $table->text('note')->nullable();

            $table->foreign('user_id')->references('id')->on('users')
                ->cascadeOnUpdate()->restrictOnDelete();

            $table->foreign('customer_id')->references('id')->on('customers')
                ->cascadeOnUpdate()->restrictOnDelete();

                $table->foreign('warehouse_id')->references('id')->on('warehouses')
                ->cascadeOnUpdate()->restrictOnDelete();
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
