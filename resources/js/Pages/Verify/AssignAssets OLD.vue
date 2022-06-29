<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout :hideNavItems="true">
        <app-header :user="newEmployee"  />
    <div class="container-fluid profile">
        <div class="row">
            <div class="col-3 profile-panel">
                <RegistrationSidebar :user="newEmployee" />
            </div>
            <div class="col-9">
                <nav>
                   <div style="margin-top:-40px" class="nav nav-tabs" id="nav-tab" role="tablist">
                        <Link class="nav-link active"  href="#" >Assign Assets</Link>
                    </div>
                </nav>

                <div class="tab-pane-content verification-content" style="padding:15px" >
                    <form>
                        <h1 class="title-border"> 
                            <span class="fa fa-info-circle"></span> 
                            Asset information 
                        </h1>
                        <div class="row g-3 mt-2">
                            <div v-for="(field,count) in fields_arr" :key="count" :class="[field.parent_classes ? field.parent_classes : 'col-4', (field.visible_if && newEmployee[field.visible_if]) || ! field.visible_if ? 'd-block' : 'd-none']" :id="field.name+'_parent'">
                                <label :for="field.name" class="text-capitalize"> 
                                    {{field.label ? field.label : formartWords( field.name )}}
                                    <small v-if="age && field.name == 'dob'" class="text-theme">Age: {{age}} Year<span v-if="age > 1">s</span></small>
                                    <small class="text-danger"> {{errors[field.name]}} </small>
                                </label>
                                <DateInput v-if="field.type == 'date'" sync :syncurl="'/v1/assign-asset/'+newEmployee.id" :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" :noDigits="field.noDigits" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :required="field.required" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val :newEmployee[field.name]" :category="field.category" />
                                <SelectInput v-else-if="field.type == 'select' && field.options" :options="field.options" sync :syncurl="'/v1/assign-asset/'+newEmployee.id" :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :noDigits="field.noDigits" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :type="field.type" :min="field.min"  :max="field.max" :required="field.required" :placeholder="formartWords(field.placeholder ? field.placeholder : 'Choose...')"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val :newEmployee[field.name]" :category="field.category" />
                                <ContentInput v-else-if="field.type == 'content'" sync :syncurl="'/v1/assign-asset/'+newEmployee.id" :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :type="field.type" :min="field.min" :noDigits="field.noDigits" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :max="field.max"  :required="field.required" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val :newEmployee[field.name]" :category="field.category" />
                                <PhoneInput v-else-if="field.type == 'phone'" sync :syncurl="'/v1/assign-asset/'+newEmployee.id" :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :type="field.type" :min="field.min"  :noDigits="field.noDigits" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :max="field.max"  :required="field.required" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val :newEmployee[field.name]" :category="field.category" />
                                <TimeInput v-else-if="field.type == 'time'"  :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" :krapin="field.krapin" :noDigits="field.noDigits"  :noLetters="field.noLetters" :noSymbols="field.noSymbols" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : task[field.name]" :modelid="employee.id" v-on:changed="update"  :category="field.category" />
                                <AddressInput v-else-if="field.type == 'address'" sync :syncurl="'/v1/assign-asset/'+newEmployee.id" :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max"  :krapin="field.krapin" :noDigits="field.noDigits" :noLetters="field.noLetters" :noSymbols="field.noSymbols" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val :newEmployee[field.name]" :modelid="newEmployee.id" v-on:changed="update"  :category="field.category" />
                                <TextInput v-else sync :syncurl="'/v1/assign-asset/'+newEmployee.id" :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :type="field.type"  :min="field.min"  :max="field.max" :krapin="field.krapin" :noDigits="field.noDigits" :noLetters="field.noLetters" :noSymbols="field.noSymbols" :required="field.required" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val :newEmployee[field.name]" :category="field.category"/>
                            </div>
                        </div>
                    </form>

                <form class="border-top pt-2 pb-2 mt-2 bg-light" id="submit-form" :action="route('employee.submit',newEmployee.username)">
                    <a href="#" @click.prevent="submit" class="btn btn-theme">Submit</a>

                    <Link @click.prevent="continueLater()" class="ml-4" >
                            Save and continue later 
                    </Link>
                </form>
                </div>

        </div>
    </div>
    </div>
        
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
import AppHeader from '@/Components/AppHeader.vue';
import RegistrationSidebar from '@/Components/RegistrationSidebar.vue';
import Personal from '@/Components/Profile/Personal.vue';
import Job from '@/Components/Profile/Job.vue';
import Leave from '@/Components/Profile/Leave.vue';
import Benefits from '@/Components/Profile/Benefits.vue';
import Assets from '@/Components/Profile/Assets.vue';
import Emergency from '@/Components/Profile/Emergency.vue';
import BreezeButton from '@/Components/Button.vue';
import Basic from '@/Components/Profile/Sections/Basic.vue';
import Tabs from '@/Components/Tabs.vue';
import TextInput from '@/Components/TextInput.vue';
import DateInput from '@/Components/DateInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import ContentInput from '@/Components/ContentInput.vue';
import PhoneInput from '@/Components/PhoneInput.vue';
import TimeInput from '@/Components/TimeInput.vue';
import AddressInput from '@/Components/AddressInput.vue';

import moment from 'moment';

export default {
    props:{
        newEmployee:Object,
        task:Object,
        settings:Array,
        formFields:Array,
    },
    data: function(){
      return{
          processing:false,
          metaData:[],
          per_page:10,
          age:'',
          current_page:1,
          last_page:null,
          next_page:null,
          loading:{},
          errors:{},
          fields_arr:this.formFields ? this.formFields : [],
      }
    },
    components:{
        BreezeAuthenticatedLayout,
        Head,
        Link,
        AppHeader,
        RegistrationSidebar,
        Personal,
        Job,
        Leave,
        Benefits,
        Assets,
        Emergency,
        BreezeButton,
        Basic,
        Tabs,
        TextInput,
        DateInput,
        SelectInput,
        ContentInput,
        PhoneInput,
        TimeInput,
        AddressInput
    },
    methods:{
        save(){
            if( confirm("Are you sure you want to submit details?") )
                $("#submit-form").submit()
        },
        continueLater(){
            alert("Details saved successfully. You can close the window and continue later")
        },
        getUserMeta(page=1){
            //this.loading = true
            axios({
                method: 'get',
                url: '/v1/user-meta/'+this.newEmployee.id+'?category=basic_details&per_page='+this.per_page+'&page='+page,
                data: {
                }
                }).then((response) => {
                    this.metaData = [...this.metaData, ...response.data.data] 
                    this.current_page = response.data.current_page
                    this.last_page = response.data.last_page
                    this.next_page = this.last_page > this.current_page + 1 ? this.current_page + 1 : this.last_page
                    //this.loading= false
                })
                .catch( (error) => {
                console.log(error.response);
            });
        },
        updateUser(name,value,type=null,target=null){
            if( ! confirm("Are you sure you want to proceed?") ){
                //if( type == 'current_time' )
                    target.checked = ! target.checked 
                return;
            } 
            axios({
                method: 'patch',
                url: '/v1/assign-asset/'+this.newEmployee.id,
                data: {
                    field:name,
                    value:value,
                    type:type,
                }
                }).then((response) => {
                    //console.log(response.data)
                    this.loading = false
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
        submit(){
            if( ! this.task ) return;

            if( ! confirm("Are you sure you want to finish task?") ) return;

            this.processing = true;

            axios({
                method: 'post',
                url: '/v1/task/complete/'+this.task.id,
                data: {
                    
                }
            }).then((response) => {
                this.processing = false
                let task = response.data

                if( task.status == 'complete' )
                    alert( "Task completed succesfully" )
                else 
                    alert( "Corrections request sent to employee" )

                window.open('/','_self');
            })
            .catch( (error) => {
                console.log(error.data);
            });
        },
        update(response){
                let name = response.name
                let error = response.error
                let value = response.value
                this[name] = value;
                if( error ) this.errors[name] = error;
                else delete this.errors[name];

                if(  name == 'dob' ) this.calcAge(value)
                this.toggleFieldVisibility(name,value) 
                //else this.toggleFieldVisibility(name,false) 

            },
        updateAddress(response){
            let data = response.value
            this.lat = data.lat
            this.lng = data.lng
            this.country = data.country
            this.search_str = data.search_str
            this.postal_code = data.postal_code
            this.physical_address = data.physical_address
        },
        toggleFieldVisibility(id,value){

            if( ! $( "#"+id+"_parent" ).hasClass('toggler') )return;

            let selector = '.visible_if_'+id+'_'+value;

            $('.toggle_visibility').addClass('d-none') 

            if( $(selector).length )
                $(selector).removeClass('d-none')
            
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
        this.getUserMeta();
    }
}
</script>
<style scoped>
ul{
}
li{
    cursor: pointer;
    padding: 15px 0;
}
li .icon{
    color: var(--theme-color);
    font-size: 1.6em;
}
</style>