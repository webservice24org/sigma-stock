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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
			$table->integer('supplier_id')->index('supplier_id');
			$table->integer('warehouse_id')->index('warehouse_id');
			$table->integer('purchase_category_id')->index('purchase_category_id');
            $table->integer('unit_id');
            
			$table->date('date');
			$table->float('tax_rate', 10, 0)->nullable()->default(0);
			$table->float('TaxNet', 10, 0)->nullable()->default(0);
			
            $table->tinyInteger('status' )
                ->default(0)
                ->comment('0=Pending, 1=Approved');
			$table->string('payment_statut', 192);
            
			$table->text('notes')->nullable();

            $table->foreign('user_id')->references('id')->on('users')
                ->cascadeOnUpdate()->restrictOnDelete();

            $table->foreign('supplier_id')->references('id')->on('suppliers')
                ->cascadeOnUpdate()->restrictOnDelete();

            $table->foreign('warehouse_id')->references('id')->on('warehouses')
                ->cascadeOnUpdate()->restrictOnDelete();

            $table->foreign('unit_id')->references('id')->on('product_units')
                ->cascadeOnUpdate()->restrictOnDelete();
                
            $table->foreign('purchase_category_id')->references('id')->on('purchase_categories')
                ->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
