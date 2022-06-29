<template>
    <div class="panel">
        <div class="circle">
            <h1 v-if="serial" class="text-center">{{serial}}.</h1>
            <p class="max-1-line"> <small>{{task.name}}</small> </p>
            <h1 class="text-center" :class="[task.status == 'complete' ? 'text-success' : 'text-danger']">
                <span :class="[task.status == 'complete' ? 'fa fa-check-circle' : 'fa fa-exclamation-triangle']" ></span>
            </h1>
            <p v-if="task.assignee" class="max-1-line"> 
                <small> 
                    <Link :href="route('profile',task.assignee.username)">
                        By {{task.assignee.first_name}}  {{task.assignee.last_name}} 
                    </Link>
                </small>  
            </p>
        </div>
        <div v-if="! last" class="line">
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
export default {
    props:{
        task:{type:Object,required:true},
        last:Boolean,
        serial:Number
    },
    components:{
        Link,
    }

}
</script>

<style scoped>
.panel{
    overflow: hidden;
}
.circle{
    max-width: 160px;
    margin: 0 auto;
    border: 1px solid var(--grey);
    align-items: center;
    padding: 5px;
    border-radius: 10px;
    overflow: hidden;
    position: relative;
    display: block;

}
.line{
    width: 1px;
    height: 10px;
    background-color: var(--theme-color);
    margin: 0 auto;
}
p{
    font-size: 16px; 
    text-align: center;
    text-transform: capitalize;
}
h1{
    font-size: 1.5em;
}
</style>