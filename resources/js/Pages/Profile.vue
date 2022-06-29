<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <app-header :user="user" :title="user.first_name +' '+ user.last_name" />
    <div class="container-fluid profile">
        <div class="row">
            <div class="col-3 profile-panel">
                <profile-sidebar :permissions="permissions" :settings="settings" :user="user" />
            </div>
            <div class="col-9">
                <nav>
                    <div style="margin-top:-40px" class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <button :class="{active:active == '1'}" class="nav-link" id="nav-personal-tab" data-bs-toggle="tab" data-bs-target="#nav-personal" type="button" role="tab" aria-controls="nav-personal" aria-selected="true">Personal</button>
                        <button :class="{active:active == '2'}" class="nav-link" id="nav-job-tab" data-bs-toggle="tab" data-bs-target="#nav-job" type="button" role="tab" aria-controls="nav-job" aria-selected="false">Job</button>
                        <button :class="{active:active == '3'}" class="nav-link " id="nav-leave-tab" data-bs-toggle="tab" data-bs-target="#nav-leave" type="button" role="tab" aria-controls="nav-leave" aria-selected="false">Leave</button>
                        <button :class="{active:active == '4'}" class="nav-link " id="nav-benefits-tab" data-bs-toggle="tab" data-bs-target="#nav-benefits" type="button" role="tab" aria-controls="nav-benefits" aria-selected="false">Benefits</button>
                        <button :class="{active:active == '5'}" class="nav-link " id="nav-assets-tab" data-bs-toggle="tab" data-bs-target="#nav-assets" type="button" role="tab" aria-controls="nav-assets" aria-selected="false">Assets</button>
                        <button :class="{active:active == '6'}" class="nav-link " id="nav-emergency-tab" data-bs-toggle="tab" data-bs-target="#nav-emergency" type="button" role="tab" aria-controls="nav-emergency" aria-selected="false">Emergency</button>
                    </div>
                    </nav>
                    <div class="tab-content tab-pane-content" id="nav-tabContent">
                        <div :class="{'active show':active == '1'}" class="tab-pane fade  bg-white" id="nav-personal" role="tabpanel" aria-labelledby="nav-personal-tab">
                            <form action="">
                                <Basic  :fields="formFields" :permissions="permissions" :settings="settings" :user="user" />
                                <Address  :fields="addressFormFields" :permissions="permissions" :settings="settings" :user="user" />
                                <Education   :permissions="permissions" :settings="settings" :user="user" />
                                <Certifications   :permissions="permissions" :settings="settings" :user="user" />
                                <Language   :permissions="permissions" :settings="settings" :user="user" />

                            </form>
                        </div>
                        <div :class="{'active show':active == '2'}" class="tab-pane fade bg-white" id="nav-job" role="tabpanel" aria-labelledby="nav-job-tab">
                            <Job :permissions="permissions" :settings="settings" :user="user" />
                        </div>
                        <div :class="{'active show':active == '3'}" class="tab-pane fade bg-white" id="nav-leave" role="tabpanel" aria-labelledby="nav-leave-tab">
                            <Leave :permissions="permissions" :settings="settings" :user="user" />
                        </div>
                        <div :class="{'active show':active == '4'}" class="tab-pane fade bg-white " id="nav-benefits" role="tabpanel" aria-labelledby="nav-benefits-tab">
                            <Benefits :permissions="permissions" :settings="settings" :user="user" />
                        </div>
                        <div :class="{'active show':active == '5'}" class="tab-pane fade bg-white " id="nav-assets" role="tabpanel" aria-labelledby="nav-assets-tab">
                            <Assets :permissions="permissions" :assetFormFields="assetFormFields" :settings="settings" :user="user" />
                        </div>
                        <div :class="{'active show':active == '6'}" class="tab-pane fade bg-white " id="nav-emergency" role="tabpanel" aria-labelledby="nav-emergency-tab">
                            <Emergency :permissions="permissions" :settings="settings" :user="user" />
                            <Dependants :permissions="permissions" :settings="settings" :user="user" />
                            <Beneficiaries :permissions="permissions" :settings="settings" :user="user" />

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
import ProfileSidebar from '@/Components/ProfileSidebar.vue';
import Basic from '@/Components/Profile/Sections/Basic.vue';
import Education from '@/Components/Profile/Sections/Education.vue';
import Certifications from '@/Components/Profile/Sections/Certifications.vue';
import Address from '@/Components/Profile/Sections/Address.vue';
import Language from '@/Components/Profile/Sections/Language.vue';

import Job from '@/Components/Profile/Job.vue';
import Leave from '@/Components/Profile/Leave.vue';
import Benefits from '@/Components/Profile/Benefits.vue';
import Assets from '@/Components/Profile/Assets.vue';
//import Emergency from '@/Components/Profile/Emergency.vue';
import Emergency from '@/Components/Profile/Sections/Emergency.vue';
import Dependants from '@/Components/Profile/Sections/Dependants.vue';
import Beneficiaries from '@/Components/Profile/Sections/Beneficiaries.vue';

export default {
    props:{
        settings:Array,
        user:Object,
        permissions:Array,
        formFields:Array,
        addressFormFields:Array,
        assetFormFields:Array,
        activeTab:String,
    },
    data() {
        return {
            active:this.activeTab ? this.activeTab : '1',
        }
    },
    components:{
        BreezeAuthenticatedLayout,
        Head,
        Link,
        AppHeader,
        ProfileSidebar,
        Basic,
        Job,
        Leave,
        Benefits,
        Assets,
        Emergency,
        Education,
        Certifications,
        Address,
        Language,
        Beneficiaries,
        Dependants
    }
}
</script>