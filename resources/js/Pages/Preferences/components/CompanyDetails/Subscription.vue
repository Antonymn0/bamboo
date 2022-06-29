<template>
    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout>
 <app-header title="Subscription" subtitle="Subscribe to a package"  />
        <div class="container">
           
            <div class="section">
                <h1> <span class="fa fa-cog"></span> Preferences   </h1>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <Sidebar />
                </div>

                <div class="col-md-9 ">                    
                  <SubscriptionPayment />
                </div>                
            </div>            
        </div>        
    </BreezeAuthenticatedLayout>
</template>
<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
import Sidebar from '../../Layouts/Sidebar.vue';
import AppHeader from '@/Components/AppHeader.vue';
import SubscriptionPayment from '../../../Subscription/SubscriptionPayment.vue';


export default {
    props:{
        company:Object
    },
    components:{
        Head,
        Sidebar,
        BreezeAuthenticatedLayout,
        AppHeader,
        SubscriptionPayment
       
    },
    data(){
        return{
            auth_user:this.$page.props.auth.user,
            field:{},
            errors:{},
            success:{},
                      
        }
    },
    methods:{
        
        
    },
    mounted(){
        console.log(this.company)
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
ul li:hover{
    cursor: pointer;
    color: var(--theme-color);
}
.active{
    color: var(--theme-color);
}
.package-box{
    border:1px solid var(--theme-color);
}
.package-box:hover{
    background: var(--theme-color);
    color:#fff;
}

</style>