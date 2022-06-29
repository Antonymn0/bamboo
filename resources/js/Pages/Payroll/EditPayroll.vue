<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
    <app-header title="Update Payroll" subtitle="Edit" :user="user" />
        <div class="container">
                <div class="tab-pane-content pt-4">
            <form action="#" class="border  mx-auto p-3" @submit.prevent="submitForm()">            
                    <h2 class="title-border pb-2"> <span class="fa fa-chart-pie"></span> Period</h2>
                     <div class="pt-3 row ">  
                        <p class="fw-bold text-muted py-4">
                            <span class="text-dark"> Payroll Cycle:  </span> 
                            <span v-if="payroll_cycle == 1">Daily</span>
                            <span v-if="payroll_cycle == 2">Weekly</span>
                            <span v-if="payroll_cycle == 3">Bi-weekly</span>
                            <span v-if="payroll_cycle == 4">Monthly</span>
                            <span v-if="payroll_cycle == 5">Quarerly</span>
                            <span v-if="payroll_cycle == 6">Semi-annualy</span>
                            <span v-if="payroll_cycle == 7">Annualy</span>

                            <!--<span class="btn text-primary text-decoration-underline float-right">
                                <Link :href="route('set.payroll.cycle')"> Update cycle </Link>
                            </span>-->
                        </p>    
                        <div class=' col-md-6 my-3'>
                            <SelectInput :options="month_options"  id="month" name="month" type="text" :min="3" :max="255" noDigits required noSymbols placeholder="Month" classes="text-capitalize" v-on:save="update" v-on:changed="update" :initVal="month"/> 
                        </div>
                        <div class='col-md-6 my-3'>
                            <SelectInput  :options="year_options"  id="year" name="year" type="text" :min="3" :max="255" noDigits required noSymbols placeholder="Year" classes="text-capitalize" v-on:save="update" v-on:changed="update" :initVal="year"/>
                        </div>
                    </div>
                    <div class="text-right pb-2 pt-4">
                        <Link :href="route('payroll', payroll.id)" class="btn btn-sm btn-secondary submit px-3 mx-2 ">Back</Link>
                        <button class="btn btn-sm btn-theme submit px-5 " @click.prevent="submitForm()">Continue</button>
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
        payroll:Object
    },
    components:{
        BreezeAuthenticatedLayout,
        Head,  
        SelectInput, 
        Link , 
          SelectInput,
        AppHeader 
    },
    data(){
        return{
            month: this.payroll.month ? this.payroll.month : '',
            year: this.payroll.year ? this.payroll.year : '',
            payroll_cycle:4, // default monthly cycle
            errors:{},
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
        }
    },
    methods:{
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

            axios.post(`/v1/update/payroll-period/${this.payroll.id}`, form_data)
            .then( response => {
                let payroll = response.data.data;
                this.$inertia.get(`/payroll/update/employees/${this.payroll.id}` );
            })
            .catch(error =>{
                console.log(error.response);
            })
        },
         fetchPayrollCycle(){
            axios.get(route('payroll-cycle.fetch', this.$page.props.auth.user.company_id))
            .then(response=>{
                this.payroll_cycle = response.data.data.payroll_cycle_id;
            })
            .catch(error=>{
                //alert('Failed to update payroll cycle!');
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
      // this.fetchPayrollCycle();    
    }
   
}
</script>
<style scoped>

</style>