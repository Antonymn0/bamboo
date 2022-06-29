<template>
<div class=" h-auto">
    <h1 class="title-border p-2"> 
        <small class="fa fa-umbrella-beach"></small>
         Leave 
         <Link :href="route('leave.show.apply-form')" class="text-sm float-right">
              <span class="fa fa-plus-circle"></span>
               Apply For Leave 
        </Link> 
    </h1>
</div>
<!--<div id="carouselExampleControls" class="carousel slide" data-bs-interval="false" data-bs-ride="carousel">
    
    <div class="section mt-4">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="row">
                    <div class="col">
                        <Type title="Annual Leave" period="days" balance="14" icon="fa fa-umbrella-beach" />
                    </div>
                    <div class="col">
                        <Type title="Sick Leave" period="days" balance="1" icon="fa fa-ambulance" />
                    </div>
                    <div class="col">
                        <Type title="Compassionate Leave" period="days" balance="4" icon="fa fa-user-friends" />
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="col">
                        <Type title="Public Holidays" period="days" balance="6" icon="fa fa-flag" />
                        <Type title="Maternity" period="days" balance="6" icon="fa fa-woman" />
                        <Type title="Paternity" period="days" balance="6" icon="fa fa-woman" />

                    </div>
            </div>
            
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon " aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        </div>
    </div>

    
    <div v-if="Object.keys(this.current_leaves).length" class="section mt-3">
        <h2 class="title-border  pb-2 pt-2"> <span class="fa fa-info-circle"></span> Upcoming Leave</h2>
       <div v-if="Object.keys(this.current_leaves).length"> 
            <ul v-for="(leave, index) in this.current_leaves" :key="index">        
                <UpcomingLeave :leave="leave" />   
            </ul>
        </div>
        <div v-else class="text-muted p-5">
            <small >No  leave records to show</small>
        </div>
    </div>



</div>-->
</template>

<script>
import Type from '../Components/LeaveType.vue'
import UpcomingLeave from '../Components/UpcomingLeave.vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import AppHeader from '@/Components/AppHeader.vue';
import ProfileSidebar from '@/Components/ProfileSidebar.vue';
export default {
  components: {
       Type,
       UpcomingLeave,
       Link,
       Head,
    AppHeader,
    ProfileSidebar,
    },
    data() {
        return {   
            auth_user:this.$page.props.auth.user, 
            current_leaves:{},
            errors:{}
        }
    },
    methods:{
        fetchLeaves(){
            axios.get(route('fetch.employee.leaves', this.auth_user.id))
            .then(response=>{
                this.current_leaves=response.data.data;
                //console.log(response.data.data);
            })
            .catch(error=>{
                console.log(error.response);
            })
        }
    },
    mounted(){
        this.fetchLeaves();
    }
}
</script>

<style scoped>
ul{
    margin: 15px 0;
}

</style>