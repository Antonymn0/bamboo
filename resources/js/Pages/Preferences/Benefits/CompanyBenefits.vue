<template>
    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout>
<app-header title="Preferences" subtitle="Benefits"  />
        <div class="container pb-2">
            
            <div class="section">
                <h1> <span class="fa fa-cog"></span> Preferences   </h1>
            </div>
            <div class="row">
                 
                <div class="col-md-3">
                    <Sidebar />
                </div>

                <div class="col-md-9 py-3"> 
                   
                    <div class="tab-pane-content pt-4">
                    <form @submit.prevent="" class="border  mx-auto p-3">
                        <h2 class="title-border pb-2"> 
                            <span  class="fa fa-umbrella-beach"></span> 
                            Select Benefits   
                        </h2>

                            <div class="col-md-9 mx-auto">                                                              
                                    <h3 class="fw-bold my-3"> Available options </h3>
                                <div class='my-3'>                                    
                                    <input type="checkbox" class="m-2" name="selected_benefit" :checked="isSelected(1, selected_benefits)" value="1" id="1" v-model="selected_benefits" @change.prevent="detectAction(1)">
                                    <label for="1">Basic Salary</label>                                    
                                </div>                                                              
                                <div class='my-3'>                                    
                                    <input type="checkbox" class="m-2" name="selected_benefit" :checked="isSelected(2 , selected_benefits)" value="2" id="2" v-model="selected_benefits" @change.prevent="detectAction(2)">
                                    <label for="2"> House Allowance</label>                                    
                                </div>                                                              
                                <div class='my-3'>                                    
                                    <input type="checkbox" class="m-2" name="selected_benefit" :checked="isSelected(3 , selected_benefits)" value="3" id="3" v-model="selected_benefits" @change.prevent="detectAction(3)">
                                    <label for="3"> Traveling  Allowance</label>                                    
                                </div>                                                              
                                <div class='my-3'>                                    
                                    <input type="checkbox" class="m-2" name="selected_benefit" :checked="isSelected(4 , selected_benefits)" value="4" id="4" v-model="selected_benefits" @change.prevent="detectAction(4)">
                                    <label for="4"> Entertainment Allowance</label>                                    
                                </div>                                                              
                                <div class='my-3'>                                    
                                    <input type="checkbox" class="m-2" name="selected_benefit" :checked="isSelected(5 , selected_benefits)" value="5" id="5" v-model="selected_benefits" @change.prevent="detectAction(5)">
                                    <label for="5"> Medical Cover</label>                                    
                                </div>                                                              
                                <div class='my-3'>                                    
                                    <input type="checkbox" class="m-2" name="selected_benefit" :checked="isSelected(6 , selected_benefits)" value="6" id="6" v-model="selected_benefits" @change.prevent="detectAction(6)">
                                    <label for="6"> NSSF</label>                                    
                                </div>                                                              
                                <div class='my-3'>                                    
                                    <input type="checkbox" class="m-2" name="selected_benefit" :checked="isSelected(7 , selected_benefits)" value="7" id="7" v-model="selected_benefits" @change.prevent="detectAction(7)">
                                    <label for="7"> Insuarance</label>                                    
                                </div>                                                              
                                                                                             
                            </div>                        
                    </form>
                </div>

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



export default {
    components:{
        Head,
        Sidebar,
        BreezeAuthenticatedLayout,
        AppHeader,
        TextInput,
        Link,
    },
    data(){
        return{
            user:this.$page.props.auth.user,
            selected_benefits:[]
        }
    },
    methods:{
        submitForm(id){            
            var form_data = new FormData();
                form_data.append('created_by', this.user.id);
                form_data.append('benefit_id', id);
                form_data.append('company_id', this.user.company_id);

            axios.post(route('company.benefits.store', this.user.company_id), form_data)
            .then(response=>{
                this.fetchCompanyBenefits();
            })
            .catch(error=>{
               console.log(error.response);
            })
        },
        isSelected(val, arr){
            var is_selected=false;
            arr.forEach(item=>{
                if(item == val) is_selected = true;
            });
        },
        fetchCompanyBenefits(){
            axios.get(route('company.benefit.fetch', this.user.company_id))
            .then(response=>{
                this.selected_benefits=[];
                response.data.data.forEach(item=>{
                    this.selected_benefits.push(item.benefit_id);
                });
            })
            .catch(error=>{
                console.log(error.response);
            })
        },
        detectAction(id){
            if(event.target.checked == true) this.submitForm(id);

            else this.deleteCompanyBenefit(id);
        },

        deleteCompanyBenefit(id){
            axios.get('/v1/company/benefits/delete/' + id +'/' + this.user.company_id )
            .then(response=>{
                //
            })
            .catch(error=>{
                console.log(error.response);
            })
        } 
       
    },
    mounted(){
       this.fetchCompanyBenefits();
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