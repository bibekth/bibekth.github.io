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
        Schema::create('vendor_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            $table->string('name');
            $table->string('file_path');
            $table->enum('status',[0,1])->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_files');
    }
};
