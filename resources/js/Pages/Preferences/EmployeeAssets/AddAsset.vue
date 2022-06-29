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
                            <form action="#" class="border  mx-auto p-3">            
                                <h2 class="title-border pb-2"> 
                                    <span class="fa fa-chart-pie"></span> 
                                    Add Assets
                                </h2>
                                <div class="pt-3  row">  
                                     <h6> Create New Asset </h6>                
                                   <div class="col-md-6">                                       
                                       <div class="my-2">
                                           <TextInput :class="{'border-danger':errors.country}" v-on:save="update" v-on:changed="update" label="Asset name" id="asset_name" name="asset_name" type="text"   required  placeholder="Asset name" classes="text-capitalize"  initVal=""/>
                                       </div>
                                       <small class="text-danger">{{this.errors.asset_name}}</small>
                                       <div class="my-3">
                                           <TextInput :class="{'border-danger':errors.country}" v-on:save="update" v-on:changed="update" label="Asset type" id="asset_type" name="asset_type" type="text"   required  placeholder="Asset type" classes="text-capitalize"  initVal=""/>
                                       </div>
                                      <small class="text-danger">{{this.errors.asset_type}}</small>
                                    </div>
                                   <div class="col-md-6">
                                       <div class="my-2">
                                           <TextInput :class="{'border-danger':errors.country}" v-on:save="update" v-on:changed="update" label="Asset registration no" id="asset_type" name="asset_registration_number" type="text"   required  placeholder="Asset reg no" classes="text-capitalize"  initVal=""/>
                                       </div>
                                      <small class="text-danger">{{this.errors.asset_registration_number}}</small>
                                       <div class="my-3">
                                           <SearchInput  label="Assign to" modeltype="user" searchurl="/v1/users/search"  placeholder="Search Employee..." name="assigned_to" id="field.id" type="text" classes="form-control text-capitalize"  required v-on:selection="selectUser" initVal=""  />
                                       </div>
                                   </div>
                                </div>
                                <div class="text-right pb-2 pt-4">
                                    <Link :href="route('employee.assets.form')" class="btn btn-secondary submit px-2 " > <span class="fa fa-chevron-left"></span> BAck</Link>
                                    <button  class="btn btn-theme submit px-5 mx-2" @click.prevent="submitForm()">  Add</button>
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
            assigned_to:null ,
            asset_name:null,    
            asset_type:null, 
            asset_registration_number:null,   
        }
    },
    methods:{  
        update(response){
            let name = response.name
            let error = response.error
            let value = response.value
            this[name] = value;
            if( error ) this.errors[name] = error;
            else delete this.errors[name];

            if( name == 'disability' ) 
                if( value ) this.toggleDisabilityFields(true) 
                else this.toggleDisabilityFields(false) 
        }, 
        submitForm(){
            this.validateForm();
            if(Object.keys(this.errors).length) return;

            var form_data = new FormData();
                form_data.append('name', this.asset_name);
                form_data.append('type', this.asset_type);
                form_data.append('company_id', this.user.company_id);
                form_data.append('asset_registration_no', this.asset_registration_number);
               if(this.assigned_to) form_data.append('assigned_to', this.assigned_to.id);

            if(!confirm('Save new asset?')) return;

            axios.post(route('employee.assets.post'), form_data)
            .then(response=>{
                console.log(response);
            })
            .catch(error=>{
                console.log(error.response);
            })
        },
        selectUser(user){
            this.assigned_to = user
        },
        validateForm(){
            this.errors={}
            if(! this.asset_name) this.errors.asset_name = "This field is required";
            if(! this.asset_type) this.errors.asset_type = "This field is required";
            if(! this.asset_registration_number) this.errors.asset_registration_number = "This field is required";
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