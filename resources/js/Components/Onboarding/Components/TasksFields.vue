<template>
<div class="row">
    <div class="mb-3" v-for="(field,count) in fields_arr" :key="count" :class="[field.parent_classes ? field.parent_classes : 'col-4', (field.visible_if && task[field.visible_if] == field.visible_criteria_value) || ! field.visible_if  ? 'd-block' : 'd-none']" :id="field.name+'_parent'">
        <!--<label :for="field.name" class="text-capitalize"> 
            <StatusIcon :showLoading="loading[field.name]"   :category="field.category"/> 
            {{formartWords(field.label ? field.label : field.name)}} 
            <small v-if="age && field.name == 'dob'" class="text-theme">Age: {{age}} Year<span v-if="age > 1">s</span></small>
            <small class="text-danger"> {{errors[field.name]}} </small>
        </label>-->
        <DateInput v-if="field.type == 'date'" :label="field.label ? field.label : field.name" :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id+'-'+task.id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max"  :required="field.required" :unique="field.unique" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : task[field.name]" :modelid="task.id" :category="field.category"/>
        <MultipleSelectInput v-else-if="field.type == 'multiselect' && field.options" :label="field.label ? field.label : field.name" :options="field.options"  :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id+'-'+task.id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="field.placeholder"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : task[field.name]" :modelid="task.id" :category="field.category"/>
        <SelectInput v-else-if="field.type == 'select' && field.options" :label="field.label ? field.label : field.name" :options="field.options"  :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id+'-'+task.id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="field.placeholder"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : task[field.name]" :modelid="task.id" :category="field.category"/>
        <ContentInput v-else-if="field.type == 'content'" :label="field.label ? field.label : field.name" :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id+'-'+task.id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max"  :required="field.required" :unique="field.unique" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : task[field.name]" :modelid="task.id" :category="field.category"/>
        <PhoneInput v-else-if="field.type == 'phone'" :label="field.label ? field.label : field.name" :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id+'-'+task.id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max"  :required="field.required" :unique="field.unique" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : task[field.name]" :modelid="task.id" :category="field.category"/>
       
        <TimeInput v-else-if="field.type == 'time'" :label="field.label ? field.label : field.name"  :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id+'-'+task.id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" :krapin="field.krapin" :noDigits="field.noDigits" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : task[field.name]" :modelid="task.id" v-on:changed="update"  :category="field.category"/>
       
        <AddressInput v-else-if="field.type == 'address'" :label="field.label ? field.label : field.name" sync :syncurl="'/v1/users/'+this.user.id" :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id+'-'+task.id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" :krapin="field.krapin" :noDigits="field.noDigits" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : user[field.name]" :modelid="user.id" v-on:changed="update"  :category="field.category"/>
        <SearchInput v-else-if="field.type == 'search'" :label="field.label ? field.label : field.name" modeltype="user" searchurl="/v1/users/search"  :noSymbols="true" :placeholder="settings ? getSetting('onboarding_assigned_to_label',settings).value ? getSetting('onboarding_assigned_to_label',settings).value : 'Search Employee...' : 'Search Employee...'" name="assigned_to" id="assigned_to" type="text" classes="form-control text-capitalize" :class="{'border-danger':errors.assigned_to}" required v-on:selection="selectUser" :initVal="getAssignedToName()"  :category="field.category"/>
        <TextInput v-else  :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :label="field.label ? field.label : field.name" :id="field.field_id+'-'+task.id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" :krapin="field.krapin" :noDigits="field.noDigits" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : task[field.name]" :modelid="task.id" :category="field.category"/>
    </div>

  <!--<div class="col-6 mb-3">
                        <label for="name">Task Name</label>
                        <select v-model="name" class="form-control" name="name" id="name">
                            <option value="">Choose</option>
                            <option>Verify - Bio-data and basic details</option>
                            <option>Verify - Education details</option>
                            <option>Contact Referees</option>
                            <option>Assign Assets</option>
                            <option>Issue Employee with ID</option>
                            <option>Employee Orientation</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label for="assigned_to">Assigned To</label>
                        <SearchInput modeltype="user" searchurl="/v1/users/search"  :noSymbols="true" :placeholder="settings ? getSetting('onboarding_assigned_to_label',settings).value ? getSetting('onboarding_assigned_to_label',settings).value : 'Search Employee...' : 'Search Employee...'" name="assigned_to" id="assigned_to" type="text" classes="form-control text-capitalize" :class="{'border-danger':errors.assigned_to}" required v-on:selection="selectUser" :initVal="getAssignedToName()"  :category="field.category"/>
                    </div>
                    <div class="col-6 mb-3">
                        <label for="due_date">Due Date</label>
                        <TextInput    :placeholder="settings ? getSetting('onboarding_due_date_label',settings).value ? getSetting('onboarding_due_date_label',settings).value : 'Due Date' : 'Due Date'" name="due_date" id="due_date" type="date" classes="form-control" :class="{'border-danger':errors.due_date}" required v-on:changed="update" :initVal="due_date"  :category="field.category"/>
                    </div>
                    <div class="col-6 mb-3">
                        <label for="description">Time</label>
                        <input  @change="update" v-model="due_time" name="time" id="time" type="time" class="form-control" >
                    </div>
                    <div class="col-12 mb-3">
                        <label for="description">{{settings ? getSetting('onboarding_description_label',settings).value ? getSetting('onboarding_description_label',settings).value : 'Description' : 'Description'}}</label>
                        <textarea @change="update" class="form-control" v-model="description" name="description" id="description"></textarea>
                    </div>-->
    </div>

</template>

<script>
import TextInput from '@/Components/TextInput.vue';
import SearchInput from '@/Components/SearchInput.vue';
import DateInput from '@/Components/DateInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import ContentInput from '@/Components/ContentInput.vue';
import moment from 'moment';
import StatusIcon from '@/Components/Profile/Sections/Components/StatusIcon.vue';
import PhoneInput from '@/Components/PhoneInput.vue';
import TimeInput from '@/Components/TimeInput.vue';
import AddressInput from '@/Components/AddressInput.vue';
import MultipleSelectInput from '@/Components/MultipleSelectInput.vue';

export default {

 components:{
        TextInput,
        DateInput,
        SelectInput,
        ContentInput,
        StatusIcon,
        PhoneInput,
        TimeInput,
        SearchInput,
        AddressInput,
        MultipleSelectInput
    },
    props:{
        settings:Array,
        employee:Object,
        task:Object,
        formFields:Array,
    },
    data: function(){
      return{
          id:this.task.id ? this.task.id : '',
          /*name:this.task.name ? this.task.name : '',
          assigned_to:this.task.assigned_to ? this.task.assigned_to : '',
          due_date:this.task.due_date ? this.task.due_date : '',
          due_time:this.task.due_time ? this.task.due_time : '',
          description:this.task.description ? this.task.description : '',*/
          errors:{},
          loading:{},
          processing:false,
          processing:false,
          user:this.$page.props.auth.user,
          fields_arr:this.formFields ? this.formFields : [],
          age:'',
          url:''
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

                if( name == 'name')
                    this.showHideCustomField()

                if( response.sync )
                    this.save()
            },
        showHideCustomField(){
            if( this.name == 'other')
                $("#custom_name_parent").addClass('d-block').removeClass('d-none');
            else
                $("#custom_name_parent").removeClass('d-block').addClass('d-none');
        },
        save(){
            this.processing = true
            $("#submit").addClass('opacity-25').attr('disabled',true);

            let fields = {
                id:this.id,
                user_id:this.user.id,
                type:'employee_onboarding',
                type_id:this.employee.id,
                //url:this.url ? this.url : this.getTaskUrl()
                
            }

             for( let i = 0; i < this.fields_arr.length; i ++  ){
                let field = this.fields_arr[i]
                if( this[field.name] )
                    fields[field.name] = this[field.name]
                
            }
            axios({
                method: 'post',
                url: '/v1/tasks',
                data:fields,
                }).then((response) => {
                    //console.log(response.data);
                    //if(response.data.id)
                      //  this.id = response.data.id

                      //  window.open('/onboard/step-four/'+response.data.username,'_self')
                    this.processing = false
                    $("#submit").removeClass('opacity-25').attr('disabled',false)
                })
                .catch( (error) => {
                console.log(error.response);
            });
        },
        selectUser(user){
            this.assigned_to = user.id
            this.save()
        },
        getAssignedToName(){
            if( this.task.assignee )
                return this.task.assignee.first_name+' '+this.task.assignee.last_name;
            return '';
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
        /*getTaskUrl(){
            
            if( ! this.id ) return;

            axios({
                method: 'get',
                url: '/v1/task-url-mapping/'+this.id+'',
                data:{

                }
                }).then((response) => {
                    console.log(response.data)
                    this.url = this.response.data 
                    return this.url
                })
                .catch( (error) => {
                console.log(error.response);
            });
        }*/
    },
}
</script>

<style>

</style>