<template>
    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout>
 <app-header title="Preferences" subtitle="Departments"  />
        <div class="container">
           
            <div class="section">
                <h1> <span class="fa fa-cog"></span> Preferences   </h1>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <Sidebar />
                </div>

                <div class="col-md-9 ">                    
                    <div class="tab-pane-content pt-4">
                    <form @submit.prevent="" class="border  mx-auto p-3">
                        <h2 class="title-border pb-2"> 
                            <span class="fa fa-id-card"></span> 
                            Update departments
                        </h2>

                        <div class="py-3 row">

                            <div class="col-md-6">
                                <div class='my-3'>
                                    <h3 class="fw-bold"> Add new department </h3>
                                </div>
                                <div class='my-3'>
                                    <TextInput :class="{'border-danger':errors.department_name}"  id="department_name" name="department_name" type="text" :min="3" :max="255" v-on:save="update" v-on:changed="update" required  placeholder="Department name" classes="text-capitalize"  initVal=""/>
                                    <small class="text-danger"> {{this.errors.department_name}} </small>
                                </div>
                                <div class='my-3'>
                                    <button class="btn btn-theme px-5" @click.prevent="addDepartment()">Add</button>
                                </div>                              
                            </div> 	

                            <div class="col-md-6">
                                <div class='my-3'>
                                    <h3 class="fw-bold"> Current departments </h3>
                                </div>
                                <div class='my-3'>
                                    <ol v-for="(department, index) in this.current_departments" :key="index" class="border-start px-2">
                                        <li class="d-flex justify-between py-1 text-capitalize"> 
                                            <span>  {{department.name}} </span>
                                            <span role="button" @click.prevent="deleteDepartment(department.id)">  <i class="bi bi-x-circle p-2 cursor-pointer"   ></i> x </span>
                                        </li>                                        
                                    </ol>
                                </div>                             
                            </div>				
                        </div>
                        <div class="text-right border-top pt-2">
                            <Link :href="route('preferences')" class="btn btn-secondary submit px-2 "> <span class="fa fa-chevron-left"></span> Back</Link>
                            <Link :href="route('set.leave.options',company.id )" class="btn btn-theme submit px-5 mx-2">  Continue </Link>
                        </div>				
                </form>
                </div>
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
import TextInput from '@/Components/TextInput.vue';


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
        Link
    },
    data(){
        return{
            auth_user:this.$page.props.auth.user,
            field:{},
            errors:{},
            department_name:null ,
            current_departments:{}

        }
    },
    methods:{
        getMetaValue(key,metaData){
            let value = '';
            for( let i = 0; i < metaData.length; i++ )
            {
                if( metaData[i].key == key ){
                    value = metaData[i].value;
                    break;
                }
            }
            return value;
        },
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
        addDepartment(){
            this.errors={}
            if(! this.department_name) { this.errors.department_name = "Enter department name"; return; }

            var form_data = new FormData();
                form_data.append('name', this.department_name);
                form_data.append('slug', this.department_name);
                form_data.append('company_id', this.company.id);
                form_data.append('created_by', this.auth_user.id);
            
            axios.post('/v1/departments', form_data)
            .then(response=>{
                this.department_name = null;
                this.fetchDepartments();
            })
            .catch(error=>{
                if(error.response.status == 422) this.errors.department_name = "Department name already exists";
                console.log(error.response);
            })
        },
        fetchDepartments(){
            axios.get(route('get.departments', this.company.id))
            .then(response=>{
                this.current_departments = response.data.data;
            })
            .catch(error=>{
                console.log(error.response);
            })
        },
        deleteDepartment(id){
            axios.get(route('delete.departments', id))
            .then(response=>{
               this.fetchDepartments();
            })
            .catch(error=>{
                console.log(error.response);
            })
        }
        
        
    },
    mounted(){
       this.fetchDepartments();
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