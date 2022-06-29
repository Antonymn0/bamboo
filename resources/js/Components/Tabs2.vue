<template>
    <div style="margin-top:-40px" class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
    <Link  class="nav-link" :class="{active:active==1}" :href="route('newuser.basic.details',user.username)" >Basic</Link>
    <Link class="nav-link" :class="{active:active==2}" :href="route('newuser.address.details',user.username)"   >Contacts</Link>
    <Link class="nav-link" :class="{active:active==3}" :href="route('newuser.education.details',user.username)"  >Education</Link>
    <Link class="nav-link" :class="{active:active==4}" :href="route('newuser.work.details',user.username)"  >Experience</Link>
    <Link class="nav-link" :class="{active:active==5}" :href="route('newuser.dependants.details',user.username)" >Dependants</Link>
    <Link class="nav-link" :class="{active:active==6}" :href="route('newuser.beneficiaries.details',user.username)" >Beneficiaries</Link>
    <Link class="nav-link" :class="{active:active==7}" :href="route('newuser.emergency.details',user.username)" >Emergency</Link>
    <Link class="nav-link" :class="{active:active==8}" :href="route('newuser.payment.details',user.username)" >Payment</Link>
</div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';

export default {
    props:{
        active:Number,
        link:String,
        user:Object
    },
    components:{
        Link
    }

}
</script>

<style>

</style>