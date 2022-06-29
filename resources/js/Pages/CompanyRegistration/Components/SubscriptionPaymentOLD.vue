<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout :hideNavItems="true">
        <app-header :title="company.company_name" subtitle="Setup"  />
			
		<div class="pt-5">
			<SubscriptionPayment />
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
import ImageInput from '@/Components/ImageInput.vue';
import SubscriptionPayment from '../../Subscription/SubscriptionPayment.vue';

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
        ImageInput,
        SubscriptionPayment
    },
	data(){
		return{
				logo_url:'/images/no-image.png',
				error:'',
               
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

		save(response){
				

				console.log(response.value)

		}
	},
    mounted(){
        //
    }
}
</script>

<style>

</style>