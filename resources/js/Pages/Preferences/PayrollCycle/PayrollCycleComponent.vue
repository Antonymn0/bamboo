<template>
<div class="container pb-2 ">
    <div class="row"> 
        <div class="col-md-10 py-3 mx-auto">                    
            <div class="tab-pane-content pt-4">
            <form @submit.prevent="" class="border  mx-auto p-3">
                <h2 class="title-border pb-2"> 
                    <span  class="fa fa-umbrella-beach"></span> 
                    Update payroll cycle
                </h2>
                <div class="col-md-9 mx-auto">                                                              
                        <h3 class="fw-bold my-3"> Available cycles </h3>
                    <div class='my-3'>                                    
                        <input type="radio" class="m-2" name="payroll_cycle" value="1" id="1" v-model="selected_payroll_cycle" @focus.prevent="submitPayrollCycle()">
                        <label for="1"> Daily</label>                                    
                    </div>                                                              
                    <div class='my-3'>                                    
                        <input type="radio" class="m-2" name="payroll_cycle" value="2" id="2" v-model="selected_payroll_cycle" @focus.prevent="submitPayrollCycle()">
                        <label for="2"> Weekly</label>                                    
                    </div>                                                              
                    <div class='my-3'>                                    
                        <input type="radio" class="m-2" name="payroll_cycle" value="3" id="3" v-model="selected_payroll_cycle" @focus.prevent="submitPayrollCycle()">
                        <label for="3"> By-weekly</label>                                    
                    </div>                                                              
                    <div class='my-3'>                                    
                        <input type="radio" class="m-2" name="payroll_cycle" value="4" id="4" v-model="selected_payroll_cycle" @focus.prevent="submitPayrollCycle()">
                        <label for="4"> Monthly </label>                                    
                    </div>                                                              
                    <div class='my-3'>                                    
                        <input type="radio" class="m-2" name="payroll_cycle" value="5" id="5" v-model="selected_payroll_cycle" @focus.prevent="submitPayrollCycle()">
                        <label for="5"> Quaterly</label>                                    
                    </div>                                                              
                    <div class='my-3'>                                    
                        <input type="radio" class="m-2" name="payroll_cycle" value="6" id="6" v-model="selected_payroll_cycle" @focus.prevent="submitPayrollCycle()">
                        <label for="6"> Semi annually</label>                                    
                    </div>                                                              
                    <div class='my-3'>                                    
                        <input type="radio" class="m-2" name="payroll_cycle" value="7" id="7" v-model="selected_payroll_cycle" @focus.prevent="submitPayrollCycle()">
                        <label for="7"> Annually</label>                                    
                    </div>                                                             
                                                                                    
                </div>                       			
            </form>
        </div>
        </div>                
    </div>            
</div>        
 
</template>

<script>



import TextInput from '@/Components/TextInput.vue';

export default {
    
    components:{
        TextInput,

    },
    data(){
        return{
            user:this.$page.props.auth.user,
            company:this.$page.props.auth.user.company,
            errors:{},
            current_payroll_cyle:null,
            selected_payroll_cycle:null
        }
    },
    methods:{        
        submitPayrollCycle(){
            if(! this.selected_payroll_cycle) return;
            var form_data = new FormData();
                form_data.append('created_by', this.user.id);
                form_data.append('payroll_cycle_id', this.selected_payroll_cycle);
                form_data.append('company_id', this.user.company_id);
            axios.post(route('payroll_cycle.store', this.user.company_id), form_data)
            .then(response=>{
                console.log(response);
                this.fetchPayrollCycle();
            })
            .catch(error=>{
                alert('Failed to update payroll cycle!');
               console.log(error.response);
            })
        },
        fetchPayrollCycle(){
            axios.get(route('payroll-cycle.fetch', this.user.company_id))
            .then(response=>{
                this.selected_payroll_cycle = response.data.data.payroll_cycle_id;
            })
            .catch(error=>{
                alert('Failed to update payroll cycle!');
                console.log(error.response);
            })
        },
        
    },
     
    mounted(){
       this.fetchPayrollCycle();
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