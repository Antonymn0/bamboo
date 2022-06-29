<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <app-header title="Leave Approvals" :user="user"  />
    <div class="container-fluid profile">
        <div class="row">
            <div class="col-3 profile-panel">
                <HomeSidebar :user="user" />
            </div>
            <div class="col-9">
                <div class="tab-pane-content p-2" >
                    <div class="card  border-0">
                        <div class="card-header bg-theme-bright text-white text-uppercase">
                            <span >
                                Pending Leave Approvals
                            </span>
                        </div>
                        <div class="card-body border">
                            <h2 class="title-border  pb-2 pt-2"> <span class="fa fa-info-circle"></span> Pending approvals</h2>
                            <ul v-for="(leave, index) in leaves" :key="index" >
                                <li class="border-bottom" v-if="leave.status == 1 || leave.status == 2">
                                    <div class="row">
                                        <div class="col-auto icon">
                                            <span :class="icon"></span>
                                        </div>
                                        <div class="col">
                                            <strong>
                                                <Link :href="route('profile', leave.user.username)">
                                                    <div class="photo" :style="'background-image:url(https://i.pravatar.cc/300?img='+leave.id+')'"></div>
                                                </Link>
                                            </strong>
                                            <br>
                                            <small >  {{leave.user.first_name }} {{leave.user.last_name }} </small>
                                            
                                        </div>
                                        <div class="col">
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
                                            <small v-if="leave.leave_type == 6">  Sabbatical   </small>
                                            <small v-if="leave.leave_type == 7">  Vacation  </small>
                                        </div>
                                        <div class="col">
                                            <strong>
                                                Start
                                            </strong>
                                            <br>
                                            <small>
                                            {{ new Date(leave.start_date).toLocaleDateString() }}
                                            </small>
                                        </div>                                   
                                        <div class="col">
                                            <strong>
                                                Days
                                            </strong>
                                            <br>
                                            <small>
                                            {{ leave.number_of_days }}
                                            </small>
                                        </div>                                   
                                        
                                        <div class="col-auto">
                                            <strong>Status</strong> <br>
                                            <small v-if="leave.status == '0'">Approved </small>
                                            <small v-if="leave.status == '1'"> Pending </small>
                                            <small v-if="leave.status == '2'">Under review </small>
                                            <small v-if="leave.status == '3'">Declined </small> 
                                        </div>
                                        
                                        <div class="col text-right edit-icon align-center">
                                        <Link :href="route('admin.leave.show.approve-form', leave.id)" class="btn btn-theme btn-sm"> Review  </Link>  
                                        </div>
                                    </div>
                                    
                                </li>
                            </ul>

                            <h2 class="title-border mt-3 pb-2 pt-5"> <span class="fa fa-info-circle"></span> All reviewed Leaves</h2>
                             <ul v-for="(leave, index) in leaves" :key="index" class="py-2">
                                <li class="border-bottom" v-if="leave.status !== 1 && leave.status !== 2">
                                    <div class="row">
                                        <div class="col-auto icon">
                                            <span :class="icon"></span>
                                        </div>
                                        <div class="col">
                                            <strong>
                                                <Link :href="route('profile', leave.user.username)">
                                                    <div class="photo" :style="'background-image:url(https://i.pravatar.cc/300?img='+leave.id+')'"></div>
                                                </Link>
                                            </strong>
                                            <br>
                                            <small >  {{leave.user.first_name }} {{leave.user.last_name }} </small>
                                            
                                        </div>
                                        <div class="col">
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
                                        </div>
                                        <div class="col">
                                            <strong>
                                                Start
                                            </strong>
                                            <br>
                                            <small>
                                            {{ new Date(leave.start_date).toLocaleDateString() }}
                                            </small>
                                        </div>                                   
                                        <div class="col">
                                            <strong>
                                                Days
                                            </strong>
                                            <br>
                                            <small>
                                            {{ leave.number_of_days }}
                                            </small>
                                        </div>                                   
                                        
                                        <div class="col-auto">
                                            <strong>Status</strong> <br>
                                            <small v-if="leave.status == '0'">Approved </small>
                                            <small v-if="leave.status == '1'"> Pending </small>
                                            <small v-if="leave.status == '2'">Under review </small>
                                            <small v-if="leave.status == '3'">Declined </small> 
                                        </div>
                                        
                                        <div class="col text-right edit-icon align-center">
                                        <Link :href="route('admin.leave.show.approve-form', leave.id)" class="btn btn-theme btn-sm disabled"> Reviewed  </Link>  
                                        </div>
                                    </div>
                                    
                                </li>
                            </ul>
                            <p class="py-5 text-center" v-if="! Object.keys(leaves).length">
                                <small>No leave requests to show</small>
                            </p>
                        </div>
                        <div class="card-footer border text-muted">
                            <Link :href="route('dashboard')">
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
        leaves:Object
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

        }
    },
    methods(){

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
    width: 50px;
    height: 50px;
    /*background-color: var(--theme-color);*/
    border-radius: 50%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: inline-block;
}

</style>