<template>
    <div style="margin-top:-40px" class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
        <Link class="nav-link" :class="{active:active==1}" :href="link ? link+'?step=1' : '' " >Basic</Link>
        <Link class="nav-link" :class="{active:active==2}" :href="link ? link+'?step=2' : '' " >Contacts</Link>
        <Link class="nav-link" :class="{active:active==3}" :href="link ? link+'?step=3' : '' " >Education</Link>
        <Link class="nav-link" :class="{active:active==4}" :href="link ? link+'?step=4' : '' " >Experience</Link>
        <Link class="nav-link" :class="{active:active==5}" :href="link ? link+'?step=5' : '' " >Dependants</Link>
        <Link class="nav-link" :class="{active:active==6}" :href="link ? link+'?step=6' : '' " >Beneficiaries</Link>
        <Link class="nav-link" :class="{active:active==7}" :href="link ? link+'?step=7' : '' " >Emergency</Link>
        <Link class="nav-link" :class="{active:active==8}" :href="link ? link+'?step=8' : '' " >Payment</Link>
        <Link class="nav-link" :class="{active:active==9}" :href="link ? link+'?step=9' : '' " >Picture</Link>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';

export default {
    props:{
        active:Number,
        link:String
    },
    components:{
        Link
    }

}
</script>

<style>

</style>