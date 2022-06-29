<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>

    <app-header title="Create Payroll" subtitle="Create" :user="user"  />
        <div class="container">
                <div class="tab-pane-content pt-4">
            <form action="#" class="border  mx-auto p-3" @submit.prevent="submitForm()">            
                    <h2 class="title-border pb-2"> 
                        <span class="fa fa-chart-pie"></span> 
                        Period
                    </h2>
                    <div class="pt-2 row ">   
                        <p class="fw-bold text-muted py-4">
                            <span class="text-dark"> Payroll Cycle: </span> 
                            <span v-if="payroll_cycle == 1">Daily</span>
                            <span v-if="payroll_cycle == 2">Weekly</span>
                            <span v-if="payroll_cycle == 3">Bi-weekly</span>
                            <span v-if="payroll_cycle == 4">Monthly</span>
                            <span v-if="payroll_cycle == 5">Quarerly</span>
                            <span v-if="payroll_cycle == 6">Semi-annualy</span>
                            <span v-if="payroll_cycle == 7">Annualy</span>

                           <!-- <span class="btn text-primary text-decoration-underline float-right">
                                <Link :href="route('set.payroll.cycle')"> Update cycle </Link>
                            </span>-->
                        </p>                 
                        <div class=' col-md-6 my-3'>
                            <SelectInput :class="{'border-danger':errors.month}" :options="month_options"  id="month" name="month" type="text" :min="3" :max="255" noDigits required noSymbols placeholder="Month" classes="text-capitalize" v-on:save="update" v-on:changed="update" :initVal="month"/> 
                        </div>
                        <div class='col-md-6 my-3'>
                            <SelectInput :class="{'border-danger':errors.year}" :options="year_options"  id="year" name="year" type="text" :min="3" :max="255"  required noSymbols placeholder="Year" classes="text-capitalize" v-on:save="update" v-on:changed="update" :initVal="year"/>
                        </div>
                    </div>
                    <div class="text-right pb-2 pt-4">
                        <button class="btn btn-theme submit px-5 " @click.prevent="submitForm()">Continue</button>
                    </div>
            </form>
                </div>    
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
import SelectInput from '@/Components/SelectInput.vue';
import AppHeader from '@/Components/AppHeader.vue';

import axios from 'axios';

export default {
    props:{
        user:Object,
        company:Object
    },
    components:{
        BreezeAuthenticatedLayout,
        Head,  
        SelectInput, 
        Link,
        AppHeader 
    },
    data(){
        return{
            month:'',
            year:'',
            errors:{},
            payroll_cycle:4, // default monthly cycle
            month_options:[
                'january',
                'february',
                'march',
                'april',
                'may',
                'june',
                'july',
                'august',
                'september',
                'october',
                'november',
                'december',
            ],
           year_options:[
                '2020',
                '2021',
                '2022',
                '2023',
            ],
          user:this.$page.props.auth.user,

        }
    },
    methods:{
        
        update(response){
                let name = response.name
                let error = response.error
                let value = response.value
                this[name] = value;
                if( error ) this.errors[name] = error;
                else delete this.errors[name];

               // if(  name == 'dob' ) this.calcAge(value)
                if( name == 'disability' ) 
                    if( value ) this.toggleDisabilityFields(true) 
                    else this.toggleDisabilityFields(false) 
            },

        submitForm(){
            this.validateForm();
            if(Object.keys(this.errors).length) return;
            var form_data = new FormData();
                form_data.append('month', this.month);
                form_data.append('year', this.year);
                form_data.append('company_id', this.company.id);
                form_data.append('created_by', this.user.id);

            axios.post('/v1/payroll/create', form_data) 
            .then( response => {        
                let payroll = response.data.data;
                this.$inertia.get('/payroll/create/employees/' + payroll.id );
               
            })
            .catch(error =>{
                if(error.response.status == 409) {
                    if(!confirm("You have already created a payroll record for this period. \n Want to edit?")) return
                    else this.$inertia.get('/payroll/update/employees/' + error.response.data.data.id );
                }
               
            })
        },
        fetchPayrollCycle(){
            axios.get(route('payroll-cycle.fetch', this.company.id))
            .then(response=>{
                this.payroll_cycle = response.data.data.payroll_cycle_id;
            })
            .catch(error=>{
               // alert('Failed to update payroll cycle!');
                console.log(error.response);
            })
        },

        validateForm(){
            this.errors={}
            if(!this.month) this.errors.month="This field is required!";
            if(!this.year) this.errors.year="This field is required!";
        }
    },
     mounted(){
       this.fetchPayrollCycle();    
    }
}
</script>
<style scoped>

</style>