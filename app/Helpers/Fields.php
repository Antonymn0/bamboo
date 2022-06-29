<?php 
namespace App\Helpers;
use App\Helpers\Constants;
use App\Helpers\Utilities;
use App\Models\Department;
use App\Models\User;

class Fields 
{
    public static function formFields(User $user = null)
    { 
        $readonly = $user ? $user->reg_status == '0' && ! $user->can('edit_profile') ? true : false : false;
        return [
            /**Start Basic Details */
            [
                'name'=>'first_name',
                'field_id'=>'first_name',
                'label' => 'First Name',
                'type'=>'text',
                'min'=>3,
                'max'=>255,
                'category'=>'basic_details',
                'active'=>1,
                'parent_classes' => 'col-4',
                'menu_order' => 0,
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly
            ],
            [
                'name'=>'middle_name',
                'label' => 'Middle Name',
                'field_id'=>'middle_name',
                'type'=>'text',
                'min'=>3,
                'max'=>255,
                'category'=>'basic_details',
                'active'=>1,
                'parent_classes' => 'col-4',
                'menu_order' => 0,
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly
            ],
            [
                'name'=>'last_name',
                'label' => 'Surname',
                'placeholder' => 'Surname',
                'field_id'=>'last_name',
                'type'=>'text',
                'min'=>3,
                'max'=>255,
                'category'=>'basic_details',
                'active'=>1,
                'parent_classes' => 'col-4',
                'menu_order' => 0,
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
            ],
            [
                'name'=>'dob',
                'label'=>'Date of Birth',
                'field_id'=>'dob',
                'type'=>'date',
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'category'=>'basic_details',
                'active'=>1,
                'parent_classes' => 'col-4',
                'menu_order' => 0,
                'max' => now(),
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','dob')->value('value') : null : null
            ],
            [
                'name'=>'gender',
                'label'=>'Gender',
                'field_id'=>'gender',
                'type'=>'select',
                'category'=>'basic_details',
                'active'=>1,
                'parent_classes' => 'col-4',
                'menu_order' => 0,
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'options' => ['male','female'],
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','gender')->value('value') : null : null

            ],
            [
                'name'=>'marital_status',
                'label'=>'Marital Status',
                'field_id'=>'marital_status',
                'type'=>'select',
                'category'=>'basic_details',
                'active'=>1,
                'parent_classes' => 'col-4',
                'menu_order' => 0,
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'options' => Constants::maritalStatus(),
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','marital_status')->value('value') : null : null

            ],
            [
                'name'=>'religion',
                'label'=>'Religion',
                'field_id'=>'religion',
                'type'=>'select',
                'category'=>'basic_details',
                'active'=>1,
                'parent_classes' => 'col-4',
                'menu_order' => 0,
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'options' => Constants::religions(),
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','religion')->value('value') : null : null

            ],
            [
                'name'=>'national_id_no',
                'label'=>'National ID No.',
                'field_id'=>'national_id_no',
                'type'=>'text',
                'min'=>7,
                'max'=>8,
                'category'=>'basic_details',
                'active'=>1,
                'parent_classes' => 'col-4',
                'menu_order' => 0,
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','national_id_no')->value('value') : null : null

            ],
            [
                'name'=>'passport_no',
                'field_id'=>'passport_no',
                'label'=>'Passport No.',
                'type'=>'text',
                'min'=>3,
                //'max'=>8,
                'category'=>'basic_details',
                'active'=>1,
                'parent_classes' => 'col-4',
                'menu_order' => 0,
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','passport_no')->value('value') : null : null

            ],
            [
                'name'=>'huduma_no',
                'field_id'=>'huduma_no',
                'label'=>'Huduma No.',
                'type'=>'text',
                'min'=>7,
                'max'=>8,
                'category'=>'basic_details',
                'active'=>1,
                'parent_classes' => 'col-4',
                'menu_order' => 0,
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','huduma_no')->value('value') : null : null

            ],
            [
                'name'=>'kra_pin_no',
                'field_id'=>'kra_pin_no',
                'label'=>'KRA PIN No.',
                'type'=>'text',
                'min'=>11,
                'max'=>11,
                'category'=>'basic_details',
                'active'=>1,
                'parent_classes' => 'col-4',
                'menu_order' => 0,
                'classes' => 'text-uppercase',
                //'noSymbols' => '',
                //'noDigits' => '',
                //'noLetters' => '',
                'required' => true,
                'readonly' => $readonly,
                'krapin' => true,
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','kra_pin_no')->value('value') : null : null

            ],
            [
                'name'=>'nhif_no',
                'field_id'=>'nhif_no',
                'label'=>'NHIF No.',
                'type'=>'text',
                'min'=>7,
                'max'=>8,
                'category'=>'basic_details',
                'active'=>1,
                'parent_classes' => 'col-4',
                'menu_order' => 0,
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','nhif_no')->value('value') : null : null

            ],
            [
                'name'=>'nssf_no',
                'field_id'=>'nssf_no',
                'label'=>'NSSF No.',
                'type'=>'text',
                'min'=>7,
                'max'=>8,
                'category'=>'basic_details',
                'active'=>1,
                'parent_classes' => 'col-4',
                'menu_order' => 0,
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','nssf_no')->value('value') : null : null

            ],
            [
                'name'=>'driving_license_no',
                'label'=>'Driving License No.',
                'field_id'=>'driving_license_no',
                'type'=>'text',
                'category'=>'basic_details',
                'active'=>1,
                'parent_classes' => 'col-4',
                'menu_order' => 0,
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','driving_license_no')->value('value') : null : null

            ],
            [
                'name'=>'nationality',
                'field_id'=>'nationality',
                'label'=>'Nationality',
                'type'=>'select',
                'category'=>'basic_details',
                'active'=>1,
                'parent_classes' => 'col-4',
                'menu_order' => 0,
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'options' => Constants::nationalities(),
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','nationality')->value('value') : null : null

            ],
            [
                'name'=>'disability',
                'placeholder' => 'None',
                'field_id'=>'disability',
                'label'=>'Disability',
                'type'=>'select',
                'category'=>'basic_details',
                'active'=>1,
                'parent_classes' => 'col-4',
                'menu_order' => 0,
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'options' => Constants::disabilities(),
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','disability')->value('value') : null : null

            ],
            [
                'name'=>'disability_cert_no',
                'field_id'=>'disability_cert_no',
                'label'=>'Disability Cert No',
                'type'=>'text',
                'category'=>'basic_details',
                'active'=>1,
                'parent_classes' => 'col-4',
                'menu_order' => 0,
                'readonly' =>  $readonly,
                'visible_if' => 'disability',
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','disability_cert_no')->value('value') : null : null
            ],
            [
                'name'=>'disability_description',
                'field_id'=>'disability_description',
                'label'=>'Disability Description',
                'type'=>'content',
                'category'=>'basic_details',
                'active'=>1,
                'parent_classes' => 'col-8',
                'menu_order' => 0,
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'visible_if' => 'disability',
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','disability_description')->value('value') : null : null
            ],
            /**End Basic Details */

            /**Start Address Fields */

            [
                'name'=>'email',
                'field_id'=>'email',
                'label' => 'Email',
                'type'=>'email',
                'category'=>'address',
                'active'=>1,
                'parent_classes' => 'col-6',
                'menu_order' => 0,
                'required' => true,
                'modelid' => $user ? $user->id : '', 
                'unique' => true,
                'uniqueurl' => route('users.record.exists'),
            ],
            [
                'name'=>'phone',
                'field_id'=>'phone',
                'type'=>'phone',
                'category'=>'address',
                'active'=>1,
                'parent_classes' => 'col-6',
                'menu_order' => 0,
                'modelid' => $user ? $user->id : '', 
                'unique' => true,
                'uniqueurl' => route('users.record.exists'),
                'noSymbols' => true,
                'noLetters' => true,
                'required' => true,
            ],
            [
                'name'=>'postal_address',
                'field_id'=>'postal_address',
                'label'=>'Postal Address',
                'type'=>'text',
                'category'=>'address',
                'active'=>1,
                'parent_classes' => 'col-6',
                'menu_order' => 0,
                'noSymbols' => true,
                'noLetters' => true,
                'required' => true,
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','postal_address')->value('value') : null : null
            ],
            [
                'name'=>'postal_code',
                'label' => 'Postal Code',
                'field_id'=>'postal_code',
                'type'=>'postal_code',
                'category'=>'address',
                'active'=>1,
                'parent_classes' => 'col-6',
                'menu_order' => 0,
                'noSymbols' => true,
                'required' => true,
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','postal_code')->value('value') : null : null
            ],
            [
                'name'=>'city',
                'field_id'=>'city',
                'label' => 'City/Town',
                'type'=>'text',
                'category'=>'address',
                'active'=>1,
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'min' => 3,
                'parent_classes' => 'col-6',
                'menu_order' => 0,
                'noSymbols' => true,
                'required' => true,
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','city')->value('value') : null : null
            ],
            [
                'name'=>'estate_name',
                'field_id'=>'estate_name',
                'label'=>'Estate Name',
                'type'=>'text',
                'category'=>'address',
                'active'=>1,
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'parent_classes' => 'col-6',
                'menu_order' => 0,
                'noSymbols' => true,
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','estate_name')->value('value') : null : null
            ],
            [
                'name'=>'building_name',
                'field_id'=>'building_name',
                'label'=>'Building Name',
                'type'=>'text',
                'category'=>'address',
                'active'=>1,
                'parent_classes' => 'col-6',
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'menu_order' => 0,
                'noSymbols' => true,
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','building_name')->value('value') : null : null
            ],
            [
                'name'=>'house_number',
                'field_id'=>'house_number',
                'label'=>'House Number',
                'type'=>'text',
                'category'=>'address',
                'active'=>1,
                'parent_classes' => 'col-6',
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'menu_order' => 0,
                'noSymbols' => true,
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','house_number')->value('value') : null : null
            ],
            [
                'name'=>'physical_address',
                'field_id'=>'physical_address',
                'label'=>'Physical Address',
                'type'=>'text',
                'category'=>'address',
                'active'=>1,
                'parent_classes' => 'col-8',
                'menu_order' => 0,
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','physical_address')->value('value') : null : null
            ],
            /**End Address Fields */



            /**Start Onboard Step 1 Fields */

            [
                'name'=>'first_name',
                'label' => 'First Name',
                'field_id'=>'first_name',
                'type'=>'text',
                'min'=>3,
                'max'=>255,
                'category'=>'onboard_step_1',
                'active'=>1,
                'parent_classes' => 'col-6',
                'menu_order' => 0,
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'required' => true,

            ],
            [
                'name'=>'last_name',
                'field_id'=>'last_name',
                'label' => 'Surname',
                'placeholder' => 'Surname',
                'type'=>'text',
                'min'=>3,
                'max'=>255,
                'category'=>'onboard_step_1',
                'active'=>1,
                'parent_classes' => 'col-6',
                'menu_order' => 0,
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'required' => true,

            ],
            [
                'name'=>'email',
                'label' => 'Email',
                'field_id'=>'email',
                'type'=>'email',
                'category'=>'onboard_step_1',
                'active'=>1,
                'parent_classes' => 'col-6',
                'menu_order' => 0,
                'required' => true,
                'unique' => true,
                'uniqueurl' => route('users.record.exists')
            ],
            [
                'name'=>'phone',
                'field_id'=>'phone',
                'type'=>'phone',
                'label' => 'Phone',
                'placeholder' => 'Phone',
                'category'=>'onboard_step_1',
                'active'=>1,
                'parent_classes' => 'col-6',
                'menu_order' => 0,
                'noSymbols' => true,
                'noLetters' => true,
                'required' => true,
                'unique' => true,
                'min'=>9,
                'max'=>15,
                'uniqueurl' => route('users.record.exists') 
            ],
            /**End Onboard Step 1 Fields */

            
            /**Start Onboard Step 2 Fields */

            [
                'name'=>'department_slug',
                'label'=> 'Department',
                'field_id'=>'department_slug',
                'type'=>'select',
                'category'=>'onboard_step_2',
                'active'=>1,
                'parent_classes' => 'col-6',
                'menu_order' => 0,
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'options' => Utilities::getAtleastOneDepartment(),
                'init_val' => $user ? $user->department ? $user->department->slug : null : null,
                'required' => true,
            ],

            [
                'name'=>'staff_id',
                'label'=> 'Staff ID',
                'placeholder'=> 'Staff ID',
                'field_id'=>'staff_id',
                'type'=>'text',
                'category'=>'onboard_step_2',
                'active'=>1,
                'parent_classes' => 'col-6',
                'menu_order' => 0,
                'required' => true,
                'unique' => true,
                'uniqueurl' => route('usermeta.exists'),
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','staff_id')->value('value') : null : null

            ],

            [
                'name'=>'position',
                'label'=> 'Position',
                'placeholder' => 'E.g. Finance manager, Accountant',
                'field_id'=>'position',
                'type'=>'text',
                'category'=>'onboard_step_2',
                'active'=>1,
                'parent_classes' => 'col-6',
                'classes' => 'text-capitalize',
                'menu_order' => 0,
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','position')->value('value') : null : null

            ],

            [
                'name'=>'grade',
                'label'=> 'Job Group/ Grade',
                'placeholder' => 'E.g. Job group M',
                'field_id'=>'grade',
                'type'=>'text',
                'category'=>'onboard_step_2',
                'active'=>1,
                'parent_classes' => 'col-6',
                'classes' => 'text-capitalize',
                'menu_order' => 0,
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','grade')->value('value') : null : null

            ],

            [ //list periods 1,2,3,4,5,4
                'name'=>'probation_period',
                'placeholder' => 'None',
                'label' => 'Probation Period',
                'field_id'=>'probation_period',
                'type'=>'select',
                'category'=>'onboard_step_2',
                'active'=>1,
                'parent_classes' => 'col-6',
                'menu_order' => 0,
                'required' => true,
                'options' => Constants::probationTypes(),
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','probation_period')->value('value') : null : null

            ],

            [//permanent no end date
                'name'=>'contract_type',
                'label' => 'Contract Type',
                'field_id'=>'contract_type',
                'type'=>'select',
                'category'=>'onboard_step_2',
                'active'=>1,
                'parent_classes' => 'col-6 toggler',
                'menu_order' => 0,
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'options' => Constants::contractTypes(),
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','contract_type')->value('value') : null : null,
            ],

            [
                'name'=>'contract_start_date',
                'label' => 'Contract Start Date',
                'field_id'=>'contract_start_date',
                'type'=>'date',
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'category'=>'onboard_step_2',
                'active'=>1,
                'parent_classes' => 'col-6',
                'menu_order' => 0,
                'set_minimums' => ['contract_end_date','reporting_date'],
                'min' => now(),
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','contract_start_date')->value('value') : null : null

            ],

            [
                'name'=>'contract_end_date',
                'label' => 'Contract End Date',
                'field_id'=>'contract_end_date',
                'type'=>'date',
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'category'=>'onboard_step_2',
                'active'=>1,
                'parent_classes' => 'col-6 toggle_invisibility not_visible_if_contract_type_permanent',
                'menu_order' => 0,
                'min' => $user ? $user->meta ? $user->meta()->where('key','contract_start_date')->value('value') : now() : now(),
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','contract_end_date')->value('value') : null : null,
                'not_visible_if' => 'contract_type',
                'visible_criteria_value' => 'permanent'
            ],

            [
                'name'=>'reporting_date',
                'label' => 'Reporting Date',
                'field_id'=>'reporting_date',
                'type'=>'date',
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'category'=>'onboard_step_2',
                'active'=>1,
                'min' => now(),
                'parent_classes' => 'col-6',
                'menu_order' => 0,
                'init_val' => $user ? $user->meta ? $user->meta()->where('key','reporting_date')->value('value') : null : null
            ],

            [
                'name'=>'reports_to',
                'label' => 'Reports to',
                'field_id'=>'reports_to',
                'placeholder' => 'Search employee...',
                'type'=>'search',
                'category'=>'onboard_step_2',
                'active'=>1,
                'parent_classes' => 'col-6',
                'menu_order' => 0,
                'searchmodel' => 'user',
                'searchurl' => '/v1/users/search'
            ],

            

            /**End Onboard Step 2 Fields */


            /**Start Onboard Step 3 Fields */
            [
                'name'=>'name',
                'label'=> 'Choose tasks',
                'placeholder'=>'Click to choose...',
                'field_id'=>'name',
                'type'=>'multiselect',
                'category'=>'onboard_step_3',
                'active'=>1,
                'parent_classes' => 'col-9',
                'menu_order' => 0,
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'options' => Constants::onboardingTasks(),
            ],
            [
                'name'=>'more_tasks',
                'label'=> 'More tasks',
                'placeholder' => 'E.g. Task A, Task B',
                'field_id'=>'more_tasks',
                'type'=>'text',
                'category'=>'onboard_step_3',
                'active'=>1,
                'parent_classes' => 'col-8',
                'menu_order' => 0,
            ],
            [
                'name'=>'assigned_to',
                'label' => 'Assigned to',
                'field_id'=>'assigned_to',
                'placeholder' => 'Assigned to',
                'type'=>'search',
                'category'=>'onboard_step_3',
                'active'=>1,
                'parent_classes' => 'col-4',
                'menu_order' => 0,
                'searchmodel' => 'user',
                'searchurl' => '/v1/users/search'
            ],
            [
                'name'=>'due_date',
                'field_id'=>'due_date',
                'label' => 'Due Date',
                'type'=>'date',
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'category'=>'onboard_step_3',
                'active'=>1,
                'min' => now(),
                'parent_classes' => 'col-6',
                'menu_order' => 0,
            ],
            [
                'name'=>'due_time',
                'field_id'=>'due_time',
                'type'=>'time',
                'category'=>'onboard_step_3',
                'active'=>1,
                'parent_classes' => 'col-6',
                'menu_order' => 0,
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,

            ],
            [
                'name'=>'description',
                'field_id'=>'description',
                'label'=>'Description',
                'placeholder' => 'Describe the task',
                'type'=>'content',
                'category'=>'onboard_step_3',
                'active'=>1,
                'parent_classes' => 'col-12',
                'menu_order' => 0,
            ],
            /**End Onboard Step 3 Fields */

            /**Start Assign Assets Fields */
            [
                'name'=>'type',
                'field_id'=>'type',
                'type'=>'select',
                'category'=>'assign_assets',
                'active'=>1,
                'parent_classes' => 'col-6 toggler',
                'menu_order' => 0,
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'options' => Constants::assignedAssets(),
                'required' => true,
            ],

            [
                'name'=>'make',
                'placeholder'=>'E.g. Toyota',
                'field_id'=>'make',
                'type'=>'text',
                'category'=>'assign_assets',
                'active'=>1,
                'parent_classes' => 'col-6 toggle_visibility visible_if_type_motor_vehicle',
                'menu_order' => 0,
                'noSymbols' => true,
                'noDigits' => true,
                'required' => true,
                'visible_if' => 'type',
                'visible_criteria_value' => 'motor_vehicle'
            ],

            [
                'name'=>'model',
                'placeholder'=>'E.g. Belta',
                'field_id'=>'model',
                'type'=>'text',
                'category'=>'assign_assets',
                'active'=>1,
                'parent_classes' => 'col-6 toggle_visibility visible_if_type_motor_vehicle',
                'menu_order' => 0,
                'noSymbols' => true,
                'noDigits' => true,
                'required' => true,
                'visible_if' => 'type',
                'visible_criteria_value' => 'motor_vehicle'
            ],

            [
                'name'=>'reg_no',
                'label' => 'Reg No.',
                'field_id'=>'reg_no',
                'type'=>'text',
                'category'=>'assign_assets',
                'active'=>1,
                'parent_classes' => 'col-6 toggle_visibility visible_if_type_motor_vehicle',
                'menu_order' => 0,
                'noSymbols' => true,
                'classes' => 'text-uppercase',
                'visible_if' => 'type',
                'visible_criteria_value' => 'motor_vehicle'
            ],

            [
                'name'=>'engine_capacity',
                'placeholder'=>'E.g. 1500cc',
                'label' => 'Engine Capacity.',
                'field_id'=>'engine_capacity',
                'type'=>'text',
                'category'=>'assign_assets ',
                'active'=>1,
                'parent_classes' => 'col-6 toggle_visibility visible_if_type_motor_vehicle',
                'menu_order' => 0,
                'visible_if' => 'type',
                'visible_criteria_value' => 'motor_vehicle'
            ],

            [
                'name'=>'mileage',
                'placeholder'=>'E.g. 8000',
                'label' => 'Mileage (KM)',
                'field_id'=>'mileage',
                'type'=>'text',
                'category'=>'assign_assets',
                'active'=>1,
                'parent_classes' => 'col-6 toggle_visibility visible_if_type_motor_vehicle',
                'menu_order' => 0,
                'noSymbols' => true,
                'noLetters' => true,
                'required' => true,
                'visible_if' => 'type',
                'visible_criteria_value' => 'motor_vehicle'
            ],

            [
                'name'=>'serial_no',
                'placeholder'=>'Serial No.',
                'field_id'=>'serial_no',
                'type'=>'text',
                'category'=>'assign_assets',
                'active'=>1,
                'parent_classes' => 'col-6 toggle_visibility visible_if_type_computer',
                'menu_order' => 0,
                'noSymbols' => true,
                'required' => true,
                'visible_if' => 'type',
                'visible_criteria_value' => 'computer',
            ],

            [
                'name'=>'computer_type',
                'label' => 'Type',
                'field_id'=>'computer_type',
                'type'=>'select',
                'category'=>'assign_assets',
                'active'=>1,
                'parent_classes' => 'col-6 toggle_visibility visible_if_type_computer',
                'menu_order' => 0,
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'noSymbols' => true,
                'required' => true,
                'visible_if' => 'type',
                'visible_criteria_value' => 'computer',
                'options' => Constants::computerTypes(),
            ],

            [
                'name'=>'brand',
                'field_id'=>'brand',
                'type'=>'text',
                'category'=>'assign_assets',
                'active'=>1,
                'parent_classes' => 'col-6 toggle_visibility visible_if_type_computer',
                'menu_order' => 0,
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'noSymbols' => true,
                'required' => true,
                'visible_if' => 'type',
                'visible_criteria_value' => 'computer'
            ],

            [
                'name'=>'description',
                'field_id'=>'description',
                'type'=>'text',
                'category'=>'assign_assets',
                'active'=>1,
                'parent_classes' => 'col-6',
                'classes' => 'text-capitalize',
                'menu_order' => 0,
            ],


            [
                'name'=>'start_date',
                'label' => 'Start Date',
                'field_id'=>'start_date',
                'type'=>'date',
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'category'=>'assign_assets',
                'active'=>1,
                'parent_classes' => 'col-6',
                'menu_order' => 0,
                'required' => true,
                'set_minimums' => ['end_date'],

            ],


            [
                'name'=>'end_date',
                'label' => 'End Date',
                'field_id'=>'end_date',
                'type'=>'date',
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
                'category'=>'assign_assets',
                'active'=>1,
                'parent_classes' => 'col-6',
                'menu_order' => 0,
            ],

            

            /**End Assign Assets Fields */


            /**Add Assign Benefits fields */
            [
                'name'=>'name',
                'label'=> 'Choose a Benefit',
                'placeholder'=>'Choose a Benefit...',
                'field_id'=>'name',
                'type'=>'select',
                'category'=>'activate_employee',
                'active'=>1,
                'parent_classes' => 'col-6',
                'menu_order' => 0,
                'noSymbols' => true,
                'noDigits' => true,
                'required' => true,
                'readonly' =>  $readonly,
                'options' => Constants::employeeBenefits(),
            ],

            [
                'name'=>'amount',
                'label'=> 'Benefit amount',
                'placeholder'=>'Enter benefit amount...',
                'field_id'=>'amount',
                'type'=>'text',
                'category'=>'activate_employee',
                'active'=>1,
                'parent_classes' => 'col-6',
                'menu_order' => 0,
                'noSymbols' => true,
                'noLetters' => true,
                'required' => true,
                'classes' => 'text-capitalize',
                'readonly' =>  $readonly,
            ],

            /*[
                'name'=>'other_benefit',
                'placeholder'=>'Specify Benefit',
                'label'=>'Specify Benefit',
                'field_id'=>'other_benefit',
                'type'=>'text',
                'category'=>'activate_employee',
                'active'=>1,
                'parent_classes' => 'col-4',
                'menu_order' => 0,
                'noSymbols' => true,
                'noDigits' => true,
                'required' => true,
                'visible_if' => 'name',
                'visible_criteria_value' => 'other'
            ],*/
            /**End Assign Benefits fields */


            

        ];
    }
}