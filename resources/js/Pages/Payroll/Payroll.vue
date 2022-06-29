<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <div class="container profile">
            <div class="section">
                <h1> <span class="fa fa-chart-pie"></span> Payroll   </h1>
                <a :href="route('payroll.show.create.period.form')" class="btn btn-outline-dark mt-3 btn-sm"> <span class="fa fa-plus-circle"></span> Create Payroll</a>
            </div>

            <div class="table-responsive mt-3">
                <table class="table">
                    <thead class="bg-light">
                        <tr>
                        <th scope="col">Period</th>
                        <th scope="col">Gross Pay</th>
                        <th scope="col">PAYEE</th>
                        <th scope="col">Other Deductions</th>
                        <th scope="col">Disbursed</th>
                        <th scope="col">No of Employees</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(payroll,count) in payrolls" :key="count">
                            <td class="text-capitalize">  
                               {{payroll.month}} , {{payroll.year}}
                            </td>
                            <td>                                
                               {{payroll.gross_pay}}
                            </td>
                            <td>
                               0
                            </td>
                            <td>
                                {{payroll.other_deductions}}
                            </td>
                            <td>
                                {{payroll.disbursed_amount}}
                            </td>
                            <td>
                                <Link href="#">
                                    {{payroll.number_of_employees}}
                                </Link>
                            </td>
                            <td>
                                <Link :href="route('payroll.show.edit.form', payroll.id)">
                                    <span class="fa fa-edit"></span>
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                    </table>
            </div>

        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
import AppHeader from '@/Components/AppHeader.vue';
import ProfileSidebar from '@/Components/ProfileSidebar.vue';
import Personal from '@/Components/Profile/Personal.vue';
import Job from '@/Components/Profile/Job.vue';
export default {
    props:{
        payrolls:Object,
        user:Object,
    },
    data(){
        return{
            error:''
        }
    },
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
.photo{
    width: 86px;
    height: 86px;
    /*background-color: var(--theme-color);*/
    border-radius: 50%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}
</style>