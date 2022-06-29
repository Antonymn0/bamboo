<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <app-header title="Approve pending leave" :user="user"  />
    <div class="container-fluid profile">
        <div class="row">
            <div class="col-3 profile-panel">
                <HomeSidebar :user="user" />
            </div>
            <div class="col-9">
                <div class="tab-pane-content p-3" >
                    <div class="card  border-0">
                        <div class="card-header  bg-theme-bright text-white text-uppercase">
                            <p class="d-flex align-items-center">                            
                                <span >
                                    <Link :href="route('profile', leave.user.username)">
                                        <div class="photo" :style="'background-image:url(https://i.pravatar.cc/300?img='+leave.id+')'"></div>
                                    </Link>
                                </span>
                                <span class="text-capitalize ml-3 w-100"> 
                                    <h2 class="w-100">
                                        {{leave.user.first_name }} {{leave.user.middle_name }} {{leave.user.last_name }}
                                        <span class="float-end text-capitalize">
                                            <span v-if="leave.leave_type == 0">  Other  </span>
                                            <span v-if="leave.leave_type == 1">  Annual leave  </span>
                                            <span v-if="leave.leave_type == 2">  Part leave  </span>
                                            <span v-if="leave.leave_type == 3">  Maternity leave  </span>
                                            <span v-if="leave.leave_type == 4">  Paternity leave  </span>
                                            <span v-if="leave.leave_type == 5">  Sick leave  </span>
                                            <span v-if="leave.leave_type == 6">  Sabbatical  </span>
                                            <span v-if="leave.leave_type == 7">  Vacation  </span>
                                             <br>

                                           <span class="fw-lighter small"> 
                                               <small class="fw-lighter small" v-if="leave.status == '0'">Approved </small>
                                                <small class="fw-lighter small" v-if="leave.status == '1'"> Pending... </small>
                                                <small class="fw-lighter small" v-if="leave.status == '2'">Under review </small>
                                                <small class="fw-lighter small" v-if="leave.status == '3'">Declined </small>
                                           </span> 
                                        </span>
                                     </h2>
                                </span>                                 
                            </p>                           
                        </div>
                        <div class="card-body border row mx-1">                            
                        <div class="col-md-6">
                            <div class="p-2 m-1 border">
                                <span class="box">
                                    <strong>
                                        Leave type
                                    </strong>
                                    <br>
                                    <small v-if="leave.leave_type == 0">  Other  </small>
                                    <small v-if="leave.leave_type == 1">  Annual leave  </small>
                                    <small v-if="leave.leave_type == 2">  Part leave  </small>
                                    <small v-if="leave.leave_type == 3">  Maternity leave  </small>
                                    <small v-if="leave.leave_type == 4">  Paternity leave  </small>
                                    <small v-if="leave.leave_type == 5">  Sick leave  </small>
                                    <small v-if="leave.leave_type == 6">  Sabbatical  </small>
                                    <small v-if="leave.leave_type == 7">  vacation  </small>
                                </span>
                            </div>
                            <div class="p-2 m-1 border rounded table-hover">
                                <span class="box">
                                    <strong>
                                        Days
                                    </strong>
                                    <br>
                                    <small>
                                    {{ leave.number_of_days }}
                                    </small>
                                </span>
                            </div> 
                            <div class="p-2 m-1 border rounded table-hover ">
                                <span class="box">
                                    <strong>Status</strong> <br>
                                    <small v-if="leave.status == '0'">Approved </small>
                                    <small v-if="leave.status == '1'"> Pending </small>
                                    <small v-if="leave.status == '2'">Under review </small>
                                    <small v-if="leave.status == '3'">Declined </small> 
                                </span>
                            </div>
                            <div class="p-2 m-1 border rounded table-hover">
                                <span class="box">
                                    <strong>
                                        Start
                                    </strong>
                                    <br>
                                    <small>
                                    {{ new Date(leave.start_date).toLocaleDateString() }}
                                    </small>
                                </span>
                            </div>                                   
                            <div class="p-2 m-1 border rounded table-hover">
                                <span class="box">
                                    <strong>
                                        End
                                    </strong>
                                    <br>
                                    <small>
                                    {{ new Date(leave.end_date).toLocaleDateString() }}
                                    </small>
                                </span>
                            </div>                                   
                            <div class="p-2 m-1 border rounded table-hover">
                                <span class="box">
                                    <strong>
                                        Reporting date
                                    </strong>
                                    <br>
                                    <small>
                                    {{ new Date(leave.reporting_date).toLocaleDateString() }}
                                    </small>
                                </span>
                            </div> 
                            
                        </div>
                                    
                        <div class="col-md-6">
                            <span class="w-100">
                                <label for="description">Description:</label>
                                <textarea class="border rounded w-100" readonly name="description" id="desciption"  cols="10" rows="5" :value="leave.description"></textarea>
                            </span> <br>
                            <span class="w-100">
                                <label for="hr_comments">Hr comments:</label>
                                <textarea class="border  w-100"  id="hr_comments" cols="10" rows="5" placeholder="Hr comments" v-model="this.hr_comments"></textarea> 
                                <small class="text-danger w-100">{{this.errors.hr_comments}}</small>
                            </span> <br>
                            <span class="mx-auto">
                               <button class="btn btn-secondary m-1" @click.prevent="declineLeave()"> <span class="spinner-border spinner-border-sm" v-if="this.decline"></span> Decline</button>
                                <button class="btn btn-secondary m-1" @click.prevent="markUnderreview()"> <span class="spinner-border spinner-border-sm" v-if="this.onhold"></span>Onhold</button>
                                <button  class="btn btn-theme m-1" @click.prevent="approveLeave()"> <span class="spinner-border spinner-border-sm" v-if="this.approve"></span> Approve</button>
                            </span>
                        </div>   
                        </div>
                        <div class="card-footer border text-muted">
                            <Link :href="route('admin.leave.approvals.page', user.username)">
                                <small class="fa fa-arrow-left"></small> Back 
                            </Link>
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
import AppHeader from '@/Components/AppHeader.vue';
import HomeSidebar from '@/Components/HomeSidebar.vue';
import Personal from '@/Components/Profile/Personal.vue';
import Job from '@/Components/Profile/Job.vue';
import Leave from '@/Components/Profile/Leave.vue';
import Benefits from '@/Components/Profile/Benefits.vue';
import Assets from '@/Components/Profile/Assets.vue';
import Emergency from '@/Components/Profile/Emergency.vue';

export default {
    props:{
        user:Object,
        leave:Object
        },

    components:{        
        BreezeAuthenticatedLayout,
        Head,
        Link,
        AppHeader,
        HomeSidebar,
        Personal,
        Job,
        Leave,
        Benefits,
        Assets,
        Emergency,
    },
    data(){
        return{
            hr_comments:null,
            errors:{},
            approve:false,
            onhold:false,
            decline:false,
        }
    },
    methods:{
        approveLeave(){
            this.validateForm();
            if(Object.keys(this.errors).length) return;
            
            var form_data = new FormData();
                form_data.append('hr_comments', this.hr_comments);
                form_data.append('approved_by', this.user.id);

            if(! confirm('Approve this leave request?')) return;
            this.approve=true;
            axios.post(route('admin.approve.leave', this.leave.id), form_data)
            .then(response=>{
                this.approve=false;
                this.$inertia.get(route('admin.leave.approvals.page', this.user.username));
            })
            .catch(error=>{
                this.approve=false;
                console.log(error.response);
            })
        },
        markUnderreview(){
            this.validateForm();
            if(Object.keys(this.errors).length) return;
            
            var form_data = new FormData();
                form_data.append('hr_comments', this.hr_comments);
                form_data.append('approved_by', this.user.id);

            if(! confirm('Put this leave under review?')) return;
            this.onhold=true;

            axios.post(route('admin.mark-under-review.leave', this.leave.id), form_data)
            .then(response=>{
                this.onhold=false;
                this.$inertia.get(route('admin.leave.approvals.page', this.user.username));
            })
            .catch(error=>{
                this.onhold=false;
                console.log(error.response);
            })
        },
        declineLeave(){
            this.validateForm();
            if(Object.keys(this.errors).length) return;

            var form_data = new FormData();
                form_data.append('hr_comments', this.hr_comments);
                form_data.append('declined_by', this.user.id);
            
            if(! confirm('Decline this leave request?')) return;
            this.decline=true;
            axios.post(route('admin.decline.leave', this.leave.id), form_data)
            .then(response=>{
                this.decline=false;
                this.$inertia.get(route('admin.leave.approvals.page', this.user.username));
            })
            .catch(error=>{
                this.decline=false;
                console.log(error.response);
            })
        },
        validateForm(){
            this.errors={}
            if (! this.hr_comments) this.errors.hr_comments = "Please give a comment";
        }

    },
    mounted(){
        console.log(this.leaves);
    }
}
</script>
<style scoped>

li{
    cursor: pointer;
    padding: 15px 0;
}
li .icon{
    color: var(--theme-color);
    font-size: 1.6em;
}
.photo{
    width: 70px;
    height: 70px;
    /*background-color: var(--theme-color);*/
    border-radius: 50%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: inline-block;
}

</style>