<template>
          <div class="row g-3 pt-2 mt-2">
            
            <div class="col-4 mb-2">
                <TextInput :label="serial+'. First Name'" :class="{'border-danger':errors.first_name}" id="first_name" name="first_name" type="text" :min="3" :max="255" noDigits required noSymbols placeholder="First Name" classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="first_name"/>
            </div>
            <div class="col-4 mb-2">
                <TextInput :class="{'border-danger':errors.middle_name}" id="middle_name" name="middle_name" type="text" :min="3" :max="255" noDigits  noSymbols placeholder="Middle Name" classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="middle_name"/>
            </div>
            <div class="col-4 mb-2">
                <TextInput :class="{'border-danger':errors.last_name}" id="last_name" name="last_name" type="text" :min="3" :max="255" noDigits required noSymbols placeholder="Surname" classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="last_name"/>
            </div>

            <div class="col-4 mb-2">
                <SelectInput label="Gender"  :key="genderOptions" :options="genderOptions" :class="{'border-danger':errors.gender}" id="gender" name="gender" required noSymbols placeholder="Choose..." classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="gender" />
            </div>
            <div class="col-8"></div>
            
            <div class="col-6 mb-2">
                <PhoneInput :class="{'border-danger':errors.phone}" id="phone" name="phone" type="text" :min="9" :max="15" noLetters required noSymbols placeholder="Phone No." classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="phone"/>
            </div>
            <div class="col-6 mb-2">
                <TextInput :class="{'border-danger':errors.email}" id="email" name="email" type="email"  :max="255"  required  placeholder="Email Address" classes="" v-on:save="update" v-on:changed="save" :initVal="email"/>
            </div>
            <div class="col-4 mb-2">
                <TextInput :class="{'border-danger':errors.postal_address}" id="postal_address" noLetters name="postal_address" type="text"   placeholder="Postal Address" classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="postal_address"/>
            </div>
            <div class="col-4 mb-2">
                <TextInput :class="{'border-danger':errors.postal_code}" id="postal_code" noSymbols name="postal_code" type="text" noLetters   placeholder="Postal Code" classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="postal_code"/>
            </div>
            <div class="col-4 mb-2">
                <TextInput :class="{'border-danger':errors.city}" id="city" noSymbols name="city" type="text"  :max="255" label="City/Town"  placeholder="City/ Town" classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="city"/>
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
        referee:Object,
        serial:Number
    },
data() {
        return {
            id:this.referee.id ? this.referee.id : '',
            first_name: this.referee.first_name ? this.referee.first_name : '',
            middle_name: this.referee.middle_name ? this.referee.middle_name : '',
            last_name: this.referee.last_name ? this.referee.last_name : '',
            phone:this.referee.phone ? this.referee.phone : '',
            email:this.referee.email ? this.referee.email : '',
            postal_address:this.referee.postal_address ? this.referee.postal_address : '',
            postal_code:this.referee.postal_code ? this.referee.postal_code : '',
            city:this.referee.city ? this.referee.city : '',
            gender:this.referee.gender ? this.referee.gender : '',
            errors:{},
            genderOptions:[
                'male',
                'female'
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
                url: '/v1/referees',
                data: {
                    id:this.id,
                    first_name: this.first_name,
                    middle_name:this.middle_name,
                    last_name:this.last_name,
                    phone:this.phone,
                    email:this.email,
                    user_id:this.user.id,
                    postal_address:this.postal_address,
                    postal_code:this.postal_code,
                    city:this.city,
                    gender:this.gender
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