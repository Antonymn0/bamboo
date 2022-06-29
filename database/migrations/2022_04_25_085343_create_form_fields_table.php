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
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('size')->nullable();
            $table->double('min')->nullable();
            $table->string('label')->nullable();
            $table->string('placeholder')->nullable();
            $table->double('max')->nullable();
            $table->string('field_id')->nullable();
            $table->string('category')->nullable();
            $table->tinyInteger('active')->nullable();
            $table->text('parent_classes')->nullable();
            $table->text('options')->nullable();
            $table->tinyInteger('menu_order')->default(0);
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
        Schema::dropIfExists('form_fields');
    }
};
