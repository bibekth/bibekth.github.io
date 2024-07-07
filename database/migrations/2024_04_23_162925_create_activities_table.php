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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cash_transaction_id')->nullable();
            $table->unsignedBigInteger('credit_transaction_id')->nullable();
            $table->unsignedBigInteger('product_price_id');
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedBigInteger('total_amount');
            $table->enum('payment_type',['cash','credit'])->default('cash');
            $table->enum('status',[0,1])->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('cash_transaction_id')->references('id')->on('cash_transactions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('credit_transaction_id')->references('id')->on('credit_transactions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_price_id')->references('id')->on('product_prices')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
};
