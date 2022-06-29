<template>
  <div class="section">
          <h2 class="title-border pb-2"> <span class="fa fa-phone-alt"></span> Contact</h2>
          <div class="row g-3 pt-2">

            <div v-for="(field,count) in fields_arr" :key="count" :class="[field.parent_classes ? field.parent_classes : 'col-4', (field.visible_if && user[field.visible_if]) || ! field.visible_if ? 'd-block' : 'd-none']" :id="field.name+'_parent'">
                        <label :for="field.name" class="text-capitalize"> 
                            <StatusIcon :showLoading="loading[field.name]" :showVerified="user[field.name+'_verified_at'] ? user[field.name+'_verified_at'].length : 0"  :category="field.category"/> 
                            {{formartWords(field.label ? field.label : field.name)}} 
                            <small v-if="age && field.name == 'dob'" class="text-theme">Age: {{age}} Year<span v-if="age > 1">s</span></small>
                            <small class="text-danger"> {{errors[field.name]}} </small>
                        </label>
                        <DateInput v-if="field.type == 'date'" sync :syncurl="'/v1/users/'+this.user.id" :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max"  :required="field.required" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : user[field.name]" :category="field.category"/>
                        <SelectInput v-else-if="field.type == 'select' && field.options" :options="field.options" sync :syncurl="'/v1/users/'+this.user.id" :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" :required="field.required" placeholder="Choose..."  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : user[field.name]" :category="field.category"/>
                        <ContentInput v-else-if="field.type == 'content'" sync :syncurl="'/v1/users/'+this.user.id" :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" noDigits noSymbols :required="field.required" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : user[field.name]" :category="field.category"/>
                        <PhoneInput v-else-if="field.type == 'phone'" :modelid="field.modelid" :unique="field.unique" :uniqueurl="field.uniqueurl" sync :syncurl="'/v1/users/'+this.user.id" :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" noDigits noSymbols :required="field.required" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : user[field.name]" :category="field.category"/>
                        <TimeInput v-else-if="field.type == 'time'"  :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" :krapin="field.krapin" :noDigits="field.noDigits" :noSymbols="field.noSymbols" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : task[field.name]" :modelid="employee.id" v-on:changed="update"  :category="field.category"/>
                        <AddressInput v-else-if="field.type == 'address'" sync :syncurl="'/v1/users/'+this.user.id" :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" :krapin="field.krapin" :noDigits="field.noDigits" :noSymbols="field.noSymbols" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : user[field.name]" :modelid="user.id" v-on:changed="update"  :category="field.category"/>
                        <TextInput v-else :modelid="field.modelid" :unique="field.unique" :uniqueurl="field.uniqueurl" sync :syncurl="'/v1/users/'+this.user.id" :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :type="field.type" :min="field.min"  :max="field.max" :krapin="field.krapin" :noDigits="field.noDigits" :noSymbols="field.noSymbols" :required="field.required" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : user[field.name]" :category="field.category"/>
               </div>
            
          </div>
      </div>
</template>

<script>
import TextInput from '@/Components/TextInput.vue';
import DateInput from '@/Components/DateInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import PhoneInput from '@/Components/PhoneInput.vue';
import ContentInput from '@/Components/ContentInput.vue';
import BreezeLabel from '@/Components/Label.vue';
import StatusIcon from './Components/StatusIcon.vue';
import moment from 'moment';
import TimeInput from '@/Components/TimeInput.vue';
import AddressInput from '@/Components/AddressInput.vue';

export default {
    props:{
        user:Object,
        fields:Array,
    },
    data() {
        return {
            age:'',
            auth_user:this.user,
            errors:{},
            loading:{},
            fields_arr:this.fields ? this.fields : [],
        }
    },
    components: {
        BreezeLabel,
        TextInput,
        StatusIcon,
        DateInput,
        SelectInput,
        ContentInput,
        PhoneInput,
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
                console.log(error,name)

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
        syncToServer(field,value,type){
            this.loading[field] = true
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
                    this.loading[field] = false
                })
                .catch( (error) => {
                console.log(error.response);
            });
        },
        setLoading(response){
            let name = response.name
            let value = response.value
            this.loading[name] = value;
            if( value ) this.loading[name] = value;
            else delete this.loading[name];
        },
        formartWords(slug){
            return slug ? slug.toString().replace(/[^a-zA-Z0-9,. ]/g,' ') : slug;
        },
        calcAge(dob){
            let bday = moment(dob);
            let now = moment();

            this.age =  now.diff(bday,'years');
        },
        disableSubmit( ){
            if( ! Object.keys(this.errors).length )
                $('.submit').css('pointer-events','').removeClass('opacity-25');
            else 
                $('.submit').css('pointer-events','none').addClass('opacity-25');
        },
    },
    mounted(){
        //console.log(this.user)
    }
}
</script>

<style>

</style>