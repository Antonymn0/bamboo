<template>
  <div class="profile-sidebar border">
      <div class="contacts border-bottom pb-2">
          <ul class="text-capitalize">
              <li v-if="user.company" class="mb-2">
                  <span class="fa fa-building"></span>&nbsp;&nbsp;
                  {{user.company.company_name}}
              </li>
              <li v-if="user.company" class="mb-2">
                  <span class="fa fa-map-marker-alt"></span>&nbsp;&nbsp;
                  {{getMetaValue('company_address',user.company.meta)}}
              </li>
              <li v-if="user.company" class="mb-2 text-lowercase">
                  <span class="fa fa-globe"></span>&nbsp;&nbsp;
                  <a :href="getMetaValue('website',user.company.meta)">
                      {{getMetaValue('website',user.company.meta)}}
                  </a>
              </li>
          </ul>
          <!--<ul class="social-icons mt-3">
              <li class="d-inline-block mr-4">
                   <a :href="getMetaValue('facebook_url',user.company.meta)" title="Facebook">
                        <span class="fab fa-facebook"></span>
                    </a>
              </li>
              <li class="d-inline-block mr-4">
                   <a :href="getMetaValue('twitter_url',user.company.meta)" title="Twitter">
                        <span class="fab fa-twitter"></span>
                    </a>
              </li>
              <li class="d-inline-block mr-4">
                    <a :href="getMetaValue('instagram_url',user.company.meta)" title="Instagram">
                        <span class="fab fa-instagram"></span>
                    </a>
              </li>
              <li class="d-inline-block mr-4">
                    <a :href="getMetaValue('linked_url',user.company.meta)" title="Linkedin">
                        <span class="fab fa-linkedin"></span>
                    </a>
              </li>
              <li class="d-inline-block mr-4">
                    <a :href="getMetaValue('website_url',user.company.meta)" title="Website">
                        <span class="fa fa-link"></span>
                    </a>
              </li>
          </ul>-->
      </div>

      <div v-if="present || on_leave || absent" class="contact border-bottom mt-3 pb-2">
          <h3 class="text-theme pb-1">Current Attendance</h3>
          <p v-if="present" class="pb-1"> <small class="fa fa-circle text-success"></small> <Link href="#"> {{present}} Present </Link></p>
          <p v-if="on_leave" class="pb-1"> <small class="fa fa-circle text-warning"></small> <Link href="#"> {{on_leave}} On leave </Link></p>
          <p v-if="absent" class="pb-1"> <small class="fa fa-circle text-danger"></small> <Link href="#"> {{absent}} Absent </Link></p>
      </div>

     <AssignedTasks />

      <div v-if="on_leave_tomorrow.length" class="contacts border-bottom mt-3 pb-2">
          <h3 class="text-theme">Who is Out Tomorrow</h3>
          <Link v-for="(employee) in on_leave_tomorrow" :key="employee.id" :href="route('profile',employee.username)">
                <div  class="avatar" :style="'background-image:url('+getAvatar(employee.media)+')'" :title="employee.first_name +' '+ employee.last_name"></div>
          </Link>
      </div>


      <div class="contacts mt-3 pb-2">
          <h3 class="text-theme">Useful Links</h3>
          <p class="mt-2 text-sm"> <Link :href="route('profile')"> My Profile </Link></p>
          <p class="mt-2 text-sm"> <Link :href="route('employees')"> People </Link></p>
          <p class="mt-2 text-sm"> <Link :href="route('payroll')"> Payroll </Link></p>
          <p class="mt-2 text-sm"> <Link :href="route('reports')"> Reports </Link></p>
      </div>

      

  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import AssignedTasks from './AssignedTasks.vue';

export default {
    props:{
        user:Object
    },
    components:{
        Link,
        AssignedTasks,
    },
    data(){
        return{
            present:'',
            on_leave:'',
            absent:'',
            on_leave_tomorrow:[],
            company:this.$page.props.auth.company
        }
    },

    methods:{
        getMetaValue(key,metaData){

            let value = '';

            for( let i = 0; i < metaData.length; i++ )
            {
                if( metaData[i].key == key ){
                    value = metaData[i].value
                    break;
                }
            }

            return value;

        },
        getAttendance(){
            axios({
                    method: 'GET',
                    url:'/v1/employee/attendance/'+this.company.id,
                    data: {},
                    }).then( response => {
                        //console.log(response.data)
                        if( ! response.data ) return;

                        this.present = response.data.present
                        this.on_leave = response.data.on_leave
                        this.absent = response.data.absent
                        this.on_leave_tomorrow = response.data.on_leave_tomorrow

                    })
                    .catch( error => {
                    console.log(error.response);
            });
        },
        getAvatar(media){
            if( media.length )
                return media[0].public_uri
        }
    },
    mounted(){
        this.getAttendance()
    }
}
</script>

<style scoped>
.avatar{
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: inline-block;
    margin: 5px;
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
}
</style>