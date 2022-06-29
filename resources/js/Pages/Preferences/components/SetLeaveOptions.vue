<template>
    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout>
<app-header title="Preferences" subtitle="Leave options"  />
        <div class="container pb-2">
            
            <div class="section">
                <h1> <span class="fa fa-cog"></span> Preferences   </h1>
            </div>
            <div class="row">
                 
                <div class="col-md-3">
                    <Sidebar />
                </div>

                <div class="col-md-9 py-3"> 
                   
                    <LeaveOptions /> 
                      <div class="text-center border-top pt-2">
                            <Link :href="route('preferences')" class="btn btn-secondary submit px-2 "> <span class="fa fa-chevron-left"></span> Back</Link>
                            <Link :href="route('preferences' )" class="btn btn-theme submit px-5 mx-2">  Save </Link>
                        </div>	
                </div>  

            </div>            
        </div>        
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
import Sidebar from '../Layouts/Sidebar.vue';
import AppHeader from '@/Components/AppHeader.vue';
import TextInput from '@/Components/TextInput.vue';
import LeaveOptions from './Leave/LeaveOptionsComponent.vue';


export default {
    props:{
        company:Object
    },
    components:{
        Head,
        Sidebar,
        BreezeAuthenticatedLayout,
        AppHeader,
        TextInput,
        Link,
        LeaveOptions
    },
    data(){
        return{
            auth_user:this.$page.props.auth.user,
        }
    },
    methods:{
        
       
    },
    mounted(){
       
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

ul li{
    padding: 15px;
}
ul li:hover, ol li:hover, ul li i:hover {
    cursor: pointer;
    color: var(--theme-color);
}
.active{
    color: var(--theme-color);
}
</style>