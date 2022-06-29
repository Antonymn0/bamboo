<template>

 <Head title="Preferences" />
    <BreezeAuthenticatedLayout> 
    <app-header title="Assets" subtitle="Manage Employee Assets"  />
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
                            <div class="border  mx-auto p-3">            
                                <h2 class="title-border pb-2"> 
                                    <span class="fa fa-chart-pie"></span> 
                                    Assets
                                </h2>
                                <div class="pt-3  table-responsive">  
                                    <p class="text-center fw-bold pb-3"> Assets record 
                                        <Link :href="route('add.new.asset')" class="btn btn-theme float-right btn-sm"> <span class="fa fa-plus"></span> New</Link>
                                    </p>
                                     <table class="table table-sm table-striped text-muted" v-if="Object.keys(current_assets).length">
                                        <thead>
                                            <th>#</th>
                                            <th >Asset name</th>
                                            <th >Asset type</th>
                                            <th>Asset reg no</th>
                                            <th >Assigned to</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(asset, index) in current_assets" :key="index">
                                                <td>{{index +1}}</td>
                                                <td class="text-capitalize">{{asset.name}}</td>
                                                <td class="text-capitalize">{{asset.type}}</td>
                                                <td>{{asset.asset_registration_no}}</td>
                                                <td class="text-capitalize">{{asset.assigned_to}}</td>
                                                <td>
                                                    <Link :href="route('edit.asset', asset.id)">  <span class="fa fa-edit mx-2  text-primary"></span> </Link>
                                                    <span class="fa fa-trash mx-2 btn text-danger border" @click.prevent="deleteAsset(asset.id)"></span>
                                                </td>
                                                
                                            </tr>
                                        </tbody>
                                     </table>
                                     <p v-else class="text-center py-5 text-muted">No assets records found</p>
                                </div>
                                
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
import Sidebar from '../Layouts/Sidebar.vue';
import AppHeader from '@/Components/AppHeader.vue';
import SearchInput from '../../../Components/SearchInput.vue';
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
         SearchInput,
    },
    data(){
        return{
            user:this.$page.props.auth.user,
            company:this.$page.props.auth.user.company,   
            errors:{}  ,
             
            current_assets:{}
        }
    },
    methods:{  
        fetchAssets(){
            axios.get(route('company.assets', this.user.company_id))
            .then(response=>{
                this.current_assets = response.data.data;
                console.log(response);
            })
            .catch(error=>{
                console.log(error.response);
            })
        },
        deleteAsset(asset_id){
            if(! confirm('Delete this asset?')) return;
            axios.get(route('asset.delete', asset_id))
            .then(response=>{
                this.fetchAssets();
            })
            .catch(error=>{
                console.log(error.response);
            })
        },

    },
    mounted(){
        this.fetchAssets();
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