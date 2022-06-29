<template>
  
         <div class="row g-3 pt-2">
            <div class="col-8">
                <TextInput :label="serial +'. Organisation'" :class="{'border-danger':errors.organisation_name}" id="organisation_name" name="organisation_name" type="text"  :max="255"  required  placeholder="Name of the professional body" classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="organisation_name"/>
            </div>
            <div class="col-8">
                <TextInput label="Certificate Name" :class="{'border-danger':errors.certificate_name}" id="certificate_name" name="certificate_name" type="text"  :max="255" noDigits required noSymbols placeholder="Certificate Name" classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="certificate_name"/>
            </div>
            <div class="col-4"></div>
            <div class="col-5">
                <TextInput label="Membership ID" :class="{'border-danger':errors.membership_id}" id="membership_id" name="membership_id" type="text"    placeholder="Membership ID" classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="membership_id"/>
            </div>
            <div class="col-3"></div>
            <div class="col-12">
                <input  type="checkbox"  :checked="expires == '1'" @input="expires = $event.target.checked" @change="save"> This certificate expires 
            </div>
            <!--<div v-if="expires == '1'" class="col-4">
                <label for="issue_date">Issue Date <small class="text-danger"> {{errors.issue_date}} </small></label>
                <TextInput :class="{'border-danger':errors.issue_date}" id="issue_date" name="issue_date" type="date"  required placeholder="Issue Date" classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="issue_date"/>
            </div>-->
            <div v-if="expires == '1'" class="col-4">
                <DateInput label="Expiry Date" :class="{'border-danger':errors.expiry_date}" id="expiry_date" name="expiry_date" type="date"  required  placeholder="Expiry Date" classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="expiry_date"/>
            </div>
            <div class="col-4"></div>
            <div class="col-9">
                <ContentInput :class="{'border-danger':errors.description}" id="description" name="description" type="text"  noDigits required noSymbols placeholder="Description" classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="description" />
            </div>
          </div>

</template>

<script>
import TextInput from '@/Components/TextInput.vue';
import ContentInput from '@/Components/ContentInput.vue';
import DateInput from '@/Components/DateInput.vue';
import BreezeLabel from '@/Components/Label.vue';
export default {
props:{
        user:Object,
        certification:Object,
        serial:Number
    },
data() {
        return {
            id:this.certification.id ? this.certification.id : '',
            certificate_name: this.certification.certificate_name ? this.certification.certificate_name : '',
            organisation_name: this.certification.organisation_name ? this.certification.organisation_name : '',
            membership_id: this.certification.membership_id ? this.certification.membership_id : '',
            expires:this.certification.expires ? this.certification.expires : true,
            issue_date:this.certification.issue_date ? this.certification.issue_date : '',
            expiry_date:this.certification.expiry_date ? this.certification.expiry_date : '',
            description:this.certification.description ? this.certification.description : '',

            errors:{}
        }
    },
    components: {
        BreezeLabel,
        TextInput,
        DateInput,
        ContentInput
    },

    methods:{
        update(response){
                let name = response.name
                let error = response.error
                let value = response.value
                this[name] = value;
                if( error ) this.errors[name] = error;
                else delete this.errors[name];
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
        save(){
            this.loading = true
            axios({
                method: 'post',
                url: '/v1/certifications',
                data: {
                    id:this.id,
                    certificate_name: this.certificate_name,
                    organisation_name: this.organisation_name,
                    membership_id: this.membership_id,
                    expires:this.expires ? 1 : 0,
                    issue_date:this.issue_date,
                    expiry_date:this.expiry_date,
                    description:this.description,
                    user_id:this.user.id
                }
                }).then((response) => {
                    this.id = response.data.id
                    this.loading = false
                   // console.log(this.id,response.data)
                })
                .catch( (error) => {
                console.log(error.response);
            });
        }
    }
}
</script>

<style>

</style>