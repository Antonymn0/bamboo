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
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_name')->nullable();
            $table->string('organisation_name')->nullable();
            $table->string('membership_id')->nullable();
            $table->string('expires')->nullable();
            $table->string('issue_date')->nullable();
            $table->string('expiry_date')->nullable();
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
        Schema::dropIfExists('certifications');
    }
};
