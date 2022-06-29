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
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('company')->nullable();
            $table->string('location')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('physical_address')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('work_experiences');
    }
};
