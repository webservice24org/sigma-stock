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
        Schema::create('sales', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
			$table->unsignedBigInteger('user_id')->index('user_id_sales');
			$table->unsignedBigInteger('customer_id')->index('sale_customer_id');
			$table->unsignedBigInteger('warehouse_id')->index('warehouse_id_sale');
			$table->date('date');
			$table->float('tax_rate', 10, 0)->nullable()->default(0);
			$table->float('discount', 10, 0)->nullable()->default(0);
			$table->float('shipping', 10, 0)->nullable()->default(0);
			$table->float('grand_total', 10, 0)->default(0);
			$table->float('paid_amount', 10, 0)->default(0);
			$table->float('due_amount', 10, 0)->default(0);
            $table->integer('installment_number');
			$table->dateTime('next_payment_date')->nullable();

			$table->text('notes')->nullable();

            $table->foreign('customer_id')->references('id')->on('customers')
                ->cascadeOnUpdate()->restrictOnDelete();

            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('sales');
    }
};
