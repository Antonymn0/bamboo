<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
            <app-header title="Notifications" subtitle="Notifications"  />
        <div class="container">
            <div class="section">
                <h1> <span class="fa fa-cog"></span> Preferences   </h1>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <Sidebar />
                </div> 
                <div class="col-md-9 p-2">
                    <h1 class="pl-2"> <span class="fa fa-bell"></span> Notifications</h1>

                        <Notifications />
                                   
                    </div>
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
import Sidebar from '../Layouts/Sidebar.vue';
import SearchInput from '../../../Components/SearchInput.vue';
import Notifications from '../../Notifications/Notifications.vue';
export default {

    components:{
        BreezeAuthenticatedLayout,
        Head,
        Link,
        AppHeader,
        ProfileSidebar,
        Personal,
        Job,
        Sidebar,
        SearchInput,
        Notifications        
    },
    data(){
        return{
            user:this.$page.props.auth.user,           
        }
    },
       
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

li{
    padding: 5px;
}
li label:hover{
    cursor: pointer;
    color: var(--theme-color);
}
.active{
    color: var(--theme-color);
}

.accordion-button:not(.collapsed) {
    color:rgb(82, 79, 79); 
    background-color: rgba(187, 185, 187, 0.027); 
    box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.125);
}
.accordion-button:focus {
    z-index: 3;
    border-color: #9272922e;
    outline: 0;
    color:rgb(71, 70, 70);
    box-shadow: 0 0 0 0.25rem #80008063;
}
</style>