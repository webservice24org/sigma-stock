<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('code', 192);
            $table->string('type_barcode', 192);
            $table->string('name', 192);
            $table->unsignedBigInteger('category_id')->index('category_id');
            $table->unsignedBigInteger('unit_id')->nullable()->index('unit_id_products');
            $table->float('making_cost', 10, 0);
            $table->float('general_price', 10, 0);
            $table->unsignedBigInteger('discount')->nullable();
            $table->float('tax_rate', 10, 0)->nullable()->default(0);
            $table->text('note')->nullable();
            $table->text('product_short_desc');
            $table->longText('product_long_desc')->nullable();
            $table->text('image')->nullable();
            $table->longText('product_gallery')->nullable();

            $table->float('stock_alert', 10, 0)->nullable()->default(0);

            $table->foreign('user_id')->references('id')->on('users')
                ->cascadeOnUpdate()->restrictOnDelete();

            $table->foreign('category_id')->references('id')->on('product_categories')
                ->cascadeOnUpdate()->restrictOnDelete();

            $table->foreign('unit_id')->references('id')->on('product_units')
                ->cascadeOnUpdate()->restrictOnDelete();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
