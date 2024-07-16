<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_master_id'); // Foreign key column
            $table->unsignedBigInteger('product_id'); // Foreign key column
            $table->unsignedBigInteger('quantity'); // Foreign key column
            $table->integer('amount')->nullable();
            $table->decimal('discount',10,2)->nullable();
            $table->decimal('total_amount',10,2)->nullable();


            $table->foreign('sales_master_id')->references('id')->on('sales_masters')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_details');
    }
};
