<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <div class="container">
            <div class="section">
                <h1> 
                    <span class="fa fa-user-minus"></span> 
                    Offboard employee
                </h1>
            </div>
        <div class="tab-pane-content">
                
            <form @submit.prevent="save" class="border">
                <h1 class="title-border mb-3 pb-2"> 
                    <small class="fa fa-clipboard-list"></small>
                    Assign offboarding tasks
                    <small class="fa fa-question-circle cursor-pointer" title="Create a task and assign it to other employees to assist in onboarding new employee"></small>
                 </h1>
                <div v-if="success" class="mb-2 font-medium text-sm text-green-600 text-capitalize">{{success}}</div>
                <div v-if="error" class="mb-2 font-medium text-sm text-danger text-capitalize">{{error}}</div>
               
                <Tasks :employee="employee" :formFields="formFields" /> 
                
                <div class="flex items-center justify-end mt-3">
                    <Link :href="route('employees')" class="btn btn-sm btn-secondary mr-4"> <span class="fa fa-chevron-left"></span> Back</Link>
                    <Link :href="route('show.finish.offboarding.user', employee.id)" class="btn btn-sm btn-theme mr-4">  Continue</Link>                    
                </div>
            </form>
        </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
import AppHeader from '@/Components/AppHeader.vue';
import ProfileSidebar from '@/Components/ProfileSidebar.vue';
import Personal from '@/Components/Profile/Personal.vue';
import Job from '@/Components/Profile/Job.vue';
import BreezeInput from '@/Components/Input.vue';
import TextInput from '@/Components/TextInput.vue';
import AddressInput from '@/Components/AddressInput.vue';
import PhoneInput from '@/Components/PhoneInput.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeButton from '@/Components/Button.vue';
import SearchInput from '@/Components/SearchInput.vue';
import Tasks from '@/Components/Onboarding/Tasks.vue';

export default {
    props:{
        employee:Object,
        success: String,
        error: String,
        settings:Array,
        formFields:Array
    },
    components:{
    BreezeAuthenticatedLayout,
    Head,
    Link,
    AppHeader,
    ProfileSidebar,
    Personal,
    Job,
    TextInput,
    AddressInput,
    PhoneInput,
    BreezeLabel,
    BreezeButton,
    SearchInput,
        Tasks
},
    data: function(){
      return{
          name:this.employee.name ? this.employee.name : '',
          department_id:this.employee.department_id ? this.employee.department_id : '',
          contract_type:this.employee.contract_type ? this.employee.contract_type : '',
          probation_period:this.employee.probation_period ? this.employee.probation_period : '',
          employment_start_date:this.employee.employment_start_date ? this.employee.employment_start_date : '',
          reporting_date:this.employee.reporting_date ? this.employee.reporting_date : '',
          //settings:[],
          departments:[],
          contract_types:[],
          probation_types:[],
          errors:{},
          processing:false,
          user:this.$page.props.auth.user,
      }
    },
    methods:{
        getSetting(name,settings){
            let setting = '';
            for( let i = 0; i < settings.length; i ++ )
            {
                if( settings[i].name == name ){
                    setting = settings[i];
                    break;
                }
            }
            return setting;
        },
        update(response){
                let name = response.name
                let error = response.error
                let value = response.value
                this[name] = value;
                if( error ) this.errors[name] = error;
                else delete this.errors[name];
            },
        
        save(){         
             window.open('/onboard/step-four/'+this.newEmployee.username,'_self')
        },
        getFieldSettings(value,field){ 
            if( ! this.settings ) return false;
            if( ! Array.isArray( this.settings ) ) return false;

            for( let i = 0; i < this.settings.length; i++ )
                if( this.settings[i].value == value )
                    this[field].push( this.settings[i] )

        },
        capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        },
        selectDepartment(department){
            this.department_id = department.id
        }
    },
    mounted(){
        this.getFieldSettings('contract_type','contract_types')
        this.getFieldSettings('probation_type','probation_types')

    }
}
</script>
<style scoped>
.section{
    padding: 30px 0;
    border-bottom: 1px solid var(--grey);
}
.section h1{
    color: var(--theme-color);
}
form{
    margin: 25px auto;
    padding: 15px;
}
</style>