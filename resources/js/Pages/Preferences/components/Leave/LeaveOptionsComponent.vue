<template>
        <div class="container pb-2 ">
            <div class="row">
                <div class="col-md-10 py-3 mx-auto">                    
                    <div class="tab-pane-content pt-4">
                    <form @submit.prevent="" class="border  mx-auto p-3">
                        <h2 class="title-border pb-2"> 
                            <span  class="fa fa-umbrella-beach"></span> 
                            Select leave options
                        </h2>
                            <div class="col-md-9 mx-auto">                                                              
                                <h3 class="fw-bold my-3"> Available options </h3>
                                <div class='my-3'>                                    
                                    <input type="checkbox" class="m-2" name="leave_type" value="1" id="1" v-model="selected_leave_types" @change.prevent="deleteLeaveType(1)">
                                    <label for="1"> Annual leave</label>                                    
                                </div>                                                              
                                <div class='my-3'>                                    
                                    <input type="checkbox" class="m-2" name="leave_type" value="2" id="2" v-model="selected_leave_types" @change.prevent="deleteLeaveType(2)">
                                    <label for="2"> Part leave</label>                                    
                                </div>                                                              
                                <div class='my-3'>                                    
                                    <input type="checkbox" class="m-2" name="leave_type" value="3" id="3" v-model="selected_leave_types" @change.prevent="deleteLeaveType(3)">
                                    <label for="3"> Martenity leave</label>                                    
                                </div>                                                              
                                <div class='my-3'>                                    
                                    <input type="checkbox" class="m-2" name="leave_type" value="4" id="4" v-model="selected_leave_types" @change.prevent="deleteLeaveType(4)">
                                    <label for="4"> Partenity leave</label>                                    
                                </div>                                                              
                                <div class='my-3'>                                    
                                    <input type="checkbox" class="m-2" name="leave_type" value="5" id="5" v-model="selected_leave_types" @change.prevent="deleteLeaveType(5)">
                                    <label for="5"> Sick leave</label>                                    
                                </div>                                                              
                                <div class='my-3'>                                    
                                    <input type="checkbox" class="m-2" name="leave_type" value="6" id="6" v-model="selected_leave_types" @change.prevent="deleteLeaveType(6)">
                                    <label for="6"> Sabbatical leave</label>                                    
                                </div>                                                              
                                <div class='my-3'>                                    
                                    <input type="checkbox" class="m-2" name="leave_type" value="7" id="7" v-model="selected_leave_types" @change.prevent="deleteLeaveType(7)">
                                    <label for="7"> Vacation leave</label>                                    
                                </div>                                                              
                                <div class='my-3'>                                    
                                    <input type="checkbox" class="m-2" name="leave_type" value="0" id="leave_type" v-model="selected_leave_types" @change.prevent="deleteLeaveType(0)">
                                    <label for="leave_type"> Other</label>                                    
                                </div>                                                              
                            </div>
                        </form>
                    </div>
                </div>                
            </div>            
        </div>        
 
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head,Link } from '@inertiajs/inertia-vue3';

import TextInput from '@/Components/TextInput.vue';


export default {
    props:{
        company:Object
    },
    components:{
        Head,
        TextInput,
        Link
    },
    data(){
        return{
            auth_user:this.$page.props.auth.user,
            company:this.$page.props.auth.user.company,
            field:{},
            errors:{},
            selected_leave_types:[] ,
            current_leaves:{}
        }
    },
    methods:{        
        submitLeaveType(){
            if(! this.selected_leave_types) return;
            var form_data = new FormData();
                form_data.append('created_by', this.auth_user.id);
                form_data.append('leave_type_id', this.selected_leave_types);
                form_data.append('company_id', this.company.id);

            axios.post(route('leave-type.store', this.company.id), form_data)
            .then(response=>{
                this.fetchLeaveTypes();
            })
            .catch(error=>{
                if(error.response.status == 422) this.errors.leave_type = "leave type already exists";
                if(error.response.status == 429) alert('Unable to capture all leave options! \n If this issue persists, please try refreshing the page.');
                console.log(error.response);
            })
        },
        fetchLeaveTypes(){
            axios.get(route('leave-type.fetch', this.company.id))
            .then(response=>{
                this.selected_leave_types=[];
                response.data.data.forEach(item=>{
                    this.selected_leave_types.push(item.leave_type_id);
                });
                this.current_leaves = response.data.data;
            })
            .catch(error=>{
                console.log(error.response);
            })
        },
        deleteLeaveType(id){
            if(event.target.checked == true) return;

            var db_id = null;
            this.current_leaves.forEach(item =>{
                   if(item.leave_type_id == id) {db_id = item.id;  }
                });
          
            axios.get(route('leave-type.delete', db_id))
            .then(response=>{
               this.fetchLeaveTypes();
            })
            .catch(error=>{
                console.log(error.response);
            })
        } 
    },
     watch: {
        selected_leave_types: function (new_value, old_value) {
            if(new_value.length > old_value.length)this.submitLeaveType();
            else return;
        }
    },
    mounted(){
       this.fetchLeaveTypes();
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