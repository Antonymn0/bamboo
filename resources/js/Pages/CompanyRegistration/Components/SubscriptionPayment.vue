<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout :hideNavItems="true">
        <app-header :title="company.company_name" subtitle="Setup"  />
			
		<div class="pt-5">
			<div class="tab-pane-content pt-4 mb-4">
                <form @submit.prevent="" class="border  mx-auto p-3">

                    <h2 class="title-border pb-2"> 
                        <span class="fa fa-id-card"></span> 
                        Service Packages
                    </h2>

                    <h5 class="text-center mt-2 mb-4 text-bold">Click to select a package</h5>

                    <div v-if="packages_arr.length" class="row">

                        <div v-for="item in packages_arr" :key="item.id"  class="col-md-6 mb-4" @click.prevent="selectedPackage = item">
                            <div class="subscription-cards">
                                <article :class="{active:selectedPackage.id == item.id}">
                                    <div class="text">
                                        <h2 v-html="item.name" class="text-capitalize"></h2>
                                        <h3>{{formaCurrency(item.price)}} <small>/month</small> </h3>
                                        <ul>
                                            <li>Manage up to {{item.max_employees}} employees.</li>
                                        </ul>
                                    </div>
                                </article>
                            </div>
                        </div>

                    </div>

                    <div class="text-right">
                        <Link :href="route('company.registration.other-details', user.username)" class="btn btn-sm btn-secondary submit px-3 m-2 "> <span class="fa fa-chevron-left"></span>  Back</Link>
                        <Link href="#" @click.prevent="subscribe" class="btn btn-sm btn-theme submit px-5 ">Continue</Link>
                    </div>
                </form>
            </div>
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
		company:Object,
        packages:Array
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
                packages_arr: this.packages ? this.packages : [],
                selectedPackage: this.packages ? this.packages.length ? this.packages[0] : '' : ''
               
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

		},

         formaCurrency(amount){
          return ! isNaN(amount) ? parseFloat(amount).toLocaleString('en-GB', { style: 'currency', currency: 'KES' }) : amount
        },

        subscribe(){
            if( ! this.selectedPackage.id ) return alert("Please select a package!");
            if( ! this.company.id ) return alert("An error occured. Please try again.");

            if(! confirm("Are you sure you want to subscribe to "+ this.selectedPackage.name +" package?") ) return;

            axios.post('/v1/subscribe/'+this.selectedPackage.id+'/'+this.company.id)
            .then(response=>{
                if( response.data )
                    window.open('/','_self');
            })
            .catch(error=>{
                               
            })
        }
	},
    mounted(){
        //
    }
}
</script>

<style>

</style>