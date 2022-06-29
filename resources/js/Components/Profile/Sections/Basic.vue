<template>
  <div class="section">
          <h2 class="pb-2 title-border"> 
              <span class="fa fa-user-circle"></span> 
              Basic information 
          </h2>
          <div class="row g-3 mt-2">

                <div v-for="(field,count) in fields_arr" :key="count" :class="[field.parent_classes ? field.parent_classes : 'col-4', (field.visible_if && user[field.visible_if]) || ! field.visible_if ? 'd-block' : 'd-none']" :id="field.name+'_parent'">
                        <DateInput v-if="field.type == 'date'" sync showAge :syncurl="'/v1/users/'+this.user.id" :label="field.label ? field.label : field.name" :classes="field.classes" :id="field.field_id" :name="field.name" :readonly="field.readonly" :type="field.type" :min="field.min"  :max="field.max" :noDigits="field.noDigits" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :required="field.required" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : user[field.name]" :category="field.category" />
                        <SelectInput v-else-if="field.type == 'select' && field.options" :label="field.label ? field.label : field.name" :options="field.options" sync :syncurl="'/v1/users/'+this.user.id" :classes="field.classes" :id="field.field_id" :name="field.name" :readonly="field.readonly" :noDigits="field.noDigits" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :type="field.type" :min="field.min"  :max="field.max" :required="field.required" :placeholder="field.placeholder"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : user[field.name]" :category="field.category" />
                        <ContentInput v-else-if="field.type == 'content'" sync :syncurl="'/v1/users/'+this.user.id" :label="field.label ? field.label : field.name" :classes="field.classes" :id="field.field_id" :name="field.name" :readonly="field.readonly" :type="field.type" :min="field.min" :noDigits="field.noDigits" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :max="field.max"  :required="field.required" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : user[field.name]" :category="field.category" />
                        <PhoneInput v-else-if="field.type == 'phone'" sync :syncurl="'/v1/users/'+this.user.id" :label="field.label ? field.label : field.name" :classes="field.classes" :id="field.field_id" :name="field.name" :readonly="field.readonly" :type="field.type" :min="field.min"  :noDigits="field.noDigits" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :max="field.max"  :required="field.required" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : user[field.name]" :category="field.category" />
                        <TimeInput v-else-if="field.type == 'time'" :label="field.label ? field.label : field.name" :classes="field.classes" :id="field.field_id" :name="field.name" :readonly="field.readonly" :type="field.type" :min="field.min"  :max="field.max" :krapin="field.krapin" :noDigits="field.noDigits"  :noLetters="field.noLetters" :noSymbols="field.noSymbols" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : task[field.name]" :modelid="employee.id" v-on:changed="update"  :category="field.category" />
                        <AddressInput v-else-if="field.type == 'address'" sync :syncurl="'/v1/users/'+this.user.id" :label="field.label ? field.label : field.name" :classes="field.classes" :id="field.field_id" :name="field.name" :readonly="field.readonly" :type="field.type" :min="field.min"  :max="field.max"  :krapin="field.krapin" :noDigits="field.noDigits" :noLetters="field.noLetters" :noSymbols="field.noSymbols" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : user[field.name]" :modelid="user.id" v-on:changed="update"  :category="field.category" />
                        <TextInput v-else sync :syncurl="'/v1/users/'+this.user.id" :label="field.label ? field.label : field.name" :classes="field.classes" :id="field.field_id" :name="field.name" :readonly="field.readonly" :type="field.type"  :min="field.min"  :max="field.max" :krapin="field.krapin" :noDigits="field.noDigits" :noLetters="field.noLetters" :noSymbols="field.noSymbols" :required="field.required" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : user[field.name]" :category="field.category"/>
               </div>

          </div>
              
      </div>
</template>

<script>
import TextInput from '@/Components/TextInput.vue';
import DateInput from '@/Components/DateInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import ContentInput from '@/Components/ContentInput.vue';
import PhoneInput from '@/Components/PhoneInput.vue';
import TimeInput from '@/Components/TimeInput.vue';
import BreezeLabel from '@/Components/Label.vue';
import moment from 'moment';
import StatusIcon from './Components/StatusIcon.vue';
import AddressInput from '@/Components/AddressInput.vue';

export default {
    props:{
        settings:Array,
        fields:Array,
        user:Object,
        permissions:Array,
        showVerifyBox:Boolean,
    },
    data() {
        return {
            errors:{},
            age:'',
            disabilities:[],
            disability_cert_no:this.user ? this.user.disability_cert_no : '',
            disability_description:this.user ? this.user.disability_description : '',
            auth_user:this.$page.props.auth.user,
            loading:{},
            religions:[],
            permissions_arr:this.permissions ? this.permissions : [],
            showVerifyOption:this.showVerifyBox ? this.showVerifyBox : false,
            verificationPermission:'verify_reg_details',
            fields_arr:this.fields ? this.fields : [],
        }
    },
    components: {
    BreezeLabel,
    TextInput,
    DateInput,
    SelectInput,
    ContentInput,
    PhoneInput,
    StatusIcon,
    TimeInput,
    AddressInput
},
     methods:{
        update(response){
                let name = response.name
                let error = response.error
                let value = response.value
                this[name] = value;
                if( error ) this.errors[name] = error;
                else delete this.errors[name];

                if( name == 'disability' ) 
                    if( value ) this.toggleDisabilityFields(true) 
                    else this.toggleDisabilityFields(false) 

                this.disableSubmit( );

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
        getFieldSettings(value,field,selector='value'){ 
            if( ! this.settings ) return false;
            if( ! Array.isArray( this.settings ) ) return false;

            for( let i = 0; i < this.settings.length; i++ )
                if( this.settings[i][selector] == value )
                    this[field].push( this.settings[i] )

        },
        formartWords(slug){
            return slug ? slug.toString().replace(/[^a-zA-Z0-9,. ]/g,' ') : slug;
        },
        capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        },
        
        toggleDisabilityFields(show){
            if( show ){
                $("#disability_cert_no_parent").removeClass('d-none').addClass('d-block')
                $("#disability_description_parent").removeClass('d-none').addClass('d-block')
            }
            else{
                $("#disability_cert_no_parent").removeClass('d-block').addClass('d-none')
                $("#disability_description_parent").removeClass('d-block').addClass('d-none')
            } 
        },
        disableSubmit( ){
            if( ! Object.keys(this.errors).length )
                $('.submit').css('pointer-events','').removeClass('opacity-25');
            else 
                $('.submit').css('pointer-events','none').addClass('opacity-25');
        },
        setLoading(response){
            let name = response.name
            let value = response.value
            this.loading[name] = value;
            if( value ) this.loading[name] = value;
            else delete this.loading[name];
        },
        calcAge(dob){
            let bday = moment(dob);
            let now = moment();

            this.age =  now.diff(bday,'years');
        },
        can(permission){
            return this.permissions_arr.includes(permission);
        }
    },
    mounted(){
        this.getFieldSettings('basic_details','fields')
        this.getFieldSettings('disability','disabilities')
        this.getFieldSettings('religion','religions')
      

    }
}
</script>

<style>

</style>