<template>
<div class="panel">
    <div v-if="tasks.length" class="contacts border-bottom mt-3 pb-2">
        <h3 class="text-theme">Assigned Tasks <small> ({{total_tasks}}) </small> </h3>
        <ul>
        <li  v-for="(task,count) in tasks" :key="count"  class="text-capitalize">
            <a href="#" @click.prevent="openTask(task)">
                {{task.name}} 
                <small class="text-lowercase" :class="[task.status == 'complete' ? 'text-success' : 'text-danger']">
                    <span :class="[task.status == 'complete' ? 'fa fa-check-circle' : 'fa fa-exclamation-triangle']"></span>
                    {{task.status}}
                </small><br>
            <small> {{ calcAge(task.created_at) }} </small>
            </a> 
        </li>
    </ul>
    <p class="text-center" v-if=" last_page > current_page">
        <a href="#" @click.prevent="fetch(current_page + 1)">Load More Tasks</a>
    </p>
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
                            <label for="status" class="col-sm-5 col-form-label text-center">
                                <StatusIcon :showLoading="loading"  /> 
                                    Update Task Status
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

        <FormModal v-if="selectedTask" id="contactReferees" title="Task Details" closeLabel="Close" >
            <template v-slot:form>
                    <h2 class="text-capitalize mb-2">{{selectedTask.name}}</h2>
                    <h3 v-if="selectedTask.employee" class="text-capitalize">Employee: {{selectedTask.employee.first_name}} {{selectedTask.employee.last_name}}</h3>
                    <!--<p v-if="selectedTask.description" class="pt-2 pb-2">Details: {{selectedTask.description}}</p>
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
                        
                    </form>-->

                    <div v-if="referees" class="table-responsive">
                        <table class="table text-capitalize">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(referee,count) in referees" :key="referee.id">
                                    <td>{{count + 1}}</td>
                                    <td> {{referee.first_name}} {{referee.last_name}} </td>
                                    <td class="text-lowercase"> {{referee.email}} </td>
                                    <td> {{referee.phone}} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <p v-else> No referees</p>

                    <form class="mt-2">
                        <div class="form-group row">
                            <label for="status" class="col-sm-5 col-form-label text-center">
                                <StatusIcon :showLoading="loading"  /> 
                                    Update Task Status
                            </label>
                            <div class="col-sm-4 ">
                                <select v-model="selectedTask.status" class="form-control" name="" id="" @change="update('status',$event.target.value)">
                                    <option value="pending">Pending</option>
                                    <option value="complete">Complete</option>
                                </select>
                            </div>
                        </div>
                        
                    </form>



                    <p v-if="loading" class="text-center p-4">
                        <span class="fa fa-spinner fa-spin"></span>
                    </p>

            </template>
        </FormModal>

    </div>
    <div>
    
    </div>
</div>

</template>

<script>
import moment from 'moment';
import FormModal from './FormModal.vue';
import StatusIcon from '@/Components/Profile/Sections/Components/StatusIcon.vue';

export default {
  components: { FormModal,StatusIcon },
    
    data: function(){
      return{
          tasks:[],
          limit:10,
          loading:false,
          current_page:1,
          last_page:'',
          total_tasks:'',
          modalID:'task-form',
          selectedTask:'',
          authUser:this.$page.props.auth.user,
          referees:[]
      }
    },
    methods:{
        fetch(page=1){
            this.loading = true
            axios({
                method: 'GET',
                url: 'v1/tasks?page='+page+'&assigned_to='+this.authUser.id+'&user_id='+this.authUser.id+'&status=pending'+'&limit='+this.limit,
                data: {
                }
                }).then((response) => {
                    this.current_page = response.data.current_page
                    this.last_page = response.data.last_page
                    this.tasks = [...this.tasks, ...response.data.data]
                    this.total_tasks = response.data.total
                    this.loading = false
                    //this.selectedTask = ''
                    //console.log(response.data)
                })
                .catch( (error) => {
                console.log(error.response);
            });
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
        finishSync(){
            //alert("Update successful!")
            jQuery('#'+this.modalID).modal('hide');
            jQuery('#contactReferees').modal('hide');
            this.loading = false
        },
        calcAge(date){
            return moment(date).fromNow();
        },
        formatDate(date){
            return moment(date).format('ll');
        },
        openTask(task){
            if( task.name != 'other' && task.type == 'employee_onboarding' && task.url && task.status != 'complete'  )
                window.open(task.url+'/'+task.id,'_self');
            else if( task.name == 'contact referees' ){

                this.selectedTask = task 

                if( ! task.type_id ) return;
                this.loading = true
                axios({
                    method: 'POST',
                    url: '/v1/users/pluck/'+task.type_id,
                    data: {
                        field:'referees',
                    }
                    }).then((response) => {

                        this.referees = response.data
                        this.loading = false

                        //this.fetch()
                    })
                    .catch( (error) => {
                    console.log(error.response);
                });

                this.$nextTick(() => {
                    jQuery('#contactReferees').modal('show');
                });

            }
            else{
                this.selectedTask = task 
                this.$nextTick(() => {
                    jQuery('#'+this.modalID).modal('show');
                });
            }
        }
    },
    mounted(){
        this.fetch()
        //console.log(this.authUser)
    }
}
</script>

<style scoped>
.panel{
    max-height: 250px;
    overflow-y: auto;
}
ul{
    margin: 0;
    padding: 0;
}
li{
    border: 1px solid var(--light);
    padding: 10px 8px;
    margin: 5px 0;
    box-shadow: 0px 0.5px 0.4px 0.1px var(--light);
    cursor: pointer;
}
.close{
    opacity: 0.8;
}
.close:hover{
    opacity: 1;
    cursor: pointer;
}
p {
    font-size: 0.8em;
   /*text-align: center;*/
}
</style>