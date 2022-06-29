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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('path');
            $table->double('size');
            $table->string('public_uri');
            $table->string('purpose')->nullable();
            $table->string('extension')->nullable();
            $table->string('alt_text')->nullable();
            $table->integer('menu_order')->nullable();
            $table->string('mediaable_type')->nullable();
            $table->timestamp('suspended_at')->nullable();
            $table->unsignedBigInteger('mediaable_id')->nullable();
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
        Schema::dropIfExists('media');
    }
};
