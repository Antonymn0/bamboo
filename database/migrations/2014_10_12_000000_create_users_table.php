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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->rememberToken();
            $table->string('password');
            $table->string('surname')->nullable();
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('other_names')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->string('email')->nullable()->unique();
            $table->timestamp('suspended_at')->nullable();
            $table->timestamp('un_suspended_at')->nullable();
            $table->string('phone')->nullable()->unique();
            $table->tinyInteger('reg_status')->nullable();
            $table->string('username')->nullable()->unique();
            $table->timestamp('first_name_verified_at')->nullable();
            $table->timestamp('middle_name_verified_at')->nullable();
            $table->timestamp('last_name_verified_at')->nullable();
            $table->timestamp('surname_verified_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->integer('activated_by')->nullable()->index();
            $table->integer('registered_by')->nullable()->index();
            $table->integer('suspended_by')->nullable()->index();
            $table->integer('un_suspended_by')->nullable()->index();
            $table->integer('reports_to')->nullable()->index();
            $table->integer('restored_by')->nullable()->index();
            $table->bigInteger('department_id')->index()->nullable();
            $table->bigInteger('company_id')->index()->nullable();

            //$table->string('staff_id')->nullable()->unique();
            /*$table->string('contract_type')->nullable();
            $table->string('probation_period')->nullable();
            $table->string('employment_start_date')->nullable();
            $table->string('contract_start_date')->nullable();
            $table->string('contract_end_date')->nullable();
            $table->string('reporting_date')->nullable();*/
            /*$table->string('address')->nullable();
            $table->string('company')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('postal_address')->nullable();
            $table->string('street_address')->nullable();
            $table->string('country')->nullable();
            $table->string('religion')->nullable();
            $table->string('county')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('postal_code')->nullable();
            $table->tinyInteger('director')->nullable();
            $table->tinyInteger('resident')->nullable();
            
            $table->string('city')->nullable();
            $table->text('biography')->nullable();
            $table->string('gender')->nullable();
            $table->timestamp('gender_verified_at')->nullable();
            $table->string('nationality')->nullable();
            $table->string('national_id_no_verified_at')->nullable();
            $table->string('national_id_no')->nullable();
            $table->string('kra_pin_no')->nullable();
            $table->string('kra_pin_no_verified_at')->nullable();

            $table->string('nhif_no')->nullable();
            $table->string('nhif_no_verified_at')->nullable();

            $table->string('nssf_no')->nullable();
            $table->string('nssf_no_verified_at')->nullable();
            
            $table->string('passport_no')->nullable();
            $table->string('passport_no_verified_at')->nullable();

            $table->string('huduma_no')->nullable();
            $table->string('huduma_no_verified_no')->nullable();

            $table->string('driving_license_no')->nullable();
            $table->string('driving_license_no_verified_at')->nullable();

            $table->string('driving_license_expiry')->nullable();
            $table->string('disability')->nullable();
            $table->string('dob')->nullable();
            $table->timestamp('dob_verified_at')->nullable();
            $table->string('physical_address')->nullable();
            $table->string('disability_cert_no')->nullable();
            $table->string('disability_cert_no_verified_at')->nullable();
            $table->string('disability_description')->nullable();
            $table->text('facebook_link')->nullable();
            $table->text('twitter_link')->nullable();
            $table->text('linkedin_link')->nullable();
            $table->text('instagram_link')->nullable();
            $table->bigInteger('registered_by')->index()->nullable();
            $table->tinyInteger('fulltime_service_director')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('basic_details_verified_at')->nullable();
            $table->text('basic_details_comments')->nullable();
            $table->timestamp('address_details_verified_at')->nullable();
            $table->text('address_details_comments')->nullable();
            $table->timestamp('education_details_verified_at')->nullable();
            $table->text('education_details_comments')->nullable();
            $table->timestamp('certifications_details_verified_at')->nullable();
            $table->text('certifications_details_comments')->nullable();
            $table->timestamp('languages_details_verified_at')->nullable();
            $table->text('languages_details_comments')->nullable();
            $table->timestamp('work_experience_details_verified_at')->nullable();
            $table->text('work_experience_details_comments')->nullable();
            $table->timestamp('referees_details_verified_at')->nullable();
            $table->text('referees_details_comments')->nullable();
            $table->timestamp('emergency_details_verified_at')->nullable();
            $table->text('emergency_details_comments')->nullable();
            $table->timestamp('dependants_details_verified_at')->nullable();
            $table->text('dependants_details_comments')->nullable();
            $table->timestamp('beneficiaries_details_verified_at')->nullable();
            $table->text('beneficiaries_details_comments')->nullable();*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
