<?php 
namespace App\Helpers;

use App\Models\User;

class Employee
{
    public static function verified(User $user)
    {
        if( is_null( $user->email_verified_at ) )
            return false;
        elseif ( is_null( $user->basic_details_verified_at ) ) 
            return false;
        elseif ( is_null( $user->address_details_verified_at ) ) 
            return false;
        elseif ( is_null( $user->education_details_verified_at ) ) 
            return false;
        elseif ( is_null( $user->certifications_details_verified_at ) ) 
            return false;
        elseif ( is_null( $user->languages_details_verified_at ) ) 
            return false;
        elseif ( is_null( $user->work_experience_details_verified_at ) ) 
            return false;
        elseif ( is_null( $user->referees_details_verified_at ) ) 
            return false;
        elseif ( is_null( $user->emergency_details_verified_at ) ) 
            return false;
        elseif ( is_null( $user->dependants_details_verified_at ) ) 
            return false;
        elseif ( is_null( $user->beneficiaries_details_verified_at ) ) 
            return false;
        return true;
    }
}