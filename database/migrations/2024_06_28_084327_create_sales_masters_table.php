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
        Schema::create('sales_masters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key column
            $table->unsignedBigInteger('coupon_id'); // Foreign key column
            $table->unsignedBigInteger('user_address_id'); // Foreign key column
            $table->date('order_date')->nullable();
            $table->decimal('sub_total',10,2)->nullable();
            $table->decimal('total_amount',10,2)->nullable();
            $table->decimal('discount',3,2)->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('cascade');
            $table->foreign('user_address_id')->references('id')->on('user_addresses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_masters');
    }
};
