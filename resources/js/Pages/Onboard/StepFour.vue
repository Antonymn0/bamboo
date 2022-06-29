<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <div class="container">
            <div class="section">
                <h1> <span class="fa fa-user-plus"></span> New Employee   </h1>
            </div>
<div class="tab-pane-content">
    
            <form @submit.prevent="save" class="border">
                <h1 class="title-border pb-2"> <small class="fa fa-info-circle"></small> Continue? </h1>

                <!--<p class="p-3"> 
                    Send the employee a link to continue registration?
                </p>-->
                
                <div class="mt-3 text-center">
                    <Link :href="route('onboard.step.three',newEmployee.username)" class="btn btn-sm btn-secondary"> <span class="fa fa-chevron-left"></span> Back</Link>
                    <button class="btn btn-theme btn-sm ml-2" :class="{ 'opacity-25': processing || Object.keys(errors).length }" :disabled="processing || Object.keys(errors).length">
                       <span v-if="processing" class="fa fa-spinner fa-spin"></span>&nbsp; Send Registration Link to Employee 
                    </button>
                    <Link :href="route('employee.registration',newEmployee.username)" class="ml-2 btn btn-theme btn-sm" >
                         Continue Registration myself &nbsp;<span class="fa fa-chevron-right"></span>
                    </Link>
                    <div>

                    </div>
                </div>
            </form>
</div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
import AppHeader from '@/Components/AppHeader.vue';
import ProfileSidebar from '@/Components/ProfileSidebar.vue';
import Personal from '@/Components/Profile/Personal.vue';
import Job from '@/Components/Profile/Job.vue';
import BreezeInput from '@/Components/Input.vue';
import TextInput from '@/Components/TextInput.vue';
import AddressInput from '@/Components/AddressInput.vue';
import PhoneInput from '@/Components/PhoneInput.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeButton from '@/Components/Button.vue';

export default {
    props:{
        newEmployee:Object,
    },
    components:{
        BreezeAuthenticatedLayout,
        Head,
        Link,
        AppHeader,
        ProfileSidebar,
        Personal,
        Job,
        TextInput,
        AddressInput,
        PhoneInput,
        BreezeLabel,
        BreezeButton
    },
    data: function(){
      return{
          settings:[],
          errors:{},
          processing:false,
          user:this.$page.props.auth.user,
      }
    },
    methods:{
        getSetting(name,settings){
            let setting = '';
            for( let i = 0; i < settings.length; i ++ )
            {
                if( settings[i].name == name ){
                    setting = settings[i];
                    break;
                }
            }
            return setting;
        },
        update(response){
                let name = response.name
                let error = response.error
                let value = response.value
                this[name] = value;
                if( error ) this.errors[name] = error;
                else delete this.errors[name];
            },
        
        save(){
            this.processing = true
            axios({
                method: 'post',
                url: '/v1/onboard/4',
                data: {
                    id:this.newEmployee.id,
                }
                }).then((response) => {
                    alert( "A link has been sent to "+this.newEmployee.first_name+" that will allow registration to continue" )
                    window.open('/employees','_self')
                    this.processing = false
                })
                .catch( (error) => {
                console.log(error.response);
            });
        }
    }
}
</script>
<style scoped>
.section{
    padding: 30px 0;
    border-bottom: 1px solid var(--grey);
}
.section h1{
    color: var(--theme-color);
}
form{
    margin: 25px auto;
    padding: 15px;
}
</style>