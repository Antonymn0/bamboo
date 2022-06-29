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
        Schema::create('payroll_user', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('payroll_id')->required()->index(); //referrences payrolls table
            $table->tinyInteger('user_id')->required()->index(); //referrences users table
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payroll_user');
    }
};
