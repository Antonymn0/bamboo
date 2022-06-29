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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('company_id')->required()->index(); //referrences companies table
            $table->tinyInteger('created_by')->required()->index(); //referrences users table
            $table->string('month')->required(); 
            $table->string('year')->required(); 
            $table->bigInteger('number_of_employees')->nullable()->default(0);
            $table->double('gross_pay')->nullable(); 
            $table->double('paye')->nullable(); 
            $table->double('other_deductions')->nullable(); 
            $table->double('disbursed_amount')->nullable(); 

            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('payrolls');
    }
};
