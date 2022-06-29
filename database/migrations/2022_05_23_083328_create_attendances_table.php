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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('company_id')->index()->nullable();
            $table->bigInteger('user_id')->required();
            $table->string('clock_in_time')->required();
            $table->bigInteger('clocked_in_by')->required();
            $table->bigInteger('clocked_out_by')->nullable();
            $table->string('clocked_out_time')->nullable();
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
        Schema::dropIfExists('attendances');
    }
};
