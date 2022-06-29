<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <div class="container">
             <div class="section">
                <h1> <span class="fa fa-bell"></span> Notifications  </h1>
            </div>

            <Notifications />
            
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
import Notifications from './Notifications/Notifications.vue';
export default {
    components:{
        BreezeAuthenticatedLayout,
        Head,
        Link,
        AppHeader,
        ProfileSidebar,
        Personal,
        Job,
        Notifications
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
.photo{
    width: 86px;
    height: 86px;
    /*background-color: var(--theme-color);*/
    border-radius: 50%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}
</style>