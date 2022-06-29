<template>
<div>
        <!--<p>Assign someone the task of verifying details/ documents filled/ referenced by the new employee</p>-->
        <p>
          Delegate the task of verifying details filled or documents referenced by the new employee to someone in your team. e.g. You may want to verify details of ID, PIN No., NSSF, NHIF, their Education etc.
          <ul>
            <li>
              IF you wish to delegate click <a href="#" class="text-primary" @click.prevent="add">here</a> or on the “+Assign Task” button below.
            </li>
            <li>

 IF you don’t want to delegate tasks click <a class="text-primary" :href="'/onboard/step-four/'+this.employee.username">here</a>  or on the “Continue” button below
            </li>
          </ul>

        </p>
        <span v-for="(task,count) in fields" :key="task.id">
                <div :class="{'border-top':count}" class="text-right">
                    <a  href="#" @click.prevent="remove(task.id)"> <span class="fa fa-times"></span> </a>
                </div>
                <TasksFields :employee="employee" :task="task" :formFields="formFields" />
            </span>
          <p class="mt-2">
            <a href="#" @click.prevent="add"> <span class="fa fa-plus-circle"></span> Delegate Task</a>
          </p>

</div>
</template>

<script>
import TasksFields from './Components/TasksFields.vue';
export default {
  components: { TasksFields },
    props:{
        settings:Array,
        employee:Object,
        formFields:Array,
    },
    data: function(){
      return{
         fields: [],
         user:this.$page.props.auth.user,
      }
    },
    methods:{
       add(){
            let item = {};
            this.fields.push(item); 
        },
        remove(val){

          if( ! confirm("Are you sure you want to delete task?") ) return;
          this.deleteTask(val);
            /*for( var i = 0; i < this.fields.length; i++)
                if( val == this.fields[i].id ){
                  console.log(this.fields[i])
                }*/
            
        },
        getTasks(){
          axios({
                method: 'GET',
                url: "/v1/tasks?user_id="+ this.user.id +"&type=employee_onboarding&type_id="+this.employee.id,
                data: {
                    
                }
                }).then((response) => {
                    if( response.data.data.length )
                      this.fields = response.data.data
                   // console.log(this.fields)
                })
                .catch( (error) => {
                console.log(error.response);
            });
        },
        deleteTask(id){
          if( ! id ) return false;

          axios({
                method: 'DELETE',
                url: "/v1/tasks/"+id,
                data: {
                    
                }
                }).then((response) => {
                   //console.log(response.data)
                   this.fields = this.fields.filter((item)=> item.id.toString() != id.toString() );
                })
                .catch( (error) => {
                console.log(error.response);
            });

        }
    },
    mounted(){
      this.getTasks()
    }
}
</script>

<style>

</style>