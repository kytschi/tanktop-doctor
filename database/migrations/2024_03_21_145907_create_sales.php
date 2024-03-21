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
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->uuid('sales_agent_id');
            $table->uuid('customer_id');
            $table->uuid('product_id');
            $table->decimal('price', total: 10, places: 2);
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
