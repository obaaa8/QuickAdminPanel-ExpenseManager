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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreignId('customer_id')->constrained('users');
            $table->foreignId('shift_id')->constrained('shifts');
            // $table->unsignedInteger('shift_id');
            // $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('cascade');
            $table->double('total_amount', 8, 2)->nullable();
            // $table->foreignId('created_by')->constrained('users');
            $table->unsignedInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('paid')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};