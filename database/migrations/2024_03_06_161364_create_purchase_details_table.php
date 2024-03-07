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
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('purchase_id');
            $table->float('discount', 10, 0)->nullable()->default(0);
			$table->float('shipping', 10, 0)->nullable()->default(0);
            $table->integer('purchase_qty');
			$table->float('grand_total', 10, 0);
			$table->float('paid_amount', 10, 0)->default(0);
			$table->float('due_amount', 10, 0)->default(0);
            
            $table->foreign('purchase_id')->references('id')->on('purchases')
                ->cascadeOnUpdate()->restrictOnDelete();
            
            
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_details');
    }
};
