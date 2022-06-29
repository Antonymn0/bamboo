<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout :hideNavItems="true">
        <app-header :title="company.company_name" subtitle="Setup"  />
			
		<div class="pt-5">
			<div class="tab-pane-content pt-4">
				<form @submit.prevent="" class="border  mx-auto p-3">
				<h2 class="title-border pb-2"> 
					<span class="fa fa-info-circle"></span> 
					Set Departments
				</h2>


				<div class="py-3 row">						
						<div class='col-12'>
							<ContentInput type="textarea" :key="departments" label="Departments"  id="departments" name="departments" required  placeholder="Eg. Human Resource, Marketing, Sales" classes="text-capitalize" v-on:save="update" v-on:change="update" :initVal="departments" />
						</div>
				</div>
				

				<div class="text-right">
                    <Link :href="route('company.registration.other-details', user.username)" class="btn btn-sm btn-secondary submit px-3 m-2 "> <span class="fa fa-chevron-left"></span>  Back</Link>
					<Link :href="route('company.registration.upload-logo', user.username)" class="btn btn-sm btn-theme submit px-5 ">Continue</Link>
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
import ContentInput from '@/Components/ContentInput.vue';
import BreezeLabel from '@/Components/Label.vue';
export default {
	props:{
		user:Object,
		company:Object
	},
    components: {
        BreezeLabel,
        TextInput,
        ContentInput,
        DateInput,
		BreezeAuthenticatedLayout,
		Head,
		Link,
		AppHeader,
    },
	data(){
		return{
				departments:'',
            	errors:{},
				loading: false,
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

                if( response.sync ) 
                    this.save() 
                    

            },
		save(){

            this.loading = true
			axios({
                method: 'POST',
                url: '/v1/set-departments/',
                data: {
                    user_id:this.user.id,
                    departments:this.departments,
                }
                }).then((response) => {
                    //console.log(response.data)
                    this.loading = false
                })
                .catch( (error) => {
                console.log(error.response);
            });

		},
        fetchDeparments(){

            this.loading = true

            if( ! this.user.company ) return;

			axios({
                method: 'GET',
                url: '/v1/get-departments/'+this.user.company.id,
                data: {
                }
                }).then((response) => {
                    this.setInitValue(response.data.data)
                    this.loading = false
                   // console.log(response.data.data)
                })
                .catch( (error) => {
                console.log(error.response);
            });

        },
        setInitValue(departments_arr){
            for( let i = 0; i < departments_arr.length; i++ ){
                this.departments += departments_arr[i].name + ' '
                if( i < departments_arr.length - 1 )
                    this.departments += ', '
            }
        }
	},
    mounted(){
        this.fetchDeparments()
    }
}
</script>

<style>

</style>