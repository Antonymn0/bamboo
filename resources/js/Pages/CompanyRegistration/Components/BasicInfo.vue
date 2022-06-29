<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout :hideNavItems="true">
        <app-header :title="company.company_name" subtitle="Setup"  />			
			
		<div class="tab-pane-content pt-4">
			<form @submit.prevent="" class="border  mx-auto p-3">
				<h2 class="title-border pb-2"> 
					<span class="fa fa-info-circle"></span> 
					Company Details
				</h2>

				<div class="py-3 row">						
						<div class='col-6 mb-4'>
							<TextInput  sync notnull  :syncurl="route('company.patch', company.id)" id="company_name" name="company_name" type="text" v-on:save="update" v-on:change="update" :min="3" :max="255" noDigits required noSymbols placeholder="Company name" classes="text-capitalize"  :initVal="company_name"/>
						</div>
						<div class='col-6 mb-4'>
						    <AddressInput sync  :syncurl="route('company.patch', company.id)" placeholder="Physical Address" v-on:save="update" v-on:change="update"  name="physical_address" id="physical_address" type="text" :class="{'border-danger':errors.physical_address}"    :initVal="getMetaValue('physical_address', company.meta)"/>
						</div>
						<div class='col-6 mb-4'>
							<PostalCodeInput  sync  :syncurl="route('company.patch', company.id)" id="postal_code" name="postal_code" v-on:save="update" v-on:change="update" type="text" :min="3" :max="255" noLetters  noSymbols placeholder="Postal Code" classes="text-capitalize"  :initVal="getMetaValue('postal_code', company.meta)"/>
						</div>
						<div class='col-6 mb-4'>
							<TextInput  sync  :syncurl="route('company.patch', company.id)" id="postal_address" name="postal_address" v-on:save="update" v-on:change="update" type="text"  noLetters  noSymbols placeholder="Postal address"   :initVal="getMetaValue('postal_address', company.meta)"/>
						</div>
						<div class='col-6 mb-4'>
							<TextInput  sync  :syncurl="route('company.patch', company.id)" id="city" name="city" type="text" v-on:save="update" v-on:change="update" :min="3" :max="255" noDigits  noSymbols label="City/Town" placeholder="City/Town" classes="text-capitalize"  :initVal="getMetaValue('city', company.meta)"/>
						</div>
						<div class='col-6 mb-4'>
							<TextInput sync  :syncurl="route('company.patch', company.id)" id="country" name="country" type="text" v-on:save="update" v-on:change="update" :min="3" :max="255" noDigits noSymbols placeholder="Country" classes="text-capitalize"  :initVal="getMetaValue('country', company.meta)"/>
						</div>
						<div class='col-6 mb-4'>
							<PhoneInput  sync  :syncurl="route('company.patch', company.id)" name="company_phone" type="numeric" v-on:save="update" v-on:change="update"  noDigits  noSymbols placeholder="Company phone" classes="text-capitalize"  :initVal="getMetaValue('company_phone', company.meta)"/>
						</div>

						<div class='col-6 mb-4'>
							<TextInput   sync  :syncurl="route('company.patch', company.id)" id="company_email" name="company_email" type="email" v-on:save="update" v-on:change="update"  placeholder="Company email"   :initVal="getMetaValue('company_email', company.meta)"/>
						</div>
                        
						<div class='col-6 '>
							<TextInput sync  :syncurl="route('company.patch', company.id)" id="website" name="website" type="text"  placeholder="Website"  v-on:save="update" v-on:change="update" :initVal="getMetaValue('website', company.meta)"/>
						</div>
						
				</div>
				<div class="text-right">
					<Link :href="Object.keys(errors).length ? '#' : route('company.registration.operations', user.username)" class="btn btn-sm btn-theme submit px-5" :class="{'opacity-25':Object.keys(errors).length}">Continue</Link>
				</div>				
		</form>
		</div>
    </BreezeAuthenticatedLayout>      
</template>>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
import AppHeader from '@/Components/AppHeader.vue';

import AddressInput from '@/Components/AddressInput.vue';
import TextInput from '@/Components/TextInput.vue';
import DateInput from '@/Components/DateInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import BreezeLabel from '@/Components/Label.vue';
import PhoneInput from '@/Components/PhoneInput.vue';
import PostalCodeInput from '@/Components/PostalCodeInput.vue';

export default {
	props:{
		user:Object,
		company:Object
	},
components: {
        BreezeLabel,
        TextInput,
        AddressInput,
        SelectInput,
        DateInput,
		BreezeAuthenticatedLayout,
		Head,
		Link,
		AppHeader,
		PhoneInput,
		PostalCodeInput
    },
	data(){
		return{
			company_name: this.company.company_name ? this.company.company_name : '',
			company_address:'',
			country:'',
			postal_code:'',
			physical_address:this.company.physical_address ? this.company.physical_address : '',
			first_name:'',
			city:'',
			location:'',
			company_phone:'',
			company_email:'',
			postal_address:'',
			website:'',	
			errors:{}	
		}
	},
	methods:{
		getMetaValue(key,metaData){
            let value = '';
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
                let name = response.name
                let error = response.error
                let value = response.value
                this[name] = value;
                if( error ) this.errors[name] = error;
                else delete this.errors[name];
            },
	},
	mounted(){
	}
}
</script>

<style>

</style>