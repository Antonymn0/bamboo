<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout :hideNavItems="true">
        <app-header :user="newEmployee"  />
    <div class="container-fluid profile">
        <div class="row">
            <div class="col-3 profile-panel">
                <RegistrationSidebar :user="newEmployee" />
            </div>
            <div class="col-9">
                <nav>
                   <div style="margin-top:-40px" class="nav nav-tabs" id="nav-tab" role="tablist">
                        <Link class="nav-link active"  href="#" >Verify Employee Biodata</Link>
                    </div>
                </nav>

                <div class="tab-pane-content verification-content" style="padding:15px" >
                    
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">Detail</th>
                            <th scope="col">Value</th>
                            <th scope="col">Verified?</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr >
                                <td>First Name</td>
                                <td> <input class="form-control text-capitalize" type="text" :value="newEmployee.first_name" @change="updateUser('first_name',$event.target.value)" /> </td>
                                <td> <input type="checkbox" :checked="newEmployee.first_name_verified_at" @change="updateUser('first_name_verified_at',$event.target.checked ? 1 : '','current_time',$event.target)" /> </td>
                            </tr>
                            <tr v-if="newEmployee.middle_name ">
                                <td>Middle Name</td>
                                <td> <input class="form-control text-capitalize" type="text" :value="newEmployee.middle_name" @change="updateUser('middle_name',$event.target.value)" /> </td>
                                <td> <input type="checkbox" :checked="newEmployee.middle_name_verified_at" @change="updateUser('middle_name_verified_at',$event.target.checked ? 1 : '','current_time',$event.target)" /> </td>
                            </tr>
                            <tr >
                                <td>Surname</td>
                                <td> <input class="form-control text-capitalize" type="text" :value="newEmployee.last_name" @change="updateUser('last_name',$event.target.value)" /> </td>
                                <td> <input type="checkbox" :checked="newEmployee.surname_verified_at" @change="updateUser('surname_verified_at',$event.target.checked ? 1 : '','current_time',$event.target)" /> </td>
                            </tr>
                            <tr >
                                <td>Email</td>
                                <td> <input class="form-control" type="email" :value="newEmployee.email" @change="updateUser('email',$event.target.value)" /> </td>
                                <td> <input type="checkbox" :checked="newEmployee.email_verified_at" @change="updateUser('emai_verified_at',$event.target.checked ? 1 : '','current_time',$event.target)" /> </td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td> <input class="form-control text-capitalize" type="text" :value="newEmployee.phone" @change="updateUser('phone',$event.target.value)" /> </td>
                                <td> <input type="checkbox" :checked="newEmployee.phone_verified_at" @change="updateUser('phone_verified_at',$event.target.checked ? 1 : '','current_time',$event.target)" /> </td>
                            </tr>

                            <tr v-for="meta in metaData" :key="meta.id" >
                                <td class="text-capitalize">{{formartWords(meta.key)}}</td>
                                <td> <input class="form-control text-capitalize" type="text" :value="formartWords(meta.value)" @change="updateUser(meta.key,$event.target.value)" /> </td>
                                <td> <input type="checkbox" :checked="meta.verified_at" @change="updateUser(meta.key,$event.target.checked ? 1 : '','current_time',$event.target)" /> </td>
                            </tr>

                        </tbody>
                    </table>

                    <p class="mb-3 text-theme" v-if="next_page" >
                        <a href="#" @click.prevent="getUserMeta(next_page)" >Load More...  <small v-if="loading" class="fa fa-spinner fa-spin"></small> </a>
                    </p>

                <form class="border-top pt-2 pb-2 bg-light" id="submit-form" :action="route('employee.submit',newEmployee.username)">
                    <a href="#" @click.prevent="submit" class="btn btn-theme">Submit</a>

                    <Link @click.prevent="continueLater()" class="ml-4" >
                            Save and continue later 
                    </Link>
                </form>
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
import RegistrationSidebar from '@/Components/RegistrationSidebar.vue';
import Personal from '@/Components/Profile/Personal.vue';
import Job from '@/Components/Profile/Job.vue';
import Leave from '@/Components/Profile/Leave.vue';
import Benefits from '@/Components/Profile/Benefits.vue';
import Assets from '@/Components/Profile/Assets.vue';
import Emergency from '@/Components/Profile/Emergency.vue';
import BreezeButton from '@/Components/Button.vue';
import Basic from '@/Components/Profile/Sections/Basic.vue';
import Tabs from '@/Components/Tabs.vue';

export default {
    props:{
        newEmployee:Object,
        task:Object,
        settings:Array,
        formFields:Array,
    },
    data: function(){
      return{
          processing:false,
          metaData:[],
          per_page:10,
          current_page:1,
          last_page:null,
          next_page:null,
          loading:false
      }
    },
    components:{
        BreezeAuthenticatedLayout,
        Head,
        Link,
        AppHeader,
        RegistrationSidebar,
        Personal,
        Job,
        Leave,
        Benefits,
        Assets,
        Emergency,
        BreezeButton,
        Basic,
        Tabs
    },
    methods:{
        save(){
            if( confirm("Are you sure you want to submit details?") )
                $("#submit-form").submit()
        },
        continueLater(){
            alert("Details saved successfully. You can close the window and continue later")
        },
        getUserMeta(page=1){
            this.loading = true
            axios({
                method: 'get',
                url: '/v1/user-meta/'+this.newEmployee.id+'?category=basic_details&per_page='+this.per_page+'&page='+page,
                data: {
                }
                }).then((response) => {
                    this.metaData = [...this.metaData, ...response.data.data] 
                    this.current_page = response.data.current_page
                    this.last_page = response.data.last_page
                    this.next_page = this.last_page >= this.current_page + 1 ?  this.current_page + 1 : ''
                    this.loading= false
                })
                .catch( (error) => {
                console.log(error.response);
            });
        },
        updateUser(name,value,type=null,target=null){
            if( ! confirm("Are you sure you want to proceed?") ){
                //if( type == 'current_time' )
                    target.checked = ! target.checked 
                return;
            } 
            axios({
                method: 'patch',
                url: '/v1/users/'+this.newEmployee.id,
                data: {
                    field:name,
                    value:value,
                    type:type,
                }
                }).then((response) => {
                    //console.log(response.data)
                    this.loading = false
                })
                .catch( (error) => {
                console.log(error.response);
            });
        },
        formartWords(slug){
            return slug ? slug.toString().replace(/[^a-zA-Z0-9,. ]/g,' ') : slug;
        },
        submit(){
            if( ! this.task ) return;

            if( ! confirm("Are you sure you want to finish task?") ) return;

            this.processing = true;

            axios({
                method: 'post',
                url: '/v1/task/complete/'+this.task.id,
                data: {
                    
                }
            }).then((response) => {
                this.processing = false
                let task = response.data

                /*if( task.status == 'complete' )
                    alert( "Task completed succesfully" )
                else 
                    alert( "Corrections request sent to employee" )*/

                window.open('/','_self');
            })
            .catch( (error) => {
                console.log(error.data);
            });
        }
    },
    mounted(){
        this.getUserMeta();
    }
}
</script>
<style scoped>
ul{
}
li{
    cursor: pointer;
    padding: 15px 0;
}
li .icon{
    color: var(--theme-color);
    font-size: 1.6em;
}
</style>