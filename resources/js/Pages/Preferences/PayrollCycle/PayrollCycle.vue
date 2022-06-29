<template>

 <Head title="Preferences" />
    <BreezeAuthenticatedLayout>
     <app-header title="Preferences" subtitle="Payroll cycle"  />
        <div class="container">
           
            <div class="section">
                <h1> <span class="fa fa-cog"></span> Preferences   </h1>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <Sidebar />
                </div>
                <div class="col-md-9">
                    <PayrollCycleComponent />   
                </div>
            </div>
                                
        </div> 

    </BreezeAuthenticatedLayout>    
 
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
import PayrollCycleComponent from './PayrollCycleComponent';
import Sidebar from '../Layouts/Sidebar.vue';
import AppHeader from '@/Components/AppHeader.vue';

import TextInput from '@/Components/TextInput.vue';


export default {
    props:{
        company:Object
    },
    components:{
        Head,
        TextInput,
        Link,
        PayrollCycleComponent,
        Sidebar,
        BreezeAuthenticatedLayout,
        AppHeader,
    },
    data(){
        return{
            auth_user:this.$page.props.auth.user,
            company:this.$page.props.auth.user.company,
          
        }
    },
    methods:{        
        
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