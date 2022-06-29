<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <app-header title="Home" :user="user"  />
    <div class="container-fluid profile">
        <div class="row">
            <div class="col-3 profile-panel">
                <HomeSidebar :user="user" />
            </div>
            <div class="col-9">
                <div class="tab-pane-content" style="margin-top:-15px;padding: 0 35px;">
                    <div class="card  border">
                        <div class="card-header bg-theme-bright text-white text-uppercase">
                            <span v-if="user.company">
                              <span class="fa fa-bell"></span>   What's happening at {{user.company.company_name}} 
                            </span>
                            <span class="float-end">
                                <a :href="route('test.payslip')" class="btn btn-theme mx-1">Generate payslip</a>
                            </span>
                        </div>

                        <Notifications />
                       
                        <div  class="card-footer border text-muted">
                            <Link  v-if="notifications" href="/notifications">
                                See More <small class="fa fa-arrow-right"></small>
                            </Link>
                        </div>
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
import HomeSidebar from '@/Components/HomeSidebar.vue';
import Personal from '@/Components/Profile/Personal.vue';
import Job from '@/Components/Profile/Job.vue';
import Leave from '@/Components/Profile/Leave.vue';
import Benefits from '@/Components/Profile/Benefits.vue';
import Assets from '@/Components/Profile/Assets.vue';
import Emergency from '@/Components/Profile/Emergency.vue';
import Notifications from './Notifications/Notifications.vue';

export default {
    props:{
        user:Object,
        notifications:Object
        },

    components:{
        
        BreezeAuthenticatedLayout,
        Head,
        Link,
        AppHeader,
        HomeSidebar,
        Personal,
        Job,
        Leave,
        Benefits,
        Assets,
        Emergency,
        Notifications,
    },
    methods:{
       
    },
   mounted(){
       //
   }

}
</script>
<style scoped>

li{
    cursor: pointer;
    padding: 15px 0;
}
li .icon{
    color: var(--theme-color);
    font-size: 1.6em;
}

</style>