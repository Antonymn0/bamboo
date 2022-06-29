<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <div class="container">
            <div class="section">
                <h1> 
                    <span class="fa fa-user-minus"></span> 
                    Finish Offboarding 
                </h1>
            </div>
        <div class="tab-pane-content">
                
            <form @submit.prevent="save" class="border">
                <h1 class="title-border mb-3 pb-2"> 
                    <small class="fa fa-clipboard-list"></small>
                    Finish offboarding
                    <small class="fa fa-question-circle cursor-pointer" title="Create a task and assign it to other employees to assist in onboarding new employee"></small>
                 </h1>
                    
                
                
                <div class="flex items-center justify-center mt-3 py-5">
                    <Link :href="route('offboard.user', employee.id)" class="btn btn-sm btn-secondary mr-4"> <span class="fa fa-chevron-left"></span> Back</Link>
                    <a href="#" class="btn btn-sm btn-theme mr-4" @click.prevent="processOffboarding()">  Offboard</a>                    
                </div>
            </form>
        </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head,Link } from '@inertiajs/inertia-vue3';


export default {
    props:{
        employee:Object,

    },
    components:{
    BreezeAuthenticatedLayout,
    Head,
    Link,
   
},
    data: function(){
      return{

          user:this.$page.props.auth.user,
      }
    },
    methods:{        
        
        processOffboarding(){
            if(! confirm('Proceed to offboard this user?')) return;          
            this.$inertia.get(route('process.offboarding.user', this.employee.id)  );
        },
        
    },
    mounted(){
        //

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