<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout :hideNavItems="true">
        <app-header :title="newEmployee.first_name+' '+newEmployee.last_name"  />
    <div class="container-fluid profile">
        <div class="row">
            <div class="col-3 profile-panel">
                <RegistrationSidebar :user="newEmployee" />
            </div>
            <div class="col-9">

                <nav>
                   <Tabs :active="1" :user="newEmployee" />
                </nav>

                <div style="padding:15px" >
                    

                <div class="tab-pane-content">
                    <h1 class="title-border pb-2"> <small class="fa fa-id-card"></small> Personal </h1>

                    <div class="row">
                        <div class="col-7">
                            <form action="">
                                <Basic :showVerifyBox="true" :fields="formFields" :permissions="permissions" :settings="settings" :user="newEmployee" />
                            </form>
                        </div>
                        
                        <div class="col-5">
                            <div class="verification-panel bg-light">
                                <h2>Verify Details</h2>

                                <div class="accordion mt-4">

                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#nameCollapse">
                                           <span class="fa fa-user-tie"></span>&nbsp; Name &nbsp; <small v-if="name_verified_at" class="fa fa-check-circle text-success"></small> <small v-else class="fa fa-exclamation-triangle text-danger"></small>
                                        </button>
                                        </h2>
                                        <div id="nameCollapse" class="accordion-collapse collapse">
                                        <div class="accordion-body">
                                            <ul>
                                                <li class="text-capitalize">
                                                    <p>
                                                        <input v-model="name_verified_at" type="checkbox" @change="save('name_verified_at',$event.target.checked,'current_time',true)"> <small>&nbsp;Mark as verified</small>&nbsp;Full Name: <strong> {{newEmployee.first_name}} {{newEmployee.middle_name}} {{newEmployee.last_name}}  </strong> 
                                                        &nbsp;
                                                    </p>
                                                   
                                                </li>
                                            </ul>
                                        </div>
                                        </div>
                                    </div>


                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#dobGenderCollapse">
                                           <span class="fa fa-birthday-cake"></span>&nbsp; Birthday & Gender &nbsp; <small v-if="dob_verified_at && gender_verified_at" class="fa fa-check-circle text-success"></small> <small v-else class="fa fa-exclamation-triangle text-danger"></small>
                                        </button>
                                        </h2>
                                        <div id="dobGenderCollapse" class="accordion-collapse collapse">
                                        <div class="accordion-body">
                                            <ul>
                                                <li class="text-capitalize">
                                                    <p>
                                                        <input v-model="dob_verified_at" type="checkbox" @change="save('dob_verified_at',$event.target.checked,'current_time',true)"> <small>&nbsp;Mark as verified</small>&nbsp;Birthday: <strong> {{newEmployee.dob ? newEmployee.dob : 'Not filled'}}   </strong> 
                                                        &nbsp;
                                                    </p>
                                                   
                                                </li>
                                                <li class="text-capitalize">
                                                    <p>
                                                        <input v-model="gender_verified_at" type="checkbox" @change="save('gender_verified_at',$event.target.checked,'current_time',true)"> <small>&nbsp;Mark as verified</small>&nbsp;Gender: <strong> {{newEmployee.gender  ? newEmployee.gender : 'Not filled'}}   </strong> 
                                                        &nbsp;
                                                    </p>
                                                   
                                                </li>
                                            </ul>
                                        </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#documentsCollapse">
                                           <span class="fa fa-id-card"></span>&nbsp; Official Documents &nbsp; <small v-if="(national_id_no_verified_at || passport_no_verified_at) && kra_pin_no_verified_at && nssf_no_verified_at && nhif_no_verified_at" class="fa fa-check-circle text-success"></small> <small v-else class="fa fa-exclamation-triangle text-danger"></small>
                                        </button>
                                        </h2>
                                        <div id="documentsCollapse" class="accordion-collapse collapse">
                                        <div class="accordion-body">
                                            <ul>
                                                <li class="text-capitalize">
                                                    <p>
                                                        &nbsp;<input v-model="national_id_no_verified_at" type="checkbox" @change="save('national_id_no_verified_at',$event.target.checked,'current_time',true)"> <small>&nbsp;Mark as verified</small>
                                                        National ID/ Alien ID: <strong> {{newEmployee.national_id_no ? newEmployee.national_id_no : 'Not filled'}}   </strong> 
                                                    </p>
                                                   
                                                </li>
                                                <li class="text-capitalize">
                                                    <p>
                                                        &nbsp;<input v-model="passport_no_verified_at" type="checkbox" @change="save('passport_no_verified_at',$event.target.checked,'current_time',true)"> <small>&nbsp;Mark as verified</small>
                                                        Passport No: <strong> {{newEmployee.passport_no  ? newEmployee.passport_no : 'Not filled'}}   </strong> 
                                                    </p>
                                                   
                                                </li>
                                                <li class="text-capitalize">
                                                    <p>
                                                        &nbsp;<input v-model="huduma_no_verified_at" type="checkbox" @change="save('huduma_no_verified_at',$event.target.checked,'current_time',true)"> <small>&nbsp;Mark as verified</small>
                                                        Huduma No: <strong> {{newEmployee.huduma_no  ? newEmployee.huduma_no : 'Not filled'}}   </strong> 
                                                    </p>
                                                   
                                                </li>
                                                <li class="text-capitalize">
                                                    <p>
                                                        &nbsp;<input v-model="driving_license_no_verified_at" type="checkbox" @change="save('driving_license_no_verified_at',$event.target.checked,'current_time',true)"> <small>&nbsp;Mark as verified</small>
                                                        Drivers License No: <strong> {{newEmployee.driving_license_no  ? newEmployee.driving_license_no : 'Not filled'}}   </strong> 
                                                    </p>
                                                   
                                                </li>
                                                <li class="text-capitalize">
                                                    <p>
                                                        &nbsp;<input v-model="kra_pin_no_verified_at" type="checkbox" @change="save('kra_pin_no_verified_at',$event.target.checked,'current_time',true)"> <small>&nbsp;Mark as verified</small>
                                                        KRA Pin: <strong> {{newEmployee.kra_pin_no  ? newEmployee.kra_pin_no : 'Not filled'}}   </strong> 
                                                    </p>
                                                   
                                                </li>
                                                <li class="text-capitalize">
                                                    <p>
                                                        &nbsp;<input v-model="nhif_no_verified_at" type="checkbox" @change="save('nhif_no_verified_at',$event.target.checked,'current_time',true)"> <small>&nbsp;Mark as verified</small>
                                                        Nhif No: <strong> {{newEmployee.nhif_no  ? newEmployee.nhif_no : 'Not filled'}}   </strong> 
                                                    </p>
                                                   
                                                </li>
                                                <li class="text-capitalize">
                                                    <p>
                                                        &nbsp;<input v-model="nssf_no_verified_at" type="checkbox" @change="save('nssf_no_verified_at',$event.target.checked,'current_time',true)"> <small>&nbsp;Mark as verified</small>
                                                        Nssf No: <strong> {{newEmployee.nssf_no  ? newEmployee.nssf_no : 'Not filled'}}   </strong> 
                                                    </p>
                                                   
                                                </li>
                                                <li v-if="newEmployee.disability" class="text-capitalize">
                                                    <p>
                                                        Disability Cert No: <strong> {{newEmployee.disability_cert_no  ? newEmployee.disability_cert_no : 'Not filled'}}   </strong> 
                                                        &nbsp;<input v-model="disability_cert_no_verified_at" type="checkbox" @change="save('disability_cert_no_verified_at',$event.target.checked,'current_time',true)"> <small>&nbsp;Mark as verified</small>
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
                        
                        <Link :href="route('newuser.address.details',newEmployee.username)" class="btn btn-theme ml-4 ">Next Page</Link>

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
import Basic from '../../Components/Profile/Sections/Basic.vue';
import Tabs from '@/Components/Tabs2.vue';
export default {
    props:{
        newEmployee:Object,
        settings:Array,
        permissions:Array,
        formFields:Array,
    },
    data: function(){
      return{
          processing:false,
          loading:{},
          name_verified_at:this.newEmployee.name_verified_at ? true : false,
          dob_verified_at:this.newEmployee.dob_verified_at ? true : false,
          gender_verified_at:this.newEmployee.gender_verified_at ? true : false,
          national_id_no_verified_at:this.newEmployee.national_id_no_verified_at ? true : false,
          passport_no_verified_at:this.newEmployee.passport_no_verified_at ? true : false,
          huduma_no_verified_at:this.newEmployee.huduma_no_verified_at ? true : false,
          driving_license_no_verified_at:this.newEmployee.driving_license_no_verified_at ? true : false,
          kra_pin_no_verified_at:this.newEmployee.kra_pin_no_verified_at ? true : false,
          nhif_no_verified_at:this.newEmployee.nhif_no_verified_at ? true : false,
          nssf_no_verified_at:this.newEmployee.nssf_no_verified_at ? true : false,
          disability_cert_no_verified_at:this.newEmployee.disability_cert_no_verified_at ? true : false,
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
                url: '/v1/users/'+this.newEmployee.id,
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