<template>
  <div class="section">
          <h2 class="pb-2 mb-4 title-border"> 
              <span class="fa fa-money-bill"></span> 
              Payment information 
          </h2>
          <div class="row g-3 mb-3">

              <div class="col-4">
                <SelectInput label="Preferred Mode" :key="paymentOptions" :options="paymentOptions"  id="preffered_mode" name="preffered_mode" required noSymbols placeholder="Choose..." classes="text-capitalize" v-on:save="update"  :initVal="preffered_mode" />
              </div>

              <div v-if="preffered_mode == 'mobile money'" class="col-4">
                <SelectInput label="Provider" :key="mobileMoneyOptions" :options="mobileMoneyOptions"  id="mobile_money" name="mobile_money" required noSymbols placeholder="Choose..." classes="text-capitalize" v-on:save="update"  :initVal="mobile_money" />
              </div>

              <div v-else-if="preffered_mode == 'bank transfer'" class="col-5">
                <SelectInput label="To My Account With" :key="accountOptions" :options="accountOptions"  id="bank_account_with" name="bank_account_with" required noSymbols placeholder="Choose..." classes="text-capitalize" v-on:save="update"  :initVal="bank_account_with" />
              </div>
</div>
<div class="row g-3">


              <div v-if="preffered_mode == 'mobile money' && mobile_money" class="col-6">
                    <PhoneInput   :class="{'border-danger':errors.mobile_number}" id="mobile_number" name="mobile_number" type="text" :min="9" :max="15" noLetters  noSymbols placeholder="Mobile Number" v-on:save="update"  v-on:loading="setLoading" :initVal="mobile_number"  />
              </div>

              <div v-if="bank_account_with == 'micro finance institution'" class="col-6">
                    <TextInput  id="microfinance_name" name="microfinance_name" type="text"   placeholder="Microfinance Name" classes="text-capitalize " required noDigits noSymbols v-on:save="update"  v-on:loading="setLoading" :initVal="microfinance_name" />
              </div>
              <div v-if="bank_account_with == 'micro finance institution'" class="col-6">
                    
                    <TextInput  id="microfinance_acc_no" name="microfinance_acc_no" type="text"   placeholder="Microfinance Account Number" classes="text-capitalize " required  v-on:save="update"  v-on:loading="setLoading" :initVal="microfinance_acc_no" />
              </div>
               <div v-if="bank_account_with == 'sacco'" class="col-6">
                    <TextInput  id="sacco_name" name="sacco_name" type="text"   placeholder="Sacco Name" classes="text-capitalize " required noDigits noSymbols v-on:save="update"  v-on:loading="setLoading" :initVal="microfinance_name" />
              </div>
              <div v-if="bank_account_with == 'sacco'" class="col-6">
                    
                    <TextInput  id="sacco_acc_no" name="sacco_acc_no" type="text"   placeholder="Sacco Account Number" classes="text-capitalize " required  v-on:save="update"  v-on:loading="setLoading" :initVal="microfinance_acc_no" />
              </div>
              <div v-if="preffered_mode == 'bank transfer'" class="col-6">
                    
                    <BankInput  id="bank_name" name="bank_name" type="text"   placeholder="Bank Name" classes="text-capitalize " required noDigits noSymbols v-on:save="update"  v-on:loading="setLoading" :initVal="bank_name" />
              </div>
              <div v-if="preffered_mode == 'bank transfer'" class="col-6">
                    <TextInput  :key="bank_name" id="bank_branch" name="bank_branch" type="text"   placeholder="Bank Branch Name" classes="text-capitalize " required noDigits noSymbols v-on:save="update"  v-on:loading="setLoading" :initVal="bank_branch" />
              </div>
              
              <div v-if="preffered_mode == 'bank transfer'" class="col-6">
                    <TextInput :key="bank_name"  id="bank_branch_code" name="bank_branch_code" type="text"   placeholder="Bank Branch Code" classes="text-capitalize " required noLetters noSymbols v-on:save="update"  v-on:loading="setLoading" :initVal="bank_branch_code" />
              </div>
              <div v-if="preffered_mode == 'bank transfer'" class="col-6">
                    
                    <TextInput  id="bank_acc_name" name="bank_acc_name" type="text"   placeholder="Bank Account Name" classes="text-capitalize " required noDigits noSymbols v-on:save="update"  v-on:loading="setLoading" :initVal="bank_acc_name" />
              </div>
              <div v-if="preffered_mode == 'bank transfer'" class="col-6">
                    
                    <TextInput  id="bank_acc_no" name="bank_acc_no" type="text"   placeholder="Bank Account Number" classes="text-capitalize " required noLetters noSymbols v-on:save="update"  v-on:loading="setLoading" :initVal="bank_acc_no" />
              </div>
              
              
          </div>
              
      </div>
</template>

<script>
import TextInput from '@/Components/TextInput.vue';
import PhoneInput from '@/Components/PhoneInput.vue';
import BankInput from '@/Components/BankInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import BreezeLabel from '@/Components/Label.vue';
import moment from 'moment';
import StatusIcon from './Components/StatusIcon.vue';
export default {
    props:{
        settings:Array,
        user:Object,
        permissions:Array,
        showVerifyBox:Boolean,
        payment:Object,
    },
    data() {
        return {
            preffered_mode: this.payment.preffered_mode ? this.payment.preffered_mode : '',
            mobile_money: this.payment.mobile_money ? this.payment.mobile_money : '',
            mobile_number: this.payment.mobile_number ? this.payment.mobile_number : '',
            bank_name: this.payment.bank_name ? this.payment.bank_name : '',
            bank_branch: this.payment.bank_branch ? this.payment.bank_branch : '',
            bank_branch_code: this.payment.bank_branch_code ? this.payment.bank_branch_code : '',
            bank_acc_name: this.payment.bank_acc_name ? this.payment.bank_acc_name : '',
            bank_acc_no: this.payment.bank_acc_no ? this.payment.bank_acc_no : '',
            bank_account_with: this.payment.bank_account_with ? this.payment.bank_account_with : '',
            microfinance_name: this.payment.microfinance_name ? this.payment.microfinance_name : '',
            microfinance_acc_no: this.payment.microfinance_acc_no ? this.payment.microfinance_acc_no : '',
            sacco_name: this.payment.sacco_name ? this.payment.sacco_name : '',
            sacco_acc_no: this.payment.sacco_acc_no ? this.payment.sacco_acc_no : '',

            auth_user:this.$page.props.auth.user,
            loading:{},
            errors:{},
            religions:[],
            permissions_arr:this.permissions ? this.permissions : [],
            showVerifyOption:this.showVerifyBox ? this.showVerifyBox : false,
            verificationPermission:'verify_reg_details',
            paymentOptions:[
                "bank transfer",
                "cash",
                "mobile money",
            ],
            mobileMoneyOptions:[
                "mpesa",
                "airtel money",
                "t kash",
                "equitel",
            ],
            accountOptions:[
                "bank",
                "micro finance institution",
                "sacco",
            ]
        }
    },
    components: {
    BreezeLabel,
    TextInput,
    PhoneInput,
    StatusIcon,
    SelectInput,
    BankInput
},
     methods:{
        update(response){
                let name = response.name
                let error = response.error
                let value = response.value
                let bank = response.bank
                let branch = response.branch
                let branch_code = response.branch_code
                this[name] = value;
                if( error ) this.errors[name] = error;
                else delete this.errors[name];

                if( bank ) this.bank_name = bank
                if( branch ) this.bank_branch = branch
                if(branch_code) this.bank_branch_code = branch_code

                if( response.sync )
                    this.syncToServer(name,value)

                //this.disableSubmit( )
            },
        updateAddress(response){
            let data = response.value
            this.lat = data.lat
            this.lng = data.lng
            this.country = data.country
            this.search_str = data.search_str
            this.postal_code = data.postal_code
            this.physical_address = data.physical_address
        },
        getFieldSettings(value,field){ 
            if( ! this.settings ) return false;
            if( ! Array.isArray( this.settings ) ) return false;

            for( let i = 0; i < this.settings.length; i++ )
                if( this.settings[i].value == value )
                    this[field].push( this.settings[i] )

        },
        capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        },
        syncToServer(field,value,type,ask=false,askMsg='Are you sure you want to proceed?',assignFieldValue=false){
            this.loading[field] = true
            if( ask )
                if( ! confirm(askMsg) ) return false;
            axios({
                method: 'patch',
                url: '/v1/users/'+this.user.id,
                data: {
                    field:field,
                    value:value,
                    type:type,
                }
                }).then((response) => {
                   // console.log(response.data)
                   if( assignFieldValue )
                        this[field] = value
                    this.loading[field] = false
                })
                .catch( (error) => {
                console.log(error.response);
            });
        },
        setLoading(response){
            let name = response.name
            let value = response.value
            this.loading[name] = value;
            if( value ) this.loading[name] = value;
            else delete this.loading[name];
        },
        calAge(dob){
            let bday = moment(dob);
            let now = moment();

            this.age =  now.diff(bday,'years');
        },
        can(permission){
            return this.permissions_arr.includes(permission);
        },
        disableSubmit( ){

            if( ! Object.keys(this.errors).length )
                $('.submit').css('pointer-events','').removeClass('opacity-25');
            else 
                $('.submit').css('pointer-events','none').addClass('opacity-25');
        },
    },
    watch:{
        dob(val){
            this.calAge(val)
        }
    },
    mounted(){
        this.getFieldSettings('disability','disabilities')
        this.getFieldSettings('religion','religions')
        if( this.user.dob )
            this.calAge( new Date( this.user.dob ))

        //console.log(this.user);
    }
}
</script>

<style>

</style>