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
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->string('institution_name')->nullable();
            $table->string('qualification')->nullable();
            $table->string('field_of_study')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('grade')->nullable();
            $table->string('gpa')->nullable();
            $table->string('marks')->nullable();
            $table->tinyInteger('graduated')->nullable();
            $table->string('grade_attained')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->bigInteger('user_id')->index();

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
        Schema::dropIfExists('education');
    }
};
