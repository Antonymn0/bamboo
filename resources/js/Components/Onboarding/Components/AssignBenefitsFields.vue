<template>
<div class="row">
    <div class="mb-3" v-for="(field,count) in fields_arr" :key="count" :class="[field.parent_classes ? field.parent_classes : 'col-4', showParent( field, benefit ) ]" :id="field.name+'_parent'">
        <DateInput v-if="field.type == 'date'" sync :syncurl="'/v1/benefit-patch/'+this.benefit.id" :label="field.label ? field.label : field.name" :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id+'-'+benefit.id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max"  :required="field.required" :unique="field.unique" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"   v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : benefit[field.name]" :modelid="benefit.id" :category="field.category"/>
        <MultipleSelectInput v-else-if="field.type == 'multiselect' && field.options" sync :syncurl="'/v1/benefit-patch/'+this.benefit.id" :label="field.label ? field.label : field.name" :options="field.options"  :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id+'-'+benefit.id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="field.placeholder"   v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : benefit[field.name]" :modelid="benefit.id" :category="field.category"/>
        <SelectInput v-else-if="field.type == 'select' && field.options" sync :syncurl="'/v1/benefit-patch/'+this.benefit.id" :label="field.label ? field.label : field.name" :options="field.options"  :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id+'-'+benefit.id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="field.placeholder"   v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : benefit[field.name]" :modelid="benefit.id" :category="field.category"/>
        <ContentInput v-else-if="field.type == 'content'" sync :syncurl="'/v1/benefit-patch/'+this.benefit.id" :label="field.label ? field.label : field.name" :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id+'-'+benefit.id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max"  :required="field.required" :unique="field.unique" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"   v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : benefit[field.name]" :modelid="benefit.id" :category="field.category"/>
        <PhoneInput v-else-if="field.type == 'phone'" sync :syncurl="'/v1/benefit-patch/'+this.benefit.id" :label="field.label ? field.label : field.name" :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id+'-'+benefit.id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max"  :required="field.required" :unique="field.unique" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"   v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : benefit[field.name]" :modelid="benefit.id" :category="field.category"/>
        <TimeInput v-else-if="field.type == 'time'" sync :syncurl="'/v1/benefit-patch/'+this.benefit.id" :label="field.label ? field.label : field.name"  :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id+'-'+benefit.id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" :krapin="field.krapin" :noDigits="field.noDigits" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"   v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : benefit[field.name]" :modelid="benefit.id"   :category="field.category"/>
        <AddressInput v-else-if="field.type == 'address'" sync :syncurl="'/v1/benefit-patch/'+this.benefit.id" :label="field.label ? field.label : field.name"  :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id+'-'+benefit.id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" :krapin="field.krapin" :noDigits="field.noDigits" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"   v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : user[field.name]" :modelid="user.id"   :category="field.category"/>
        <SearchInput v-else-if="field.type == 'search'" sync :syncurl="'/v1/benefit-patch/'+this.benefit.id" :label="field.label ? field.label : field.name" modeltype="user" searchurl="/v1/users/search"  :noSymbols="true" :placeholder="settings ? getSetting('onboarding_assigned_to_label',settings).value ? getSetting('onboarding_assigned_to_label',settings).value : 'Search Employee...' : 'Search Employee...'" name="assigned_to" id="assigned_to" type="text" classes="form-control text-capitalize" :class="{'border-danger':errors.assigned_to}" required v-on:selection="selectUser" :initVal="getAssignedToName()"  :category="field.category"/>
        <TextInput v-else  :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" sync :syncurl="'/v1/benefit-patch/'+this.benefit.id" :label="field.label ? field.label : field.name" :id="field.field_id+'-'+benefit.id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" :krapin="field.krapin" :noDigits="field.noDigits" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"   v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : benefit[field.name]" :modelid="benefit.id" :category="field.category"/>
    </div>
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
        benefit:Object,
        formFields:Array,
    },
    data: function(){
      return{
          id:this.benefit.id ? this.benefit.id : '',
          /*name:this.benefit.name ? this.benefit.name : '',
          assigned_to:this.benefit.assigned_to ? this.benefit.assigned_to : '',
          due_date:this.benefit.due_date ? this.benefit.due_date : '',
          due_time:this.benefit.due_time ? this.benefit.due_time : '',
          description:this.benefit.description ? this.benefit.description : '',*/
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
                //url:this.url ? this.url : this.getbenefitUrl()
                
            }

             for( let i = 0; i < this.fields_arr.length; i ++  ){
                let field = this.fields_arr[i]
                if( this[field.name] )
                    fields[field.name] = this[field.name]
                
            }
            axios({
                method: 'post',
                url: '/v1/benefits',
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
            if( this.benefit.assignee )
                return this.benefit.assignee.first_name+' '+this.benefit.assignee.last_name;
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
        showParent(field,user){

            let dependantVal = ''

            if( ! field.visible_if ) return;
            
            dependantVal = $("#"+field.visible_if).val();

            //console.log(field.visible_if)

            if( dependantVal == field.visible_criteria_value )
                return ''
            else if( field.not_visible_if ) {
                let value = user[field.not_visible_if] ? user[field.not_visible_if] : this.getUserMeta(user.meta,field.not_visible_if);
                return field.not_visible_if && field.visible_criteria_value == value ? 'd-none' : '';
            }
            else return ''           
        },
        /*getbenefitUrl(){
            
            if( ! this.id ) return;

            axios({
                method: 'get',
                url: '/v1/benefit-url-mapping/'+this.id+'',
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