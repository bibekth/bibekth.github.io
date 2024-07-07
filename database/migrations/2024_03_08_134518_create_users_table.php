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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->integer('mpin')->nullable()->max(4);
            $table->enum('role',['Admin','Vendor','User'])->default('User');
            $table->string('phone_number')->unique();
            $table->unsignedInteger('otp_code')->nullable()->default(null)->max(6);
            $table->dateTime('otp_registered')->nullable();
            $table->string('token')->nullable();
            $table->string('device_id')->nullable()->default(null);
            $table->enum('status',[0,1])->default(1);
            $table->string('fcm_id')->nullable()->default(null);
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade')->onUpdate('cascade');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
