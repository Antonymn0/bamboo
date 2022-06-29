<template>
          <div class="row g-3 pt-2">
            <div class="col-8">
                {{visa}}
                <label for="language_name">Language <small class="text-danger"> {{errors.language_name}} </small></label>
                <TextInput :class="{'border-danger':errors.language_name}" id="language_name" name="language_name" type="text" :min="3" :max="255" noDigits required noSymbols placeholder="Language Name" classes="text-capitalize" v-on:save="update" :initVal="form.language_name"/>
            </div>
            <div class="col-4"></div>
            <div class="col-4">
                <label for="twitter">Written Proficiency <small class="text-danger"> {{errors.twitter}} </small></label>
                <select v-model="form.marital_status" id="marital_status" name="marital_status" class="form-select">
                        <option value="">Choose...</option>
                        <option value="1">Beginner</option>
                        <option value="2">Intermediate</option>
                        <option value="3">Proficient</option>
                        <option value="4">Native </option>
                </select>
            </div>
            <div class="col-4">
                <label for="twitter">Spoken Proficiency <small class="text-danger"> {{errors.twitter}} </small></label>
                <select v-model="form.marital_status" id="marital_status" name="marital_status" class="form-select">
                        <option value="">Choose...</option>
                        <option value="1">Beginner</option>
                        <option value="2">Intermediate</option>
                        <option value="3">Proficient</option>
                        <option value="4">Native </option>
                </select>
            </div>
          </div>
</template>

<script>
import TextInput from '@/Components/TextInput.vue';
import BreezeLabel from '@/Components/Label.vue';
export default {
props:{
    visa:Object
},
data() {
        return {
            form: this.$inertia.form({
                first_name: '',
                middle_name: '',
                last_name: '',
                dob:'',
                gender:'',
                marital_status:'',
                qualification:'',
                grade:''
            }),
            errors:{}
        }
    },
    components: {
        BreezeLabel,
        TextInput,
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
            this.form.lat = data.lat
            this.form.lng = data.lng
            this.form.country = data.country
            this.form.search_str = data.search_str
            this.form.postal_code = data.postal_code
            this.form.physical_address = data.physical_address
        }
    }
}
</script>

<style>

</style>