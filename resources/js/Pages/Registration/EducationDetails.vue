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
                   <Tabs :active="3" :employee="newEmployee" :link="'/employee/registration/'+newEmployee.username" />
                </nav>
                <div class="tab-pane-content"  >
                    
                    <form action="">
                        <Education :settings="settings" :user="newEmployee" />
                        <Certifications :settings="settings" :user="newEmployee" />
                        <Language :settings="settings" :user="newEmployee" />
                    </form>
                <form class="border-top p-2 bg-light" id="submit-form" :action="route('employee.submit',newEmployee.username)">
                    <Link :href="'/employee/registration/'+newEmployee.username+'?step=2'" class="btn btn-sm btn-secondary mr-4"> <span class="fa fa-chevron-left"></span> Back</Link>

                    <Link :href="'/employee/registration/'+newEmployee.username+'?step=4'" class="btn btn-sm btn-theme submit" >Next Page </Link>

                    <Link @click.prevent="continueLater()" class="ml-4" >
                            Save and continue later 
                    </Link>
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
import Education from '@/Components/Profile/Sections/Education.vue';
import Certifications from '@/Components/Profile/Sections/Certifications.vue';
import Language from '@/Components/Profile/Sections/Language.vue';
import Tabs from '@/Components/Tabs.vue';

export default {
    props:{
        newEmployee:Object,
        settings:Array,
    },
    data: function(){
      return{
          processing:false
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
        Education,
        Certifications,
        Language,
        Tabs
    },
    methods:{
        save(){
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
/*.edit-icon{
    display: none;
}
li:hover .edit-icon{
    display: block;
}*/
</style>