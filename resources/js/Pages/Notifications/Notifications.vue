<template>
   <span class="text-center p-5   text-muted" v-if="! Object.keys(notifications).length">
    <br> No notifications to show for now <br>
        </span>  
        
    <div class="card-body border py-3" v-if=" Object.keys(notifications).length">
        <ul v-for="(notification, index) in notifications" :key="index"> 

            <!-- leave application notifications                               -->
            <li class="border-bottom" v-if="notification.data.notification_type == 'leave' " >
                <div class="row" >                                       
                    <div class="col-auto icon">
                        <span class="fa fa-umbrella-beach"></span>
                    </div>
                    <div class="col-7 " >                                            
                        <strong>
                            <span v-if="notification.data.notification_sub_type == 'leave_created' ">
                                You have new leave requests awaiting  approval.
                                <Link :href="route(notification.data.notification_url, user.username)" class="text-theme">
                                    Click to open
                                </Link>
                            </span>
                            <span v-if="notification.data.notification_sub_type == 'leave_approved' ">
                                Your  leave request has been approved.
                                <Link :href="route(notification.data.notification_url, user.username)" class="text-theme">
                                        Click to open
                                </Link>
                            </span>                                                
                            <span v-if="notification.data.notification_sub_type == 'leave_under_review' ">
                                Your  leave application request has been put on hold and is under review.
                                <Link :href="route(notification.data.notification_url, user.username)" class="text-theme">
                                    Click to view Hr comments
                                </Link>
                            </span>                                                
                            <span v-if="notification.data.notification_sub_type == 'leave_declined' ">
                                Your  leave application request has been declined.
                                <Link :href="route(notification.data.notification_url, user.username)" class="text-theme">
                                    Click to view HR comments
                                </Link>                                               
                            </span>                                                
                        </strong>
                        <br>
                        <small>
                            1 minutes ago
                        </small>
                    </div>
                    <div class="col text-right edit-icon ">
                        <button @click.prevent="deleteNotification(notification.id)"> <span class=" p-2 fa fa-times" ></span> </button>   
                    </div>                                       
                </div>                                    
            </li>

            <!-- Auth notifications  -->
            <li class="border-bottom" v-if="notification.data.notification_type == 'auth' " >
                <div class="row" >                                       
                    <div class="col-auto icon">
                        <span class="fa fa-lock"></span>
                    </div>
                    <div class="col-7 " >                                       
                        <strong> 
                            <span v-if="notification.data.notification_sub_type == 'password_changed' ">
                                Your password has been successfully changed.
                                <Link :href="route(notification.data.notification_url)" class="text-theme">
                                    Click here to change again
                                </Link>
                            </span>                                                
                        </strong>
                        <br>
                        <small>
                            1 minutes ago
                        </small>
                    </div>
                    <div class="col text-right edit-icon ">
                        <button @click.prevent="deleteNotification(notification.id)"> <span class=" p-2 fa fa-times" ></span> </button>   
                    </div>                                       
                </div>                                    
            </li>
            <!-- payment notifications  -->
            <li class="border-bottom" v-if="notification.data.notification_type == 'payment' " >
                <div class="row" >                                       
                    <div class="col-auto icon">
                        <span class="fa fa-wallet"></span>
                    </div>
                    <div class="col-7 " >                                       
                        <strong> 
                            <span v-if="notification.data.notification_sub_type == 'payment_recieved' ">
                                Your subscription payment has been recieved.
                                <Link :href="route(notification.data.notification_url, user.username)" class="text-theme">
                                    Click here to confirm the reciept
                                </Link>
                            </span>                                                
                        </strong>
                        <br>
                        <small>
                            1 minutes ago
                        </small>
                    </div>
                    <div class="col text-right edit-icon ">
                        <button @click.prevent="deleteNotification(notification.id)"> <span class=" p-2 fa fa-times" ></span> </button>   
                    </div>                                       
                </div>                                    
            </li>
            
            <!--account  activation  notifications  -->
            <li class="border-bottom" v-if="notification.data.notification_type == 'activation' " >
                <div class="row" >                                       
                    <div class="col-auto icon">
                        <span class="fa fa-unlock"></span>
                    </div>
                    <div class="col-7 " >                                       
                        <strong> 
                            <span v-if="notification.data.notification_sub_type == 'account_activated' ">
                                Your account has been successfuly activated.
                                <Link :href="route(notification.data.notification_url)" class="text-theme">
                                    Enjoy!
                                </Link>
                            </span>                                                
                        </strong>
                        <br>
                        <small>
                            1 minutes ago
                        </small>
                    </div>
                    <div class="col text-right edit-icon ">
                        <button @click.prevent="deleteNotification(notification.id)"> <span class=" p-2 fa fa-times" ></span> </button>  
                    </div>                                       
                </div>                                    
            </li>
            
        </ul>
    </div>
</template>

<script>
import { Head,Link } from '@inertiajs/inertia-vue3';

export default {
    components:{
        Link,
        Head,
    },
  
    data(){
        return{
           user:this.$page.props.auth.user,
           notifications:{}
        }
    },
    methods:{
        fetchNotification(){
            axios.get(route('get.user.all-notifications', this.user.id))
            .then(response=>{
                this.notifications = response.data.data;
            })
            .catch(error=>{
                console.log(error.response);
            })
        },
        deleteNotification(id){
            axios.get(route('notification.delete', id))
            .then(response=>{
                this.notifications= response.data.data;
            })
            .catch(error=>{
                console.log(error.response);
            })
        }
    },
    mounted(){
        this.fetchNotification();
    }


}
</script>

<style>

</style>