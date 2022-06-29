<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <div class="container">
            <div class="section">
                <h1> 
                    <span class="fa fa-user-plus"></span> 
                    {{settings ? getSetting('onboarding_page_two_title',settings).value ? getSetting('onboarding_page_two_title',settings).value : 'New Employee' : 'New Employee'}}
                </h1>
            </div>
        <div class="tab-pane-content" id="nogo">
            <form @submit.prevent="save" class="border">
                <h1 class="title-border mb-4 pb-2"> 
                    <small class="fa fa-briefcase"></small>
                    {{settings ? getSetting('onboarding_page_two_sub_title',settings).value ? getSetting('onboarding_page_two_sub_title',settings).value : 'Employee Job' : 'Employee Job'}}
                 </h1>
                <div v-if="success" class="mb-2 font-medium text-sm text-green-600 text-capitalize">{{success}}</div>
                <div v-if="error" class="mb-2 font-medium text-sm text-danger text-capitalize">{{error}}</div>
                
                <div class="row">
                    <div class="mb-4" v-for="(field,count) in fields_arr" :key="count" :class="[field.parent_classes ? field.parent_classes : 'col-4', showParent( field,newEmployee )]" :id="field.name+'_parent'">
                  
                        <DateInput v-if="field.type == 'date'"  :setMinimums="field.set_minimums"   :label="field.label" :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max"  :required="field.required" :unique="field.unique" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : newEmployee[field.name]" :modelid="newEmployee.id" :category="field.category"/>
                        <SelectInput v-else-if="field.type == 'select' && field.options" :label="field.label" :options="field.options"  :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="field.placeholder ? field.placeholder : 'Choose...'"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : newEmployee[field.name]" :modelid="newEmployee.id" :category="field.category"/>
                        <ContentInput v-else-if="field.type == 'content'" :label="field.label" :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max"  :required="field.required" :unique="field.unique" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : newEmployee[field.name]" :modelid="newEmployee.id" :category="field.category"/>
                        <PhoneInput v-else-if="field.type == 'phone'" :label="field.label" :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max"  :required="field.required" :unique="field.unique" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : newEmployee[field.name]" :modelid="newEmployee.id" :category="field.category"/>
                        <TimeInput v-else-if="field.type == 'time'" :label="field.label" :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" :krapin="field.krapin" :noDigits="field.noDigits" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : task[field.name]" :modelid="employee.id" v-on:changed="update"  :category="field.category"/>
                        <AddressInput v-else-if="field.type == 'address'" sync :syncurl="'/v1/users/'+this.user.id" :label="field.label" :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" :krapin="field.krapin" :noDigits="field.noDigits" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : user[field.name]" :modelid="user.id" v-on:changed="update"  :category="field.category"/>
                       
                        <SearchInput v-else-if="field.type == 'search'" :label="field.label ? field.label : field.name" modeltype="user" :searchurl="field.searchurl"  :noSymbols="true" :placeholder="settings ? getSetting('onboarding_assigned_to_label',settings).value ? getSetting('onboarding_assigned_to_label',settings).value : 'Search Employee...' : 'Search Employee...'" :name="field.name" :id="field.id" :type="field.type" classes="form-control text-capitalize" :class="{'border-danger':errors.assigned_to}" required v-on:selection="selectUser" :initVal="getSupervisorName()"  :category="field.category"/>
                       
                       <TextInput v-else  :label="field.label" :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" :krapin="field.krapin" :noDigits="field.noDigits" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : newEmployee[field.name]" :modelid="newEmployee.id" :category="field.category"/>
                    </div>
                </div>
                
                
                
                <div class="flex items-center justify-end mt-3">
                    <Link :href="route('onboard',newEmployee.username)" class="btn btn-sm btn-secondary mr-4"> <span class="fa fa-chevron-left"></span> Back</Link>
                    <BreezeButton class="ml-4" :class="{ 'opacity-25': processing || Object.keys(errors).length }" :disabled="processing || Object.keys(errors).length">
                       <span v-if="processing" class="fa fa-spinner fa-spin"></span>&nbsp; Continue 
                    </BreezeButton>
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
import AddressInput from '@/Components/AddressInput.vue';
import PhoneInput from '@/Components/PhoneInput.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeButton from '@/Components/Button.vue';
import SearchInput from '../../Components/SearchInput.vue';
import TextInput from '@/Components/TextInput.vue';
import DateInput from '@/Components/DateInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import ContentInput from '@/Components/ContentInput.vue';
import moment from 'moment';
import StatusIcon from '@/Components/Profile/Sections/Components/StatusIcon.vue';
import TimeInput from '@/Components/TimeInput.vue';

export default {
    props:{
        newEmployee:Object,
        success: String,
        error: String,
        settings:Array,
        formFields:Array,
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
    DateInput,
    SelectInput,
    ContentInput,
    StatusIcon,
    TimeInput
},
    data: function(){
      return{
          /*staff_id:this.newEmployee.staff_id ? this.newEmployee.staff_id : '',
          department_id:this.newEmployee.department_id ? this.newEmployee.department_id : '',
          contract_type:this.newEmployee.contract_type ? this.newEmployee.contract_type : '',
          probation_period:this.newEmployee.probation_period ? this.newEmployee.probation_period : '',
          //employment_start_date:this.newEmployee.employment_start_date ? this.newEmployee.employment_start_date : '',
          reporting_date:this.newEmployee.reporting_date ? this.newEmployee.reporting_date : '',
          contract_start_date:this.newEmployee.contract_start_date ? this.newEmployee.contract_start_date : '',
          contract_end_date:this.newEmployee.contract_end_date ? this.newEmployee.contract_end_date : '',*/
          //settings:[],
          departments:[],
          contract_types:[],
          probation_types:[],
          errors:{},
          loading:{},
          processing:false,
          user:this.$page.props.auth.user,
          fields_arr:this.formFields ? this.formFields : [],
          age:'',

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
                this.toggleFieldVisibility(name,value)
            },
        
        save(){
            //if( ! this.validate() ) return;

            this.processing = true
            let fields = {
                id:this.newEmployee ? this.newEmployee.id : '',
                registered_by:this.registered_by,
            }
            for( let i = 0; i < this.fields_arr.length; i ++  ){
                let field = this.fields_arr[i]
                if( this[field.name] )
                    fields[field.name] = this[field.name]
            }

            axios({
                method: 'post',
                url: '/v1/onboard/2',
                data:fields,
                }).then((response) => {
                    //console.log(response.data  == 1 )
                   // alert( "A link has been sent to "+this.newEmployee.staff_id+" that will allow registration to continue" )
                    window.open('/onboard/step-three/'+this.newEmployee.username,'_self')
                    this.processing = false
                })
                .catch( (error) => {
                console.log(error.response);
            });
        },
        getDepartments(){
            axios({
                method: 'GET',
                url: '/v1/departments',
                data: {
                   
                }
                }).then((response) => {
                   // console.log( response.data )
                   this.departments = response.data.data
                })
                .catch( (error) => {
                console.log(error.response);
            });
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
        },
        getSupervisorName(){
            if( this.newEmployee.supervisor )
                return this.newEmployee.supervisor.first_name+' '+this.newEmployee.supervisor.last_name;
            return '';
        },
        validate(){

            /*if( ! this.department_id ) this.errors.department_id = 'Required';
            else delete this.errors.department_id;

            if( ! this.staff_id ) this.errors.staff_id = 'Required';
            else delete this.errors.staff_id

            if( ! this.contract_type ) this.errors.contract_type = 'Required';
            else delete this.errors.contract_type

            if( ! this.contract_start_date ) this.errors.contract_start_date = 'Required';
            else delete this.errors.contract_start_date

            if( ! this.contract_end_date && this.contract_type != 'permanent') this.errors.contract_end_date = 'Required';
            else delete this.errors.contract_end_date

            return Object.keys(this.errors).length ? false : true;*/


        },
        formartWords(slug){
            return slug ? slug.toString().replace(/[^a-zA-Z0-9,. ]/g,' ') : slug;
        },
        calcAge(dob){
            let bday = moment(dob);
            let now = moment();

            this.age =  now.diff(bday,'years');
        },
        setLoading(response){
            let name = response.name
            let value = response.value
            this.loading[name] = value;
            if( value ) this.loading[name] = value;
            else delete this.loading[name];
        },
        toggleFieldVisibility(id,value){
            if( ! $( "#"+id+"_parent" ).hasClass('toggler') )return;

            let selector = '.visible_if_'+id+'_'+value;
            let selector2 = '.not_visible_if_'+id+'_'+value;

            if( $(selector).length )
                $(selector).removeClass('d-none')
            else 
                $('.toggle_visibility').addClass('d-none')

 
            if( $(selector2).length )
                $(selector2).addClass('d-none')
            else 
                $('.toggle_invisibility').removeClass('d-none')
                    

        },
        showParent(field,user){

            if( field.visible_if && user[field.visible_if] == field.visible_criteria_value )
                return ''
            else if( field.not_visible_if ) {
                let value = user[field.not_visible_if] ? user[field.not_visible_if] : this.getUserMeta(user.meta,field.not_visible_if);
                return field.not_visible_if && field.visible_criteria_value == value ? 'd-none' : '';
            }
            else return ''           
        },
        getUserMeta(metaData,key){
            let value = '';
            for(let i = 0; i < metaData.length; i++ ){
                if( metaData[i].key == key.toString() ){
                    value = metaData[i].value
                    break;
                }
            }
            return value;
        },
        selectUser(user){
            axios({
                method: 'PATCH',
                url: '/v1/users/'+this.newEmployee.id,
                data: {
                    field:'reports_to',
                    value:user.id,
                }
                }).then((response) => {
                    //console.log( response.data )
                })
                .catch( (error) => {
                console.log(error.response);
            });
        },
    },
   
    mounted(){
        this.getFieldSettings('contract_type','contract_types')
        this.getFieldSettings('probation_type','probation_types')
        this.getDepartments()
        //console.log(this.newEmployee)

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