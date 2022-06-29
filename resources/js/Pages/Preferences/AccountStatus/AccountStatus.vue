<template>

 <Head title="Preferences" />
    <BreezeAuthenticatedLayout>
     <app-header title="Preferences" subtitle="Account Status"  />
        <div class="container">
           
            <div class="section">
                <h1> <span class="fa fa-cog"></span> Preferences   </h1>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <Sidebar />
                </div>
                <div class="col-md-9">
                      <div class="container">
                            <div class="tab-pane-content pt-4">
                        <form action="#" class="border  mx-auto p-3">            
                                <h2 class="title-border pb-2"> 
                                    <span class="fa fa-chart-pie"></span> 
                                    Account status
                                </h2>
                                <div class="pt-3 row ">                    
                                    <div class=' col-md-5 my-3'>
                                        <p class="fw-bold py-2">Account name</p>
                                       <p>{{user.first_name}} {{user.middle_name}} {{user.last_name}}</p>
                                    </div>
                                    <div class='col-md-3 my-3'>
                                        <p class="fw-bold py-2">Account Status</p>
                                        <span v-if="user.reg_status == 0"> Active</span>
                                        <span v-if="user.reg_status == 1"> Initiated</span>
                                        <span v-if="user.reg_status == 2"> Under review</span>
                                        <span v-if="user.reg_status == 3"> Corrections requested</span>
                                        <span v-if="user.reg_status == 3"> Review complete</span>                                        
                                  </div>
                                    <div class='col-md-3 my-3'>
                                        <p class="fw-bold py-2">Job Status</p>
                                        <span v-if="user.status == 0"> Active </span>
                                        <span v-if="user.status == 1"> On leave</span>
                                        <span v-if="user.status == 2"> Reserved</span>
                                        <span v-if="user.status == 3"> Suspended</span>
                                        <span v-if="user.status == 4"> Dismissed</span>                                        
                                  </div>
                                </div>
                                <div class="text-right pb-2 pt-4">
                                    <a :href="route('preferences')" class="btn btn-theme submit px-5 " > <span class="fa fa-chevron-left"></span> Back</a>
                                </div>
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
        Sidebar,
        BreezeAuthenticatedLayout,
        AppHeader,
    },
    data(){
        return{
            user:this.$page.props.auth.user,
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