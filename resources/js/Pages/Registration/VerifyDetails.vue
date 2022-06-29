<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout :hideNavItems="true">
        <app-header :user="newEmployee" :title="newEmployee.first_name+' '+newEmployee.last_name"  />
    <div class="container-fluid profile">
        <div class="row">
            <div class="col-3 profile-panel">
                <RegistrationSidebar :user="newEmployee" />
            </div>
            <div class="col-9">
                <nav>
                   <Tabs  :employee="newEmployee"  />
                </nav>

                <div class="tab-pane-content" style="padding:15px" >
                    
                    <PreviewBasicDetails :user="newEmployee" />

                <p class="p-2">
                            <input v-model="declaration" type="checkbox" >
                            I certify that the data and information I have provided in all the forms above are true and correct to the best of my knowledge and belief and I understand that I subject myself to disciplinary action if the above facts are found to be falsified
                </p>

                <form class="border-top pt-2 pb-2 bg-light" id="submit-form" :action="route('employee.submit',newEmployee.username)">
                    
                    <Link :href="'/employee/registration/'+newEmployee.username+'?step=9'" class="btn btn-sm btn-secondary"> <span class="fa fa-chevron-left"></span> Back</Link>
                    
                    <BreezeButton @click.prevent="save" class="ml-4 btn btn-theme submit" :class="{'opacity-25':! declaration}" :disabled="! declaration ">Submit</BreezeButton>

                    
                </form>
                </div>
        </div>
    </div>
    </div>
        
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
import AppHeader from '@/Components/AppHeader.vue';
import RegistrationSidebar from '@/Components/RegistrationSidebar.vue';
import Personal from '@/Components/Profile/Personal.vue';
import Job from '@/Components/Profile/Job.vue';
import Leave from '@/Components/Profile/Leave.vue';
import Benefits from '@/Components/Profile/Benefits.vue';
import Assets from '@/Components/Profile/Assets.vue';
import Emergency from '@/Components/Profile/Emergency.vue';
import BreezeButton from '@/Components/Button.vue';
import Basic from '@/Components/Profile/Sections/Basic.vue';
import Tabs from '@/Components/Tabs.vue';
import PreviewBasicDetails from './Components/PreviewBasicDetails.vue';
import PreviewEducationDetails from './Components/PreviewEducationDetails.vue';

export default {
    props:{
        newEmployee:Object,
        settings:Array,
        formFields:Array,
    },
    data: function(){
      return{
          processing:false,
          declaration:false
      }
    },
    components:{
    BreezeAuthenticatedLayout,
    Head,
    Link,
    AppHeader,
    RegistrationSidebar,
    Personal,
    Job,
    Leave,
    Benefits,
    Assets,
    Emergency,
    BreezeButton,
    Basic,
    Tabs,
    PreviewBasicDetails,
    PreviewEducationDetails 
},
    methods:{
        save(){
            if( ! this.declaration ) return;

            if( confirm("Are you sure you want to submit details?") )
                $("#submit-form").submit()
        },
        continueLater(){
            alert("Details saved successfully. You can close the window and continue later")
        }
    },
    mounted(){
    }
}
</script>
<style scoped>
ul{
}
li{
    cursor: pointer;
    padding: 15px 0;
}
li .icon{
    color: var(--theme-color);
    font-size: 1.6em;
}
</style>