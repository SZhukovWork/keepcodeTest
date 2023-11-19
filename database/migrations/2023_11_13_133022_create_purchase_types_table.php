<?php

use App\Models\PurchaseType\PurchaseType;
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
        Schema::create('purchase_types', function (Blueprint $table) {
            $table->id();
            $table->string("title",100);
            $table->unsignedBigInteger("validity_period");
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_types');
    }
};
