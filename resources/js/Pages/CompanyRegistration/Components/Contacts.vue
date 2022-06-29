<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout :hideNavItems="true">
        <app-header :title="company.company_name" subtitle="Setup"  />
			
			<div class="tab-pane-content pt-4">
				<form @submit.prevent="" class="border  mx-auto p-3">
				<h2 class="title-border pb-2"> 
					<span class="fa fa-info-circle"></span> 
					Contact Details
				</h2>

				<div class="py-3 row">						

						<div class='col-6 mb-4'>
							<PhoneInput  sync  :syncurl="route('company.patch', company.id)" name="company_phone" type="numeric"  noDigits required noSymbols placeholder="Company phone" classes="text-capitalize"  :initVal="getMetaValue('company_phone', company.meta)"/>
						</div>

						<div class='col-6 mb-4'>
							<TextInput   sync  :syncurl="route('company.patch', company.id)" id="company_email" name="company_email" type="email"  required  placeholder="Company email"   :initVal="getMetaValue('company_email', company.meta)"/>
						</div>
						
                        <div class='col-6'>
							<TextInput :class="{'border-danger':errors.city}" sync  :syncurl="route('company.patch', company.id)" id="city" name="city" type="text" :min="3" :max="255" noDigits required noSymbols placeholder="City" classes="text-capitalize"  :initVal="getMetaValue('city', company.meta)"/>
						</div>
						<div class='col-6 '>
							<TextInput sync  :syncurl="route('company.patch', company.id)" id="website" name="website" type="text"  required  placeholder="Website"  :initVal="getMetaValue('website', company.meta)"/>
						</div>					
						
				</div>
				<div class="text-right">
					<Link :href="route('company.registration.basic-info', user.username)" class="btn btn-sm btn-secondary submit px-3 m-2 "> <span class="fa fa-chevron-left"></span>  Back</Link>
					<Link :href="route('company.registration.operations', user.username)" class="btn btn-sm btn-theme submit px-5 ">Continue</Link>
				</div>
			</form>				
		</div>
    </BreezeAuthenticatedLayout>      
</template>>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
import AppHeader from '@/Components/AppHeader.vue';

import TextInput from '@/Components/TextInput.vue';
import PhoneInput from '@/Components/PhoneInput.vue';
import DateInput from '@/Components/DateInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import BreezeLabel from '@/Components/Label.vue';
import moment from 'moment';
export default {
	props:{
		user:Object,
		company:Object
	},
components: {
        BreezeLabel,
        TextInput,
        PhoneInput,
        SelectInput,
        DateInput,
		BreezeAuthenticatedLayout,
		Head,
		Link,
		AppHeader
    },
	data(){
		return{
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
	}
}
</script>

<style>

</style>