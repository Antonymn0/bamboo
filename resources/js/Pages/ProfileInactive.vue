<template>
    <Head :title="title_val" />

    <BreezeAuthenticatedLayout>
        <app-header :user="user" :title="user.first_name+' '+user.last_name" :subtitle="subtitle_val" />
    <div class="container-fluid profile">
        <div class="row">
            <div v-if="can('approve_employee')" class="col-2">
                
                <h1 class="mb-2 mt-2 text-theme text-center"> Progress </h1>

                <div class="pb-4">
                    <RegProgress />
                </div>

                <div class="text-center">
                    <Link   :href="route('activate.employee',user.username)"  class="btn bt-sm bg-danger btn-danger mb-2">  Activate Account</Link>
                </div>


            </div>
            <div class="col-10">
                <div class="pt-2 pb-4">

                    <h1 class="mb-2 text-theme"> <span class="text-capitalize">{{user.first_name}} {{user.last_name}} </span>  account not activated!</h1>

                    <h2 v-if="tasks.length" class="mb-2">Here are some task<span v-if="tasks.length > 1">s</span> assigned to you regarding this account.</h2>

                    <div v-if="tasks.length" class="table-responsive mb-2">
                        <table class="table">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col">Serial </th>
                                    <th scope="col">Name </th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Assigned By</th>
                                    <th scope="col">Due On</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-capitalize">
                                <tr v-for="(task,count) in tasks" :key="task.id">
                                    <td @click="openTask(task)">{{count + 1}}</td>
                                    <td @click="openTask(task)">
                                        {{task.name}}<br>
                                        <small> Assigned {{ calcAge(task.created_at) }} </small>
                                    </td>
                                    <td @click="openTask(task)">{{task.description}}</td>
                                    <td> <Link :href="route('profile',task.user.username)"> {{task.user.first_name}}</Link></td>
                                    <td @click="openTask(task)">{{formatDate(task.due_date)}}</td>
                                    <td @click="openTask(task)">
                                        <small class="text-lowercase" :class="[task.status == 'complete' ? 'text-success' : 'text-danger']">
                                            <span :class="[task.status == 'complete' ? 'fa fa-check-circle' : 'fa fa-exclamation-triangle']"></span>
                                            {{task.status}}
                                        </small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <p class="text-center" v-if=" last_page > current_page">
                            <a href="#" @click.prevent="fetch(current_page + 1)">Load More...</a>
                        </p>

                    </div>

                    <Link :href="route('employees')" class="btn btn-sm btn-theme">Employees Page</Link>
                    <Link v-if="can('approve_employee')" :href="route('activate.employee',user.username)" class="btn btn-sm btn-danger ml-4">Activate Account</Link>

                </div>

                <FormModal v-if="selectedTask" :id="modalID" title="Task Details" closeLabel="Close" >
                    <template v-slot:form>
                        <h2 class="text-capitalize">{{selectedTask.name}}</h2>
                        <p v-if="selectedTask.description" class="pt-2 pb-2">Details: {{selectedTask.description}}</p>
                        
                        <p v-if="selectedTask.user">
                            <small class="text-capitalize">By: {{selectedTask.user.first_name}} </small>
                        </p>
                        <p v-if="selectedTask.due_date" class="pt-2 pb-2">Due: {{formatDate(selectedTask.due_date)}} <span v-if="selectedTask.due_time">at {{selectedTask.due_time}}</span> </p>
                        <hr>
                        <form class="mt-2">
                            <div class="form-group row">
                                <label for="status" class="col-sm-4 col-form-label text-center">
                                    <StatusIcon :showLoading="loading"  /> 
                                        Update Status
                                </label>
                                <div class="col-sm-4 ">
                                    <select v-model="selectedTask.status" class="form-control" name="" id="" @change="update('status',$event.target.value)">
                                        <option value="pending">Pending</option>
                                        <option value="complete">Complete</option>
                                    </select>
                                </div>
                            </div>
                            
                    </form>

            </template>
        </FormModal>

            </div>
        </div>
    </div>
        
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
import AppHeader from '@/Components/AppHeader.vue';
import ProfileSidebar from '@/Components/ProfileSidebar.vue';
import Personal from '@/Components/Profile/Personal.vue';
import Job from '@/Components/Profile/Job.vue';
import Leave from '@/Components/Profile/Leave.vue';
import Benefits from '@/Components/Profile/Benefits.vue';
import Assets from '@/Components/Profile/Assets.vue';
//import Emergency from '@/Components/Profile/Emergency.vue';
import Emergency from '@/Components/Profile/Sections/Emergency.vue';
import moment from 'moment';
import FormModal from '@/Components/FormModal.vue';
import StatusIcon from '@/Components/Profile/Sections/Components/StatusIcon.vue';
import RegProgress from '../Components/RegProgress.vue';

export default {
    props:{
        settings:Array,
        user:Object,
        permissions:Array,
        pageTitle:String,
        pageSubTitle:String,
    },
    data() {
        return {
            title_val:this.pageTitle ? this.pageTitle : this.user.first_name + ' ' + this.user.last_name + ' profile',
            subtitle_val:this.pageSubTitle ? this.pageSubTitle : 'Profile Inactive',
            tasks:[],
            limit:10,
            loading:false,
            current_page:1,
            last_page:'',
            total_tasks:'',
            modalID:'task-form',
            selectedTask:'',
            authUser:this.$page.props.auth.user,
            permissions_arr:this.permissions ? this.permissions : [],
        }
    },
    methods:{
        fetch(page=1){
            this.loading = true
            axios({
                method: 'GET',
                url: '/v1/tasks?page='+page+'&assigned_to='+this.authUser.id+'&user_id='+this.authUser.id+'&status=pending'+'&limit='+this.limit,
                data: {
                }
                }).then((response) => {
                    this.current_page = response.data.current_page
                    this.last_page = response.data.last_page
                    this.tasks = [...this.tasks, ...response.data.data]
                    this.loading = false
                    //this.selectedTask = ''
                    //console.log(response.data)
                })
                .catch( (error) => {
                console.log(error.response);
            });
        },
        formatDate(date){
            return moment(date).format('ll');
        },
        calcAge(date){
            return moment(date).fromNow();
        },
        openTask(task){
            if( task.name != 'other' && task.type == 'employee_onboarding' && task.url && task.status != 'complete'  )
                window.open(task.url+'/'+task.id,'_self');
            else{
                this.selectedTask = task 
                this.$nextTick(() => {
                    jQuery('#'+this.modalID).modal('show');
                });
            }
        },
        update(field,value){
            if( ! this.selectedTask ) return;
            this.loading = true
            if( ! confirm("Are you sure you want update task status to "+ value +"?") ) {this.selectedTask.status = value == 'pending' ? 'complete' : 'pending'; return;}
            axios({
                method: 'PATCH',
                url: '/v1/task-patch/'+this.selectedTask.id,
                data: {
                    field:field,
                    value:value
                }
                }).then((response) => {
                    //console.log(response.data)
                    //this.fetch()
                    this.selectedTask = response.data
                    //setTimeout(this.finishSync, 1000);
                    this.finishSync()
                })
                .catch( (error) => {
                console.log(error.response);
            });
        },
        /*activateUser(){
            if( ! confirm("Are you sure you want to activate this account? ") ) return;
            this.loading = true
            axios({
                method: 'PUT',
                url: '/v1/user-activate/'+this.user.id,
                data: {
                    activated_by:this.authUser.id,
                }
                }).then((response) => {
                    //console.log(response.data)
                    //this.fetch()
                    //setTimeout(this.finishSync, 1000);
                    this.loading = false
                    window.open('/profile/'+this.user.username,'_self');
                })
                .catch( (error) => {
                console.log(error.response);
            });


        },*/
        finishSync(){
            alert("Update successful!")
            jQuery('#'+this.modalID).modal('hide');
            this.loading = false
        },
        can(permission){
            return this.permissions_arr.includes(permission);
        }
    },
    mounted(){
        this.fetch()
    },
    components:{
    BreezeAuthenticatedLayout,
    Head,
    Link,
    AppHeader,
    ProfileSidebar,
    Personal,
    Job,
    Leave,
    Benefits,
    Assets,
    Emergency,
    FormModal,
    StatusIcon,
    RegProgress
}
}
</script>
<style scoped>
td{
    cursor: pointer;
}
</style>