<?php 

namespace App\Helpers;
use Illuminate\Support\Facades\Route;
use App\Models\Setting;
use App\Helpers\Constants;
use App\Helpers\Fields;
use App\Models\FormField;
use App\Models\User;


class PageSettings
{
    public static function login()
    {
        $arr = [
            'canResetPassword' => Route::has('password.request'),
            'settings' => self::getSettings('login_page'),
        ];

        return array_merge($arr,self::commonElements());
    }

    public static function register()
    {
        $arr = [
            'settings' => self::getSettings('register_page'),
        ];

        return array_merge($arr,self::commonElements());
    }

    public static function password_reset()
    {
        $arr = [
            'settings' => self::getSettings('password_reset_page'),
        ];

        return array_merge($arr,self::commonElements());
    }

    public static function dashboard()
    {
        $arr = [
            'settings' => self::getSettings('dashboard_page'),
        ];

        return array_merge($arr,self::commonElements());
    }

    public static function employees()
    {
        $arr = [
            'settings' => self::getSettings('employees_page'),
        ];

        return array_merge($arr,self::commonElements());
    }

    public static function profile()
    {
        $arr = [
            'settings' => self::getSettings('profile_page'),
        ];

        return array_merge($arr,self::commonElements());
    }

    public static function payroll()
    {
        $arr = [
            'settings' => self::getSettings('payroll_page'),
        ];

        return array_merge($arr,self::commonElements());
    }

    public static function reports()
    {
        $arr = [
            'settings' => self::getSettings('reports_page'),
        ];

        return array_merge($arr,self::commonElements());
    }

    public static function preferences()
    {
        $arr = [
            'settings' => self::getSettings('preferences_page'),
        ];

        return array_merge($arr,self::commonElements());
    }

    public static function notifications()
    {
        $arr = [
            'settings' => self::getSettings('notifications_page'),
        ];

        return array_merge($arr,self::commonElements());
    }

    public static function onboard()
    {
        $arr = [
            'settings' => self::getSettings('onboard_page'),
        ];

        return array_merge($arr,self::commonElements());
    }

    public static function onboard_step_two()
    {
        $arr = [
            'settings' => self::getSettings('onboard_page'),
        ];

        return array_merge($arr,self::commonElements());
    }

    public static function onboard_step_three()
    {
        $arr = [
            'settings' => self::getSettings('onboard_page'),
        ];

        return array_merge($arr,self::commonElements());
    }

    public static function onboard_step_four()
    {
        $arr = [
            'settings' => self::getSettings('onboard_page'),
        ];

        return array_merge($arr,self::commonElements());
    }

    public static function employee_registration()
    {
        $arr = [
            'settings' => self::getSettings('employee_registration','registration_field'),
        ];

        return array_merge($arr,self::commonElements());
    }
    public static function verify_employee_biodata()
    {
        $arr = [
            'settings' => self::getSettings('verify_employee_biodata'),
        ];

        return array_merge($arr,self::commonElements());
    }
    public static function verify_education()
    {
        $arr = [
            'settings' => self::getSettings('verify_education'),
        ];

        return array_merge($arr,self::commonElements());
    }
    public static function assign_assets()
    {
        $arr = [
            'settings' => self::getSettings('assign_assets'),
        ];

        return array_merge($arr,self::commonElements());
    }

    public static function activate_employee()
    {
        $arr = [
            'settings' => self::getSettings('activate_employee'),
        ];

        return array_merge($arr,self::commonElements());
    }

    public static function user_profile_inactive()
    {
        $arr = [
            'settings' => self::getSettings('user_profile_inactive'),
        ];

        return array_merge($arr,self::commonElements());
    }

    /*public static function newuser_basic_details()
    {
        $arr = [
            'settings' => self::getSettings('newuser_basic_details'),
        ];

        return array_merge($arr,self::commonElements());
    }

    public static function newuser_address_details()
    {
        $arr = [
            'settings' => self::getSettings('newuser_address_details'),
        ];

        return array_merge($arr,self::commonElements());
    }

    public static function newuser_education_details()
    {
        $arr = [
            'settings' => self::getSettings('newuser_education_details'),
        ];

        return array_merge($arr,self::commonElements());
    }

    public static function newuser_work_details()
    {
        $arr = [
            'settings' => self::getSettings('newuser_work_details'),
        ];

        return array_merge($arr,self::commonElements());
    }

    public static function newuser_other_details()
    {
        $arr = [
            'settings' => self::getSettings('newuser_other_details'),
        ];

        return array_merge($arr,self::commonElements());
    }

    public static function newuser_dependants_details()
    {
        $arr = [
            'settings' => self::getSettings('newuser_dependants_details'),
        ];

        return array_merge($arr,self::commonElements());
    }

    public static function newuser_beneficiaries_details()
    {
        $arr = [
            'settings' => self::getSettings('newuser_beneficiaries_details'),
        ];

        return array_merge($arr,self::commonElements());
    }

    public static function newuser_emergency_details()
    {
        $arr = [
            'settings' => self::getSettings('newuser_emergency_details'),
        ];

        return array_merge($arr,self::commonElements());
    }

    public static function newuser_payment_details()
    {
        $arr = [
            'settings' => self::getSettings('newuser_payment_details'),
        ];

        return array_merge($arr,self::commonElements());
    }*/


    protected static function getSettings($page,$scope = null)
    {
        $scope = $scope ? $scope : $page;
        $settings = Setting::whereNotNull('active')->where('scope',$scope)->orWhere(function($query) {
            $query->where('scope','*')->whereNotNull('active');
        })->get();

        if( $page == 'profile_page' || $page == 'employee_registration' || 'newuser_basic_details'):
            $settings = self::addDisabilitiesToSettings($settings);
            $settings = self::addReligionToSettings($settings);
        endif;

        if( $page == 'onboard_page' ):
            $settings = self::addContractTypesToSettings($settings);
            $settings = self::addProbationTypesToSettings($settings);
        endif;


        return $settings;
    }

    protected static function commonElements()
    {
        return [
            'success' => session('success'),
            'error' => session('error'),
            'status' => session('status'),
        ];
    }


    protected static function addReligionToSettings($settings)
    {
        $religions = Constants::religions();
        
        foreach( $religions as $religion ){ 
            if( $settings->contains(function($setting,$key) use ($religion) { return $setting['name'] == $religion && $setting['value'] == 'religion'; } ) )
                continue;
            else
                $settings->push([ 'name' =>  $religion, 'value' => 'religion', 'active' => 1 ]);
        }
        return $settings;
    }

    protected static function addDisabilitiesToSettings($settings)
    {
        $disabilities = Constants::disabilities();
        
        foreach( $disabilities as $disability ){ 
            if( $settings->contains(function($setting,$key) use ($disability) { return $setting['name'] == $disability && $setting['value'] == 'disability'; } ) )
                continue;
            else
                $settings->push([ 'name' =>  $disability, 'value' => 'disability', 'active' => 1 ]);
        }
        return $settings;
    }

    protected static function addContractTypesToSettings($settings)
    {
        $contractTypes = Constants::contractTypes();
        
        foreach( $contractTypes as $type ){ 
            if( $settings->contains(function($setting,$key) use ($type) { return $setting['name'] == $type && $setting['value'] == 'contract_type'; } ) )
                continue;
            else
                $settings->push([ 'name' =>  $type, 'value' => 'contract_type', 'active' => 1 ]);
        }
        return $settings;
    }

    protected static function addProbationTypesToSettings($settings)
    {
        $probationTypes = Constants::probationTypes();
        
        foreach( $probationTypes as $type ){ 
            if( $settings->contains(function($setting,$key) use ($type) { return $setting['name'] == $type && $setting['value'] == 'contract_type'; } ) )
                continue;
            else
                $settings->push([ 'name' =>  $type, 'value' => 'probation_type', 'active' => 1 ]);
        }
        return $settings;
    }

    public static function form_fields($category, User $user = null)
    {
        $fields = FormField::where('active',1)->where('category',$category)->get();

        $predefinedFields = Fields::formFields($user);

        foreach( $predefinedFields as $field ){ 

            if( $field['category'] != $category ) continue;

            if( $fields->contains(function($setting,$key) use ($field) { return $setting['name'] == $field['name'] || $setting['field_id'] == $field['field_id']; } ) )
                continue;
            else
                $fields->push($field);
        }

        return $fields;


    }

}