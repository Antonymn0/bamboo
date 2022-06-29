<template>
  <div class="border-bottom px-2">
    <div class="row">
        <div class="col-auto icon">
            <span :class="icon"></span>
        </div>
        <div class="col">
            <strong>
                Leave type
            </strong>
            <br>
            <small v-if="this.leave.leave_type == 0">  Other  </small>
            <small v-if="this.leave.leave_type == 1">  Annual leave  </small>
            <small v-if="this.leave.leave_type == 2">  Part leave  </small>
            <small v-if="this.leave.leave_type == 3">  Maternity leave  </small>
            <small v-if="this.leave.leave_type == 4">  Paternity leave  </small>
            <small v-if="this.leave.leave_type == 5">  Sick leave  </small>
            <small v-if="this.leave.leave_type == 6">  Sabbatical   </small>
            <small v-if="this.leave.leave_type == 7">  Vacation  </small>
        </div>
        <div class="col">
            <strong>
                Start
            </strong>
            <br>
            <small>
            {{ new Date(this.leave.start_date).toLocaleDateString() }}
            </small>
        </div>
        <div class="col">
            <strong>
                End
            </strong>
            <br>
            <small>
            {{ new Date(this.leave.end_date).toLocaleDateString() }}
            </small>
        </div>
        <div class="col">
            <strong>Reporting date</strong> <br>
            <small>
                {{ new Date(this.leave.reporting_date).toLocaleDateString() }}
                </small>
        </div>
        
        <div class="col">
            <strong>Hr comments</strong> <br>
            <small>{{this.leave.hr_comments}}</small>
        </div>
        <div class="col-auto">
            <strong>Status</strong> <br>
            <small v-if="this.leave.status == 0">Approved </small>
            <small v-if="this.leave.status == 1">Pending </small>
            <small v-if="this.leave.status == 2">Under review </small>
            <small v-if="this.leave.status == 3">Declined </small>
        </div>
        
        <div class="col text-right ">
            <Link :href="route('show.edit.leave.form', this.leave.id)" class="fa fa-edit btn btn-sm btn-theme" v-if="this.leave.status ==1 || this.leave.status ==2" >  </Link>  
            <Link :href="route('show.edit.leave.form', this.leave.id)" class="fa fa-edit btn btn-sm btn-theme disabled" v-if="this.leave.status ==0 || this.leave.status ==3" >  </Link>  
        </div>
    </div>
    
</div>
</template>

<script>
import { Head,Link } from '@inertiajs/inertia-vue3';
export default {
    props:{
        leave:Object,      
        
    },
    components:{
        Link
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
.edit-icon{
    display: none;
}
li:hover .edit-icon{
    display: block;
}
</style>