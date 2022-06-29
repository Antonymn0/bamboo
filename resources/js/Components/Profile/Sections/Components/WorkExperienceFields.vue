<template>
  
          <div class="row g-3 pt-2">
            <div class="col-8">
                <TextInput :label="serial+'. Title'" :class="{'border-danger':errors.title}" id="title" name="title" type="text" :min="3" :max="255" noDigits required noSymbols placeholder="Position Title" classes="text-capitalize" v-on:save="update"  v-on:changed="save" :initVal="title"/>
            </div>
            <div class="4"></div>
            <div class="col-6 mb-2">
                <TextInput label="Company" :class="{'border-danger':errors.company}" id="company" name="company" type="text" :min="3" :max="255" noDigits required noSymbols placeholder="Company Name" classes="text-capitalize" v-on:save="update"  v-on:changed="save" :initVal="company"/>
            </div>
            <div class="col-6 mb-2">
                <AddressInput label="Location" :class="{'border-danger':errors.location}" id="location" name="location" type="text" :min="3" :max="255" required noSymbols placeholder="Company Location" classes="text-capitalize" v-on:save="updateAddress"  v-on:changed="save" :initVal="location"/>
            </div>
            
            <div class="col-4 mb-2">
                <!--<label for="start_date">From <small class="text-danger"> {{errors.start_dat}} </small></label>
                <input v-model="start_date" @change="save" :class="{'border-danger':errors.start_date}" id="start_date" name="start_date" type="date"    required placeholder="Start Date" class="form-control" v-on:save="update"  v-on:changed="save" :initVal="start_date"/>-->
                <DateInput label="Start Date"  :id="serial+'-start_date'" name="start_date" type="text"  required  placeholder="Start Date Name" classes="text-capitalize" v-on:save="update"  v-on:changed="save" :initVal="start_date"/>
            </div>
            <div class="col-4 mb-2">
                <!--<label for="end_date">To <small class="text-danger"> {{errors.end_date}} </small></label>
                <input v-model="end_date" @change="save" :class="{'border-danger':errors.end_date}" id="end_date" name="end_date" type="date"  :min="start_date"  requireds placeholder="End Date" class="form-control" v-on:save="update"  v-on:changed="save" :initVal="end_date"/>-->
                <DateInput label="End Date" :key="start_date" :min="start_date" :id="serial+'-end_date'" name="end_date" type="text"  required  placeholder="Start Date Name" classes="text-capitalize" v-on:save="update"  v-on:changed="save" :initVal="end_date"/>
            </div>

            <div class="col-7 mb-2">
                <label for="description">Description <small class="text-danger"> {{errors.description}} </small></label>
                <textarea v-model="description" name="description" id="description" class="form-control" @change="save"></textarea>
            </div>
          </div>

</template>

<script>
import TextInput from '@/Components/TextInput.vue';
import DateInput from '@/Components/DateInput.vue';
import ContentInput from '@/Components/ContentInput.vue';
import AddressInput from '@/Components/AddressInput.vue';
import BreezeLabel from '@/Components/Label.vue';
export default {
props:{
        user:Object,
        experience:Object,
        serial:Number
    },
data() {
        return {
            id:this.experience.id ? this.experience.id : '',
            title: this.experience.title ? this.experience.title : '',
            company: this.experience.company ? this.experience.company : '',
            location: this.experience.location ? this.experience.location : '',
            start_date:this.experience.start_date ? this.experience.start_date : '',
            end_date:this.experience.end_date ? this.experience.end_date : '',
            description:this.experience.description ? this.experience.description : '',
            lat:this.experience.lat ? this.experience.lat : '',
            lng:this.experience.lng ? this.experience.lng : '',
            country:this.experience.country ? this.experience.country : '',
            search_str:this.experience.search_str ? this.experience.search_str : '',
            postal_code:this.experience.postal_code ? this.experience.postal_code : '',
            physical_address:this.experience.physical_address ? this.experience.physical_address : '',
            errors:{}
        }
    },
    components: {
        BreezeLabel,
        TextInput,
        AddressInput,
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
            this.location = data.physical_address
            this.save()
        },
        save(){
            this.loading = true
            axios({
                method: 'post',
                url: '/v1/work-experience',
                data: {
                    id:this.id,
                    title: this.title,
                    company: this.company,
                    location: this.location,
                    start_date:this.start_date,
                    end_date:this.end_date,
                    description:this.description,
                    lat:this.lat,
                    lng:this.lng,
                    country:this.country,
                    postal_code:this.postal_code,
                    physical_address:this.physical_address,
                    user_id:this.user.id
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