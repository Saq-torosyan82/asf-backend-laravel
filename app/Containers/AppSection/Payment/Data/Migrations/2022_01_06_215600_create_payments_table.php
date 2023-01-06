<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('deal_id');
            $table->foreign('deal_id')->references('id')->on('deals')
                ->onDelete('cascade')->onUpdate('cascade');


            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->double('amount', 10, 2);
            $table->date('date');
            $table->boolean('is_paid')->default(false)->index();
            $table->date('paid_date')->nullable();
            $table->json('extra_data')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
}
