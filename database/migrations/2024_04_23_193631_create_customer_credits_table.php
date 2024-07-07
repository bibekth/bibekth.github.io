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
        Schema::create('customer_credits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assign_customer_id');
            $table->unsignedBigInteger('credit_amount')->default(0);
            $table->enum('status',[0,1])->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('assign_customer_id')->references('id')->on('assigncustomers')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_credits');
    }
};
