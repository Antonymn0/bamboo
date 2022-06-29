<template>
  <div class="tab-pane-content">
      <h1 class="title-border pb-2"> <small class="fa fa-id-card"></small> Personal </h1>
      <form action="" >
        <Basic :settings="settings" :user="user" :permissions="permissions" />
      
        <Address :settings="settings" :user="user" :permissions="permissions" />

        <Contact :settings="settings" :user="user" :permissions="permissions" />

      </form>

      
      <Education :settings="settings" :user="user" :permissions="permissions" />

        <Certifications :settings="settings" :user="user" :permissions="permissions" />

       <Language :settings="settings" :user="user" :permissions="permissions" />

        <WorkExperience :settings="settings" :user="user" :permissions="permissions" />
      <Dependants :settings="settings" :user="user" :permissions="permissions" />

      <Beneficiaries :settings="settings" :user="user" :permissions="permissions" />

      <Emergency :settings="settings" :user="user" :permissions="permissions" />

      <Referees :settings="settings" :user="user" :permissions="permissions" />

      <form action="">
        <Social :settings="settings" :user="user" :permissions="permissions" />
       </form>

      <!-- <Visa :settings="settings" :user="user" :permissions="permissions" />-->

       
  </div>
</template>

<script>
import TextInput from '@/Components/TextInput.vue';
import BreezeLabel from '@/Components/Label.vue';
import Basic from './Sections/Basic.vue';
import Address from './Sections/Address.vue';
import Contact from './Sections/Contact.vue';
import Social from './Sections/Social.vue';
import Education from './Sections/Education.vue';
import Language from './Sections/Language.vue';
import Visa from './Sections/Visa.vue';
import Dependants from './Sections/Dependants.vue';
import Beneficiaries from './Sections/Beneficiaries.vue';
import Certifications from './Sections/Certifications.vue';
import WorkExperience from './Sections/WorkExperience.vue';
import Emergency from './Sections/Emergency.vue';
import Referees from './Sections/Referees.vue';

export default {
    props:{
        settings:Array,
        user:Object,
        permissions:Array,

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
            }),
            errors:{}
        }
    },
    components: {
    BreezeLabel,
    TextInput,
    Basic,
    Address,
    Contact,
    Social,
    Education,
    Language,
    Visa,
    Dependants,
    Certifications,
    Beneficiaries,
    WorkExperience,
    Emergency,
    Referees
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
    },
}
</script>
