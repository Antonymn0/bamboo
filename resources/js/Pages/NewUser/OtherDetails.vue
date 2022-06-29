<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout :hideNavItems="true">
        <app-header :title="newEmployee.first_name+' '+newEmployee.last_name"  />
    <div class="container-fluid profile">
        <div class="row">
            <div class="col-3 profile-panel">
                <RegistrationSidebar :user="newEmployee" />
            </div>
            <div class="col-9">
                <nav>
                    <Tabs :active="7" :user="newEmployee" />
                </nav>

                <div style="padding:15px" >
                    

                <div class="tab-pane-content">
                    <h1 class="title-border pb-2"> <small class="fa fa-id-card"></small> Personal </h1>
                    <form action="">
                        <Emergency :showVerifyBox="true" :permissions="permissions" :settings="settings" :user="newEmployee" />
                        <Dependants :showVerifyBox="true" :permissions="permissions" :settings="settings" :user="newEmployee" />
                        <Beneficiaries :showVerifyBox="true" :permissions="permissions" :settings="settings" :user="newEmployee" />
                    </form>

                    <form class="border-top pt-2 pb-2 bg-light" id="submit-form" >
                        
                        <Link :href="route('newuser.work.details',newEmployee.username)" class="btn btn-secondary mr-4"> <span class="fa fa-chevron-left"></span> Back</Link>

                        <Link href="#" @click.prevent="finish" class="btn btn-theme ml-4 ">Finish</Link>

                        <Link @click.prevent="continueLater()" class="ml-4" >
                                Save and continue later &nbsp;<span class="fa fa-chevron-right"></span>
                        </Link>
                    </form>

                </div>
                
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
import BreezeButton from '@/Components/Button.vue';
import Emergency from '../../Components/Profile/Sections/Emergency.vue';
import Dependants from '../../Components/Profile/Sections/Dependants.vue';
import Beneficiaries from '../../Components/Profile/Sections/Beneficiaries.vue';
import Tabs from '@/Components/Tabs2.vue';
export default {
    props:{
        newEmployee:Object,
        settings:Array,
        permissions:Array,
        currentTaskID:Number,
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
        BreezeButton,
        Emergency,
        Dependants,
        Beneficiaries,
        Tabs

    },
    methods:{
        save(){
            if( confirm("Are you sure you want to send the form back to employee?") )
                $("#submit-form").submit()
        },
        continueLater(){
            alert("Details saved successfully. You can close the window and continue later")
        },
        finish(){
            if( ! this.currentTaskID ) return;

            if( ! confirm("Are you sure you want to finish task?") ) return;

            this.processing = true;
            axios({
                method: 'post',
                url: '/v1/task/complete/'+this.currentTaskID,
                data: {
                    
                }
            }).then((response) => {
                this.processing = false
                let task = response.data

                if( task.status == 'complete' )
                    alert( "Task completed succesfully" )
                else 
                    alert( "Corrections request sent to employee" )

                window.open('/update/task/'+task.id,'_self');
            })
            .catch( (error) => {
                console.log(error.data);
            });
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