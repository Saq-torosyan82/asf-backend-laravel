<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDealsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->string('deal_type', 30)->index();
            $table->string('contract_type', 30);
            $table->string('status', 20)->index();
            $table->string('reason', 30)->nullable()->index();
            $table->string('currency', 3);
            $table->double('contract_amount', 11, 2);
            $table->double('upfront_amount', 11, 2)->default(0);
            $table->double('interest_rate', 4, 2);
            $table->double('gross_amount', 11, 2)->default(0);
            $table->double('deal_amount', 11, 2)->default(0);

            $table->date('first_installment');
            $table->string('frequency', 20);
            $table->unsignedTinyInteger('nb_installmetnts');
            $table->date('funding_date');

            $table->json('criteria_data');
            $table->json('payments_data');
            $table->json('fees_data');
            $table->json('user_documents')->nullable();
            $table->json('consent_data')->nullable();
            $table->json('contact_data')->nullable();
            $table->json('extra_data')->nullable();

            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
            //$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
}
