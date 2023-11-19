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
        Schema::create('order_products', function (Blueprint $table) {
            $table->unsignedBigInteger("product_id");
            $table->unsignedBigInteger("purchase_type_id")->nullable()->default(null);
            $table->unsignedBigInteger("order_id");

            $table->primary(["product_id","order_id"]);

            $table->float("price");

            $table->foreign("product_id")->references("id")->on("products");
            $table->foreign("purchase_type_id")->references("id")->on("purchase_types");
            $table->foreign("order_id")->references("id")->on("orders");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_purchases');
    }
};
