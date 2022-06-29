<template>
    <Head title="Dashboard"  />

    <BreezeAuthenticatedLayout>
        <div class="container">
            <div class="section">
                <h1> 
                    <span class="fa fa-user-plus"></span> 
                    {{settings ? getSetting('onboarding_page_one_title',settings).value ? getSetting('onboarding_page_one_title',settings).value : 'New Employee' : 'New Employee'}}
                </h1>
            </div>
        <div class="tab-pane-content">
    
            <form @submit.prevent="save" class="border">
                <h1 class="title-border mb-4 pb-2"> 
                    <small class="fa fa-id-card"></small>
                    {{settings ? getSetting('onboarding_page_two_sub_title',settings).value ? getSetting('onboarding_page_two_sub_title',settings).value : 'Employee Basic Details' : 'Employee Basic Details'}}  
                </h1>
                <div v-if="success" class="mb-2 font-medium text-sm text-green-600 text-capitalize">{{success}}</div>
                <div v-if="error" class="mb-2 font-medium text-sm text-danger text-capitalize">{{error}}</div>
                <div class="row">


                    <div class="mb-4" v-for="(field,count) in fields_arr" :key="count" :class="[field.parent_classes ? field.parent_classes : 'col-4', (field.visible_if && user[field.visible_if]) || ! field.visible_if ? 'd-block' : 'd-none']" :id="field.name+'_parent'">
                        <!--<label :for="field.name" class="text-capitalize"> 
                            <StatusIcon :showLoading="loading[field.name]"    :category="field.category"/> 
                            {{formartWords(field.label ? field.label : field.name)}}
                            <small v-if="age && field.name == 'dob'" class="text-theme">Age: {{age}} Year<span v-if="age > 1">s</span></small>
                            <small class="text-danger"> {{errors[field.name]}} </small>
                        </label>-->
                        <DateInput v-if="field.type == 'date'"  :classes="field.classes" :id="field.field_id" :name="field.name" :label="field.label" :type="field.type" :min="field.min"  :max="field.max"  :required="field.required" :unique="field.unique" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : newEmployee[field.name]" :modelid="newEmployee.id" :category="field.category"/>
                        <SelectInput v-if="field.type == 'select' && field.options" :options="field.options"  :classes="field.classes" :id="field.field_id" :name="field.name" :label="field.label" :type="field.type" :min="field.min"  :max="field.max" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" placeholder="Choose..."  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : newEmployee[field.name]" :modelid="newEmployee.id" :category="field.category"/>
                        <ContentInput v-else-if="field.type == 'content'"  :classes="field.classes" :id="field.field_id" :name="field.name" :label="field.label" :type="field.type" :min="field.min"  :max="field.max"  :required="field.required" :unique="field.unique" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : newEmployee[field.name]" :modelid="newEmployee.id" :category="field.category"/>
                        <PhoneInput v-else-if="field.type == 'phone'"  :classes="field.classes" :id="field.field_id" :name="field.name" :label="field.label" :type="field.type" :min="field.min"  :max="field.max"  :required="field.required" :unique="field.unique" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : newEmployee[field.name]" :modelid="newEmployee.id" :category="field.category"/>
                        <TimeInput v-else-if="field.type == 'time'"  :classes="field.classes" :id="field.field_id" :name="field.name" :label="field.label" :type="field.type" :min="field.min"  :max="field.max" :krapin="field.krapin" :noDigits="field.noDigits" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : task[field.name]" :modelid="employee.id" v-on:changed="update"  :category="field.category"/>
                        <AddressInput v-else-if="field.type == 'address'" sync :syncurl="'/v1/users/'+this.user.id" :classes="field.classes" :id="field.field_id" :name="field.name" :label="field.label" :type="field.type" :min="field.min"  :max="field.max" :krapin="field.krapin" :noDigits="field.noDigits" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : user[field.name]" :modelid="user.id" v-on:changed="update"  :category="field.category"/>
                        <TextInput v-else  :classes="field.classes" :id="field.field_id" :name="field.name" :label="field.label" :type="field.type" :min="field.min"  :max="field.max" :krapin="field.krapin" :noDigits="field.noDigits" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : newEmployee[field.name]" :modelid="newEmployee.id" :category="field.category"/>
                    </div>

                </div>

                <div class="flex items-center justify-end">
                    <BreezeButton class="ml-4" :class="{ 'opacity-25': processing || Object.keys(errors).length }" :disabled="processing || Object.keys(errors).length">
                       <span v-if="processing" class="fa fa-spinner fa-spin"></span>&nbsp; Continue &nbsp;<span class="fa fa-chevron-right"></span>
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
import TextInput from '@/Components/TextInput.vue';
import AddressInput from '@/Components/AddressInput.vue';
import PhoneInput from '@/Components/PhoneInput.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeButton from '@/Components/Button.vue';
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
        DateInput,
        SelectInput,
        ContentInput,
        BreezeLabel,
        BreezeButton,
        StatusIcon,
        TimeInput
    },
    data: function(){
      return{
        //   first_name:this.newEmployee ? this.newEmployee.first_name : '',
          last_name:this.newEmployee ? this.newEmployee.last_name : '',
          email:this.newEmployee ? this.newEmployee.email : '',
          phone:this.newEmployee ? this.newEmployee.phone : '',
          registered_by:this.$page.props.auth.user.id,
          settings:[],
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
            },
        
        save(){
            
            if(  Object.keys(this.loading).length ) return;

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
                url: '/v1/onboard/1',
                data: fields,
                }).then((response) => {
                    if(response.data.id)
                        window.open('/onboard/step-two/'+response.data.username,'_self')
                    this.processing = false
                })
                .catch( (error) => {
                console.log(error.response);
            });
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
    },
    mounted(){
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