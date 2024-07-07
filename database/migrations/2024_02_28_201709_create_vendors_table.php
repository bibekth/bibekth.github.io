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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('firm_name');
            $table->string('name');
            $table->string('contact')->unique();
            $table->string('email')->unique()->nullable();
            $table->string('address');
            $table->string('pan_vat')->nullable();
            $table->enum('status',[0,1])->default(1);
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->unsignedBigInteger('municipality')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('municipality')->references('id')->on('municipals')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendors');
    }
};
