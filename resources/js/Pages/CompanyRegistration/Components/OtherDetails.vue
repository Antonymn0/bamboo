<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout :hideNavItems="true">
        <app-header :title="company.company_name" subtitle="Setup"  />
			
			<div class="tab-pane-content pt-4">
				<form @submit.prevent="" class="border  mx-auto p-3">
				<h2 class="title-border pb-2"> 
					<span class="fa fa-info-circle"></span> 
					Other Details 
				</h2>

				<div class="py-3 row">						
						<div class='col-6 mb-4'>
							<TextInput  sync  :syncurl="route('company.patch', company.id)" id="kra_pin" name="kra_pin" type="text" :min="11" :max="11" krapin required  placeholder="KRA Pin" classes="text-uppercase" v-on:save="update" v-on:change="update" :initVal="getMetaValue('kra_pin', company.meta)"/>
						</div>						
						<div class='col-6 mb-4'>
							<TextInput  sync  :syncurl="route('company.patch', company.id)" id="nhif_no" name="nhif_no" type="text"  :min="5" :max="15" noLetters placeholder="NHIF No." classes="text-capitalize" v-on:save="update" v-on:change="update"  :initVal="getMetaValue('nhif_no', company.meta)"/>
						</div>
						<div class='col-6 mb-4'>
							<TextInput  sync  :syncurl="route('company.patch', company.id)" id="nssf_no" name="nssf_no" type="text" :min="5" :max="15" noLetters  placeholder="NSSF No."  v-on:save="update" v-on:change="update" :initVal="getMetaValue('nssf_no', company.meta)"/>
						</div>						
						<div class='col-6 mb-4'>
							<TextInput  sync  :syncurl="route('company.patch', company.id)" id="company_registration_number" name="company_registration_number" type="text" v-on:save="update" v-on:change="update"  placeholder="Company Registration No" classes="text-capitalize"  :initVal="getMetaValue('company_registration_number', company.meta)"/>
						</div>
				</div>
				<div class="text-right">
					<Link :href="route('company.registration.operations', user.username)" class="btn btn-sm btn-secondary submit px-3 m-2 "> <span class="fa fa-chevron-left"></span>  Back</Link>
					<Link :href="Object.keys(errors).length ? '' : route('company.registration.set-departments', user.username)" :class="{'opacity-25':Object.keys(errors).length}" class="btn btn-sm btn-theme submit px-5">Continue</Link>
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
		AppHeader
    },
	data(){
		return{
			kra_pin:'',
			registration_no:'',		
			errors:{kra_pin:'required'}	
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
	}
}
</script>

<style>

</style>