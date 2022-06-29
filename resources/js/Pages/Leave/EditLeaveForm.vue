<template>
    <Head title="Leave" />
    <BreezeAuthenticatedLayout>
    <app-header title="Leave Application" subtitle="Update leave" />

    <div class="container-fluid profile">
        <div class="row pt-2">

            <div class="col-3 profile-panel"> 
                <profile-sidebar :permissions="permissions" :settings="settings" :user="user" />
            </div>

            <div class="col-9 ">
                <div class="tab-pane-content">
                    <h1 class="title-border p-2 pt-1"> 
                        <small class="fa fa-umbrella-beach"></small>
                        Edit leave request      
                    </h1>

                    <div class="p-3 col-md-10 mx-auto">
                        <div class="border rounded p-3 row">
                            <div class="col-md-6 mx-auto p-3">
                                <h4 class="fw-bold"> Leave type: </h4>
                                <div v-for="(option,index) in this.current_leaves_options" :key="index">
                                    <span v-if="option.leave_type_id == 1">
                                        <input type="radio" name="leave_type" id="1" value="1" v-model="this.leave_type" class="form-control p-2 mr-1" >
                                        <label for="1" class="p-2 m-1" >Anual leave</label>
                                      <br>  
                                    </span>
                                    
                                    <span v-if="option.leave_type_id == 2">
                                        <input type="radio" name="leave_type" id="2" value="2" v-model="this.leave_type" class="form-control p-2 mr-1" >
                                        <label for="2" class="p-2 m-1">Part leave</label>
                                       <br> 
                                    </span>
                                    
                                    <span v-if="option.leave_type_id == 5">
                                        <input type="radio" name="leave_type" id="5" value="5" v-model="this.leave_type" class="form-control p-2 mr-1" >
                                        <label for="5" class="p-2 mr-2">Sick leave</label>
                                    <br>
                                    </span>
                                    
                                    <span v-if="option.leave_type_id == 3">
                                        <input type="radio" name="leave_type" id="3" value="3" v-model="this.leave_type" class="form-control p-2 mr-1" >
                                        <label for="3" class="p-2 m-1">Maternity leave</label>
                                    <br>
                                    </span>
                                    
                                    <span v-if="option.leave_type_id == 4">
                                        <input type="radio" name="leave_type" id="4" value="4" v-model="this.leave_type" class="form-control p-2 mr-1" >
                                        <label for="4" class="p-2 m-1">Paternity leave</label>
                                    <br>
                                    </span>  
                                    <span v-if="option.leave_type_id == 7">
                                        <input type="radio" name="leave_type" id="7" value="7" v-model="this.leave_type" class="form-control p-2 mr-1" >
                                        <label for="7" class="p-2 m-1">Vacation</label>
                                    <br>
                                    </span>  
                                    <span v-if="option.leave_type_id == 6">
                                        <input type="radio" name="leave_type" id="6" value="6" v-model="this.leave_type" class="form-control p-2 mr-1" >
                                        <label for="6" class="p-2 m-1">Sabbatical</label>
                                    <br>
                                    </span>  
                                    <span v-if="option.leave_type_id == 0">
                                        <input type="radio" name="leave_type" id="0" value="0" v-model="this.leave_type" class="form-control p-2 mr-1" >
                                        <label for="0" class="p-2 m-1">Other leave</label>
                                    <br>
                                    </span>  
                                    <small class="text-danger">{{this.errors.leave_type}}</small>                             
                                </div>
                                <small class="text-danger">{{this.errors.leave_type}}</small>                             
                            </div>
                            <div class="col-md-5  py-2 mx-auto"> 
                                <h4 class="fw-bold py-2">  Select days </h4> 
                                <div class=" py-2">              
                                    <TextInput   :classes="field" id="number_of_days" label="Number of days" name="number_of_days" type="number" min="1"   required   placeholder="Number of days"  v-on:save="update"  initVal="" />                                 
                                    <small class="text-danger">{{this.errors.number_of_days}}</small> 
                                </div>           
                                <div class=" py-2">              
                                    <DateInput   :classes="field" id="start_date" label="From" name="start_date" type="date"   required   placeholder="Date from"  v-on:save="update"  :initVal="leave.start_date" />                                 
                                    <small class="text-danger">{{this.errors.start_date}}</small> 
                                </div>                                
                                
                                <div class="  py-2">              
                                    <DateInput   :classes="field" label="To" id="end_date" name="end_date" type="date"   required   placeholder="Date to"  v-on:save="update"  :initVal="leave.end_date" />                                 
                                    <small class="text-danger">{{this.errors.end_date}}</small> 
                                </div> 
                                <div class="  py-2">              
                                    <textarea class="rounded border w-100" placeholder="Description" v-model="description"></textarea>                                 
                                    <small class="text-danger">{{this.errors.description}}</small> 
                                </div>                              

                                <div class="pt-5">
                                    <Link :href="route('profile', auth_user.username)" class="btn btn-secondary m-1"> <span class="fa fa-chevron-left"></span> Back </Link>
                                    <button href="#" class="btn btn-theme px-4 m-1" @click.prevent="submitForm()"> <span class="spinner-border spinner-border-sm" v-if="this.submit_form"></span> Continue </button>
                                </div>
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
import Type from '../../Components/Components/LeaveType.vue'
import UpcomingLeave from '../../Components/Components/UpcomingLeave.vue';
import ProfileSidebar from '@/Components/ProfileSidebar.vue';
import AppHeader from '@/Components/AppHeader.vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
import DateInput from '@/Components/DateInput.vue';
import TextInput from '@/Components/TextInput.vue';
import SearchInput from '../../Components/SearchInput.vue';

export default {
    props:{
        settings:Array,
        user:Object,
        permissions:Array,
        formFields:Array,
        leave:Object
    },
    components: {
        Type,
        UpcomingLeave,
        Link,
        AppHeader,
        ProfileSidebar,
        BreezeAuthenticatedLayout,
        DateInput,
        SearchInput,
        TextInput
    },
    data() {
        return {  
            auth_user:this.$page.props.auth.user,
            field:{},
            errors:{},
            leave_type:this.leave.leave_type,
            start_date:this.leave.start_date,
            end_date:this.leave.end_date,
            description:this.leave.description ? this.leave.description : null,
            number_of_days:this.leave.number_of_days ? this.leave.number_of_days : null,
            submit_form:false,
            current_leaves_options:{}
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
                form_data.append('leave_type', this.leave_type);
                form_data.append('start_date', this.start_date);
                form_data.append('end_date', this.end_date);
                form_data.append('description', this.description);
                form_data.append('number_of_days', this.number_of_days);

            this.submit_form=true;
            axios.post(route('leave.patch', this.leave.id), form_data)
            .then(response=>{
                this.submit_form=false;
                this.$inertia.get(route('profile', this.auth_user.username)  );
            })
            .catch(error=>{
                this.submit_form=false;
                console.log(error.response)
            })
        },
        fetchLeaveTypes(){
            axios.get(route('leave-type.fetch', this.user.company_id))
            .then(response=>{               
                this.current_leaves_options = response.data.data;
                console.log(this.current_leaves_options); 
            })
            .catch(error=>{
                console.log(error.response);
            })
        },
        validateForm(){
            this.errors={}

            if(! this.leave_type) this.errors.leave_type = 'Please select leave type';
            if(! this.start_date) this.errors.start_date = 'Please select start date';
            if(! this.end_date) this.errors.end_date = 'Please select end date';
            if(! this.description) this.errors.description = 'Please enter description';
            if(! this.number_of_days) this.errors.number_of_days = 'Please enter number of days';
        }
    },
    mounted(){
        this.fetchLeaveTypes();
    }
}
</script>

<style scoped>
ul{
    margin: 15px 0;
}

</style>