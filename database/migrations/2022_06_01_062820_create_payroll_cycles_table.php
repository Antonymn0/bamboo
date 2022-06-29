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
        Schema::create('payroll_cycles', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id')->required()->index();
            $table->integer('created_by')->required()->index();
            $table->integer('payroll_cycle_id')->required();
            $table->string('payroll_cycle_name')->nullable();

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
        Schema::dropIfExists('payroll_cycles');
    }
};
