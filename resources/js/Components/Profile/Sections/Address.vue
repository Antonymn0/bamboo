<template>
  <div class="section">
          <h2 class="title-border pb-2 mb-2"> <span class="fa fa-home"></span> 
            Address
          </h2>
          <div class="row g-3 pt-2">

              <div v-for="(field,count) in fields_arr" :key="count" :class="[field.parent_classes ? field.parent_classes : 'col-4', (field.visible_if && user[field.visible_if]) || ! field.visible_if ? 'd-block' : 'd-none']" :id="field.name+'_parent'">
                        
                        <DateInput v-if="field.type == 'date'" sync :syncurl="'/v1/users/'+this.user.id" :classes="field.classes" :id="field.field_id" :label="field.label" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" :noDigits="field.noDigits"  :required="field.required" :noLetters="field.noLetters" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:changed="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : user[field.name]" :category="field.category"/>
                        <SelectInput v-else-if="field.type == 'select' && field.options" :options="field.options" sync :syncurl="'/v1/users/'+this.user.id" :classes="field.classes" :id="field.field_id" :label="field.label" :name="field.name" :type="field.type" :noDigits="field.noDigits" :noLetters="field.noLetters" :min="field.min"  :max="field.max" :required="field.required" placeholder="Choose..."  v-on:save="update" v-on:changed="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : user[field.name]" :category="field.category"/>
                        <ContentInput v-else-if="field.type == 'content'" sync :syncurl="'/v1/users/'+this.user.id" :classes="field.classes" :id="field.field_id" :label="field.label" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" :noDigits="field.noDigits" :noLetters="field.noLetters" :required="field.required" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:changed="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : user[field.name]" :category="field.category"/>
                        <PhoneInput v-else-if="field.type == 'phone'" :modelid="field.modelid" :unique="field.unique" :uniqueurl="field.uniqueurl" sync :syncurl="'/v1/users/'+this.user.id" :classes="field.classes" :id="field.field_id" :label="field.label" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" :noDigits="field.noDigits" :noLetters="field.noLetters" :required="field.required" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:changed="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : user[field.name]" :category="field.category"/>
                        <TimeInput v-else-if="field.type == 'time'"  :classes="field.classes" :id="field.field_id" :label="field.label" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" :krapin="field.krapin" :noDigits="field.noDigits"  :noLetters="field.noLetters" :noSymbols="field.noSymbols" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:changed="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : user[field.name]" :modelid="user.id" v-on:changedd="update"  :category="field.category"/>
                        <AddressInput v-else-if="field.type == 'address'" sync :syncurl="'/v1/users/'+this.user.id" :classes="field.classes" :id="field.field_id" :label="field.label" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" :krapin="field.krapin" :noDigits="field.noDigits"  :noLetters="field.noLetters" :noSymbols="field.noSymbols" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:changed="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : user[field.name]" :modelid="user.id" v-on:changedd="update"  :category="field.category"/>
                        <PostalCodeInput v-else-if="field.type == 'postal_code'" sync :syncurl="'/v1/users/'+this.user.id" :classes="field.classes" :id="field.field_id" :label="field.label" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" :krapin="field.krapin" :noDigits="field.noDigits"  :noLetters="field.noLetters" :noSymbols="field.noSymbols" :required="field.required" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:changed="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : user[field.name]"  :category="field.category"/>
                        <TextInput v-else sync :syncurl="'/v1/users/'+this.user.id" :classes="field.classes" :id="field.field_id" :label="field.label" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" :krapin="field.krapin" :noDigits="field.noDigits"  :noLetters="field.noLetters" :noSymbols="field.noSymbols" :required="field.required" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:changed="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : user[field.name]"  :category="field.category"/>
               </div>

            

          </div>
      </div>
</template>

<script>
import BreezeLabel from '@/Components/Label.vue';
import AddressInput from '@/Components/AddressInput.vue';
import StatusIcon from './Components/StatusIcon.vue';
import TextInput from '@/Components/TextInput.vue';
import DateInput from '@/Components/DateInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import ContentInput from '@/Components/ContentInput.vue';
import PhoneInput from '@/Components/PhoneInput.vue';
import PostalCodeInput from '@/Components/PostalCodeInput.vue';
import TimeInput from '@/Components/TimeInput.vue';
import moment from 'moment';

export default {
    props:{
        user:Object,
        showVerifyBox:Boolean,
        permissions:Array,
        settings:Array,
        fields:Array,
    },
    data() {
        return {
            
            age:'',
            errors:{},
            loading:{},
            auth_user:this.$page.props.auth.user,
            permissions_arr:this.permissions ? this.permissions : [],
            showVerifyOption:this.showVerifyBox ? this.showVerifyBox : false,
            verificationPermission:'verify_reg_details',
            fields_arr:this.fields ? this.fields : [],
        }
    },
    components: {
    BreezeLabel,
    TextInput,
    AddressInput,
    StatusIcon,
    DateInput,
    SelectInput,
    ContentInput,
    PhoneInput,
    StatusIcon,
    TimeInput,
    PostalCodeInput
},
     methods:{
        update(response){
                let name = response.name
                let error = response.error
                let value = response.value
                this[name] = value;
                if( error ) this.errors[name] = error;
                else delete this.errors[name];

                this.disableSubmit( );
            },
        updateAddress(response){
            let data = response.value
            this.lat = data.lat
            //this.syncToServer('lat',this.lat)
            this.lng = data.lng
            //this.syncToServer('lng',this.lng)
            this.country = data.country
            //this.syncToServer('country',this.country)
            this.search_str = data.search_str
            this.postal_code = data.postal_code
            //this.syncToServer('postal_code',this.postal_code)
            this.street_address = data.physical_address
            //this.syncToServer('street_address',this.street_address)
        },
        setLoading(response){
            let name = response.name
            let value = response.value
            this.loading[name] = value;
            if( value ) this.loading[name] = value;
            else delete this.loading[name];
        },
        syncToServer(field,value,type,ask=false,askMsg='Are you sure you want to proceed?',assignFieldValue=false){
            this.loading[field] = true
            if( ask )
                if( ! confirm(askMsg) ) return false;

            

            axios({
                method: 'patch',
                url: '/v1/users/'+this.user.id,
                data: {
                    field:field,
                    value:value,
                    type:type,
                }
                }).then((response) => {
                   // console.log(response.data)
                   if( assignFieldValue )
                        this[field] = value
                    this.loading[field] = false
                })
                .catch( (error) => {
                console.log(error.response);
            });
        },
         formartWords(slug){
            return slug ? slug.toString().replace(/[^a-zA-Z0-9,. ]/g,' ') : slug;
        },
        can(permission){
            return this.permissions_arr.includes(permission);
        },
        disableSubmit( ){

            if( ! Object.keys(this.errors).length )
                $('.submit').css('pointer-events','').removeClass('opacity-25');
            else 
                $('.submit').css('pointer-events','none').addClass('opacity-25');
        },
    },
    mounted(){
        
    }
}
</script>

<style>

</style>