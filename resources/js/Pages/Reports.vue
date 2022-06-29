<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
    <div class="container">
            <div class="section">
                <h1> <span class="fa fa-chart-bar"></span> Reports   </h1>
            </div>
        <div class="tab-pane-content">

            <div class="section border-0" style="max-width:800px">
                <h2 class="title-border pb-2"> <span class="fa  fa-balance-scale"></span> Satutory Reports</h2>

                <div class="table-responsive mt-3">
                    <table class="table">
                        <thead class="bg-light">
                            <tr>
                            <th scope="col">Serial</th>
                            <th scope="col">Name</th>
                            <th scope="col">Created On</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr >
                                <td>
                                    HRM-001
                                </td>
                                
                                <td>
                                    <Link href="#">
                                        February 2022 P9 Payroll
                                    </Link>
                                </td>
                               
                                <td>
                                    12/12/2021
                                </td>
                            </tr>
                            <tr >
                                <td>
                                    HRM-002
                                </td>
                                
                                <td>
                                    <Link href="#">
                                        February 2022 NHIF 
                                    </Link>
                                </td>
                               
                                <td>
                                    12/12/2021
                                </td>
                            </tr>

                            <tr >
                                <td>
                                    HRM-003
                                </td>
                                
                                <td>
                                    <Link href="#">
                                        February 2022 NSSF                                    </Link>
                                </td>
                               
                                <td>
                                    12/12/2021
                                </td>
                            </tr>
                        </tbody>
                        </table>
                </div>

            </div>



            <div class="section border-0" style="max-width:800px">
                <h2 class="title-border pb-2"> <span class="fa  fa-user-tie"></span> Manegerial Reports</h2>

                <div class="table-responsive mt-3">
                    <table class="table">
                        <thead class="bg-light">
                            <tr>
                            <th scope="col">Serial</th>
                            <th scope="col">Name</th>
                            <th scope="col">Created On</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr >
                                <td>
                                    HRM-001
                                </td>
                                
                                <td>
                                    <Link href="#">
                                        February 2021 Roll Call
                                    </Link>
                                </td>
                               
                                <td>
                                    12/12/2021
                                </td>
                            </tr>
                            <tr >
                                <td>
                                    HRM-002
                                </td>
                                
                                <td>
                                    <Link href="#">
                                        February 2022 Overtime 
                                    </Link>
                                </td>
                               
                                <td>
                                    12/12/2021
                                </td>
                            </tr>

                            <tr >
                                <td>
                                    HRM-003
                                </td>
                                
                                <td>
                                    <Link href="#">
                                        February 2022 Employee turnover                                    </Link>
                                </td>
                               
                                <td>
                                    12/12/2021
                                </td>
                            </tr>
                        </tbody>
                        </table>
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