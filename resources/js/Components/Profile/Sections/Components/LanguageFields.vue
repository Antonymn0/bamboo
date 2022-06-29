<template>
          <div class="row g-3 pt-2">
            <div class="col-4">
                <TextInput :label="serial+'. Language'"  id="name" name="name" type="text"  :max="255" noDigits required noSymbols placeholder="Language Name" classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="name"/>
            </div>
            <div class="col-4">
                
                <SelectInput label="Written Proficiency"  :key="proficiencyOptions" :options="proficiencyOptions"  id="written_proficiency" name="written_proficiency" required noSymbols placeholder="Choose..." classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="written_proficiency" />
            </div>
            <div class="col-4">
                
                <SelectInput label="Spoken Proficiency"  :key="proficiencyOptions" :options="proficiencyOptions"  id="spoken_proficiency" name="spoken_proficiency" required noSymbols placeholder="Choose..." classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="spoken_proficiency" />
            </div>
          </div>
</template>

<script>
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import BreezeLabel from '@/Components/Label.vue';
export default {
    props:{
        user:Object,
        language:Object,
        serial:Number
    },
data() {
        return {
            id:this.language.id ? this.language.id : '',
            name: this.language.name ? this.language.name : '',
            written_proficiency: this.language.written_proficiency ? this.language.written_proficiency : '',
            spoken_proficiency: this.language.spoken_proficiency ? this.language.spoken_proficiency : '',
            errors:{},
            proficiencyOptions:[
                "beginner",
                "intermediate",
                "proficient",
                "native",
            ]
        }
    },
    components: {
        BreezeLabel,
        TextInput,
        SelectInput,
    },

    methods:{
        update(response){
                let name = response.name
                let error = response.error
                let value = response.value
                this[name] = value;
                if( error ) this.errors[name] = error;
                else delete this.errors[name];
                if( response.sync )
                    this.save()
                //this.disableSubmit( )
                
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
                url: '/v1/languages',
                data: {
                    id:this.id,
                    name: this.name,
                    written_proficiency: this.written_proficiency,
                    spoken_proficiency: this.spoken_proficiency,
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