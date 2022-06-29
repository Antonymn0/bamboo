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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();         
            $table->string('slug')->required();
            $table->string('company_name')->required();
            $table->timestamp('suspended_at')->nullable();
            $table->integer('activated_by')->nullable()->index();
            $table->integer('registered_by')->nullable()->index();
            $table->integer('suspended_by')->nullable()->index();
            $table->integer('restored_by')->nullable()->index();
            $table->tinyInteger('registration_status')->nullable();
            /*$table->string('registration_no')->nullable()->unique();
            $table->string('postal_address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('website')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('country')->nullable();
            $table->string('county')->nullable();
            $table->string('city')->nullable();
            $table->string('town')->nullable();
            $table->string('alternate_email')->nullable();
            $table->string('phone')->nullable();
            $table->string('physical_address')->nullable();
            $table->string('company_address')->nullable();
            $table->string('kra_pin')->nullable();
            $table->string('nssf_no')->nullable();
            $table->string('nhif_no')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->string('description')->nullable();*/
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
};
