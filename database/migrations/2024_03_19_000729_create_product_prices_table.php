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
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('variant_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('variant_id')->references('id')->on('variants')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade')->onUpdate('cascade');
            $table->string('quantity');
            $table->integer('price');
            $table->enum('status',[0,1])->default(1);
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
        Schema::dropIfExists('product_prices');
    }
};
