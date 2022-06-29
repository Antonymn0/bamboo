<template>

    <div v-if="tasks.length">
        <ProgressPanel v-for="(task,count) in tasks" :key="task.id" :task="task" :last="tasks.length == count + 1" :serial="count + 1" />
        <p class="text-center" v-if=" last_page > current_page">
                <a href="#" @click.prevent="fetch(current_page + 1)">Load More...</a>
            </p>
    </div>
</template>

<script>
import ProgressPanel from './ProgressPanel.vue'
export default {
  components: { ProgressPanel },
  data() {
        return {
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
                url: '/v1/tasks?page='+page+'&assigned_to='+this.authUser.id+'&user_id='+this.authUser.id+'&limit='+this.limit,
                data: {
                }
                }).then((response) => {
                    this.current_page = response.data.current_page
                    this.last_page = response.data.last_page
                    this.tasks = [...this.tasks, ...response.data.data]
                    this.total_tasks = response.data.total
                    this.loading = false
                    //this.selectedTask = ''
                    //console.log(this.tasks)
                })
                .catch( (error) => {
                console.log(error.response);
            });
        },
  },
  mounted(){
        this.fetch()
    },

}
</script>

<style scoped>

</style>