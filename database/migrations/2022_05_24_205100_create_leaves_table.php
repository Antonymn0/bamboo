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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_id')->required();
            $table->bigInteger('created_by')->required();
            $table->string('leave_type')->required();
            $table->dateTime('start_date')->required();
            $table->dateTime('end_date')->required();
            $table->dateTime('reporting_date')->required();
            $table->tinyInteger('status')->nullable();
            $table->text('description')->nullable();
            $table->text('hr_comments')->nullable();
            $table->bigInteger('approved_by')->nullable();
            $table->bigInteger('declined_by')->nullable();
            $table->tinyInteger('number_of_days')->nullable();

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
        Schema::dropIfExists('leaves');
    }
};
