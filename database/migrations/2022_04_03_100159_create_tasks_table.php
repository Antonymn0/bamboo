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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('custom_name')->nullable();
            $table->string('slug')->nullable();
            $table->string('assigned_to')->index()->nullable();
            $table->string('due_date')->nullable();
            $table->string('due_time')->nullable();
            $table->string('url')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('pending');
            $table->string('type')->nullable();
            $table->bigInteger('type_id')->index()->nullable();
            $table->bigInteger('user_id')->index()->nullable();

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
        Schema::dropIfExists('tasks');
    }
};
