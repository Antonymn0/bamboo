<template>
   <div class="bg-gray-100">
                    <ul>
                        <li class="active border-bottom">
                            <Link :href="route('preferences')">
                                <span class="fa fa-lock "></span>
                                Access Levels
                                <span class="fa fa-chevron-right float-right"></span>
                            </Link>
                        </li>
                        <li class="border-bottom">
                            <Link :href="route('account.status')">
                                <span class="fa fa-wallet text-muted"></span>
                                Account Status
                                <span class="fa fa-chevron-right float-right"></span>
                            </Link>
                        </li>
                        <li class="border-bottom">
                            <Link :href="route('user.change.password')">
                                <span class="fa fa-wallet text-muted"></span>
                                Password Reset
                                <span class="fa fa-chevron-right float-right"></span>
                            </Link>
                        </li>
                        <li class="border-bottom">
                            <Link :href="route('loans')">
                                <span class="fa fa-wallet text-muted"></span>
                                Loan
                                <span class="fa fa-chevron-right float-right"></span>
                            </Link>
                        </li>
                        <li class="border-bottom">
                            <Link :href="route('leave.options')">
                                <span class="fa fa-umbrella-beach text-muted"></span>
                                Leave
                                <span class="fa fa-chevron-right float-right"></span>
                            </Link>
                        </li>
                        <li class="border-bottom">
                            <Link :href="route('set.payroll.cycle')">
                                <span class="fa fa-money-bill-wave text-muted"></span>
                                Payroll Cycle
                                <span class="fa fa-chevron-right float-right"></span>
                            </Link>
                        </li>
                        <li class="border-bottom">
                            <Link :href="route('company.benefits')">
                                <span class="fa fa-heart text-muted"></span>
                                Benefits
                                <span class="fa fa-chevron-right float-right"></span>
                            </Link>
                        </li>
                        <li class="border-bottom">
                            <Link :href="route('preferences.time-tracking')">
                                <span class="fa fa-clock text-muted"></span>
                                Time Tracking
                                <span class="fa fa-chevron-right float-right"></span>
                            </Link>
                        </li>
                        <li class="border-bottom">
                            <Link :href="route('preferences.notifications')">
                                <span class="fa fa-bell text-muted"></span>
                                Notifications
                                <span class="fa fa-chevron-right float-right"></span>
                            </Link>
                        </li>
                        <li class="border-bottom">
                            <Link :href="route('logo.and.color')">
                                <span class="fa fa-palette text-muted"></span>
                                Logo & Color
                                <span class="fa fa-chevron-right float-right"></span>
                            </Link>
                        </li>
                        <li class="border-bottom">
                            <Link :href="route('employee.assets.form')">
                                <span class="fa fa-clipboard text-muted"></span>
                                Employee Assets
                                <span class="fa fa-chevron-right float-right"></span>
                            </Link>
                        </li>
                        <li class="border-bottom">
                             <Link :href="route('preferences.company-details')">
                                <span class="fa fa-building text-muted"></span>
                                Company Details
                                <span class="fa fa-chevron-right float-right"></span>
                            </Link>
                        </li>
                    </ul>
                </div>
 
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
import AppHeader from '@/Components/AppHeader.vue';
import ProfileSidebar from '@/Components/ProfileSidebar.vue';
import Personal from '@/Components/Profile/Personal.vue';
import Job from '@/Components/Profile/Job.vue';
export default {
    components:{
        BreezeAuthenticatedLayout,
        Head,
        Link,
        AppHeader,
        ProfileSidebar,
        Personal,
        Job,
    }
}
</script>
<style scoped>
.section{
    padding: 30px 0;
    border-bottom: 1px solid var(--grey);
}
.section h1{
    color: var(--theme-color);
}

li{
    padding: 15px;
}
li:hover{
    cursor: pointer;
    color: var(--theme-color);
}
.active{
    color: var(--theme-color);
}
</style>