<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout :hideNavItems="true">
        <app-header :title="newEmployee.first_name+' '+newEmployee.last_name" />
    <div class="container-fluid profile">
        <div class="row">
            <div class="col-3 profile-panel">
                <RegistrationSidebar :user="newEmployee" />
            </div>
            <div class="col-9">
                <nav>
                    <Tabs :active="3" :user="newEmployee" />
                </nav>
                <div style="padding:15px" >
                    

                <div class="tab-pane-content">
                    <h1 class="title-border pb-2"> <small class="fa fa-id-card"></small> Personal </h1>

                    <div class="row">
                        <div class="col-7">
                            <form action="">
                                <Education :showVerifyBox="true" :permissions="permissions" :settings="settings" :user="newEmployee" />
                                <Certifications :showVerifyBox="true" :permissions="permissions" :settings="settings" :user="newEmployee" />
                                <Language :showVerifyBox="true" :permissions="permissions" :settings="settings" :user="newEmployee" />
                            </form>
                        </div>
                        <div class="col-5">
                            <div class="verification-panel bg-light">
                                <h2>Verify Details</h2>

                                <div class="accordion mt-4">

                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#nameCollapse">
                                           <span class="fa fa-graduation-cap"></span>&nbsp; Education &nbsp; <small v-if="verified_at" class="fa fa-check-circle text-success"></small> <small v-else class="fa fa-exclamation-triangle text-danger"></small>
                                        </button>
                                        </h2>
                                        <div id="nameCollapse" class="accordion-collapse collapse">
                                        <div class="accordion-body">
                                            <ul>
                                                <!--Loop-->
                                                <li v-for="(education,count) in newEmployee.education" :key="education.id" class="text-capitalize">
                                                    <p>
                                                        {{count + 1}}. Institution: <strong> {{education.institution_name}}  ({{education.qualification}}) </strong> 
                                                        &nbsp;<input v-model="education.verified_at" type="checkbox" @change="save('verified_at',$event.target.checked,'current_time',true)"> <small>&nbsp;Mark as verified</small>
                                                    </p>
                                                   
                                                </li>

                                            </ul>
                                        </div>      
                                        </div>
                                    </div>


                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <form class="border-top pt-2 pb-2 bg-light" id="submit-form" >
                        
                        <Link :href="route('newuser.address.details',newEmployee.username)" class="btn btn-secondary mr-4"> <span class="fa fa-chevron-left"></span> Back</Link>

                        <Link :href="route('newuser.work.details',newEmployee.username)" class="btn btn-theme ml-4 ">Next Page</Link>

                        <Link @click.prevent="continueLater()" class="ml-4" >
                                Save and continue later &nbsp;<span class="fa fa-chevron-right"></span>
                        </Link>
                    </form>

                </div>
                
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
import Education from '../../Components/Profile/Sections/Education.vue';
import Certifications from '../../Components/Profile/Sections/Certifications.vue';
import Language from '../../Components/Profile/Sections/Language.vue';
import Tabs from '@/Components/Tabs2.vue';
export default {
    props:{
        newEmployee:Object,
        settings:Array,
        permissions:Array,
    },
    data: function(){
      return{
          processing:false,
          verified_at:this.newEmployee.verified_at ? true : false,
          loading:{}
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
        Education,
        Certifications,
        Language,
        Tabs

    },
    methods:{
        save(){
            if( confirm("Are you sure you want to send the form back to employee?") )
                $("#submit-form").submit()
        },
        continueLater(){
            alert("Details saved successfully. You can close the window and continue later")
        },
        save(field,value,type,ask=false,askMsg='Are you sure you want to proceed?'){
            this.loading[field] = true
            if( ask )
                if( ! confirm(askMsg) ) 
                {
                    this[field] = ! this[field];
                    return false;
                }

            

            axios({
                method: 'patch',
                url: '/v1/education/'+this.newEmployee.id,
                data: {
                    field:field,
                    value:value,
                    type:type,
                }
                }).then((response) => {
                       //console.log(response.data)
                       this.loading[field] = false
                })
                .catch( (error) => {
                console.log(error.response);
            });
        },
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