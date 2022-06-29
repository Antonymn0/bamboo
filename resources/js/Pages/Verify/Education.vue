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
                        <Link class="nav-link active"  href="#" >Verify Education Details</Link>
                    </div>
                </nav>

                <div class="tab-pane-content verification-content" style="padding:15px" >
                    <div v-if="newEmployee.education.length">
                        <h1 class="title-border pb-2"> <small class="fa fa-graduation-cap"></small> Education Details</h1>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                <th scope="col">Serial</th>
                                <th scope="col">Qualification</th>
                                <th scope="col">Field of Study</th>
                                <th scope="col">From</th>
                                <th scope="col">To</th>
                                <th scope="col">Achievement</th>
                                <th scope="col">Verified?</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">

                                <tr v-for="(education,count) in newEmployee.education" :key="education.id" >
                                    <td>{{count + 1}}</td>
                                    <td> <input class="form-control text-capitalize" type="text" :value="education.institution_name" @change="updateEducation('/v1/certification/'+certification.id,'membership_id',$event.target.value)" /> </td>
                                    <td> <input class="form-control text-capitalize" type="text" :value="education.field_of_study" @change="updateEducation('/v1/education/'+education.id,'field_of_study',$event.target.value)" /> </td>
                                    <td> <input class="form-control text-capitalize" type="text" :value="education.start_date" @change="updateEducation('/v1/education/'+education.id,'start_date',$event.target.value)" /> </td>
                                    <td> <input class="form-control text-capitalize" type="text" :value="education.end_date" @change="updateEducation('/v1/education/'+education.id,'end_date',$event.target.value)" /> </td>
                                    <td> <input class="form-control text-capitalize" type="text" :value="getAchievement(education).value" @change="updateEducation('/v1/education/'+education.id,getAchievement(education).name,$event.target.value)" /> </td>
                                    <td> <input type="checkbox" :checked="education.verified_at" @change="updateEducation('/v1/education/'+education.id,'verified_at',$event.target.checked ? 1 : '','current_time',$event.target)" /> </td>
                                </tr>
                                

                            </tbody>
                        </table>
                    </div>


                    <div v-if="newEmployee.certifications.length">
                        <h1 class="title-border pb-2"> <small class="fa fa-certificate"></small> Professional Certifications</h1>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                <th scope="col">Serial</th>
                                <th scope="col">Certificate Name</th>
                                <th scope="col">Professional Body</th>
                                <th scope="col">Membership No.</th>
                                <th scope="col">Expiry</th>
                                <th scope="col">Verified?</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">

                                <tr v-for="(certification,count) in newEmployee.certifications" :key="certification.id" >
                                    <td>{{count + 1}}</td>
                                    <td> <input class="form-control text-capitalize" type="text" :value="certification.certificate_name" @change="updateEducation('/v1/certification/'+certification.id,'certificate_name',$event.target.value)" /> </td>
                                    <td> <input class="form-control text-capitalize" type="text" :value="certification.organisation_name" @change="updateEducation('/v1/certification/'+certification.id,'organisation_name',$event.target.value)" /> </td>
                                    <td> <input class="form-control" type="text" :value="certification.membership_id" @change="updateEducation('/v1/certification/'+certification.id,'membership_id',$event.target.value)" /> </td>
                                    <td> <input class="form-control text-capitalize" type="text" :value="certification.expiry_date" @change="updateEducation('/v1/certification/'+certification.id,'expiry_date',$event.target.value)" /> </td>
                                    <td> <input type="checkbox" :checked="certification.verified_at" @change="updateEducation('/v1/certification/'+certification.id,'verified_at',$event.target.checked ? 1 : '','current_time',$event.target)" /> </td>
                                </tr>
                                

                            </tbody>
                        </table>
                    </div>

                    <div v-if="newEmployee.languages.length">
                        <h1 class="title-border pb-2"> <small class="fa fa-language"></small> Languages</h1>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                <th scope="col">Serial</th>
                                <th scope="col">Language</th>
                                <th scope="col">Written Proficiency</th>
                                <th scope="col">Spoken Proficiency</th>
                                <th scope="col">Verified?</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">

                                <tr v-for="(language,count) in newEmployee.languages" :key="language.id" >
                                    <td>{{count + 1}}</td>
                                    <td> <input class="form-control text-capitalize" type="text" :value="language.name" @change="updateEducation('/v1/language/'+language.id,'membership_id',$event.target.value)" /> </td>
                                    <td> <input class="form-control text-capitalize" type="text" :value="language.written_proficiency" @change="updateEducation('/v1/language/'+language.id,'membership_id',$event.target.value)" /> </td>
                                    <td> <input class="form-control text-capitalize" type="text" :value="language.spoken_proficiency" @change="updateEducation('/v1/language/'+language.id,'membership_id',$event.target.value)" /> </td>
                                    <td> <input type="checkbox" :checked="language.verified_at" @change="updateEducation('/v1/language/'+language.id,'verified_at',$event.target.checked ? 1 : '','current_time',$event.target)" /> </td>
                                </tr>
                                

                            </tbody>
                        </table>
                    </div>

                    <p class="mb-3 text-theme" v-if="next_page < last_page" >
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
                    this.next_page = this.last_page > this.current_page + 1 ? this.current_page + 1 : this.last_page
                    this.loading= false
                })
                .catch( (error) => {
                console.log(error.response);
            });
        },
        updateEducation(url,name,value,type=null,target=null){
            if( ! confirm("Are you sure you want to proceed?") ){
                //if( type == 'current_time' )
                    target.checked = ! target.checked 
                return;
            } 
            axios({
                method: 'patch',
                url: url,
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
        getAchievement(education){
            if( education.qualification == 'kcpe' )
                return {name:'marks',value:education.marks}
            else if( education.qualification == 'kcse' || education.qualification == 'cpe' )
                return {name:'grade_attained',value:education.grade_attained}
            return {name:'grade',value:education.grade}
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