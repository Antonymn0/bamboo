<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout :hideNavItems="true">
        <app-header :title="company.company_name" subtitle="Setup"  />
		
			<div class="tab-pane-content pt-4">
				<form @submit.prevent="" class="border  mx-auto p-3">
				<h2 class="title-border pb-2"> 
					<span class="fa fa-info-circle"></span> 
					Operations 
				</h2>

				<div class="py-3 row">						
						<div class='col-6 mb-4'>
							<SelectInput label="Number of employees" v-on:save="update" v-on:change="update"  :options="number_of_employees_options" sync  :syncurl="route('company.patch', company.id)" id="number_of_employees" name="number_of_employees" type="text" required  placeholder="Choose..." classes="text-capitalize"  :initVal="getMetaValue('number_of_employees', company.meta)"/>
						</div>
						<div v-if="number_of_employees == '30 and more' " class='col-6 mb-4'>
							<TextInput label="Specify Number of employees" v-on:save="update" v-on:change="update"  sync  :syncurl="route('company.patch', company.id)" id="actual_number_of_employees" name="actual_number_of_employees" type="text" required  placeholder="Choose..." classes="text-capitalize"  :initVal="getMetaValue('actual_number_of_employees', company.meta)"/>
						</div>
						<div class='col-6 mb-4'>
							<SelectInput label="Industry" v-on:save="update" v-on:change="update"  :options="industry_options" sync  :syncurl="route('company.patch', company.id)" id="industry" name="industry" type="text"  required noSymbols placeholder="Choose..." classes="text-capitalize"  :initVal="getMetaValue('industry', company.meta)"/>
						</div>
				</div>
				<div class="text-right">
					<Link :href="route('company.registration.basic-info', user.username)" class="btn btn-sm btn-secondary submit px-3 m-2 "> <span class="fa fa-chevron-left"></span>  Back</Link>
					<Link :href="Object.keys(errors).length ? '#' : route('company.registration.other-details', user.username)" class="btn btn-sm btn-theme submit px-5 " :class="{'opacity-25':Object.keys(errors).length}">Continue</Link>
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
        SelectInput,
        DateInput,
		BreezeAuthenticatedLayout,
		Head,
		Link,
		AppHeader,
    },
	data(){
		return{		
			
			number_of_employees_options:[
				'0 - 6',
				'7 - 14',
				'15 - 29',
				'30 and more'
			],			
			region_of_operation_options:[
				'Coast',
				'Central',
				'Western',
				'Eastern',
				'North Eastern',
				'Country wide',
				'East africa',
				'Global',
			],			
			industry_options:[
				'Agriculture, forestry and fishing',
				'Mining and quarrying',
				'Manufacturing',
				'Electricity, Oil, Gas, steam and air conditioning supply',	
				'Water supply  Waste management sewerage and remediation activities',				
				'Construction',				
				'Wholesale and retail trade repair of motor vehicles and motorcycles',				
				'Transportation and storage',	
				'Accommodation and food service activities',				
				'Information and communication',				
				'Financial and insurance activities',				
				'Real estate activities',				
				'Professional, scientific and technical activities',				
				'Administrative and support service activities',				
				'Public administration and defence compulsory social security',				
				'Education',	
				'Human health and social work activities',				
				'Arts, entertainment and recreation',				
				'Service activities',				
				/*'Activities of households as employers undifferentiated goods- and services-producing activities of households for own use',*/				
				'Activities of extraterritorial organizations and bodies',				
			],			
			errors:{},
			number_of_employees:'',	
			actual_number_of_employees:'',	

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
            },
		
	}
}
</script>

<style>

</style>