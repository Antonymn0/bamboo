<template>

<Head title="Preferences" />
    <BreezeAuthenticatedLayout> 
    <app-header title="Preferences" subtitle="Loans"  />
        <div class="container">
           
            <div class="section">
                <h1> <span class="fa fa-cog"></span> Preferences   </h1>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <Sidebar />
                </div>
                <div class="col-md-9">
                      <div class="">
                            <div class="tab-pane-conten p-4">
                        <form action="#" class="border  mx-auto p-3">            
                                <h2 class="title-border pb-2"> 
                                    <span class="fa fa-chart-pie"></span> 
                                    Loans
                                </h2>
                                <div class="pt-3 row ">
                                    <div class=' col-md-6 my-3'>                                        
                                        <input type="checkbox" name="loan" id="loan" value="yes" class="mr-2 shadow" v-model="loan">
                                        <label for="loan">Does the company offer loans?</label> <br>
                                        <small class="text-danger ">{{this.errors.loan}}</small>
                                        <div class="mt-4">
                                            <TextInput :class="{'border-danger ':errors.country}" v-on:save="update" v-on:changed="update" label="Loan name" id="loan_name" name="loan_name" type="text"   required  placeholder="loan_name" classes="text-capitalize"  initVal=""/>                                  
                                        </div>
                                        <small class="text-danger">{{this.errors.loan_name}}</small>
                                        <div class="mt-4">
                                            <TextInput :class="{'border-danger':errors.country}" v-on:save="update" v-on:changed="update" label="max amount" id="loan_name" name="max_loan_amount" type="number"  noLetters  required  placeholder="Max loan amount" classes="text-capitalize"  initVal=""/>                                  
                                        </div>  
                                         <small class="text-danger">{{this.errors.max_loan_amount}}</small>
                                    </div>
                                   
                                    <div class='col-md-6 my-3 pt-4'>
                                        <div class="">
                                            <TextInput :class="{'border-danger':errors.country}" v-on:save="update" v-on:changed="update" label="Interest rate" id="interest-rate" name="interest_rate" type="number" noLetters  required  placeholder="Interest rate" classes="text-capitalize"  initVal=""/>                                  
                                        </div>                                 
                                        <small class="text-danger">{{this.errors.interest_rate}}</small>                              
                                        <div class="mt-4">
                                            <TextInput :class="{'border-danger':errors.country}" v-on:save="update" v-on:changed="update" label="Repayment period in months" id="repayment_period" name="max_repayment_period" type="number"  noLetters required  placeholder="Repayment period in months" classes="text-capitalize"  initVal=""/>                                  
                                        </div>  
                                        <small class="text-danger">{{this.errors.max_repayment_period}}</small>                           
                                  </div>
                                  <div class="text-right pb-2 pt-4">
                                    <Link :href="route('preferences')" class="btn btn-secondary submit px-2 mx-2" > <span class="fa fa-chevron-left"></span> Back</Link>
                                    <button class="btn btn-theme px-5" @click.prevent="submitForm()"> Save </button> 
                                </div>
                                  <div>
                                    <div class=" border mt-4 " v-if="current_loan_records.length">
                                       <p class="fw-bold text-center mx-auto py-2 ">Records</p>                                          
                                            <p class="table-responsive w-100 p-2">
                                                 <table class="table table-striped table-sm text-muted ">
                                                    <thead>
                                                        <th># </th>
                                                        <th>Loan  </th>
                                                        <th> Max amount </th>
                                                        <th> Interest</th>
                                                        <th>Repayment </th>
                                                        <th>Action </th>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="text-muted" v-for="(loan, index) in current_loan_records" :key="index">
                                                            <td>{{index +1}}  </td>
                                                            <td class="text-capitalize">{{loan.loan_name}}  </td>
                                                            <td>Ksh {{loan.max_loan_amount}} </td>
                                                            <td> {{loan.interest_rate}}% </td>
                                                            <td> {{loan.max_repayment_period}} months</td>
                                                            <td> <i @click.prevent="deleteLoanRecord(loan.id)" class="text-danger btn">Delete </i></td>
                                                        </tr>
                                                    </tbody>
                                                 </table>       
                                            </p>                                      
                                      </div>
                                  </div>
                                </div>
                                
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
import Sidebar from '../Layouts/Sidebar.vue';
import AppHeader from '@/Components/AppHeader.vue';

import TextInput from '@/Components/TextInput.vue';

export default {
    props:{
        company:Object
    },
    components:{
        Head,
        TextInput,
        Link,
        Sidebar,
        BreezeAuthenticatedLayout,
        AppHeader,
    },
    data(){
        return{
            user:this.$page.props.auth.user,
            company:this.$page.props.auth.user.company, 
            errors:{},
            loan:false,
            loan_name:null,
            max_loan_amount:null,
            max_repayment_period:null,
            interest_rate:null,
            current_loan_records:[]
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

            if( name == 'disability' ) 
                if( value ) this.toggleDisabilityFields(true) 
                else this.toggleDisabilityFields(false) 
        },  
        submitForm(){
            this.validateForm();
            if(Object.keys(this.errors).length) return;

            var form_data = new FormData();
                form_data.append('loan', this.loan);
                form_data.append('loan_name', this.loan_name);
                form_data.append('max_loan_amount', this.max_loan_amount);
                form_data.append('interest_rate', this.interest_rate);
                form_data.append('max_repayment_period', this.max_repayment_period);
                form_data.append('company_id', this.user.company_id);
                
            if(! confirm('Save record?')) return;

            axios.post(route('loans.post', this.user.company_id), form_data)
            .then(response=>{
               this.getLoanRecord();
            })
            .catch(error=>{
                console.log(error.response);
            })
        },
        getLoanRecord(){ 
            axios.get(route('loans.get.record', this.user.company_id))
            .then(response=>{
                console.log(response);
                this.current_loan_records = response.data.data;
                console.log(this.current_loan_records);
            })
            .catch(error=>{
                console.log(error.response);
            })
        },
        deleteLoanRecord(loan_id){ 
            if(! confirm('Delete this record?')) return;

            axios.get(route('loans.delete.record', loan_id))
            .then(response=>{
                this.getLoanRecord();
            })
            .catch(error=>{
                console.log(error.response);
            })
        },
        validateForm(){
            this.errors={}

            if(! this.loan) this.errors.loan = 'Please tick this field';
            if(! this.loan_name) this.errors.loan_name = 'This field is required';
            if(! this.max_loan_amount) this.errors.max_loan_amount = 'This field is required';
            if(! this.max_repayment_period) this.errors.max_repayment_period = 'This field is required';
            if(! this.interest_rate) this.errors.interest_rate = 'This field is required';
        }
    },
    mounted(){
        this.getLoanRecord();
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

ul li{
    padding: 15px;
}
ul li:hover, ol li:hover, ul li i:hover {
    cursor: pointer;
    color: var(--theme-color);
}
.active{
    color: var(--theme-color);
}
</style>