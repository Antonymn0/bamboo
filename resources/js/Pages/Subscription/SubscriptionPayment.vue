<template>
                      
    <div class="tab-pane-content pt-4 mb-4">
        <form @submit.prevent="" class="border  mx-auto p-3">
            <h2 class="title-border pb-2"> 
                <span class="fa fa-id-card"></span> 
                Service Packages
            </h2>

            <div class="py-4 row ">
                <!--<div class="col-md-12 p-3 mx-auto" v-if="! getMetaValue('number_of_employees', company.meta)"> 
                    <div class=" border rounded align-middle text-center p-2"> 
                        <span class="fw-bold py-2"> Update company info: <br> </span> <br>
                        <div class="py-3 row">	
                              					
                            <div class='col-6'>
                                <SelectInput label="Number of employees"  :options="number_of_employees_options" sync  :syncurl="route('company.patch', company.id)" id="number_of_employees" name="number_of_employees" type="text" required noSymbols placeholder="Choose..." classes="text-capitalize"  :initVal="getMetaValue('number_of_employees', company.meta)"/>
                            </div>
                            <div class='col-6'>
                                <SelectInput label="Industry"  :options="industry_options" sync  :syncurl="route('company.patch', company.id)" id="industry" name="industry" type="text"  required noSymbols placeholder="Choose..." classes="text-capitalize"  :initVal="getMetaValue('industry', company.meta)"/>
                            </div>
                            <Link :href="route('company.registration.subscription', auth_user.username)" class="btn btn-theme mx-auto px-2 w-50 mt-3"> Update</Link>
                        </div>
                    </div>
                </div>-->

                 <div class="col-md-10 p-3 mx-auto" v-if=" getMetaValue('number_of_employees', company.meta)"> 
                    <div class=" package-box rounded  align-middle text-center p-2" > 
                            <h2 class="fw-bold py-3 text-capitalize">{{company.company_name}} Size </h2>
                            <h3 class="fw- lead" > {{getMetaValue('number_of_employees', company.meta) == '30 and more' ?  getMetaValue('actual_number_of_employees', company.meta) : getMetaValue('number_of_employees', company.meta)}} Employees</h3>
                            <small> {{formatCurrency(amount)}}/Month </small> <br>
                    </div>
                </div>
                <div id="payments"  class="d-block text-center" v-if="getMetaValue('number_of_employees', company.meta)">                        
                <h2>Pay via <span class="text-success">Mpesa </span> </h2>
                    <div class="py-2" >
                        <div class="phone-input d-inline-block">
                            <PhoneInput    :id="phone" :name="phone" type="number" :min="9"  :max="15"  required noSymbols noLetters placeholder="Mpesa no" v-model="phone"   v-on:input="update"   :initVal="auth_user.phone" />
                        </div>
                        <button class="btn btn-sm btn-theme mb-2 ml-3" @click.prevent=" sendSTKPush()"> <span class="spinner-border spinner-border-sm" v-if="stkpush"></span> Click to intiate payment </button>
                    <br><small class="text-danger">{{errors.phone}}</small> 
                    <small class="text-success">{{success.phone}}</small> <br>
                        <!--<button class="btn btn-sm btn-theme mb-3" @click.prevent=" sendSTKPush()"> <span class="spinner-border spinner-border-sm" v-if="stkpush"></span> Make Payment </button>-->
                    </div>			
                    <div class="py-2" id="reciept" style="display:none">
                       <!-- <div>
                            <input type="text" disabled class="form-control disabled" v-model="mpesa_reciept_no" placeholder="Mpesa reciept no">
                        </div>-->
                        <small class="text-danger">{{errors.mpesa_reciept_no}}</small> 
                        <small class="text-success py-2">{{success.mpesa_reciept_no}}</small> <br>
                        <button class="btn btn-secondary mb-3 disabled" @click.prevent="detectPaymentReciept()"> <span class="spinner-border spinner-border-sm" v-if="detect_spinner"></span> Awaiting to detect your Payment </button>
                    </div>			
                </div>			
            </div>
            <div class="text-right border-top pt-2" v-if="getMetaValue('number_of_employees', company.meta)">
                <Link :href="route('company.registration.upload-logo', auth_user.username)" class="btn btn-secondary submit px-2 ">
                    <span class="fa fa-chevron-left"></span> Back
                </Link>
                <Link :href="route('dashboard', auth_user.company_id)"  class="btn btn-theme submit px-5 mx-2" v-if="payment_successful" >  Finish setup </Link>
                <Link href="#"  class="btn btn-theme submit px-5 mx-2 disabled" v-else >  Finish setup </Link>
                <Link :href="route('company.registration.upload-logo', auth_user.username)" class="btn btn-sm btn-secondary submit px-2 "> <span class="fa fa-chevron-left"></span> Back</Link>
                <Link :href="route('dashboard', auth_user.company_id)"  class="btn btn-sm btn-theme submit px-5 mx-2" v-if="payment_successful" >  Finish setup </Link>
                <Link href="#"  class="btn btn-sm btn-theme submit px-5 mx-2 disabled" v-else >  Finish setup </Link>
            </div>				
        </form>
    </div>
         
</template>
<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
import PhoneInput from '@/Components/PhoneInput.vue';
import AppHeader from '@/Components/AppHeader.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import AddressInput from '@/Components/AddressInput.vue';

export default {
    props:{
    },
    components:{
        Head,

        BreezeAuthenticatedLayout,
        SelectInput,
        AppHeader,
        TextInput,
        AddressInput,
        PhoneInput,
        Link
    },
    data(){
        return{
            auth_user:this.$page.props.auth.user,
            company: this.$page.props.auth.user.company,
            field:{},
            errors:{},
            success:{},
            phone:this.$page.props.auth.user.phone,
            amount:1,
            stkpush:false,
            detect_spinner:false,
            payment_successful:false,
            industry_options:[
				'Automobile',
				'Hospitality',
				'Transport',
				'Contstruction',				
			],
            number_of_employees_options:[
				'1 to 5',
				'6 to 14',
				'15 to 29',
				'30 and above'
			],

        }
    },
    methods:{
        getMetaValue(key,metaData){
            let value = null;
            for( let i = 0; i < metaData.length; i++ )
            {
                if( metaData[i].key == key ){
                    value = metaData[i].value;
                    break;
                }
            }
            return value;
        },
        update(response){
           this.phone = response.target.value;   
           this.cleanPhoneNumber();         
        },
        updateMpesaReciept(response){
            this.mpesa_reciept_no = response.target.value.toUpperCase();
        },

        sendSTKPush(){
            this.validateForm();

            if(Object.keys(this.errors).length) return;
            if(! confirm('Proceed to make an Mpesa payment?')) return;

            var form_data = new FormData();
                form_data.append('phone', this.phone);
                form_data.append('amount', this.amount);
                form_data.append('transaction_description', 'Bamboo Subscription payment');
            this.stkpush = true;
            axios.post(route('send.mpesa.stk-push', this.auth_user.id), form_data)
            .then(response=>{
                this.stkpush = false;
                if(response.data.ResponseCode == 0) {                     
                    this.success.phone = "Success! \n Please follow the prompts on your phone to complete the payment."; 
                    setTimeout(()=>{
                        document.getElementById('reciept').style.display = 'block';
                        this.detectPaymentReciept(response.data.CheckoutRequestID);
                    }, 3000)
                    }
                else this.errors.phone = 'Error! \n' + response.data.errorMessage;
            })
            .catch(error=>{
                this.stkpush = false;
                console.log(error.response);
            })
        },
        formatCurrency(amount){
          return ! isNaN(amount) ? amount.toLocaleString('en-GB', { style: 'currency', currency: 'KES' }) : amount
        },

        detectPaymentReciept(checkout_id){
            this.detect_spinner = true;

            axios.get(route('detect.mpesa.payment', checkout_id))
            .then(response=>{
                if(response.status == 200) {
                    this.detect_spinner = false;

                    this.success.mpesa_reciept_no = "Success, Payment confirmed!"
                    setTimeout(()=>{
                        this.hidePaymentFields();
                    }, 3000)
                }
            })
            .catch(error=>{
                setTimeout(()=>{
                    this.detectPaymentReciept(checkout_id); //repeat after every 5 sec
                }, 5000)                
            })
        },
        cleanPhoneNumber(){  
            this.errors = {}      
            this.success = {}      
            if(this.phone.length !== 10 ) {
                this.errors.phone = 'Invalid mpesa number!';
                return;
                }
            this.phone = '254' + this.phone.substring(1);
        },
        validateForm(){
            this.errors = {}
            this.success = {}
            if(!this.phone) this.errors.phone = 'Please provide a valid mpesa number';
            if(!this.amount) this.errors.amount = 'Amount is required!'
        },
        hidePaymentFields(){
            document.getElementById('payments').style.display = 'none';
            this.payment_successful = true;
        },
        calculateSubscriptionAmount(){
            let num_employees = this.getMetaValue('number_of_employees', this.company.meta)
            let actual_num_employees = this.getMetaValue('actual_number_of_employees', this.company.meta)

            if( num_employees == '0 - 6' )
                this.amount = 999;
            else if( num_employees == '7 - 14')
                this.amount = 1499;
            else if( num_employees == '15 - 29')
                this.amount = 2499;
            else if( num_employees == '30 and more')
                this.amount = parseFloat(actual_num_employees) * 125;
        }
        
    },
    mounted(){
        setTimeout(()=>{
            // if company is fully registered, hide payment fields
           if(this.$page.props.auth.user.company.registration_status == 0) {
               this.hidePaymentFields();
           }
        }, 1500);
        this.calculateSubscriptionAmount()
    }
}
</script>

<style scoped>
.section{
    padding-top: 30px;
    border-bottom: 1px solid var(--grey);
}
.section h1{
    color: var(--theme-color);
}

ul li{
    padding: 15px;
}
ul li:hover{
    /*cursor: pointer;
    color: var(--theme-color);*/
}
.active{
    color: var(--theme-color);
}
.package-box{
    border:1px solid var(--theme-color);
}
/*.package-box:hover{
    background: var(--theme-color);
    color:#fff;
}*/
.phone-input{
    max-width: 250px;
    margin:10px auto;
}

</style>