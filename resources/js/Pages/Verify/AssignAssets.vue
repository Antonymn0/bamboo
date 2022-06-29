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
                    <div >
                       <a href="#" @click.prevent="openModal" class="btn btn-outline-dark mt-3 btn-sm"> <span class="fa fa-plus-circle"></span> Create Asset</a>
                    </div>
         
                        <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Serial</th>
                                <th scope="col">Current User</th>
                                <th scope="col">Date Assigned</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Assign</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr v-for="asset in assets" :key="asset.id" >
                                <td class="text-capitalize">{{formartWords(asset.type)}}</td>
                                <td>{{getMeta(asset.meta,'reg_no') ? getMeta(asset.meta,'reg_no') : getMeta(asset.meta,'serial_no') }} </td>
                                <td class="text-capitalize">
                                    {{asset.assignee ? asset.assignee.first_name + ' ' + asset.assignee.last_name : '' }}<br>
                                    <a v-if="asset.assignee" @click.prevent="assignAsset(asset.id,'')" href="#"> <small class="text-danger text-lowercase"> Withdraw </small> </a>
                                </td>
                                <td>{{formatDate(asset.start_date)}}</td>
                                <td>{{formatDate(asset.end_date)}}</td>
                                <td> <button :disabled="asset.assignee" @click.prevent="assignAsset(asset.id)"  class="btn btn-sm btn-theme">Assign</button> </td>
                            </tr>
                            
                            
                        </tbody>
                    </table>
                        

                <form class="border-top pt-2 pb-2 mt-2 bg-light" id="submit-form" :action="route('employee.submit',newEmployee.username)">
                    <a href="#" @click.prevent="submit" class="btn btn-sm btn-theme">Finish Task</a>

                    <!--<Link @click.prevent="continueLater()" class="ml-4" >
                            Save and continue later 
                    </Link>-->
                </form>
                </div>

            <FormModal :id="modalID" title="Create an Asset" v-on:save="save">
                <template v-slot:form>
                        <div class="row g-3">
                            <div v-for="(field,count) in fields_arr" :key="count" :class="[field.parent_classes ? field.parent_classes : 'col-4', (field.visible_if && newEmployee[field.visible_if]) || ! field.visible_if ? 'd-block' : 'd-none']" :id="field.name+'_parent'">
                                <DateInput v-if="field.type == 'date'"  :setMinimums="field.set_minimums"  :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :label="field.label" :type="field.type" :min="field.min"  :max="field.max" :noDigits="field.noDigits" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :required="field.required" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val :newEmployee[field.name]" :category="field.category" />
                                <SelectInput v-else-if="field.type == 'select' && field.options" :options="field.options"  :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :label="field.label" :noDigits="field.noDigits" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :type="field.type" :min="field.min"  :max="field.max" :required="field.required" :placeholder="formartWords(field.placeholder ? field.placeholder : 'Choose...')"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val :newEmployee[field.name]" :category="field.category" />
                                <ContentInput v-else-if="field.type == 'content'"  :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :label="field.label" :type="field.type" :min="field.min" :noDigits="field.noDigits" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :max="field.max"  :required="field.required" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val :newEmployee[field.name]" :category="field.category" />
                                <PhoneInput v-else-if="field.type == 'phone'"  :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :label="field.label" :type="field.type" :min="field.min"  :noDigits="field.noDigits" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :max="field.max"  :required="field.required" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val :newEmployee[field.name]" :category="field.category" />
                                <TimeInput v-else-if="field.type == 'time'"  :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :label="field.label" :type="field.type" :min="field.min"  :max="field.max" :krapin="field.krapin" :noDigits="field.noDigits"  :noLetters="field.noLetters" :noSymbols="field.noSymbols" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : task[field.name]" :modelid="employee.id" v-on:changed="update"  :category="field.category" />
                                <AddressInput v-else-if="field.type == 'address'"  :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :label="field.label" :type="field.type" :min="field.min"  :max="field.max"  :krapin="field.krapin" :noDigits="field.noDigits" :noLetters="field.noLetters" :noSymbols="field.noSymbols" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val :newEmployee[field.name]" :modelid="newEmployee.id" v-on:changed="update"  :category="field.category" />
                                <TextInput v-else  :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :label="field.label" :type="field.type"  :min="field.min"  :max="field.max" :krapin="field.krapin" :noDigits="field.noDigits" :noLetters="field.noLetters" :noSymbols="field.noSymbols" :required="field.required" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val :newEmployee[field.name]" :category="field.category"/>
                            </div>
                        </div>
                </template>
            </FormModal>

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
import FormModal from '@/Components/FormModal.vue';

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
          modalID:'asset-form',
          errors:{},
          fields_arr:this.formFields ? this.formFields : [],
          assets:[],
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
    AddressInput,
    FormModal
},
    methods:{
        formatDate(date){
                    return date ? moment(date).format('MMM Do YYYY') : date;
                },
        save(){
            //if( confirm("Are you sure you want to submit details?") )
               // $("#submit-form").submit()

               let fields = {}

               for( let i = 0; i < this.fields_arr.length; i ++  ){
                let field = this.fields_arr[i]
                
                if( this[field.name] )
                    fields[field.name] = this[field.name]

                fields['company_id'] = this.newEmployee.company_id

            }
            

            axios({
                method: 'post',
                url: '/v1/assets',
                data:fields,
                }).then((response) => {
                    //console.log(response.data);
                    ///if(response.data.id)
                       // this.id = response.data.id

                      //  window.open('/onboard/step-four/'+response.data.username,'_self')
                    location.reload()
                })
                .catch( (error) => {
                console.log(error.response);
            });

               //location.reload()
        },
        continueLater(){
            alert("Details saved successfully. You can close the window and continue later")
        },
        getMeta(metaData,key){
            if( ! metaData || ! key ) return;
            let value ='';
            for(let i=0; i< metaData.length; i++)
            {
                if( metaData[i].key == key )
                {
                    value = metaData[i].value;
                    break;
                }
            }
            return value;
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

                /*if( task.status == 'complete' )
                    alert( "Task completed succesfully" )
                else 
                    alert( "Corrections request sent to employee" )*/

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
        openModal(){
            jQuery('#'+this.modalID).modal('show');
        },
        fetchAssets(){
            axios({
                method: 'GET',
                url: '/v1/assets',
                data:{},
                }).then((response) => {
                    this.assets = response.data
                })
                .catch( (error) => {
                console.log(error.response);
            });
        },
        assignAsset(assetID,value=this.newEmployee.id){
            if( ! confirm("Are you sure you want to proceed?")) return;

            axios({
                method: 'PATCH',
                url: '/v1/asset-patch/'+assetID,
                data:{
                    field:'assigned_to',
                    value:value
                },
                }).then((response) => {
                    location.reload()
                })
                .catch( (error) => {
                console.log(error.response);
            });
        }
    },
    mounted(){
        this.fetchAssets();
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