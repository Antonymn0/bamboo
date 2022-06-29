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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('checkout_request_id')->unique()->required();
            $table->string('merchant_request_id')->unique()->required();
            $table->integer('company_id')->required()->index(); // references companies table
            $table->integer('user_id')->required();   // references users table
            
            $table->double('transaction_amount')->nullable();
            $table->integer('mpesa_result_code')->nullable();
            $table->string('transaction_reciept_number')->nullable()->unique();
            $table->timestamp('transaction_date')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('payment_method')->nullable();

            $table->tinyInteger('record_reconciled')->nullable(); // true or false            
            $table->integer('record_reconciled_by')->nullable()->index();
            $table->timestamp('record_reconciled_at')->nullable();
            $table->string('transaction_type')->nullable(); //  payment or reversal or dispute
           

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
        Schema::dropIfExists('payments');
    }
};
