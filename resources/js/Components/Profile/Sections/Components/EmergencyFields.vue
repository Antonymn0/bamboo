<template>
          <div class="row g-3 pt-2 mt-2">
              <div class="col-6">
                <SelectInput :label="serial + '. Relationship'" :key="relationshipOptions" :options="relationshipOptions" :class="{'border-danger':errors.relationship}" id="relationship" name="relationship" required noSymbols placeholder="Choose..." classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="relationship" />
            </div>
             <div v-if="relationship == 'other'" class="col-6">
                <TextInput  :class="{'border-danger':errors.other}" id="relationship_description" name="relationship_description" type="text"  :max="255" noDigits required noSymbols placeholder="Specify Relationship" classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="relationship_description"/>
            </div>
            
            <div class="col-6">
                <TextInput :class="{'border-danger':errors.first_name}" id="first_name" name="first_name" type="text" :min="3" :max="255" noDigits required noSymbols placeholder="First Name" classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="first_name"/>
            </div>
            <div class="col-6">
                <TextInput :class="{'border-danger':errors.middle_name}" id="middle_name" name="middle_name" type="text" :min="3" :max="255" noDigits  noSymbols placeholder="Middle Name" classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="middle_name"/>
            </div>
            <div class="col-6">
                <TextInput :class="{'border-danger':errors.last_name}" id="last_name" name="last_name" type="text" :min="3" :max="255" noDigits required noSymbols placeholder="Surname" classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="last_name"/>
            </div>
            
            <div class="col-6">
                <PhoneInput :class="{'border-danger':errors.phone}" id="phone" name="phone" type="text" :min="10" :max="15" noLetters  noSymbols placeholder="Phone No." classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="phone"/>
            </div>
            <div class="col-6">
                <TextInput :class="{'border-danger':errors.email}" id="email" name="email" type="email"  :max="255"    placeholder="Email Address"  v-on:save="update" v-on:changed="save" :initVal="email"/>
            </div>
            <div class="col-6">
                <TextInput :class="{'border-danger':errors.national_id_no}" id="national_id_no" noSymbols name="national_id_no" type="text" noLetters :min="7" :max="8"  placeholder="National ID No." classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="national_id_no"/>
            </div>
            <div class="col-6">
                <TextInput :class="{'border-danger':errors.passport_no}" id="passport_no" noSymbols name="passport_no" type="text" :min="5" :max="255"  placeholder="Passport No." classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="passport_no"/>
            </div>
            <div class="col-6">
                <TextInput :class="{'border-danger':errors.postal_address}" id="postal_address" noLetters name="postal_address" type="text"   placeholder="Postal Address" classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="postal_address"/>
            </div>
            <div class="col-6">
                <TextInput :class="{'border-danger':errors.postal_code}" id="postal_code" noSymbols name="postal_code" type="text" noLetters   placeholder="Postal Code" classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="postal_code"/>
            </div>
            <div class="col-6">
                <TextInput label="City/Town" :class="{'border-danger':errors.city}" id="city" noSymbols name="city" type="text"  :max="255"  placeholder="City/ Town" classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="city"/>
            </div>

          </div>
</template>

<script>
import TextInput from '@/Components/TextInput.vue';
import PhoneInput from '@/Components/PhoneInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import BreezeLabel from '@/Components/Label.vue';
export default {
props:{
        user:Object,
        emergency:Object,
        serial:Number
    },
data() {
        return {
            id:this.emergency ? this.emergency.id : '',
            dob: this.emergency.dob ? this.emergency.dob : '',
            first_name: this.emergency.first_name ? this.emergency.first_name : '',
            middle_name: this.emergency.middle_name ? this.emergency.middle_name : '',
            last_name: this.emergency.last_name ? this.emergency.last_name : '',
            phone:this.emergency.phone ? this.emergency.phone : '',
            email:this.emergency.email ? this.emergency.email : '',
            national_id_no:this.emergency.national_id_no ? this.emergency.national_id_no : '',
            passport_no:this.emergency.passport_no ? this.emergency.passport_no : '',
            relationship:this.emergency.relationship ? this.emergency.relationship : '',
            postal_address:this.emergency.postal_address ? this.emergency.postal_address : '',
            postal_code:this.emergency.postal_code ? this.emergency.postal_code : '',
            city:this.emergency.city ? this.emergency.city : '',
            relationship_description:this.emergency.relationship_description ? this.emergency.relationship_description : '',
            errors:{},
            relationshipOptions:[
                "son",
                "daughter",
                "spouse",
                "other",
            ]
        }
    },
    components: {
        BreezeLabel,
        TextInput,
        SelectInput,
        PhoneInput
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
                url: '/v1/emergency-contact',
                data: {
                    id:this.id,
                    first_name: this.first_name,
                    middle_name:this.middle_name,
                    last_name:this.last_name,
                    dob:this.dob,
                    phone:this.phone,
                    email:this.email,
                    national_id_no:this.national_id_no,
                    passport_no:this.passport_no,
                    relationship:this.relationship,
                    relationship_description:this.relationship_description,
                    user_id:this.user.id,
                    postal_address:this.postal_address,
                    postal_code:this.postal_code,
                    city:this.city
                }
                }).then((response) => {
                    this.id = response.data.id
                    this.loading = false
                    //console.log(this.id,response.data)
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