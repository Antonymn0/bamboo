<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
    <app-header title="Create Payroll" subtitle="Select  employees" :user="user"  />
        <div class="container-fluid">
            <div class="section  py-3 mx-auto">
            </div>  
            <div class="p-3  mx-auto ">
                <h2 class="row align-center">                     
                    <span class="col-md-6"> 
                        Select employees
                    </span> 
                    <!--<span class=" col-md-6 "> 
                       <span class="float-right btn col-md-6  btn-theme" @click="generatePayroll()">Generate payroll</span>
                    </span> -->
                </h2>
                <div class=" mt-2 ">                    
             <div class="table-responsive mt-3">
                <table class="table">
                    <thead class="bg-light">
                        <tr>
                        <th scope="col"> <input type="checkbox" @click="selectAll($event.target)" /> </th>

                        <!--<th scope="col" class="text-center"> 
                            <span class="btn btn-theme rounded p-1 px-2" @click.prevent="selectAll()" v-if="! selected_employees.length">Select all </span>  
                            <span class="btn btn-theme rounded p-1 px-2" @click.prevent="unselectAll()" v-if="selected_employees.length">Unselect all</span> </th>-->
                        <th scope="col">Employee Photo </th>
                        <th scope="col">Staff ID</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Department</th>
                        <th scope="col">Contract Type</th>
                        <th scope="col">Hire Date</th>
                        <th scope="col">Basic pay</th>
                        </tr>
                    </thead>
                    <tbody class="text-capitalize">
                        <tr v-for="(employee,count) in employees" :key="count">
                            <td class="align-middle">
                                <input type="checkbox" name="employees" :id="employee.id" :value="employee.id" v-model="selected_employees">
                            </td>
                            <td :style="employee.reg_status != '0' ? 'opacity:0.5' : ''">
                                <Link :href="route('profile',employee.username)">
                                    <div class="photo" :style="'background-image:url(https://i.pravatar.cc/300?img='+count+')'"></div>
                                </Link>
                            </td>
                            <td>
                                <Link :href="route('profile',employee.username)">
                                    {{getMetaValue('staff_id',employee.meta)}}
                                </Link>
                            </td>
                            <td>
                                <Link :href="route('profile',employee.username)">
                                    {{employee.first_name}} {{employee.last_name}}
                                </Link>
                            </td>
                            <td>
                                {{employee.department ? employee.department.name : ''}}
                            </td>
                            <td>
                                {{getMetaValue('contract_type',employee.meta)}}
                            </td>
                            <td>
                                {{formatDate(getMetaValue('contract_start_date',employee.meta))}}
                            </td>
                            <td>                                
                                {{getBasicSalary(employee.benefits)}}
                            </td>
                        </tr>
                    </tbody>
                    </table>
                </div>

                </div>
                <div class="text-right pb-2">
                    <button @click.prevent="generatePayroll()" class="btn btn-sm btn-theme">Generate Payroll</button>
				    <!-- <Link :href="route('payroll.show.create.employees.form')" class="btn btn-theme submit px-5 ">Continue</Link> -->
				</div>
            </div>    

        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
import SelectInput from '@/Components/SelectInput.vue';
import AppHeader from '@/Components/AppHeader.vue';
import moment from 'moment';

export default {
    props:{
        payroll:Object,
        employees:Object
    },
    components:{
        BreezeAuthenticatedLayout,
        Head,  
        SelectInput, 
        Link ,
        AppHeader   
    },
    data(){
        return{
           selected_employees:[],
          user:this.$page.props.auth.user,

        }
    },
    methods:{
        formatDate(date){
            return date ? moment(date).format('MMM Do YYYY') : date;
        },
        getBasicSalary(benefits){
            if(! Object.keys(benefits).length) return ;
            var amount = 0;

            benefits.forEach(benefit=>{               
                if(benefit.name == 'basic salary') amount = benefit.amount;
            });
            return amount;
        },
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
        selectAll(element){
            if( ! element.checked ) return this.unselectAll();

            this.employees.forEach(employee => {
                this.selected_employees.push(employee.id);
            });
        },
        unselectAll(){
            this.selected_employees = [];
        },
        generatePayroll(){
            if(! this.selected_employees.length) { alert('Please select employees to pay!'); return; }
            if(! confirm(`Generate payroll for ${this.selected_employees.length} employees? \n This action will generate a payroll record and save it for future refference.`)) return;
            var form_data = new FormData();
            form_data.append('selected employees', this.selected_employees);

            axios.post(`/v1/payroll/generate-payroll/${this.payroll.id}`, form_data)
            .then(response =>{
                //console.log(response);
                this.$inertia.get('/payroll' );
            })
            .then( error =>{
                console.log(error.response);
            })
        }
    },
  
    
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
    width: 50px;
    height: 50px;
    /*background-color: var(--theme-color);*/
    border-radius: 50%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: inline-block;
}
</style>